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
            // Dashboard
            [
                'name' => 'dashboard.index',
                'method' => 'GET',
                'module' => 'Dashboard',
                'created_by' => null,
                'updated_by' => null,
            ],
            
            // Users
            [
                'name' => 'users.index',
                'method' => 'GET',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'users.create',
                'method' => 'GET',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'users.store',
                'method' => 'POST',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'users.edit',
                'method' => 'GET',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'users.update',
                'method' => 'PUT',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'users.destroy',
                'method' => 'DELETE',
                'module' => 'Users',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Roles
            [
                'name' => 'roles.index',
                'method' => 'GET',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'roles.create',
                'method' => 'GET',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'roles.store',
                'method' => 'POST',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'roles.edit',
                'method' => 'GET',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'roles.update',
                'method' => 'PUT',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'roles.destroy',
                'method' => 'DELETE',
                'module' => 'Roles',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Menus
            [
                'name' => 'menus.index',
                'method' => 'GET',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menus.create',
                'method' => 'GET',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menus.store',
                'method' => 'POST',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menus.edit',
                'method' => 'GET',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menus.update',
                'method' => 'PUT',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menus.destroy',
                'method' => 'DELETE',
                'module' => 'Menus',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Routes
            [
                'name' => 'routes.index',
                'method' => 'GET',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'routes.create',
                'method' => 'GET',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'routes.store',
                'method' => 'POST',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'routes.edit',
                'method' => 'GET',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'routes.update',
                'method' => 'PUT',
                'module' => 'Routes',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'routes.destroy',
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
