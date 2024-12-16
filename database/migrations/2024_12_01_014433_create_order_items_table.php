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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // relation with orders table
            $table->foreignId('order_id')->references('id')->on('orders')->cascadeOnUpdate();
            // relation with products table
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->longText('product_object')->comment('جهت ذخیره شی ای از محصولی که کاربر سفارش داده جهت استفاده های بعدی');
            //relation with amazing-sales table
            $table->foreignId('amazing_sale_id')->nullable()->references('id')->on('amazing_sales')->cascadeOnUpdate();
            $table->longText('amazing_sale_object')->comment('جهت ذخیره شی تخفیف شگفت انگیزی که به مشتری داده شده است.');
            $table->decimal('amazing_sale_discount_amount',20, 3)->nullable();
            $table->integer('number')->default(1);
            $table->decimal('final_product_price',20, 3)->nullable();
            $table->decimal('final_total_price',20, 3)->nullable()->comment('number * final_product_price');
            // relation with product_colors table
            $table->foreignId('color_id')->nullable()->references('id')->on('product_colors')->cascadeOnUpdate();
            // relation with guarantees table
            $table->foreignId('guaranty_id')->nullable()->references('id')->on('guaranties')->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
