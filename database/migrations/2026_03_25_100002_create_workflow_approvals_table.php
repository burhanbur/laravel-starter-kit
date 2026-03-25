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
        Schema::create('workflow_approvals', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_definition_id', 36);
            $table->smallInteger('version');
            $table->boolean('is_active')->default(true);
            $table->index(['workflow_definition_id', 'version']);
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('workflow_approvals', function (Blueprint $table) {
            $table->foreign('workflow_definition_id')->references('id')->on('workflow_definitions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_approvals');
    }
};
