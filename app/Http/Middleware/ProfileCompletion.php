<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth.form');
        }

        if (!empty(Auth::user()->email) && empty(Auth::user()->mobile) && empty(Auth::user()->email_verified_at)) {
            return redirect()->route('customer.profile.index');
        }

        if (empty(Auth::user()->firstname) || empty(Auth::user()->lastname) || empty(Auth::user()->national_code)) {
            return redirect()->route('customer.profile.index');
        }

        if (!empty(Auth::user()->mobile) && empty(Auth::user()->email) && empty(Auth::user()->mobile_verified_at)) {
            return redirect()->route('customer.profile.index');
        }

        return $next($request);
    }
}
