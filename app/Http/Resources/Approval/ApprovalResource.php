<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                         => $this->id,
            'workflow_request_id'        => $this->workflow_request_id,
            'workflow_approval_stage_id' => $this->workflow_approval_stage_id,
            'workflow_approval_id'       => $this->workflow_approval_id,
            'approval_type_id'           => $this->approval_type_id,
            'approval_status_id'         => $this->approval_status_id,
            'user_id'                    => $this->user_id,
            'position_id'                => $this->position_id,
            'delegate_from_user_id'      => $this->delegate_from_user_id,
            'delegate_from_position_id'  => $this->delegate_from_position_id,
            'level'                      => $this->level,
            'qrcode_path'                => $this->qrcode_path,
            'note'                       => $this->note,
            'approved_at'                => $this->approved_at,
            'created_by'                 => $this->created_by,
            'updated_by'                 => $this->updated_by,
            'created_at'                 => $this->created_at,
            'updated_at'                 => $this->updated_at,
            'approval_status'            => new ApprovalStatusResource($this->whenLoaded('approvalStatus')),
            'approver_type'              => new ApproverTypeResource($this->whenLoaded('approverType')),
        ];
    }
}
