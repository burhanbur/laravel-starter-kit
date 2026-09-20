<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_request_id');
            $table->uuid('workflow_approval_stage_id');
            $table->uuid('workflow_approver_id');
            $table->uuid('delegated_approver_id')->nullable();
            $table->uuid('actor_user_id');
            $table->uuid('actor_position_id')->nullable();
            $table->string('decision');
            $table->text('note')->nullable();
            $table->string('qrcode_path')->nullable();
            $table->string('signature_hash', 64);
            $table->smallInteger('signature_key_version')->default(1);
            $table->timestamp('acted_at');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('workflow_request_id')->references('id')->on('workflow_requests')->cascadeOnDelete();
            $table->foreign('workflow_approval_stage_id')->references('id')->on('workflow_approval_stages')->restrictOnDelete();
            $table->foreign('workflow_approver_id')->references('id')->on('workflow_approvers')->restrictOnDelete();
            $table->foreign('delegated_approver_id')->references('id')->on('delegated_approvers')->nullOnDelete();
            $table->foreign('actor_user_id')->references('id')->on('users')->restrictOnDelete();
            $table->unique(['workflow_request_id', 'workflow_approver_id']);
            $table->index(['workflow_request_id', 'workflow_approval_stage_id']);
            $table->index(['actor_user_id', 'acted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
