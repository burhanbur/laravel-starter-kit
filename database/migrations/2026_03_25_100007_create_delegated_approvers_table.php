<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delegated_approvers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_approver_id');
            $table->uuid('delegate_user_id')->nullable();
            $table->uuid('delegate_position_id')->nullable();
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('workflow_approver_id')->references('id')->on('workflow_approvers')->cascadeOnDelete();
            $table->foreign('delegate_user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['workflow_approver_id', 'is_active', 'start_date', 'end_date'], 'delegated_approvers_active_period_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delegated_approvers');
    }
};
