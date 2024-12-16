<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert(
            [
                'id' => 1,
                'title' => 'راسته فرش',
                'description' => 'به راسته فرش خوش اومدین',
                'keywords' => 'فرش،گلیم، قالی و محصولات مرتبط در راسته فرش',
                'logo' => public_path('images\setting\2023\04\07\logo.jpg'),
                'icon' => public_path('images\setting\2023\04\07\icon.jpg'),
                'email' => 'test@gmail.com',
                'phone' => '09388199203',
                'address' => 'ارومیه،شهرک شهریار'
            ]
        );

    }
}
