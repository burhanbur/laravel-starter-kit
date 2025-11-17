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
                'description' => 'Menampilkan daftar user',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.create',
                'method' => 'GET',
                'module' => 'Users',
                'description' => 'Menampilkan form untuk membuat user baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.store',
                'method' => 'POST',
                'module' => 'Users',
                'description' => 'Menyimpan data user baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.edit',
                'method' => 'GET',
                'module' => 'Users',
                'description' => 'Menampilkan form untuk mengedit data user',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.update',
                'method' => 'PUT',
                'module' => 'Users',
                'description' => 'Memperbarui data user',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.destroy',
                'method' => 'DELETE',
                'module' => 'Users',
                'description' => 'Menghapus data user',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Change Password
            [
                'name' => 'user.change-password',
                'method' => 'GET',
                'module' => 'Users',
                'description' => 'Menampilkan form untuk mengubah password user',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'user.update-password',
                'method' => 'PUT',
                'module' => 'Users',
                'description' => 'Memperbarui password user',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Roles
            [
                'name' => 'role.index',
                'method' => 'GET',
                'module' => 'Roles',
                'description' => 'Menampilkan daftar role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.create',
                'method' => 'GET',
                'module' => 'Roles',
                'description' => 'Menampilkan form untuk membuat role baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.store',
                'method' => 'POST',
                'module' => 'Roles',
                'description' => 'Menyimpan data role baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.edit',
                'method' => 'GET',
                'module' => 'Roles',
                'description' => 'Menampilkan form untuk mengedit data role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.update',
                'method' => 'PUT',
                'module' => 'Roles',
                'description' => 'Memperbarui data role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.destroy',
                'method' => 'DELETE',
                'module' => 'Roles',
                'description' => 'Menghapus data role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.menu.show',
                'method' => 'GET',
                'module' => 'Roles',
                'description' => 'Menampilkan konfigurasi menu role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.menu.update',
                'method' => 'POST',
                'module' => 'Roles',
                'description' => 'Memperbarui konfigurasi menu role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.permission.show',
                'method' => 'GET',
                'module' => 'Roles',
                'description' => 'Menampilkan konfigurasi permission role',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'role.permission.update',
                'method' => 'POST',
                'module' => 'Roles',
                'description' => 'Memperbarui konfigurasi permission role',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Menus
            [
                'name' => 'menu.index',
                'method' => 'GET',
                'module' => 'Menus',
                'description' => 'Menampilkan daftar menu',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.create',
                'method' => 'GET',
                'module' => 'Menus',
                'description' => 'Menampilkan form untuk membuat menu baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.store',
                'method' => 'POST',
                'module' => 'Menus',
                'description' => 'Menyimpan data menu baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.edit',
                'method' => 'GET',
                'module' => 'Menus',
                'description' => 'Menampilkan form untuk mengedit data menu',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.update',
                'method' => 'PUT',
                'module' => 'Menus',
                'description' => 'Memperbarui data menu',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'menu.destroy',
                'method' => 'DELETE',
                'module' => 'Menus',
                'description' => 'Menghapus data menu',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Routes
            [
                'name' => 'route.index',
                'method' => 'GET',
                'module' => 'Routes',
                'description' => 'Menampilkan daftar route',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.create',
                'method' => 'GET',
                'module' => 'Routes',
                'description' => 'Menampilkan form untuk membuat route baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.store',
                'method' => 'POST',
                'module' => 'Routes',
                'description' => 'Menyimpan data route baru',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.edit',
                'method' => 'GET',
                'module' => 'Routes',
                'description' => 'Menampilkan form untuk mengedit data route',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.update',
                'method' => 'PUT',
                'module' => 'Routes',
                'description' => 'Memperbarui data route',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'route.destroy',
                'method' => 'DELETE',
                'module' => 'Routes',
                'description' => 'Menghapus data route',
                'created_by' => null,
                'updated_by' => null,
            ],

            // Impersonate
            [
                'name' => 'impersonate',
                'method' => 'POST',
                'module' => 'Impersonate',
                'description' => 'Memulai impersonasi pengguna',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'leave-impersonate',
                'method' => 'GET',
                'module' => 'Impersonate',
                'description' => 'Menghentikan impersonasi pengguna',
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
