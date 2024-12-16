<?php

namespace App\Providers;

use App\Constants\PaymentStatusType;
use App\Models\Admin\Content\Menu;
use App\Models\Admin\Content\Page;
use App\Models\Admin\Market\Brand;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\City;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\ProductCategory;
use App\Models\Admin\Market\Province;
use App\Models\Admin\Setting\Setting;
use App\Models\Comment;
use App\Models\Notification;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('admin/*', function ($view) {
            $view->with('unseen_comments', Comment::where('seen', '0')->orderByDesc('created_at')->get());
            $view->with('notifications', Notification::where('read_at', '=', null)->orderByDesc('created_at')->get());
            $view->with('orders', Order::orderByDesc('created_at')->get());

        });


        view()->composer('app/*',function ($view) {
            if (Auth::check()) {
                $view->with('cart_items',CartItem::where('user_id', Auth::id())->get());
            } else {
                $view->with('cart_items', collect()); // Provide an empty collection if user is not authenticated
            }

            $view->with('menus',ProductCategory::whereStatus(1)->whereParentId(null)->get());
            $view->with('pages',Page::whereStatus(1)->get());
            $view->with('brands',Brand::whereStatus(1)->get());
            $view->with('setting',Setting::first());
            $view->with('product_categories',ProductCategory::whereStatus(1)->get());
            $view->with('provinces',Province::whereStatus(1)->get());
            $view->with('cities',City::whereStatus(1)->get());

        });


    }
}
