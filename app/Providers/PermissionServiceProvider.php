<?php

namespace App\Providers;

use App\Models\Admin\User\Permission;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try {
            // Fetch permissions from cache or database
            $permissions = Cache::remember('permission', now()->addSeconds(60), function () {
                return Permission::get();
            });

            // Define gates based on permissions
            $permissions->each(function ($permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    return $user->has_permission_to($permission);
                });
            });
        } catch (AuthorizationException $exception) {
            // Handle authorization exception
            Log::error('Error defining gate: ' . $exception->getMessage());
            abort(403, 'خطا در دسترسی. لطفا با پشتیبانی تماس بگیرید.');
        }

        Blade::directive('role', function ($role) {
            return "<?php if (auth()->check() && auth()->user()->has_role($role)) :  ?>";
        });

        Blade::directive('endrole', function ($role) {
            return "<?php endif; ?>";
        });

        Blade::directive('permission', function ($permission) {
            return "<?php if (auth()->check() && auth()->user()->has_permission($permission)) :  ?>";
        });

        Blade::directive('endpermission', function ($permission) {
            return "<?php endif; ?>";
        });

    }
}
