<?php

namespace App\Http\Middleware;

use App\Constants\UserTypeValue;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::check() && \Auth::user()->is_vendor()) {
            return $next($request);
        }
        abort(403);
    }
}
