<?php

namespace Database\Seeders;

use App\Models\MenuType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu_types')->delete();

        $menuTypes = [
            [
                'id' => 1,
                'name' => 'Sidebar Menu',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'id' => 2,
                'name' => 'Topbar Menu',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'id' => 3,
                'name' => 'Footer Menu',
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($menuTypes as $menu) {
            MenuType::create($menu);
        }
    }
}
