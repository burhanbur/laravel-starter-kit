<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class UpdateWorkflowApprovalRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'status'       => ['sometimes', 'required', 'string', 'in:DRAFT,PUBLISHED,RETIRED'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Status harus DRAFT, PUBLISHED, atau RETIRED',
        ];
    }
}
