<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Admin\Content\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'Website\Models\Model' => 'Website\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {


    }
}
