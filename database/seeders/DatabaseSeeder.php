<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $this->call([
                RoleSeeder::class,
                UserSeeder::class,
                RouteSeeder::class,
                MenuTypeSeeder::class,
                MenuSeeder::class,
                RoleMenuSeeder::class,
                RolePermissionSeeder::class,
                ApprovalStatusSeeder::class,
                ApproverTypeSeeder::class,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
