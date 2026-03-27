<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreWorkflowApprovalRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'workflow_definition_id' => ['required', 'string', 'exists:workflow_definitions,id'],
            'version'                => [
                'required',
                'integer',
                'min:1',
                Rule::unique('workflow_approvals')->where(function ($query) {
                    return $query->where('workflow_definition_id', $this->workflow_definition_id);
                }),
            ],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'workflow_definition_id.required' => 'Workflow definition wajib diisi',
            'workflow_definition_id.exists'   => 'Workflow definition tidak ditemukan',
            'version.required'                => 'Versi wajib diisi',
            'version.unique'                  => 'Versi sudah digunakan untuk workflow definition ini',
        ];
    }
}
