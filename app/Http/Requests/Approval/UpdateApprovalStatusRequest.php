<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class UpdateApprovalStatusRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'code'        => ['sometimes', 'required', 'string', 'max:50'],
            'name'        => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode status wajib diisi',
            'name.required' => 'Nama status wajib diisi',
        ];
    }
}
