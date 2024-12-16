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
        Schema::create('category_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->foreignId('category_attribute_id')->references('id')->on('category_attributes')->cascadeOnUpdate();
            $table->text('value');
            $table->tinyInteger('type')->default(0)->comment('value type is 0 => simple, 1 => multi values select by customers (affected on price)');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_attribute_values');
    }
};
