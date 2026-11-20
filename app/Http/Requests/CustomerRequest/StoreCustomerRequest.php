<?php

namespace App\Http\Requests\CustomerRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => [
                'required',
                'string',
                'max:50',
                'min:3',
                function ($attribute, $value, $fail) {
                    // جلب الكنية من الطلب (إن وجدت)
                    $lastName = request()->input('last_name');

                    // البحث عن زبون بنفس الاسم الأول
                    $query = \App\Models\Customer::where('first_name', $value);

                    // إذا كان هناك كنية، نبحث عنها أيضاً، وإلا نتأكد أن الزبون القديم بدون كنية
                    if (! empty($lastName)) {
                        $query->where('last_name', $lastName);
                    } else {
                        $query->where(function ($q) {
                            $q->whereNull('last_name')->orWhere('last_name', '');
                        });
                    }

                    if ($query->exists()) {
                        $fail('هذا الاسم مستخدم من قبل!');
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
            'phone.regex' => 'الرجاء إدخال رقم هاتف صالح (مثال: +963512345678)',
        ];
    }
}
