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
        Schema::create('product_user', function (Blueprint $table) {
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->primary(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_user');
    }
};
