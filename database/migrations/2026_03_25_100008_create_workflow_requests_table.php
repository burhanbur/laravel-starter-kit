<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_approval_id');
            $table->string('request_code');
            $table->string('request_source');
            $table->uuid('requester_id');
            $table->uuid('current_stage_id')->nullable();
            $table->uuid('approval_status_id');
            $table->string('callback_url')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals')->restrictOnDelete();
            $table->foreign('requester_id')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('current_stage_id')->references('id')->on('workflow_approval_stages')->nullOnDelete();
            $table->foreign('approval_status_id')->references('id')->on('approval_statuses')->restrictOnDelete();
            $table->unique(['request_source', 'request_code']);
            $table->index(['approval_status_id', 'created_at']);
            $table->index('current_stage_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_requests');
    }
};
