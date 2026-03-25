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
        Schema::create('delegated_approvers', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_approver_id', 36);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);
            $table->char('delegate_user_id', 36)->nullable();
            $table->char('delegate_position_id', 36)->nullable();
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('delegated_approvers', function (Blueprint $table) {
            $table->foreign('workflow_approver_id')->references('id')->on('workflow_approvers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegated_approvers');
    }
};
