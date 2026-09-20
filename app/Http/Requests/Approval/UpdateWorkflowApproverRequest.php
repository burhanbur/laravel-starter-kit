<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class UpdateWorkflowApproverRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'approver_type_id' => ['sometimes', 'required', 'string', 'exists:approver_types,id'],
            'user_id'          => ['nullable', 'string', 'exists:users,id'],
            'position_id'      => ['nullable', 'string'],
            'is_optional'      => ['nullable', 'boolean'],
            'can_delegate'     => ['nullable', 'boolean'],
            'remarks'          => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'approver_type_id.exists' => 'Tipe approver tidak ditemukan',
            'user_id.exists'          => 'User tidak ditemukan',
        ];
    }
}
