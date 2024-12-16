<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;

class NotificationController extends Controller
{

    public function readAll()
    {
        $notifications = Notification::where('read_at','=',null)->get();
        foreach ($notifications as $notification){
            $notification->read_at = now();
            $notification->save();
        }
    }

    public function index()
    {
        $notifications = Notification::all()->toArray();
        return view('admin.notification.index',compact('notifications'));
    }
}
