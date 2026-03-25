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
        Schema::create('workflow_approval_stages', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_approval_id', 36);
            $table->smallInteger('sequence');
            $table->smallInteger('level');
            $table->string('approval_logic')->comment('ALL or ANY');
            $table->string('name')->nullable()->comment('Optional, e.g. Manager Approval');
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('workflow_approval_stages', function (Blueprint $table) {
            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_approval_stages');
    }
};
