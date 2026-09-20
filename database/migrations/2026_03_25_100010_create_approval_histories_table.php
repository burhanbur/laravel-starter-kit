<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_request_id');
            $table->uuid('approval_id')->nullable();
            $table->uuid('actor_user_id')->nullable();
            $table->string('action');
            $table->text('note')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('workflow_request_id')->references('id')->on('workflow_requests')->cascadeOnDelete();
            $table->foreign('approval_id')->references('id')->on('approvals')->nullOnDelete();
            $table->foreign('actor_user_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['workflow_request_id', 'created_at']);
            $table->index(['actor_user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
    }
};
