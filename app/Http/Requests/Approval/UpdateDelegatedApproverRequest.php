<?php

namespace App\Http\Requests\Approval;

use App\Http\Requests\BaseFormRequest;

class UpdateDelegatedApproverRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'start_date'           => ['sometimes', 'required', 'date'],
            'end_date'             => ['sometimes', 'required', 'date', 'after_or_equal:start_date'],
            'is_active'            => ['nullable', 'boolean'],
            'delegate_user_id'     => ['nullable', 'string', 'exists:users,id'],
            'delegate_position_id' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after_or_equal'  => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'delegate_user_id.exists'  => 'User delegasi tidak ditemukan',
        ];
    }
}
