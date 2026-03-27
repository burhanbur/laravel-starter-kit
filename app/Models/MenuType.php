<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuType extends Model
{
    use HasFactory;

    public const SIDEBAR = 1;
    public const TOPBAR = 2;
    public const FOOTER = 3;

    protected $table = 'menu_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'menu_type_id');
    }
}
