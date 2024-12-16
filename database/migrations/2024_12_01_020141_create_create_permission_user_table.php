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
        Schema::create('create_permission_user', function (Blueprint $table) {
            // relation with users table
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            // relation with roles table
            $table->foreignId('permission_id')->references('id')->on('permissions')->cascadeOnUpdate();

            $table->primary(['user_id', 'permission_id']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_permission_user');
    }
};
