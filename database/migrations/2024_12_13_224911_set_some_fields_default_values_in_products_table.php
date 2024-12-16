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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 10, 2)->nullable()->change();
            $table->decimal('length', 10, 1)->comment('cm unit')->nullable()->change();
            $table->decimal('width', 10, 1)->comment('cm unit')->nullable()->change();
            $table->decimal('height', 10, 1)->comment('cm unit')->nullable()->change();
            $table->unsignedBigInteger('marketable_number')->default(1)->change();
            $table->unsignedBigInteger('sold_number')->default(1)->change();
            $table->unsignedBigInteger('frozen_number')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight', 10, 2)->change();
            $table->decimal('length', 10, 1)->comment('cm unit')->change();
            $table->decimal('width', 10, 1)->comment('cm unit')->change();
            $table->decimal('height', 10, 1)->comment('cm unit')->change();
        });
    }
};
