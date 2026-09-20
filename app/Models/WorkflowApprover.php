<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class WorkflowApprover extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workflow_approvers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_approval_stage_id',
        'approver_type_id',
        'user_id',
        'position_id',
        'is_optional',
        'can_delegate',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'is_optional' => 'boolean',
            'can_delegate' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (WorkflowApprover $approver): void {
            $approver->id ??= (string) uuidv7();
        });
    }

    public function stage()
    {
        return $this->belongsTo(WorkflowApprovalStage::class, 'workflow_approval_stage_id');
    }

    public function approverType()
    {
        return $this->belongsTo(ApproverType::class, 'approver_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function delegatedApprovers()
    {
        return $this->hasMany(DelegatedApprover::class, 'workflow_approver_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'workflow_approver_id');
    }
}
