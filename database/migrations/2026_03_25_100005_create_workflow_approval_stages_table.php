<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_approval_stages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('workflow_approval_id');
            $table->smallInteger('sequence');
            $table->string('approval_logic')->default('ANY');
            $table->string('name');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('workflow_approval_id')->references('id')->on('workflow_approvals')->cascadeOnDelete();
            $table->unique(['workflow_approval_id', 'sequence']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_approval_stages');
    }
};
