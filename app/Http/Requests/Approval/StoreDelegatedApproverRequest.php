<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreDelegatedApproverRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_approver_id'   => ['required', 'string', 'exists:workflow_approvers,id'],
            'start_date'             => ['required', 'date'],
            'end_date'               => ['required', 'date', 'after_or_equal:start_date'],
            'is_active'              => ['nullable', 'boolean'],
            'delegate_user_id'       => ['nullable', 'string', 'exists:users,id'],
            'delegate_position_id'   => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_approver_id.required' => 'Workflow approver wajib diisi',
            'workflow_approver_id.exists'   => 'Workflow approver tidak ditemukan',
            'start_date.required'           => 'Tanggal mulai wajib diisi',
            'end_date.required'             => 'Tanggal selesai wajib diisi',
            'end_date.after_or_equal'       => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'delegate_user_id.exists'       => 'User delegasi tidak ditemukan',
        ];
    }
}
