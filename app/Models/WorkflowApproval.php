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
        'status',
        'published_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'version' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (WorkflowApproval $approval): void {
            $approval->id ??= (string) uuidv7();
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

    public function workflowRequests()
    {
        return $this->hasMany(WorkflowRequest::class, 'workflow_approval_id');
    }
}
