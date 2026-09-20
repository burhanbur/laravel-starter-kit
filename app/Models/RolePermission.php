<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolePermission extends MultiplePrimaryKey
{
    use HasFactory;

    protected $table = 'role_permissions';
    protected $primaryKey = ['role_id', 'route_id'];
    public $incrementing = false;

    protected $fillable = [
        'role_id',
        'route_id',
        'created_by',
    ];

    /**
     * Get the role that owns the role permission.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the route that owns the role permission.
     */
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
}
