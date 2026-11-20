<?php

namespace App\Http\Requests\PaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',

            'amount' => 'required|numeric|min:0.01',

            'notes' => 'nullable|string|max:255',

            'date' => 'required|date|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'الرجاء اختيار العميل',
            'customer_id.exists' => 'العميل غير موجود',

            'amount.required' => 'الرجاء إدخال قيمة الدفعة',
            'amount.numeric' => 'القيمة يجب أن تكون رقم',
            'amount.min' => 'القيمة يجب أن تكون أكبر من صفر',

            'notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'notes.max' => 'الملاحظات طويلة جداً',

            'date.required' => 'الرجاء إدخال تاريخ الدفعة',
            'date.date' => 'صيغة التاريخ غير صحيحة',
            'date.date_format' => 'صيغة التاريخ يجب أن تكون سنة-شهر-يوم',
        ];
    }
}
