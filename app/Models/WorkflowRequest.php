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
        'callback_url',
        'requester_id',
        'current_level',
        'current_approval_status_id',
        'remarks',
        'signature_hash',
        'completed_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
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

    public function workflowApproval()
    {
        return $this->belongsTo(WorkflowApproval::class, 'workflow_approval_id');
    }

    public function currentApprovalStatus()
    {
        return $this->belongsTo(ApprovalStatus::class, 'current_approval_status_id');
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
