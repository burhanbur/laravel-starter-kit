<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DelegatedApprover extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'delegated_approvers';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_approver_id',
        'start_date',
        'end_date',
        'is_active',
        'delegate_user_id',
        'delegate_position_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
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

    public function workflowApprover()
    {
        return $this->belongsTo(WorkflowApprover::class, 'workflow_approver_id');
    }

    public function delegateUser()
    {
        return $this->belongsTo(User::class, 'delegate_user_id');
    }
}
