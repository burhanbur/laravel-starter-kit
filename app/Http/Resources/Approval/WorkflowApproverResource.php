<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowApproverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                         => $this->id,
            'workflow_approval_stage_id' => $this->workflow_approval_stage_id,
            'approval_type_id'           => $this->approval_type_id,
            'user_id'                    => $this->user_id,
            'position_id'                => $this->position_id,
            'level'                      => $this->level,
            'is_optional'                => $this->is_optional,
            'can_delegate'               => $this->can_delegate,
            'remarks'                    => $this->remarks,
            'created_by'                 => $this->created_by,
            'updated_by'                 => $this->updated_by,
            'created_at'                 => $this->created_at,
            'updated_at'                 => $this->updated_at,
            'approver_type'              => new ApproverTypeResource($this->whenLoaded('approverType')),
            'delegated_approvers'        => DelegatedApproverResource::collection($this->whenLoaded('delegatedApprovers')),
        ];
    }
}
