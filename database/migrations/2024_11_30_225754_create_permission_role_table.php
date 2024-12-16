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
        Schema::create('permission_role', function (Blueprint $table) {
            // relation with roles table
            $table->foreignId('role_id')->references('id')->on('roles')->cascadeOnUpdate();
            // relation with permissions table
            $table->foreignId('permission_id')->references('id')->on('permissions')->cascadeOnUpdate();

            $table->primary(['role_id', 'permission_id']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
    }
};
