<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowApprovalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'workflow_definition_id' => $this->workflow_definition_id,
            'version'                => $this->version,
            'status'                 => $this->status,
            'published_at'           => $this->published_at,
            'created_by'             => $this->created_by,
            'updated_by'             => $this->updated_by,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
            'workflow_definition'    => new WorkflowDefinitionResource($this->whenLoaded('workflowDefinition')),
            'stages'                 => WorkflowApprovalStageResource::collection($this->whenLoaded('stages')),
        ];
    }
}
