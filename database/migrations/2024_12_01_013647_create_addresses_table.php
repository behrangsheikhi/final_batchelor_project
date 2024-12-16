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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            // relation with users table
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            // relation with provinces table
            $table->foreignId('province_id')->references('id')->on('provinces')->cascadeOnUpdate();
            // relation with cities table
            $table->foreignId('city_id')->references('id')->on('cities')->cascadeOnUpdate();
            $table->string('postal_code')->unique()->nullable()->comment('کد پستی');
            $table->text('address')->nullable()->comment('مثلا کوچه، کوی، و غیره');
            $table->string('no')->nullable()->comment('طبقه');
            $table->string('unit')->nullable()->comment('واحد');
            $table->string('recipient_first_name')->nullable()->comment('نام دریافت کننده');
            $table->string('recipient_last_name')->nullable()->comment('نام خانوادگی دریافت کننده');
            $table->string('mobile')->nullable();
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
        Schema::dropIfExists('addresses');
    }
};
