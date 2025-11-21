<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menus';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'icon',
        'deleted_by',
        'created_by',
        'updated_by',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($menu) {
            if (empty($menu->id)) {
                $menu->id = (string) uuidv7();
            }
        });
    }

    /**
     * Get the role menus for the menu.
     */
    public function roleMenus()
    {
        return $this->hasMany(RoleMenu::class, 'menu_id');
    }
}
