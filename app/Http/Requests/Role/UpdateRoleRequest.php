<?php 

namespace App\Http\Requests\Role;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roleId = $this->route('id') ?? $this->route('role');

        return [
            'code' => ['sometimes', 'required', 'string', 'max:10', Rule::unique('roles', 'code')->ignore($roleId)],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'code.required' => 'Kode role wajib diisi',
            'code.unique' => 'Kode role sudah digunakan',
            'code.max' => 'Kode role maksimal 10 karakter',
            'name.required' => 'Nama role wajib diisi',
            'name.max' => 'Nama role maksimal 255 karakter',
        ];
    }
}
