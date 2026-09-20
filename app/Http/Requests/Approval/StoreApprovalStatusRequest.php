<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreApprovalStatusRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'code'        => ['required', 'string', 'max:50', 'unique:approval_statuses,code'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode status wajib diisi',
            'code.unique'   => 'Kode status sudah digunakan',
            'name.required' => 'Nama status wajib diisi',
        ];
    }
}
