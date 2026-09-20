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
        'approval_logic',
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return ['sequence' => 'integer'];
    }

    protected static function booted(): void
    {
        static::creating(function (WorkflowApprovalStage $stage): void {
            $stage->id ??= (string) uuidv7();
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
