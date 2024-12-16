<?php

namespace App\Http\Controllers\Admin;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin() || Auth::user()->is_super_admin()) {
                return view('admin.index');
            } elseif (Auth::user()->is_customer()) {
                return view('app.customer.dashboard.index');
            }
            return redirect()->route('admin.auth-form');
        }

    }
}
