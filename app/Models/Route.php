<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Route extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'routes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'method',
        'module',
        'description',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($route) {
            if (empty($route->id)) {
                $route->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the role menus for the route.
     */
    public function roleMenus()
    {
        return $this->hasMany(RoleMenu::class, 'route_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'route_id', 'role_id')
                    ->withTimestamps();
    }

    /**
     * Get badge color class based on HTTP method
     *
     * @param string $method
     * @return string
     */
    public static function getMethodBadgeColor($method)
    {
        return match(strtoupper($method)) {
            'GET' => 'badge-primary',
            'POST' => 'badge-success',
            'PUT' => 'badge-warning',
            'PATCH' => 'badge-info',
            'DELETE' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}
