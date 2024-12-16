<?php

namespace Database\Seeders;

use App\Constants\StatusTypeValue;
use App\Constants\UserTypeValue;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProjectFinalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // users table seeder
        $id = Str::uuid()->toString();
        DB::table('users')->insert([
            'id' => $id,
            'email' => 'behisheikhi990@gmail.com',
            'mobile' => '09149736292',
            'firstname' => 'بهرنگ',
            'lastname' => 'شیخی',
            'password' => Hash::make('gods gift1'),
            'user_type' => UserTypeValue::SUPER_ADMIN,
            'status' => StatusTypeValue::ACTIVE,
            'national_code' => '2740233817',
            'email_verified_at' => Carbon::now(),
            'mobile_verified_at' => Carbon::now(),
            'activation' => 1,
            'activation_date' => Carbon::now(),
            'slug' => 'بهرنگ-شیخی',
        ]);

        // roles table seeder

        // permissions seeder


    }
}
