<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowApprovalStageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'workflow_approval_id' => $this->workflow_approval_id,
            'sequence'             => $this->sequence,
            'level'                => $this->level,
            'approval_logic'       => $this->approval_logic,
            'name'                 => $this->name,
            'created_by'           => $this->created_by,
            'updated_by'           => $this->updated_by,
            'created_at'           => $this->created_at,
            'updated_at'           => $this->updated_at,
            'workflow_approvers'   => WorkflowApproverResource::collection($this->whenLoaded('workflowApprovers')),
        ];
    }
}
