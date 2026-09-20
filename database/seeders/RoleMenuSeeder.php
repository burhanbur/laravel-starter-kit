<?php

namespace Database\Seeders;

use App\Models\RoleMenu;
use App\Models\Role;
use App\Models\Menu;
use App\Models\MenuType;
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

        // Get Superadmin role
        $superadminRole = Role::where('code', 'SA')->first();
        
        if (!$superadminRole) {
            $this->command->error('Superadmin role not found. Please run RoleSeeder first.');
            return;
        }

        // Get all menus
        $usersMenu = Menu::where('name', 'Manajemen Pengguna')->first();
        $konfigurasiMenu = Menu::where('name', 'Konfigurasi')->first();
        $menusMenu = Menu::where('name', 'Manajemen Menu')->first();
        $routesMenu = Menu::where('name', 'Manajemen Route')->first();
        $rolesMenu = Menu::where('name', 'Manajemen Peran')->first();
        $approvalMenu = Menu::where('name', 'Manajemen Approval')->first();

        // Get routes
        $usersIndexRoute = Route::where('name', 'user.index')->first();
        $menusIndexRoute = Route::where('name', 'menu.index')->first();
        $routesIndexRoute = Route::where('name', 'route.index')->first();
        $rolesIndexRoute = Route::where('name', 'role.index')->first();
        $approvalIndexRoute = Route::where('name', 'approval.workflow-definition.index')->first();

        // 1. Sidebar Menu: Manajemen Pengguna
        if ($usersMenu && $usersIndexRoute) {
            RoleMenu::create([
                'parent_id' => null,
                'role_id' => $superadminRole->id,
                'menu_id' => $usersMenu->id,
                'route_id' => $usersIndexRoute->id,
                'menu_type_id' => MenuType::SIDEBAR,
                'sequence' => 1,
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ]);
        }

        // 2. Navbar / Topbar Menu: Parent Konfigurasi
        if ($konfigurasiMenu) {
            $konfigurasiRoleMenu = RoleMenu::create([
                'parent_id' => null,
                'role_id' => $superadminRole->id,
                'menu_id' => $konfigurasiMenu->id,
                'route_id' => null,
                'menu_type_id' => MenuType::TOPBAR,
                'sequence' => 1,
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ]);

            // Children under Konfigurasi:
            // 2.1 Manajemen Menu
            if ($menusMenu && $menusIndexRoute) {
                RoleMenu::create([
                    'parent_id' => $konfigurasiRoleMenu->id,
                    'role_id' => $superadminRole->id,
                    'menu_id' => $menusMenu->id,
                    'route_id' => $menusIndexRoute->id,
                    'menu_type_id' => MenuType::TOPBAR,
                    'sequence' => 1,
                    'is_active' => true,
                    'created_by' => null,
                    'updated_by' => null,
                ]);
            }

            // 2.2 Manajemen Route
            if ($routesMenu && $routesIndexRoute) {
                RoleMenu::create([
                    'parent_id' => $konfigurasiRoleMenu->id,
                    'role_id' => $superadminRole->id,
                    'menu_id' => $routesMenu->id,
                    'route_id' => $routesIndexRoute->id,
                    'menu_type_id' => MenuType::TOPBAR,
                    'sequence' => 2,
                    'is_active' => true,
                    'created_by' => null,
                    'updated_by' => null,
                ]);
            }

            // 2.3 Manajemen Peran
            if ($rolesMenu && $rolesIndexRoute) {
                RoleMenu::create([
                    'parent_id' => $konfigurasiRoleMenu->id,
                    'role_id' => $superadminRole->id,
                    'menu_id' => $rolesMenu->id,
                    'route_id' => $rolesIndexRoute->id,
                    'menu_type_id' => MenuType::TOPBAR,
                    'sequence' => 3,
                    'is_active' => true,
                    'created_by' => null,
                    'updated_by' => null,
                ]);
            }

            // 2.4 Manajemen Approval
            if ($approvalMenu && $approvalIndexRoute) {
                RoleMenu::create([
                    'parent_id' => $konfigurasiRoleMenu->id,
                    'role_id' => $superadminRole->id,
                    'menu_id' => $approvalMenu->id,
                    'route_id' => $approvalIndexRoute->id,
                    'menu_type_id' => MenuType::TOPBAR,
                    'sequence' => 4,
                    'is_active' => true,
                    'created_by' => null,
                    'updated_by' => null,
                ]);
            }
        }
    }
}
