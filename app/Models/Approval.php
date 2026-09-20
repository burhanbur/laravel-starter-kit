<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LogicException;

class Approval extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'approvals';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_request_id',
        'workflow_approval_stage_id',
        'workflow_approver_id',
        'delegated_approver_id',
        'actor_user_id',
        'actor_position_id',
        'decision',
        'note',
        'qrcode_path',
        'signature_hash',
        'signature_key_version',
        'acted_at',
    ];

    protected function casts(): array
    {
        return [
            'signature_key_version' => 'integer',
            'acted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Approval $approval): void {
            $approval->id ??= (string) uuidv7();
        });
        static::updating(fn () => throw new LogicException('Approval decisions are immutable.'));
        static::deleting(fn () => throw new LogicException('Approval decisions are append-only.'));
    }

    public function workflowRequest()
    {
        return $this->belongsTo(WorkflowRequest::class, 'workflow_request_id');
    }

    public function workflowApprovalStage()
    {
        return $this->belongsTo(WorkflowApprovalStage::class, 'workflow_approval_stage_id');
    }

    public function workflowApprover()
    {
        return $this->belongsTo(WorkflowApprover::class, 'workflow_approver_id');
    }

    public function delegatedApprover()
    {
        return $this->belongsTo(DelegatedApprover::class, 'delegated_approver_id');
    }

    public function actorUser()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    public function approvalHistories()
    {
        return $this->hasMany(ApprovalHistory::class, 'approval_id');
    }
}
