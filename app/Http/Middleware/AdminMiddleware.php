<?php

namespace App\Http\Middleware;

use App\Constants\UserTypeValue;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
        if (Auth::check() && (Auth::user()->is_admin() || Auth::user()->is_super_admin())) {
            // If user is authorized, proceed with the request
            return $next($request);
        }

        return redirect()->route('app.home')->with('error', 'مجاز به دسترسی به این صفحه نیستید.');
    }
}
