<?php

namespace Database\Seeders;

use Faker\Provider\Uuid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                'id' =>16,
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
}
