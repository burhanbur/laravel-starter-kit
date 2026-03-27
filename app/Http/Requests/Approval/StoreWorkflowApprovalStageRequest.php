<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreWorkflowApprovalStageRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_approval_id' => ['required', 'string', 'exists:workflow_approvals,id'],
            'sequence'             => ['required', 'integer', 'min:1'],
            'level'                => ['required', 'integer', 'min:1'],
            'approval_logic'       => ['required', 'string', 'in:ALL,ANY'],
            'name'                 => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_approval_id.required' => 'Workflow approval wajib diisi',
            'workflow_approval_id.exists'   => 'Workflow approval tidak ditemukan',
            'sequence.required'             => 'Sequence wajib diisi',
            'level.required'                => 'Level wajib diisi',
            'approval_logic.required'       => 'Logika approval wajib diisi',
            'approval_logic.in'             => 'Logika approval harus ALL atau ANY',
        ];
    }
}
