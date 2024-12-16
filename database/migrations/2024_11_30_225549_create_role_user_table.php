<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            // relation with users table
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            // relation with roles table
            $table->foreignId('role_id')->references('id')->on('roles')->cascadeOnUpdate();
            $table->primary(['user_id', 'role_id']);
            $table->timestamp('created_at')->useCurrent();
        });

        DB::table('role_user')->insert([
            [
                'user_id' => 1,
                'role_id' => 1,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
