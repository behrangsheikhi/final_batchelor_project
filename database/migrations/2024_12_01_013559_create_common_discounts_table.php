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
        Schema::create('common_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('percentage');
            $table->unsignedBigInteger('discount_ceiling')->nullable()->comment('کف تخفیف');
            $table->unsignedBigInteger('minimum_order_amount')->nullable()->comment('حداقل مقدار سفارش ');
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
        Schema::dropIfExists('common_discounts');
    }
};
