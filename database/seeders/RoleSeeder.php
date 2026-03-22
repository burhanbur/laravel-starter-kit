<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();

        $roles = [
            [
                'code' => 'SA',
                'name' => 'Super Admin',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'code' => 'ADM',
                'name' => 'Administrator',
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'code' => 'USR',
                'name' => 'User',
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
