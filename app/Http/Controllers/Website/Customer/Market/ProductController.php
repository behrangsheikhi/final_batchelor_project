<?php

namespace App\Http\Controllers\Website\Customer\Market;

use App\Constants\CommentTypeValue;
use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductCategory;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentCreated;
use DB;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Collection;

class ProductController extends Controller
{

    public function product(Product $product)
    {
        // TODO : LATER WE WILL COMPLETE THIS RELATED PRODUCTS BY LAZY LOADING
        $related_products = Product::with('category')->whereHas('category',function ($query) use ($product){
            $query->where('id',$product->category->id);
        })->whereStatus(1)->get()->except($product->id);

        $product->view += 1;
        $product->save();
        return view('app.customer.market.product.product', compact(['product', 'related_products']));
    }

    public function addComment(Product $product, Request $request)
    {
        $author = auth()->user();
        $request->validate([
            'body' => 'required|max:1000|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&!! ؟?)(]+$/u',
        ]);

        $inputs['body'] = str_replace(PHP_EOL, '<br>', $request->body);
        $inputs['author_id'] = $author->id;
        $inputs['commentable_id'] = $product->id;
        $inputs['commentable_type'] = CommentTypeValue::PRODUCT_COMMENT;
        Comment::create($inputs);

        // notify super admin that the user has been registered
        $super_admin = User::whereUserType(UserTypeValue::SUPER_ADMIN)->first();
        $details = [
            'message' => 'نظر جدید ثبت شد!'
        ];
        $super_admin?->notify(new NewCommentCreated($details));
        return back()->with('swal-success', 'نظر شما ثبت شد و پس از تایید مدیر نمایش داده خواهد شد.');
    }

    public function addToCompare(Product $product)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $compare = $user->compares()->firstOrCreate([]); // Get or create the user's comparison instance

            $toggle = $compare->products()->toggle($product->id); // Toggle product in comparison
            $isAdded = in_array($product->id, $toggle['attached']); // Check if product was added

            $message = $isAdded ? 'محصول به لیست مقایسه افزوده شد.' : 'محصول از لیست مقایسه حذف شد.';
            $alertType = $isAdded ? 'success' : 'info';

            return response()->json([
                'status' => true,
                'added' => $isAdded,
                'message' => $message,
                'alertType' => $alertType
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'ابتدا وارد حساب کاربری خود شوید',
                'alertType' => 'warning',
            ]);
        }
    }


    public function addToFavorite(Product $product)
    {
        if (Auth::check()) {
            $product->users()->toggle([Auth::user()->id]); // Toggle relationship efficiently

            $message = $product->users->contains(Auth::user()->id)
                ? 'محصول به علاقه مندی ها افزوده شد.'
                : 'محصول از علاقه مندی ها حذف شد.';
            $alertType = $product->users->contains(Auth::user()->id)
                ? 'success'
                : 'info';

            return response()->json([
                'status' => true,
                'added' => $product->users->contains(Auth::user()->id),
                'message' => $message,
                'alertType' => $alertType
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'ابتدا وارد حساب کاربری خود شوید',
                'alertType' => 'warning',
            ]);
        }

    }

    public function productCategory(ProductCategory $category)
    {
        $products = $category->products()->paginate(12);
        return view('app.customer.market.product.products', compact(['category','products']));
    }

    public function rating(Request $request, Product $product)
    {
        $product_ids = Auth::user()->is_user_purchased_this_product($product->id);
        if (Auth::check() && $product_ids->count() > 0) {
            Auth::user()->rate($product, $request->rating);

            return \response()->json([
                'status' => 200,
                'message' => 'امتیاز شما با موفقیت ثبت شد.',
                'alertType' => 'success'
            ]);
        } else {
            return \response()->json([
                'status' => 200,
                'message' => 'شما خریدار این محصول نبوده اید، لذا نمی توانید امتیاز ثبت کنید.',
                'alertType' => 'warning'
            ]);
        }

    }

    public function ajaxProductSearch(Request $request)
    {
        $search = $request->input('search');

        // Validate input
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Search for products
        $products = Product::where('name', 'like', '%' . $search . '%')->get(['id', 'name']);
        return response()->json([
            'data' => $products
        ]);
    }




}
