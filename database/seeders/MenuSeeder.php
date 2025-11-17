<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->delete();

        $menus = [
            [
                'name' => 'Dashboard',
                'icon' => 'flaticon2-dashboard',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'Manajemen Pengguna',
                'icon' => 'flaticon2-avatar',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'Manajemen Peran',
                'icon' => 'flaticon2-shield',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'Manajemen Menu',
                'icon' => 'flaticon2-list-2',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'Manajemen Route',
                'icon' => 'flaticon2-layers-1',
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
