<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routes')->delete();

        $routes = [
            // Users
            [
                'name' => 'user.index',
                'method' => 'GET',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.create',
                'method' => 'GET',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.store',
                'method' => 'POST',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.edit',
                'method' => 'GET',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.update',
                'method' => 'PUT',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.destroy',
                'method' => 'DELETE',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Roles
            [
                'name' => 'role.index',
                'method' => 'GET',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.create',
                'method' => 'GET',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.store',
                'method' => 'POST',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.edit',
                'method' => 'GET',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.update',
                'method' => 'PUT',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.destroy',
                'method' => 'DELETE',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Menus
            [
                'name' => 'menu.index',
                'method' => 'GET',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.create',
                'method' => 'GET',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.store',
                'method' => 'POST',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.edit',
                'method' => 'GET',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.update',
                'method' => 'PUT',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.destroy',
                'method' => 'DELETE',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Routes
            [
                'name' => 'route.index',
                'method' => 'GET',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.create',
                'method' => 'GET',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.store',
                'method' => 'POST',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.edit',
                'method' => 'GET',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.update',
                'method' => 'PUT',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.destroy',
                'method' => 'DELETE',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
