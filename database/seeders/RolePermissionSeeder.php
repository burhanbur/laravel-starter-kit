<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use App\Models\Role;
use App\Models\Route;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_permissions')->delete();

        // Get Superadmin role
        $superadminRole = Role::where('code', 'SA')->first();
        
        if (!$superadminRole) {
            $this->command->error('Superadmin role not found. Please run RoleSeeder first.');
            return;
        }

        // Get all routes
        $usersIndexRoute = Route::whereIn('name', ['user.index', 'user.create', 'user.edit', 'user.store', 'user.update', 'user.destroy'])->get();
        $rolesIndexRoute = Route::whereIn('name', ['role.index', 'role.create', 'role.edit', 'role.store', 'role.update', 'role.destroy'])->get();
        $menusIndexRoute = Route::whereIn('name', ['menu.index', 'menu.create', 'menu.edit', 'menu.store', 'menu.update', 'menu.destroy'])->get();
        $routesIndexRoute = Route::whereIn('name', ['route.index', 'route.create', 'route.edit', 'route.store', 'route.update', 'route.destroy'])->get();

        // Manajemen Pengguna menu
        if ($usersIndexRoute) {
            foreach ($usersIndexRoute as $route) {
                RolePermission::create([
                    'role_id' => $superadminRole->id,
                    'route_id' => $route->id,
                    'created_by' => null,
                ]);
            }
        }

        // Manajemen Peran menu
        if ($rolesIndexRoute) {
            foreach ($rolesIndexRoute as $route) {
                RolePermission::create([
                    'role_id' => $superadminRole->id,
                    'route_id' => $route->id,
                    'created_by' => null,
                ]);
            }
        }

        // Manajemen Menu menu
        if ($menusIndexRoute) {
            foreach ($menusIndexRoute as $route) {
                RolePermission::create([
                    'role_id' => $superadminRole->id,
                    'route_id' => $route->id,
                    'created_by' => null,
                ]);
            }
        }

        // Manajemen Route menu
        if ($routesIndexRoute) {
            foreach ($routesIndexRoute as $route) {
                RolePermission::create([
                    'role_id' => $superadminRole->id,
                    'route_id' => $route->id,
                    'created_by' => null,
                ]);
            }
        }
    }
}
