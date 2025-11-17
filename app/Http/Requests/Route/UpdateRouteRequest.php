<?php 

namespace App\Http\Requests\Route;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateRouteRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeId = $this->route('id') ?? $this->route('route');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'method' => ['sometimes', 'required', 'string', 'in:GET,POST,PUT,PATCH,DELETE'],
            'module' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
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
            'name.required' => 'Nama route wajib diisi',
            'name.max' => 'Nama route maksimal 255 karakter',
            'method.required' => 'Method wajib diisi',
            'method.in' => 'Method harus salah satu dari: GET, POST, PUT, PATCH, DELETE',
            'module.required' => 'Module wajib diisi',
            'module.max' => 'Module maksimal 255 karakter',
            'description.max' => 'Deskripsi maksimal 500 karakter',
        ];
    }
}
