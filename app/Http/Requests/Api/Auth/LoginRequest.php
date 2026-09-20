<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseFormRequest;

class LoginRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identity' => 'required|string',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'identity.required' => 'Email atau username wajib diisi.',
            'identity.string'   => 'Format email atau username tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.string'   => 'Format password tidak valid.',
            'password.min'      => 'Password minimal harus 6 karakter.',
        ];
    }
}
