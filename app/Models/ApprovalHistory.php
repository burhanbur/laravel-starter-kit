<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LogicException;

class ApprovalHistory extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $table = 'approval_histories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'workflow_request_id',
        'approval_id',
        'actor_user_id',
        'action',
        'note',
        'metadata',
    ];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }

    protected static function booted(): void
    {
        static::creating(function (ApprovalHistory $history): void {
            $history->id ??= (string) uuidv7();
        });
        static::updating(fn () => throw new LogicException('Approval history is immutable.'));
        static::deleting(fn () => throw new LogicException('Approval history is append-only.'));
    }

    public function workflowRequest()
    {
        return $this->belongsTo(WorkflowRequest::class, 'workflow_request_id');
    }

    public function approval()
    {
        return $this->belongsTo(Approval::class, 'approval_id');
    }

    public function actorUser()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }
}
