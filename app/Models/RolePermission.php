<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends MultiplePrimaryKey
{
    use HasFactory;

    protected $primaryKey = ['role_id', 'route_id'];
    protected $table = 'role_permissions';
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'route_id',
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
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}
