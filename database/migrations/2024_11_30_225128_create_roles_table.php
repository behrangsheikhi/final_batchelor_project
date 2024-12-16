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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('roles')->insert([
            [
                'name' => 'super-admin',
                'description' => 'بالاترین نوع سطح دسترسی',
                'status' => 0
            ],

            [
                'name' => 'admin',
                'description' => 'سطح دسترسی ادمین',
                'status' => 0
            ],

            [
                'name' => 'writer',
                'description' => 'سطح دسترسی نویسنده سایت',
                'status' => 0
            ],
        ]);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
