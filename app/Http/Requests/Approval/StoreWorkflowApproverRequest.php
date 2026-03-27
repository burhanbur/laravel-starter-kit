<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreWorkflowApproverRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_approval_stage_id' => ['required', 'string', 'exists:workflow_approval_stages,id'],
            'approval_type_id'           => ['required', 'string', 'exists:approver_types,id'],
            'user_id'                    => ['nullable', 'string', 'exists:users,id'],
            'position_id'                => ['nullable', 'string'],
            'level'                      => ['required', 'integer', 'min:1'],
            'is_optional'                => ['nullable', 'boolean'],
            'can_delegate'               => ['nullable', 'boolean'],
            'remarks'                    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_approval_stage_id.required' => 'Stage approval wajib diisi',
            'workflow_approval_stage_id.exists'   => 'Stage approval tidak ditemukan',
            'approval_type_id.required'           => 'Tipe approver wajib diisi',
            'approval_type_id.exists'             => 'Tipe approver tidak ditemukan',
            'user_id.exists'                      => 'User tidak ditemukan',
            'level.required'                      => 'Level wajib diisi',
        ];
    }
}
