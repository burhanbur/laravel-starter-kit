<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateApproverTypeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'code'        => [
                'sometimes',
                'required',
                'string',
                'max:50',
                Rule::unique('approver_types', 'code')->ignore($this->route('id')),
            ],
            'name'        => ['sometimes', 'required', 'string', 'max:255'],
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
