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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            // relation with users table
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            // relation with products table
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnUpdate();
            // relation with product_colors table
            $table->foreignId('product_color_id')->references('id')->on('product_colors')->cascadeOnUpdate();
            // relation with guarantees table
            $table->foreignId('guaranty_id')->references('id')->on('guaranties')->cascadeOnUpdate();
            $table->integer('number')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
