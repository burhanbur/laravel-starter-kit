<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_approvers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_approval_stage_id');
            $table->uuid('approver_type_id');
            $table->uuid('user_id')->nullable();
            $table->uuid('position_id')->nullable();
            $table->boolean('is_optional')->default(false);
            $table->boolean('can_delegate')->default(true);
            $table->text('remarks')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('workflow_approval_stage_id')->references('id')->on('workflow_approval_stages')->cascadeOnDelete();
            $table->foreign('approver_type_id')->references('id')->on('approver_types')->restrictOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->unique(['workflow_approval_stage_id', 'user_id']);
            $table->unique(['workflow_approval_stage_id', 'position_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_approvers');
    }
};
