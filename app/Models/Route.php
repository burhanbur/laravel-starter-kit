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
        'endpoint',
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
}
