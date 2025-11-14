<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        $users = [
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@example.com',
                'phone' => '081234567890',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'phone' => '081234567891',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ],
            [
                'name' => 'User Demo',
                'username' => 'user',
                'email' => 'user@example.com',
                'phone' => '081234567892',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'created_by' => null,
                'updated_by' => null,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            
            // Assign role berdasarkan username
            if ($user->username === 'superadmin') {
                $user->assignRole('SA'); // Super Admin role
            } elseif ($user->username === 'admin') {
                $user->assignRole('ADM'); // Administrator role
            } else {
                $user->assignRole('USR'); // User role
            }
        }
    }
}
