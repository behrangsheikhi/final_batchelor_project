<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param string $roles
     * @param string|null $permission
     * @return Response
     */
// Middleware
    public function handle(Request $request, Closure $next, string $roles, ?string $permission = null): Response
    {
        if (Auth::check()) {
            // Check if the user has any of the specified roles
            $rolesArray = explode('|', $roles);
            foreach ($rolesArray as $role) {
                if ($request->user()->has_any_role([$role])) {
                    // If the user has the role and permission is null, allow access
                    if ($permission === null) {
                        return $next($request);
                    }
                    // If permission is not null, check if the user has the permission
                    elseif ($request->user()->can($permission)) {
                        return $next($request);
                    } else {
                        // If user doesn't have the permission, abort with 403
                        abort(403, 'دسترسی غیر مجاز');
                    }
                }
            }

            // If the user doesn't have any of the specified roles, abort with 403
            abort(403, 'دسترسی غیر مجاز.');
        }

        // If the user is not authenticated, redirect to the authentication form
        return redirect()->route('admin.auth-form');
    }


}
