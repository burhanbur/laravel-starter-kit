<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ApprovalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'approval_histories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_request_id',
        'approval_id',
        'user_id',
        'action',
        'note',
        'qrcode_path',
        'signature_hash',
        'approved_at',
        'created_by',
        'updated_by',
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

    public function approval()
    {
        return $this->belongsTo(Approval::class, 'approval_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
