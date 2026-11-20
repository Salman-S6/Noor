<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest\StorePaymentRequest;
use App\Http\Requests\PaymentRequest\UpdatePaymentRequest;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());

        $customer = $payment->customer;

        return response()->json([
            'message' => 'تمت إضافة الدفعة بنجاح',
            'payment' => $payment,
            'current_balance' => $customer->balance,
        ], 201);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        $customer = $payment->customer;

        return response()->json([
            'message' => 'تم تحديث الدفعة بنجاح',
            'payment' => $payment,
            'current_balance' => $customer->balance,
        ], 200);
    }

    public function destroy(Payment $payment)
    {
        try {
            // نحتفظ ببيانات الزبون قبل الحذف لنتمكن من إرجاع الرصيد الجديد المحدث
            $customer = $payment->customer;

            $payment->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'تم حذف الدفعة بنجاح',
                'current_balance' => $customer->balance, // إرجاع الرصيد بعد الحذف لتحديث واجهة فلاتر
            ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting payment: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء حذف الدفعة',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
