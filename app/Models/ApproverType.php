<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ApproverType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'approver_types';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected static function booted(): void
    {
        static::creating(function (ApproverType $type): void {
            $type->id ??= (string) uuidv7();
        });
    }

    public function workflowApprovers()
    {
        return $this->hasMany(WorkflowApprover::class, 'approver_type_id');
    }
}
