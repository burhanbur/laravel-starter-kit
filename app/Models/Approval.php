<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Approval extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'approvals';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_request_id',
        'workflow_approval_stage_id',
        'workflow_approval_id',
        'approval_type_id',
        'approval_status_id',
        'user_id',
        'position_id',
        'delegate_from_user_id',
        'delegate_from_position_id',
        'level',
        'qrcode_path',
        'signature_hash',
        'note',
        'approved_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function workflowRequest()
    {
        return $this->belongsTo(WorkflowRequest::class, 'workflow_request_id');
    }

    public function workflowApprovalStage()
    {
        return $this->belongsTo(WorkflowApprovalStage::class, 'workflow_approval_stage_id');
    }

    public function workflowApproval()
    {
        return $this->belongsTo(WorkflowApproval::class, 'workflow_approval_id');
    }

    public function approverType()
    {
        return $this->belongsTo(ApproverType::class, 'approval_type_id');
    }

    public function approvalStatus()
    {
        return $this->belongsTo(ApprovalStatus::class, 'approval_status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvalHistories()
    {
        return $this->hasMany(ApprovalHistory::class, 'approval_id');
    }
}
