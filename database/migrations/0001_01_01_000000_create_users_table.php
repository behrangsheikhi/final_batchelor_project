<?php

use App\Constants\UserTypeValue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Psy\Util\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique();
            $table->string('password')->nullable();
            $table->string('national_code')->unique()->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('slug')->unique()->nullable()->comment('mixture of firstname and lastname'); // mixture of firstname and lastname
            $table->text('profile_photo_path')->nullable()->comment('avatar');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->tinyInteger('activation')->default(0)->comment('0 is inactive,1 is active'); //before confirmation
            $table->timestamp('activation_date')->nullable();
            $table->tinyInteger('user_type')->default(0)->comment('1 for super_admin, 2 for admin, 3 for app, 4 for normal user, 5 for vendor');
            $table->tinyInteger('status')->default('0'); // after confirmation
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        DB::table('users')->where('id','=',1)->delete();
        DB::table('users')->insert([
            'id' => 1,
            'email' => 'behisheikhi990@gmail.com',
            'mobile' => '09149736292',
            'password' => Hash::make('gods gift1'),
            'national_code' => '2740233817',
            'firstname' => 'بهرنگ',
            'lastname' => 'شیخی',
            'activation' => 1,
            'status' => 1,
            'user_type' => UserTypeValue::SUPER_ADMIN,
            'email_verified_at' => Carbon::now(),
            'activation_date' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
