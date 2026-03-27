<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreApprovalStatusRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_approval_id' => ['required', 'string', 'exists:workflow_approvals,id'],
            'code'                 => ['required', 'string', 'max:50'],
            'name'                 => ['required', 'string', 'max:255'],
            'description'          => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_approval_id.required' => 'Workflow approval wajib diisi',
            'workflow_approval_id.exists'   => 'Workflow approval tidak ditemukan',
            'code.required'                 => 'Kode status wajib diisi',
            'name.required'                 => 'Nama status wajib diisi',
        ];
    }
}
