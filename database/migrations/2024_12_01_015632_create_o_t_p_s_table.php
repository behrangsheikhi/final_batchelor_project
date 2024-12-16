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
        Schema::create('o_t_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->string('otp_code');
            $table->string('identity')->nullable()->comment('کاربر با چی وارد شده');
            $table->string('type')->default('mobile')->comment('this can be mobile or email');
            $table->tinyInteger('used')->default('0')->comment('0=> not used,1=> used');
            $table->tinyInteger('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('o_t_p_s');
    }
};
