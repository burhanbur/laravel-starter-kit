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
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_request_id', 36);
            $table->char('approval_id', 36)->nullable();
            $table->char('user_id', 36);
            $table->string('action');
            $table->text('note')->nullable();
            $table->string('qrcode_path')->nullable();
            $table->string('signature_hash')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->char('created_by', 36)->nullable();
            $table->timestamps();
        });

        Schema::table('approval_histories', function (Blueprint $table) {
            $table->foreign('workflow_request_id')->references('id')->on('workflow_requests')->onDelete('cascade');
            $table->foreign('approval_id')->references('id')->on('approvals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
    }
};
