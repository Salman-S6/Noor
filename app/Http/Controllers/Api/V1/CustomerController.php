<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\CustomerRequest\StoreCustomerRequest;
use App\Http\Requests\CustomerRequest\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('invoices', 'payments');

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('page') || $request->boolean('paginate')) {
            $perPage = (int) $request->query('per_page', 20);
            return response()->json($query->paginate($perPage), 200);
        }

        return response()->json($query->get(), 200);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json($customer, 201);
    }

    public function show(Customer $customer)
    {
        $customer->load('invoices', 'payments');
        return response()->json($customer, 200);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json($customer, 200);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }

    public function getTotalDebts()
    {
        try {
            // 1. حساب مجموع كل الفواتير (المسحوبات)
            $totalInvoices = Invoice::sum('amount');

            // 2. حساب مجموع كل الدفعات (المقبوضات)
            $totalPayments = Payment::sum('amount');

            // 3. الرصيد المتبقي لك في السوق
            $totalDebts = $totalInvoices - $totalPayments;

            return response()->json([
                'status' => 'success',
                'total_debts' => $totalDebts
            ], 200);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error calculating total debts: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء حساب إجمالي الديون',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * كشف الزبائن: جميع الزبائن مع مجموع فواتيرهم ودفعاتهم والرصيد المتبقي
     * GET /api/customers/summary
     */
    public function summary(Request $request)
    {
        $customers = Customer::query()
            ->withSum('invoices as total_invoices', 'amount')
            ->withSum('payments as total_payments', 'amount')
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($customer) {
                $firstName = $customer->first_name;
                if (is_string($firstName)) {
                    $decoded = json_decode($firstName, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $firstName = $decoded;
                    }
                }

                $totalInvoices = round((float) ($customer->total_invoices ?? 0), 2) + 0;
                $totalPayments = round((float) ($customer->total_payments ?? 0), 2) + 0;
                $balance = round($totalInvoices - $totalPayments, 2) + 0;

                return [
                    'id' => (int) $customer->id,
                    'first_name' => $firstName,
                    'last_name' => $customer->last_name,
                    'phone' => $customer->phone,
                    'total_invoices' => $totalInvoices,
                    'total_payments' => $totalPayments,
                    'balance' => $balance,
                ];
            });

        return response()->json([
            'customers' => $customers,
        ], 200);
    }

    public function getOverdue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'days' => ['required', 'integer', 'in:30,60,90'],
            'page' => ['nullable', 'integer', 'min:1'],
        ], [
            'days.required' => 'حقل عدد الأيام مطلوب',
            'days.in' => 'عدد الأيام غير صالح، الخيارات المتاحة: 30, 60, 90',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $days = (int) $request->query('days');
        $page = (int) $request->query('page', 1);
        $today = Carbon::today();

        $customers = Customer::query()
            ->withSum('invoices as total_invoices', 'amount')
            ->withSum('payments as total_payments', 'amount')
            ->withCount('payments')
            ->withMax('payments as last_payment_date', 'date')
            ->withMin('invoices as oldest_invoice_date', 'date')
            ->get();

        $overdueCustomers = collect();

        foreach ($customers as $customer) {
            $balance = round(((float)($customer->total_invoices ?? 0)) - ((float)($customer->total_payments ?? 0)), 2) + 0;

            if ($balance <= 0) {
                continue;
            }

            if ($customer->payments_count > 0 && $customer->last_payment_date !== null) {
                $lastPaymentDateStr = Carbon::parse($customer->last_payment_date)->format('Y-m-d');
                $daysOverdue = (int) Carbon::parse($lastPaymentDateStr)->startOfDay()->diffInDays($today);

                if ($daysOverdue >= $days) {
                    $overdueCustomers->push([
                        'customer' => $customer->formatForApi(),
                        'balance' => $balance,
                        'days_overdue' => $daysOverdue,
                        'last_payment_date' => $lastPaymentDateStr,
                    ]);
                }
            } else {
                $oldestInvoiceDateStr = $customer->oldest_invoice_date
                    ? Carbon::parse($customer->oldest_invoice_date)->format('Y-m-d')
                    : null;

                $daysOverdue = $oldestInvoiceDateStr
                    ? (int) Carbon::parse($oldestInvoiceDateStr)->startOfDay()->diffInDays($today)
                    : 0;

                if ($daysOverdue >= $days) {
                    $overdueCustomers->push([
                        'customer' => $customer->formatForApi(),
                        'balance' => $balance,
                        'days_overdue' => $daysOverdue,
                        'last_payment_date' => null,
                    ]);
                }
            }
        }

        $sorted = $overdueCustomers->sortByDesc('balance')->values();

        $totalOverdue = round((float) $sorted->sum('balance'), 2) + 0;
        $customersCount = $sorted->count();

        $perPage = 15;
        $pageItems = $sorted->forPage($page, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $pageItems,
            $customersCount,
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return response()->json([
            'total_overdue' => $totalOverdue,
            'customers_count' => $customersCount,
            'customers' => $paginator,
        ], 200);
    }
}
