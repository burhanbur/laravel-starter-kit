<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WorkflowApproval extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workflow_approvals';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_definition_id',
        'version',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
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

    public function workflowDefinition()
    {
        return $this->belongsTo(WorkflowDefinition::class, 'workflow_definition_id');
    }

    public function stages()
    {
        return $this->hasMany(WorkflowApprovalStage::class, 'workflow_approval_id');
    }

    public function approvalStatuses()
    {
        return $this->hasMany(ApprovalStatus::class, 'workflow_approval_id');
    }

    public function workflowRequests()
    {
        return $this->hasMany(WorkflowRequest::class, 'workflow_approval_id');
    }
}
