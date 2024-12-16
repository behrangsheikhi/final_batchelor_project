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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // relation with users table
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            // relation with addresses table
            $table->foreignId('address_id')->nullable()->references('id')->on('addresses')->cascadeOnUpdate();
            $table->longText('address_object')->nullable()->comment('یک شی از آدرس کاربر که بعدها میتوان استفاده کرد');
            // relation with payments table
            $table->foreignId('payment_id')->nullable()->references('id')->on('payments')->cascadeOnUpdate();
            $table->longText('payment_object')->nullable()->comment('یک شی از نحوه پرداخت کاربر که بعدها میتوان استفاده کرد');
            $table->tinyInteger('payment_type')->default(0)->comment('1 => online, 2 => offline, 3 => cash');
            $table->tinyInteger('payment_status')->default(0)->comment('0 => not returned, 1 => canceled, 2 => paid, 3 => pending');
            // relation with delivery_methods table
            $table->foreignId('delivery_method_id')->nullable()->references('id')->on('delivery_methods')->cascadeOnUpdate();
            $table->longText('delivery_object')->nullable()->comment('یک شی از روش ارسال به کاربر که بعدها میتوان استفاده کرد');
            $table->decimal('delivery_amount', 20, 3)->nullable()->comment('هزینه ارسال');
            $table->tinyInteger('delivery_status')->default(0)->comment('0=>not sent, 1=>sending,2=>sent,3=>delivered');
            $table->timestamp('delivery_date')->nullable();
            $table->decimal('order_final_amount', 20, 3)->nullable()->comment('مجموع نهایی سفارش بدون تخفیف و هزینه ارسال');
            $table->decimal('order_discount_amount', 20, 3)->nullable()->comment('مجموع کل تخفیف');
            // relation with coupons table
            $table->foreignId('coupon_id')->nullable()->references('id')->on('coupons')->cascadeOnUpdate();
            $table->longText('coupon_object')->nullable()->comment('یک شی از کد تحفیف کاربر که بعدها میتوان استفاده کرد');
            $table->decimal('order_coupon_discount_amount',20, 3)->nullable()->comment('مقدار تخفیف کد تخفیف');
            // relation with common_discounts table
            $table->foreignId('common_discount_id')->nullable()->references('id')->on('common_discounts')->cascadeOnUpdate();
            $table->longText('common_discount_object')->nullable()->comment('یک شی از کد تخفیف همگانی به کاربر که بعدها میتوان استفاده کرد');
            $table->decimal('order_common_discount_amount',20, 3)->nullable()->comment('مقدار کل تخفیف عمومی');
            $table->decimal('order_total_products_discount_amount', 20, 3)->nullable()->comment('مقدار کل تخفیف کالاهای سفارش داده شده');
            $table->tinyInteger('order_status')->default(0)->comment('0=>not checked yet,1=>pending for verify,2=>declined,3=>verified,4=>canceled,5=>returned');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
