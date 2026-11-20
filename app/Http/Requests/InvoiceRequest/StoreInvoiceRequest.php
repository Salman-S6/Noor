<?php

namespace App\Http\Requests\InvoiceRequest;

use App\Models\AppFeature;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->has('items')) {
            $feature = AppFeature::findByKey('invoice_items');
            if ($feature && ! $feature->is_enabled) {
                abort(response()->json([
                    'status' => 'disabled',
                    'feature' => 'invoice_items',
                    'message' => $feature->disabled_message ?: 'ميزة تفاصيل وبنود الفواتير غير متاحة حالياً.',
                    'action' => $feature->action_type,
                ], 403));
            }
        }

        return true;
    }

    protected function prepareForValidation()
    {
        // إذا أُرسلت البنود ولم يُرسل المبلغ الكلي، نحسبه تلقائياً من مجموع البنود
        if (!$this->filled('amount') && $this->has('items') && is_array($this->items) && count($this->items) > 0) {
            $calculatedAmount = 0;
            foreach ($this->items as $item) {
                $qty = isset($item['quantity']) ? (float) $item['quantity'] : 1;
                $price = isset($item['unit_price']) ? (float) $item['unit_price'] : 0;
                $total = isset($item['total_price']) ? (float) $item['total_price'] : ($qty * $price);
                $calculatedAmount += $total;
            }
            $this->merge(['amount' => $calculatedAmount]);
        }
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',

            'invoice_number' => 'required|string|regex:/^[0-9]+$/|min:1|unique:invoices,invoice_number',

            'amount' => 'required|numeric|min:0',

            'notes' => 'nullable|string|max:255',

            'date' => 'required|date|date_format:Y-m-d',

            // بنود الفاتورة اختيارية تماماً لضمان عدم تعطل النظام القديم
            'items' => 'nullable|array',
            'items.*.description' => 'required_with:items|string|max:255',
            'items.*.quantity' => 'required_with:items|numeric|min:0.01',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
            'items.*.total_price' => 'nullable|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'الرجاء اختيار العميل',
            'customer_id.exists' => 'هذا العميل غير موجود',

            'invoice_number.required' => 'الرجاء إدخال رقم الفاتورة',
            'invoice_number.string' => 'رقم الفاتورة يجب أن يكون نصاً',
            'invoice_number.regex' => 'رقم الفاتورة يجب أن يحتوي فقط على أرقام',
            'invoice_number.min' => 'رقم الفاتورة يجب أن يكون أكبر من صفر',
            'invoice_number.unique' => 'رقم الفاتورة مستخدم من قبل',

            'amount.required' => 'الرجاء إدخال قيمة الفاتورة',
            'amount.numeric' => 'القيمة يجب أن تكون رقم',
            'amount.min' => 'القيمة يجب أن تكون أكبر من أو تساوي صفر',

            'date.required' => 'الرجاء إدخال تاريخ الفاتورة',
            'date.date' => 'صيغة التاريخ غير صحيحة',
            'date.date_format' => 'صيغة التاريخ يجب أن تكون سنة-شهر-يوم',

            'notes.string' => 'الملاحظات يجب أن تكون نصاً',
            'notes.max' => 'الملاحظات طويلة جداً',

            'items.array' => 'قائمة البنود يجب أن تكون مصفوفة',
            'items.*.description.required_with' => 'وصف البند مطلوب',
            'items.*.description.string' => 'وصف البند يجب أن يكون نصاً',
            'items.*.description.max' => 'وصف البند لا يجب أن يتجاوز 255 حرفاً',
            'items.*.quantity.required_with' => 'كمية البند مطلوبة',
            'items.*.quantity.numeric' => 'كمية البند يجب أن تكون رقماً',
            'items.*.quantity.min' => 'كمية البند يجب أن تكون أكبر من صفر',
            'items.*.unit_price.required_with' => 'سعر الوحدة مطلوب',
            'items.*.unit_price.numeric' => 'سعر الوحدة يجب أن يكون رقماً',
            'items.*.unit_price.min' => 'سعر الوحدة يجب أن يكون صفر أو أكثر',
            'items.*.total_price.numeric' => 'إجمالي البند يجب أن يكون رقماً',
        ];
    }
}
