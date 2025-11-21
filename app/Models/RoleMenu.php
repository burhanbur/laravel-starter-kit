<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoleMenu extends Model
{
    use HasFactory;

    protected $table = 'role_menus';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'parent_id',
        'role_id',
        'menu_id',
        'route_id',
        'menu_type_id',
        'sequence',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sequence' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($roleMenu) {
            if (empty($roleMenu->id)) {
                $roleMenu->id = (string) uuidv7();
            }
        });
    }

    /**
     * Get the parent role menu.
     */
    public function parent()
    {
        return $this->belongsTo(RoleMenu::class, 'parent_id');
    }

    /**
     * Get the children role menus.
     */
    public function children()
    {
        return $this->hasMany(RoleMenu::class, 'parent_id');
    }

    /**
     * Get the role that owns the role menu.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Get the menu that owns the role menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    /**
     * Get the route that owns the role menu.
     */
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    /**
     * Get the menu type that owns the role menu.
     */
    public function menuType()
    {
        return $this->belongsTo(MenuType::class, 'menu_type_id');
    }
}
