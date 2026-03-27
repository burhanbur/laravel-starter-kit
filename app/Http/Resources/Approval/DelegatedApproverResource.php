<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegatedApproverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'workflow_approver_id'   => $this->workflow_approver_id,
            'start_date'             => $this->start_date,
            'end_date'               => $this->end_date,
            'is_active'              => $this->is_active,
            'delegate_user_id'       => $this->delegate_user_id,
            'delegate_position_id'   => $this->delegate_position_id,
            'created_by'             => $this->created_by,
            'updated_by'             => $this->updated_by,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
