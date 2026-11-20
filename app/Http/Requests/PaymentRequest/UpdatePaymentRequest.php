<?php

namespace App\Http\Requests\PaymentRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'sometimes|required|exists:customers,id',

            'amount' => 'sometimes|required|numeric|min:0',

            'notes' => 'nullable|string|max:255',

            'date' => 'sometimes|required|date|date_format:Y-m-d',
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
