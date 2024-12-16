<?php

namespace App\Listeners;

use App\Constants\UserTypeValue;
use App\Models\Admin\Content\Post;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateAuthorOnPostDeletion
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(User $user): void
    {
//        $first_admin = User::where('user_type',UserTypeValue::SUPER_ADMIN)->first();
//        if($first_admin){
//            Post::where('author_id',$user->id)->update(['author_id',$first_admin->id]);
//        }
    }
}
