<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'endpoint',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($role) {
            if (empty($role->id)) {
                $role->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the role menus for the role.
     */
    public function roleMenus()
    {
        return $this->hasMany(RoleMenu::class, 'role_id');
    }
}
