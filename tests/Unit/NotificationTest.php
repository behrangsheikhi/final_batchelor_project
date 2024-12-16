<?php

use App\Notifications\NewUserRegistered;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends \Tests\TestCase
{
    use RefreshDatabase;
    public function test_read_all_notifications(): void
    {
        $user = \App\Models\User::factory()->create();
        $user->notify(new NewUserRegistered('hello notifs!'));

        $this->assertCount(1,$user->notifications);
        $controller = new Class{
            public function readAll(): void
            {
                $notifications = Notification::where('read_at', '=', null)->get();
                foreach ($notifications as $notification) {
                    $notification->read_at = now();
                    $notification->save();
                }
            }
        };
        $controller->readAll();
        $this->assertCount(0,$user->fresh()->notifications);
    }
}
