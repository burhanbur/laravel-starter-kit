<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('key_prefix')->index();
            $table->string('key_hash', 64)->unique();
            $table->text('description')->nullable();
            $table->string('application')->nullable();
            $table->json('ip_whitelist')->nullable();
            $table->json('permissions')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('rate_limit')->default(60);
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};
