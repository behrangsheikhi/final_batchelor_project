<?php

use App\Constants\UserTypeValue;
use App\Models\Admin\User\Permission;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permission_user', function (Blueprint $table) {
            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['permission_id', 'user_id']);
            $table->timestamp('created_at')->useCurrent();

        });


        // bound admin permissions to user admin
        DB::table('permission_user')->delete();
        $permissions = Permission::whereStatus(1)->get();
        $user = User::where('mobile', '09149736292')
            ->where('email', 'behisheikhi990@gmail.com')
            ->where('user_type', UserTypeValue::SUPER_ADMIN)
            ->first();

        if ($user) {
            // Get the user's ID
            $userId = $user->id;

            // Iterate over permissions and insert them into the pivot table
            foreach ($permissions as $permission) {
                DB::table('permission_user')->insert([
                    'user_id' => $userId,
                    'permission_id' => $permission->id,
                ]);
            }

        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
    }
};
