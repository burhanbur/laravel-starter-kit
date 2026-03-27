<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreWorkflowRequestRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_approval_id' => ['required', 'string', 'exists:workflow_approvals,id'],
            'request_code'         => ['required', 'string', 'max:255', 'unique:workflow_requests,request_code'],
            'request_source'       => ['required', 'string', 'max:255'],
            'callback_url'         => ['nullable', 'url', 'max:500'],
            'requester_id'         => ['required', 'string', 'exists:users,id'],
            'remarks'              => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_approval_id.required' => 'Workflow approval wajib diisi',
            'workflow_approval_id.exists'   => 'Workflow approval tidak ditemukan',
            'request_code.required'         => 'Kode request wajib diisi',
            'request_code.unique'           => 'Kode request sudah digunakan',
            'request_source.required'       => 'Sumber request wajib diisi',
            'callback_url.url'              => 'Format callback URL tidak valid',
            'requester_id.required'         => 'Requester wajib diisi',
            'requester_id.exists'           => 'Requester tidak ditemukan',
        ];
    }
}
