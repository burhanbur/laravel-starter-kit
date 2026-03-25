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
        Schema::create('workflow_approvers', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('workflow_approval_stage_id', 36);
            $table->char('approval_type_id', 36);
            $table->char('user_id', 36)->nullable();
            $table->char('position_id', 36)->nullable();
            $table->smallInteger('level')->comment('Order of approval sequence');
            $table->boolean('is_optional')->default(false);
            $table->boolean('can_delegate')->default(true);
            $table->text('remarks')->nullable();
            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('workflow_approvers', function (Blueprint $table) {
            $table->foreign('workflow_approval_stage_id')->references('id')->on('workflow_approval_stages')->onDelete('cascade');
            $table->foreign('approval_type_id')->references('id')->on('approver_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_approvers');
    }
};
