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
        Schema::create('approvals', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_request_id', 36);
            $table->char('workflow_approval_stage_id', 36);
            $table->char('workflow_approval_id', 36);
            $table->char('approval_type_id', 36);
            $table->char('approval_status_id', 36);
            $table->char('user_id', 36)->nullable();
            $table->char('position_id', 36)->nullable();
            $table->char('delegate_from_user_id', 36)->nullable();
            $table->char('delegate_from_position_id', 36)->nullable();
            $table->smallInteger('level');
            $table->string('qrcode_path')->nullable();
            $table->string('signature_hash')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('approvals', function (Blueprint $table) {
            $table->foreign('workflow_request_id')->references('id')->on('workflow_requests')->onDelete('cascade');
            $table->foreign('workflow_approval_stage_id')->references('id')->on('workflow_approval_stages')->onDelete('cascade');
            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals')->onDelete('cascade');
            $table->foreign('approval_type_id')->references('id')->on('approver_types')->onDelete('cascade');
            $table->foreign('approval_status_id')->references('id')->on('approval_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
