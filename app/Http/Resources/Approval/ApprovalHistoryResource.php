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
            'user_id'             => $this->user_id,
            'action'              => $this->action,
            'note'                => $this->note,
            'qrcode_path'         => $this->qrcode_path,
            'approved_at'         => $this->approved_at,
            'created_by'          => $this->created_by,
            'updated_by'          => $this->updated_by,
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}
