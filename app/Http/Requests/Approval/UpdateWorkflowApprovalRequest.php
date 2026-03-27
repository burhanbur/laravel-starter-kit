<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class UpdateWorkflowApprovalRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'is_active' => ['sometimes', 'required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'is_active.boolean' => 'Status aktif harus berupa boolean',
        ];
    }
}
