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

            // Approval - Workflow Definition
            ['name' => 'approval.workflow-definition.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar workflow definition',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-definition.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat workflow definition',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-definition.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan workflow definition',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-definition.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah workflow definition',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-definition.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui workflow definition',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-definition.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus workflow definition',          'created_by' => null, 'updated_by' => null],

            // Approval - Workflow Approval
            ['name' => 'approval.workflow-approval.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar workflow approval',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat workflow approval',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan workflow approval',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah workflow approval',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui workflow approval',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus workflow approval',          'created_by' => null, 'updated_by' => null],

            // Approval - Approval Status
            ['name' => 'approval.approval-status.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar approval status',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval-status.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat approval status',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval-status.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan approval status',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval-status.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah approval status',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval-status.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui approval status',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval-status.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus approval status',          'created_by' => null, 'updated_by' => null],

            // Approval - Approver Type
            ['name' => 'approval.approver-type.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar tipe approver',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approver-type.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat tipe approver',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approver-type.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan tipe approver',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approver-type.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah tipe approver',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approver-type.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui tipe approver',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approver-type.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus tipe approver',          'created_by' => null, 'updated_by' => null],

            // Approval - Workflow Approval Stage
            ['name' => 'approval.workflow-approval-stage.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar tahap workflow',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval-stage.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat tahap workflow',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval-stage.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan tahap workflow',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval-stage.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah tahap workflow',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval-stage.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui tahap workflow',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approval-stage.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus tahap workflow',          'created_by' => null, 'updated_by' => null],

            // Approval - Workflow Approver
            ['name' => 'approval.workflow-approver.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar workflow approver',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approver.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat workflow approver',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approver.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan workflow approver',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approver.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah workflow approver',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approver.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui workflow approver',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-approver.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus workflow approver',          'created_by' => null, 'updated_by' => null],

            // Approval - Delegated Approver
            ['name' => 'approval.delegated-approver.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar delegasi approver',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.delegated-approver.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat delegasi approver',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.delegated-approver.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan delegasi approver',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.delegated-approver.edit',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Form ubah delegasi approver',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.delegated-approver.update',  'method' => 'PUT',    'module' => 'Approval', 'description' => 'Perbarui delegasi approver',       'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.delegated-approver.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus delegasi approver',          'created_by' => null, 'updated_by' => null],

            // Approval - Workflow Request
            ['name' => 'approval.workflow-request.index',   'method' => 'GET',    'module' => 'Approval', 'description' => 'Daftar permintaan approval',        'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-request.create',  'method' => 'GET',    'module' => 'Approval', 'description' => 'Form buat permintaan approval',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-request.store',   'method' => 'POST',   'module' => 'Approval', 'description' => 'Simpan permintaan approval',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-request.show',    'method' => 'GET',    'module' => 'Approval', 'description' => 'Detail permintaan approval',         'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.workflow-request.destroy', 'method' => 'DELETE', 'module' => 'Approval', 'description' => 'Hapus permintaan approval',          'created_by' => null, 'updated_by' => null],

            // Approval - Approval Action
            ['name' => 'approval.approval.index',  'method' => 'GET',  'module' => 'Approval', 'description' => 'Daftar aksi approval',   'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval.create', 'method' => 'GET',  'module' => 'Approval', 'description' => 'Form aksi approval',      'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval.store',  'method' => 'POST', 'module' => 'Approval', 'description' => 'Proses aksi approval',    'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval.show',   'method' => 'GET',  'module' => 'Approval', 'description' => 'Detail aksi approval',    'created_by' => null, 'updated_by' => null],

            // Approval - Approval History
            ['name' => 'approval.approval-history.index', 'method' => 'GET', 'module' => 'Approval', 'description' => 'Daftar riwayat approval',  'created_by' => null, 'updated_by' => null],
            ['name' => 'approval.approval-history.show',  'method' => 'GET', 'module' => 'Approval', 'description' => 'Detail riwayat approval',  'created_by' => null, 'updated_by' => null],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
