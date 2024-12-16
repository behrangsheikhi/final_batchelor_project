<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Models\Admin\Ticket\TicketAdmin;
use App\Models\Admin\User\AdminUser;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use function PHPUnit\Framework\directoryExists;

class TicketAdminController extends Controller
{

    public function index()
    {

        $admins = User::where('user_type', UserTypeValue::SUPER_ADMIN)
            ->where('user_type',UserTypeValue::ADMIN)
            ->where('activation','=','1')
            ->orWhere('status','=','1')
            ->get();
        return view('admin.ticket.admin.index', compact('admins'));
    }

    public function set(User $admin)
    {
        try {
            $this->authorize('set-ticket-admin');
        } catch (AuthorizationException $exception) {
            return redirect()->back()->with('swal-error', 'عملیات غیر مجاز');
        }
        TicketAdmin::where('user_id', $admin->id)->first() ? TicketAdmin::where('user_id', $admin->id)->forceDelete() : TicketAdmin::create(['user_id' => $admin->id]);
        return redirect()->route('admin.ticket.admin.index')->with('swal-success', 'عملیات با موفقیت انجام شد');
    }
}
