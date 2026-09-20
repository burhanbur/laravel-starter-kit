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
            'workflow_approver_id'       => $this->workflow_approver_id,
            'delegated_approver_id'      => $this->delegated_approver_id,
            'actor_user_id'              => $this->actor_user_id,
            'actor_position_id'          => $this->actor_position_id,
            'decision'                   => $this->decision,
            'note'                       => $this->note,
            'qrcode_path'                => $this->qrcode_path,
            'signature_hash'             => $this->signature_hash,
            'signature_key_version'      => $this->signature_key_version,
            'acted_at'                   => $this->acted_at,
            'created_at'                 => $this->created_at,
        ];
    }
}
