<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends MultiplePrimaryKey
{
    use HasFactory;

    protected $table = 'user_roles';
    protected $primaryKey = ['role_id', 'user_id'];
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'user_id',
        'created_by',
    ];

    /**
     * Get the role that owns the user role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the user that owns the user role.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
