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
        Schema::create('guaranties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // relation with products table
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->decimal('price_increase', 20, 3)->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guaranties');
    }
};
