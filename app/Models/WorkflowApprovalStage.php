<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WorkflowApprovalStage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workflow_approval_stages';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_approval_id',
        'sequence',
        'level',
        'approval_logic',
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
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

    public function workflowApprovers()
    {
        return $this->hasMany(WorkflowApprover::class, 'workflow_approval_stage_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'workflow_approval_stage_id');
    }
}
