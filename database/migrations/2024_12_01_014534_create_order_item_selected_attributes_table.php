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
        Schema::create('order_item_selected_attributes', function (Blueprint $table) {
            $table->id();
            // relation with order_items table
            $table->foreignId('order_item_id')->references('id')->on('order_items')->cascadeOnUpdate();
            // relation with category_attributes table
            $table->foreignId('category_attribute_id')->references('id')->on('category_attributes')->cascadeOnUpdate();
            // relation with category_values table
            $table->foreignId('category_value_id')->references('id')->on('category_attribute_values')->cascadeOnUpdate();
            $table->string('value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_selected_attributes');
    }
};
