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
        Schema::create('approval_status', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_approval_id', 36);
            $table->string('code')->comment('e.g. PENDING, APPROVED, REJECTED');
            $table->string('name');
            $table->text('description')->nullable();
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('approval_status', function (Blueprint $table) {
            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_status');
    }
};
