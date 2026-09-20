<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreApproverTypeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'code'        => ['required', 'string', 'max:50', 'unique:approver_types,code'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tipe approver wajib diisi',
        ];
    }
}
