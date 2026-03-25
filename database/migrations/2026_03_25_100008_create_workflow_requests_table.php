<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workflow_requests', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_approval_id', 36);
            $table->string('request_code');
            $table->string('request_source');
            $table->string('callback_url')->nullable();
            $table->char('requester_id', 36);
            $table->smallInteger('current_level');
            $table->char('current_approval_status_id', 36);
            $table->text('remarks')->nullable();
            $table->string('signature_hash')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('workflow_requests', function (Blueprint $table) {
            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals')->onDelete('cascade');
            $table->foreign('current_approval_status_id')->references('id')->on('approval_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_requests');
    }
};
