<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'user_activities';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($activity) {
            if (empty($activity->id)) {
                $activity->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user that owns the activity.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
