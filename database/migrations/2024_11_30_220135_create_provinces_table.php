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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
        // remove any record of the provinces and add provinces
        DB::table('provinces')->delete();

        $provinces = [
            [
                'id' => 1,
                "name" => "آذربایجان شرقی",
                "status" => 1,
            ],
            [
                'id' => 2,
                "name" => "آذربایجان غربی",
                "status" => 1,
            ],
            [
                'id' => 3,
                "name" => "اردبیل",
                "status" => 1,
            ],
            [
                'id' => 4,
                "name" => "اصفهان",
                "status" => 1,
            ],
            [
                'id' => 5,
                "name" => "البرز",
                "status" => 1,
            ],
            [
                'id' => 6,
                "name" => "ایلام",
                "status" => 1,
            ],
            [
                'id' => 7,
                "name" => "بوشهر",
                "status" => 1,
            ],
            [
                'id' => 8,
                "name" => "تهران",
                "status" => 1,
            ],
            [
                'id' => 9,
                "name" => "چهارمحال و بختیاری",
                "status" => 1,
            ],
            [
                'id' => 10,
                "name" => "خراسان جنوبی",
                "status" => 1,
            ],
            [
                'id' => 11,
                "name" => "خراسان رضوی",
                "status" => 1,
            ],
            [
                'id' => 12,
                "name" => "خراسان شمالی",
                "status" => 1,
            ],
            [
                'id' => 13,
                "name" => "خوزستان",
                "status" => 1,
            ],
            [
                'id' => 14,
                "name" => "زنجان",
                "status" => 1,
            ],
            [
                'id' => 15,
                "name" => "سمنان",
                "status" => 1,
            ],
            [
                'id' => 16,
                "name" => "سیستان و بلوچستان",
                "status" => 1,
            ],
            [
                'id' => 17,
                "name" => "فارس",
                "status" => 1,
            ],
            [
                'id' => 18,
                "name" => "قزوین",
                "status" => 1,
            ],
            [
                'id' => 19,
                "name" => "قم",
                "status" => 1,
            ],
            [
                "id" => 20,
                "name" => "کردستان",
                "status" => 1,
            ],
            [
                "id" => 21,
                "name" => "کرمان",
                "status" => 1,
            ],
            [
                "id" => 22,
                "name" => "کرمانشاه",
                "status" => 1,
            ],
            [
                "id" => 23,
                "name" => "کهگیلویه و بویراحمد",
                "status" => 1,
            ],
            [
                "id" => 24,
                "name" => "گلستان",
                "status" => 1,
            ],
            [
                "id" => 25,
                "name" => "لرستان",
                "status" => 1,
            ],
            [
                "id" => 26,
                "name" => "گیلان",
                "status" => 1,
            ],
            [
                "id" => 27,
                "name" => "مازندران",
                "status" => 1,
            ],
            [
                "id" => 28,
                "name" => "مرکزی",
                "status" => 1,
            ],
            [
                "id" => 29,
                "name" => "هرمزگان",
                "status" => 1,
            ],
            [
                "id" => 30,
                "name" => "همدان",
                "status" => 1,
            ],
            [
                "id" => 31,
                "name" => "یزد",
                "status" => 1,
            ]
        ];

        DB::table('provinces')->insert($provinces);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
