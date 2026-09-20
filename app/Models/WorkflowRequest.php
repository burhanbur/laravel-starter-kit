<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WorkflowRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workflow_requests';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_approval_id',
        'request_code',
        'request_source',
        'requester_id',
        'current_stage_id',
        'approval_status_id',
        'callback_url',
        'remarks',
        'completed_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return ['completed_at' => 'datetime'];
    }

    protected static function booted(): void
    {
        static::creating(function (WorkflowRequest $request): void {
            $request->id ??= (string) uuidv7();
        });
    }

    public function workflowApproval()
    {
        return $this->belongsTo(WorkflowApproval::class, 'workflow_approval_id');
    }

    public function approvalStatus()
    {
        return $this->belongsTo(ApprovalStatus::class, 'approval_status_id');
    }

    public function currentStage()
    {
        return $this->belongsTo(WorkflowApprovalStage::class, 'current_stage_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'workflow_request_id');
    }

    public function approvalHistories()
    {
        return $this->hasMany(ApprovalHistory::class, 'workflow_request_id');
    }
}
