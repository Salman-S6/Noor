<?php

namespace App\Http\Requests\CustomerRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $customerId = $this->route('customer')->id ?? $this->route('customer');

        return [
            'first_name' => [
                'sometimes',
                'required',
                'string',
                'max:50',
                'min:3',
                function ($attribute, $value, $fail) use ($customerId) {
                    $lastName = request()->input('last_name');

                    // استثناء الزبون الحالي من الفحص
                    $query = \App\Models\Customer::where('id', '!=', $customerId)
                        ->where('first_name', $value);

                    if (! empty($lastName)) {
                        $query->where('last_name', $lastName);
                    } else {
                        $query->where(function ($q) {
                            $q->whereNull('last_name')->orWhere('last_name', '');
                        });
                    }

                    if ($query->exists()) {
                        $fail('يوجد زبون آخر مسجل بنفس هذا الاسم!');
                    }
                },
            ],

            'last_name' => 'nullable|string|max:50',

            'phone' => ['nullable', 'string', 'max:14', 'regex:/^\+?(?:[0-9] ?){7,15}[0-9]$/'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'الرجاء إدخال الاسم الأول',
            'first_name.max' => 'الاسم الأول طويل جداً',
            'first_name.min' => 'الاسم الأول قصير جداً',

            'last_name.max' => 'الاسم الأخير طويل جداً',

            'phone.max' => 'رقم الهاتف طويل جداً',
            'phone.regex' => 'الرجاء إدخال رقم هاتف صالح (مثال: +966512345678)',
        ];
    }
}
