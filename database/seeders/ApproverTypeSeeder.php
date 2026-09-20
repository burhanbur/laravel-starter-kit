<?php

namespace Database\Seeders;

use App\Models\ApproverType;
use Illuminate\Database\Seeder;

class ApproverTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'USER' => ['User', 'A specific application user.'],
            'POSITION' => ['Position', 'An external or local position identifier.'],
        ];

        foreach ($types as $code => [$name, $description]) {
            ApproverType::withTrashed()->updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'description' => $description,
                    'deleted_at' => null,
                ],
            );
        }
    }
}
