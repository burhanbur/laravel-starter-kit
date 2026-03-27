<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreApprovalActionRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_request_id' => ['required', 'string', 'exists:workflow_requests,id'],
            'action'              => ['required', 'string', 'in:APPROVED,REJECTED'],
            'note'                => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_request_id.required' => 'Workflow request wajib diisi',
            'workflow_request_id.exists'   => 'Workflow request tidak ditemukan',
            'action.required'              => 'Action wajib diisi',
            'action.in'                    => 'Action harus APPROVED atau REJECTED',
        ];
    }
}
