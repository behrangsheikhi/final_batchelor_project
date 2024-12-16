<?php

namespace App\Http\Controllers\Website\Customer;

use App\Http\Controllers\Controller;
use App\Models\Admin\Content\Banner;
use App\Models\Admin\Content\Page;
use App\Models\Admin\Market\Brand;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductCategory;
use App\Models\Admin\Setting\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        // banners
        $slideshow_images = Banner::where('position', 1)->where('status', 1)->get();
        $top_banners = Banner::where('position', 2)->where('status', 1)->take(2)->get();
        $middle_banners = Banner::where('position', 3)->where('status', 1)->take(2)->get();
        $bottom_banner = Banner::where('position', 4)->where('status', 1)->first();

        // brands
        $brands = Brand::orderByDesc('created_at')->get();


        // TODO : WORK ON THESE QUERIES
        $most_visited_products = Product::latest()
            ->whereMarketable(1)
            ->whereStatus(1)
            ->take(5)
            ->where('view', '>=', '10')
            ->get();

        $suggested_products = Product::latest()
            ->whereMarketable(1)
            ->where('status', 1)
            ->take(5)
            ->get();

        $setting = Setting::first();

        $product_categories = ProductCategory::whereStatus(1)
            ->orderByDesc('created_at')
            ->get();
        return view('app.home', compact([
            'slideshow_images',
            'top_banners',
            'middle_banners',
            'bottom_banner',
            'most_visited_products',
            'suggested_products',
            'setting',
            'product_categories'
        ]));
    }

    public function products(Request $request, ProductCategory $category = null)
    {
        if ($category) {
            $product_model = $category->products();
        } else {
            $product_model = new Product();
        }

        // getting brands
        $brands = Brand::whereStatus(1)->get();

        // getting product categories
        $categories = ProductCategory::whereStatus(1)->whereNull('parent_id')->get();

        // Assign search item, handling potential null
        $searchItem = $request->search ?? null;

        // Create title dynamically
        $title = $searchItem ? "جستجو برای: $searchItem" : 'جستجو';

        // Initialize column and direction variables
        $column = 'created_at';
        $direction = 'ASC';

        // Determine column and direction based on sort option
        switch ($request->sort) {
            case '1':
                $column = 'created_at';
                $direction = 'DESC';
                break;

            case '2':
                $column = 'most_favorite';
                $direction = 'DESC';
                break;

            case '3':
                $column = 'price';
                $direction = 'DESC';
                break;

            case '4':
                $column = 'price';
                $direction = 'ASC';
                break;

            case '5':
                $column = 'view';
                $direction = 'DESC';
                break;

            case '6':
                $column = 'sold_number';
                $direction = 'DESC';
                break;

            default:
                $column = 'created_at';
                $direction = 'ASC';
                break;
        }

        if ($request->search) {
            $query = $product_model->whereMarketable(1)
                ->where('name', 'like', '%' . $request->search . '%')
                ->orderBy($column, $direction);
        } else {
            $query = $product_model->whereMarketable(1)
                ->orderBy($column, $direction);
        }


        $products = $query->orderBy($column, $direction)
            ->when($request->max_price && $request->min_price, function ($query) use ($request) {
                $query->whereBetween('price', [$request->min_price, $request->max_price]);
            })
            ->when($request->min_price, function ($query) use ($request) {
                $query->where('price', '>=', $request->min_price);
            })
            ->when($request->max_price, function ($query) use ($request) {
                $query->where('price', '<=', $request->max_price);
            })
            ->when($request->brands, function ($query) use ($request) {
                $query->whereIn('brand_id', $request->brands);
            })
            ->paginate(12);

        $products = $products->appends($request->query());
        // get selected brands
        $selected_brands_array = [];
        if ($request->brands) {
            $selected_brands = Brand::find($request->brands);
            foreach ($selected_brands as $selected_brand) {
                $selected_brands_array[] = $selected_brand->persian_name;
            }
        }


        return view('app.customer.market.product.products', compact([
            'products',
            'brands',
            'categories',
            'searchItem',
            'selected_brands_array'
        ]));
    }

    public function page(Page $page)
    {
        return \view('app.pages.page', compact(['page']));
    }
}
