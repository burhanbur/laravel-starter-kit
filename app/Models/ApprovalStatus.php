<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ApprovalStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'approval_statuses';
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
        static::creating(function (ApprovalStatus $status): void {
            $status->id ??= (string) uuidv7();
        });
    }

    public function workflowRequests()
    {
        return $this->hasMany(WorkflowRequest::class, 'approval_status_id');
    }
}
