<?php

namespace App\Http\Resources\Approval;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'workflow_request_id' => $this->workflow_request_id,
            'approval_id'         => $this->approval_id,
            'actor_user_id'       => $this->actor_user_id,
            'action'              => $this->action,
            'note'                => $this->note,
            'metadata'            => $this->metadata,
            'created_at'          => $this->created_at,
        ];
    }
}
