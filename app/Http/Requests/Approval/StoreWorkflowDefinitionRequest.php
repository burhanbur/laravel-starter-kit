<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class StoreWorkflowDefinitionRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'code'        => ['required', 'string', 'max:100', 'unique:workflow_definitions,code'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode workflow wajib diisi',
            'code.unique'   => 'Kode workflow sudah digunakan',
            'name.required' => 'Nama workflow wajib diisi',
        ];
    }
}
