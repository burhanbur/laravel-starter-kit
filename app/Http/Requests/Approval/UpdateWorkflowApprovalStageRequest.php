<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class UpdateWorkflowApprovalStageRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'sequence'       => ['sometimes', 'required', 'integer', 'min:1'],
            'level'          => ['sometimes', 'required', 'integer', 'min:1'],
            'approval_logic' => ['sometimes', 'required', 'string', 'in:ALL,ANY'],
            'name'           => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'approval_logic.in' => 'Logika approval harus ALL atau ANY',
        ];
    }
}
