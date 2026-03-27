<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                          => $this->id,
            'workflow_approval_id'        => $this->workflow_approval_id,
            'request_code'                => $this->request_code,
            'request_source'              => $this->request_source,
            'callback_url'                => $this->callback_url,
            'requester_id'                => $this->requester_id,
            'current_level'               => $this->current_level,
            'current_approval_status_id'  => $this->current_approval_status_id,
            'remarks'                     => $this->remarks,
            'signature_hash'              => $this->signature_hash,
            'completed_at'                => $this->completed_at,
            'created_by'                  => $this->created_by,
            'updated_by'                  => $this->updated_by,
            'created_at'                  => $this->created_at,
            'updated_at'                  => $this->updated_at,
            'workflow_approval'           => new WorkflowApprovalResource($this->whenLoaded('workflowApproval')),
            'current_approval_status'     => new ApprovalStatusResource($this->whenLoaded('currentApprovalStatus')),
            'approvals'                   => ApprovalResource::collection($this->whenLoaded('approvals')),
            'approval_histories'          => ApprovalHistoryResource::collection($this->whenLoaded('approvalHistories')),
        ];
    }
}
