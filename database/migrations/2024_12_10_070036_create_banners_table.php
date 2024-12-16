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
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->string('slug', 255);
            $table->text('description')->nullable();
            $table->text('image');
            $table->text('url');
            $table->tinyInteger('position')->default(0)->comment('define in model');
            $table->tinyInteger('visible_in_menu')->default(0)->comment('define in model');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes(); // This automatically adds the `deleted_at` column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
