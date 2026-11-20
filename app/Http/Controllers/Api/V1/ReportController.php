<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function customerBalance(Customer $customer)
    {
        return response()->json([
            'total_invoices' => $customer->invoices()->sum('amount'),
            'total_payments' => $customer->payments()->sum('amount'),
            'balance' => $customer->balance,
        ]);
    }

    public function getMovement(Request $request)
    {
        try {
            $filter = $request->query('filter', 'daily');
            $now = now();

            // 1. تجهيز استعلام الفواتير (المسحوبات)
            $invoices = Invoice::select(
                'id', 'customer_id', 'amount', 'notes', 'date', 'created_at',
                'invoice_number',
                DB::raw("'withdrawal' as type") // إضافة نوع الحركة
            );

            // 2. تجهيز استعلام الدفعات (المقبوضات)
            $payments = Payment::select(
                'id', 'customer_id', 'amount', 'notes', 'date', 'created_at',
                DB::raw('NULL as invoice_number'), // تعويض العمود الناقص ليتطابق الجدولان
                DB::raw("'receipt' as type") // إضافة نوع الحركة
            );

            // 3. تطبيق الفلترة
            switch ($filter) {
                case 'daily':
                    $invoices->whereDate('date', $now->toDateString());
                    $payments->whereDate('date', $now->toDateString());
                    break;
                case 'weekly':
                    // تحديد تاريخ اليوم
                    $endDate = $now->toDateString();
                    // الرجوع للخلف 6 أيام (لأن اليوم الحالي محسوب، فيصبح المجموع 7 أيام)
                    $startDate = $now->copy()->subDays(6)->toDateString();

                    $invoices->whereBetween('date', [$startDate, $endDate]);
                    $payments->whereBetween('date', [$startDate, $endDate]);
                    break;
                case 'monthly':
                    $invoices->whereMonth('date', $now->month)->whereYear('date', $now->year);
                    $payments->whereMonth('date', $now->month)->whereYear('date', $now->year);
                    break;
                case 'yearly':
                    $invoices->whereYear('date', $now->year);
                    $payments->whereYear('date', $now->year);
                    break;
            }

            // 4. حساب المجاميع الكلية (نحسبها قبل التقسيم لكي تعطينا المجموع الحقيقي لكل البيانات)
            $totalWithdrawals = (clone $invoices)->sum('amount');
            $totalReceipts = (clone $payments)->sum('amount');

            // 5. دمج الجدولين، الترتيب، والتقسيم (Pagination)
            $movements = $invoices->unionAll($payments)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->with('customer') // جلب بيانات الزبون للـ 10 عنصر فقط!
                ->paginate(10); // 👈 هنا حددنا 10 عنصراً في كل صفحة

            return response()->json([
                'total_withdrawals' => $totalWithdrawals,
                'total_receipts' => $totalReceipts,
                'movements' => $movements, // لارافيل سيرجعها بشكل كائن يحتوي على الصفحات
            ], 200);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting account movement: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب الحركة',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function summary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period' => ['required', 'string', Rule::in(['week', 'month', 'quarter', 'year'])],
        ], [
            'period.required' => 'حقل الفترة مطلوب',
            'period.in' => 'الفترة المحددة غير صالحة، الخيارات المتاحة: week, month, quarter, year',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $period = $request->query('period');
        $today = Carbon::today();
        $to = $today;
        $toDateStr = $to->format('Y-m-d');

        $seriesSlots = [];
        $from = null;
        $prevFrom = null;
        $prevTo = null;

        if ($period === 'week') {
            $from = $to->copy()->subDays(6);
            for ($i = 0; $i < 7; $i++) {
                $curDate = $from->copy()->addDays($i)->format('Y-m-d');
                $seriesSlots[] = [
                    'date' => $curDate,
                    'start' => $curDate,
                    'end' => $curDate,
                ];
            }
            $prevTo = $from->copy()->subDay();
            $prevFrom = $prevTo->copy()->subDays(6);

        } elseif ($period === 'month') {
            $from = $to->copy()->subDays(29);
            for ($i = 0; $i < 30; $i++) {
                $curDate = $from->copy()->addDays($i)->format('Y-m-d');
                $seriesSlots[] = [
                    'date' => $curDate,
                    'start' => $curDate,
                    'end' => $curDate,
                ];
            }
            $prevTo = $from->copy()->subDay();
            $prevFrom = $prevTo->copy()->subDays(29);

        } elseif ($period === 'quarter') {
            $from = $to->copy()->subDays(89);
            $curStart = $from->copy();
            while ($curStart->lte($to)) {
                $curEnd = $curStart->copy()->addDays(6);
                if ($curEnd->gt($to)) {
                    $curEnd = $to->copy();
                }
                $seriesSlots[] = [
                    'date' => $curStart->format('Y-m-d'),
                    'start' => $curStart->format('Y-m-d'),
                    'end' => $curEnd->format('Y-m-d'),
                ];
                $curStart = $curStart->copy()->addDays(7);
            }
            $prevTo = $from->copy()->subDay();
            $prevFrom = $prevTo->copy()->subDays(89);

        } elseif ($period === 'year') {
            $from = $to->copy()->subMonths(11)->startOfMonth();
            for ($i = 0; $i < 12; $i++) {
                $monthStart = $from->copy()->addMonths($i)->startOfMonth();
                $monthEnd = $monthStart->copy()->endOfMonth();
                if ($monthEnd->gt($to)) {
                    $monthEnd = $to->copy();
                }
                $seriesSlots[] = [
                    'date' => $monthStart->format('Y-m-01'),
                    'start' => $monthStart->format('Y-m-d'),
                    'end' => $monthEnd->format('Y-m-d'),
                ];
            }
            $prevTo = $from->copy()->subDay();
            $prevFrom = $prevTo->copy()->subMonths(11)->startOfMonth();
        }

        $fromDateStr = $from->format('Y-m-d');

        $periodPayments = Payment::whereBetween('date', [$fromDateStr, $toDateStr])
            ->select('date', 'amount')
            ->get();

        $periodInvoices = Invoice::whereBetween('date', [$fromDateStr, $toDateStr])
            ->select('date', 'amount')
            ->get();

        $totalReceipts = round((float) $periodPayments->sum('amount'), 2) + 0;
        $totalWithdrawals = round((float) $periodInvoices->sum('amount'), 2) + 0;
        $net = round($totalReceipts - $totalWithdrawals, 2) + 0;
        $invoicesCount = $periodInvoices->count();

        $series = [];
        foreach ($seriesSlots as $slot) {
            $sStart = $slot['start'];
            $sEnd = $slot['end'];

            $slotReceipts = $periodPayments->filter(function ($p) use ($sStart, $sEnd) {
                $pDate = is_string($p->date) ? $p->date : $p->date->format('Y-m-d');
                return $pDate >= $sStart && $pDate <= $sEnd;
            })->sum('amount');

            $slotWithdrawals = $periodInvoices->filter(function ($inv) use ($sStart, $sEnd) {
                $iDate = is_string($inv->date) ? $inv->date : $inv->date->format('Y-m-d');
                return $iDate >= $sStart && $iDate <= $sEnd;
            })->sum('amount');

            $series[] = [
                'date' => $slot['date'],
                'receipts' => round((float) $slotReceipts, 2) + 0,
                'withdrawals' => round((float) $slotWithdrawals, 2) + 0,
            ];
        }

        // حساب previous_net
        $prevFromStr = $prevFrom->format('Y-m-d');
        $prevToStr = $prevTo->format('Y-m-d');

        $prevPaymentsCount = Payment::whereBetween('date', [$prevFromStr, $prevToStr])->count();
        $prevInvoicesCount = Invoice::whereBetween('date', [$prevFromStr, $prevToStr])->count();

        if ($prevPaymentsCount === 0 && $prevInvoicesCount === 0) {
            $previousNet = null;
        } else {
            $prevReceipts = (float) Payment::whereBetween('date', [$prevFromStr, $prevToStr])->sum('amount');
            $prevWithdrawals = (float) Invoice::whereBetween('date', [$prevFromStr, $prevToStr])->sum('amount');
            $previousNet = round($prevReceipts - $prevWithdrawals, 2) + 0;
        }

        // أعلى 5 زبائن رصيداً (balance > 0) ترتيب تنازلي
        $topDebtors = Customer::query()
            ->withSum('invoices as total_invoices', 'amount')
            ->withSum('payments as total_payments', 'amount')
            ->get()
            ->map(function ($customer) {
                $balance = round(((float)($customer->total_invoices ?? 0)) - ((float)($customer->total_payments ?? 0)), 2) + 0;
                return [
                    'customer' => $customer->formatForApi(),
                    'balance' => $balance,
                ];
            })
            ->filter(fn ($item) => $item['balance'] > 0)
            ->sortByDesc('balance')
            ->take(5)
            ->values()
            ->all();

        return response()->json([
            'period' => $period,
            'from' => $fromDateStr,
            'to' => $toDateStr,
            'total_receipts' => $totalReceipts,
            'total_withdrawals' => $totalWithdrawals,
            'net' => $net,
            'previous_net' => $previousNet,
            'invoices_count' => $invoicesCount,
            'series' => $series,
            'top_debtors' => $topDebtors,
        ], 200);
    }
}
