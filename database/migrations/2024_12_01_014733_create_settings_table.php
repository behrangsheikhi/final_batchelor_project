<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
            $table->text('logo')->nullable();
            $table->text('icon')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('email')->nullable();
            $table->timestamps();
        });

        // add setting data
        DB::table('settings')->insert(
            [
                'id' => 1,
                'title' => 'راسته فرش',
                'description' => 'به راسته فرش خوش اومدین',
                'keywords' => 'فرش،گلیم، قالی و محصولات مرتبط در راسته فرش',
                'logo' => 'images/setting/2024/02/06/logo.jpg', // Save relative path
                'icon' => 'images/setting/2024/02/06/icon.jpg', // Save relative path
                'email' => 'test@gmail.com',
                'phone' => '09149736292',
                'address' => 'ارومیه، جاده سلماس، دانشگاه آزاد اسلامی، دانشده فنی و مهندسی، گروه کامپیوتر و فناری اطلاعات'
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
