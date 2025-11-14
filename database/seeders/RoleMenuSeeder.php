<?php

namespace Database\Seeders;

use App\Models\RoleMenu;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Route;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_menus')->delete();

        
    }
}
