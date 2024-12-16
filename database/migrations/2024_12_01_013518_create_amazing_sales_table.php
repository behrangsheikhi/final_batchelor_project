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
        Schema::create('amazing_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnUpdate();
            $table->integer('percentage')->comment('درصد تخفیف');
            $table->tinyInteger('status')->default(0);
            $table->timestamp('start_date')->useCurrent()->comment('تاریخ شروع');
            $table->timestamp('end_date')->useCurrent()->comment('تاریخ پایان');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazing_sales');
    }
};
