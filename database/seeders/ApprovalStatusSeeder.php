<?php

namespace Database\Seeders;

use App\Models\ApprovalStatus;
use Illuminate\Database\Seeder;

class ApprovalStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'PENDING' => ['Pending', 'Waiting for the first approval decision.'],
            'IN_PROGRESS' => ['In Progress', 'One or more workflow stages are being processed.'],
            'APPROVED' => ['Approved', 'The workflow request was approved.'],
            'REJECTED' => ['Rejected', 'The workflow request was rejected.'],
            'CANCELLED' => ['Cancelled', 'The workflow request was cancelled.'],
        ];

        foreach ($statuses as $code => [$name, $description]) {
            ApprovalStatus::withTrashed()->updateOrCreate(
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
