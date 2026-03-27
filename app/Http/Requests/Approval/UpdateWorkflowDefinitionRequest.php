<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkflowDefinitionRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'code'        => ['sometimes', 'required', 'string', 'max:100', Rule::unique('workflow_definitions', 'code')->ignore($id)],
            'name'        => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique'   => 'Kode workflow sudah digunakan',
            'name.required' => 'Nama workflow wajib diisi',
        ];
    }
}
