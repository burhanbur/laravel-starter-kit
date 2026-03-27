<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\BaseFormRequest;

class NotificationRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'virtual_account' => 'required',
            'customer_name' => 'required',
            'trx_id' => 'required',
            'trx_amount' => 'required',
            'payment_amount' => 'required',
            'datetime_payment' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'virtual_account.required' => 'Virtual account wajib diisi',
            'customer_name.required' => 'Customer name wajib diisi',
            'trx_id.required' => 'Trx ID wajib diisi',
            'trx_amount.required' => 'Trx amount wajib diisi',
            'payment_amount.required' => 'Payment amount wajib diisi',
            'datetime_payment.required' => 'Datetime payment wajib diisi',
        ];
    }
}
