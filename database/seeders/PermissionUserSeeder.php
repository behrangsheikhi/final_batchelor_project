<?php

namespace Database\Seeders;

use App\Constants\UserTypeValue;
use App\Models\Admin\User\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
}
