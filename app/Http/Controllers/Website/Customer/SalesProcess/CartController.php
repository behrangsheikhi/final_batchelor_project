<?php

namespace App\Http\Controllers\Website\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\Product;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        if (Auth::check()){

            $cart_items = CartItem::where('user_id',Auth::user()->id)->get();
            $related_products = Product::all();

            return view('app.customer.sales-process.cart',compact(['cart_items','related_products']));
        }else{
            return redirect()->route('customer.auth-form');
        }
    }


    public function addToCart(Product $product, Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'color' => 'nullable|exists:product_colors,id',
                'guaranty' => 'nullable|exists:guarantees,id',
                'number' => 'numeric|min:1|max:' . $product->marketable_number,
            ], [
                'color.exists' => 'رنگ انتخابی موجود نمی باشد',
                'guaranty.exists' => 'گارانتی انتخابی موجود نمی باشد',
                'number.max' => 'تعداد کالای انتخابی بیش از موجودی انبار است.'
            ]);

            // Find all cart items for the current user related to this product
            $cartItems = CartItem::where('product_id', $product->id)->where('user_id', Auth::user()->id)->get();

            // If color or guaranty is not selected, set them to null
            $color = $request->color ?? null;
            $guaranty = $request->guaranty ?? null;

            // Initialize a variable to track whether the product is already in the cart
            $productInCart = false;

            foreach ($cartItems as $cartItem) {
                if ($cartItem->product_color_id == $color && $cartItem->guaranty_id == $guaranty) {
                    $productInCart = true;
                    // Update the existing cart item with the new number
                    $newNumber = $cartItem->number + $request->number;
                    $cartItem->update(['number' => $newNumber]);
                    // Update the product's numbers
                    $product->update([
                        'marketable_number' => $product->marketable_number - $request->number,
                        'frozen_number' => $product->frozen_number + $request->number
                    ]);
                    break; // Exit the loop since we found the product in the cart
                }
            }

            if (!$productInCart) {
                // If the product is not already in the cart, create a new cart item
                $add_to_cart_process = CartItem::create([
                    'product_color_id' => $color,
                    'guaranty_id' => $guaranty,
                    'user_id' => Auth::user()->id,
                    'product_id' => $product->id,
                    'number' => $request->number
                ]);

                if ($add_to_cart_process) {
                    // Update the product's numbers
                    $product->update([
                        'marketable_number' => $product->marketable_number - $request->number,
                        'frozen_number' => $product->frozen_number + $request->number
                    ]);
                    return back()->with('swal-success', 'محصول مورد نظر با موفقیت به سبد خرید اضافه شد');
                }
            }
            return back()->with('swal-success', 'سبد خرید شما با موفقیت ویرایش شد.');
        } else {
            return redirect()->route('customer.auth-form');
        }
    }

    public function ajaxAddToCart(Product $product, Request $request)
    {
        if (Auth::check()) {
            if ($product->marketable_number > 0){
                $request->validate([
                    'color' => 'nullable|exists:product_colors,id',
                    'guaranty' => 'nullable|exists:guarantees,id',
                    'number' => 'numeric|min:1|max:1',
                ], [
                    'color.exists' => 'رنگ انتخابی موجود نمی باشد',
                    'guaranty.exists' => 'گارانتی انتخابی موجود نمی باشد',
                    'number.max' => 'تعداد کالای انتخابی بیش از موجودی انبار است.'
                ]);

                // Find all cart items for the current user related to this product
                $cartItems = CartItem::where('product_id', $product->id)->where('user_id', Auth::user()->id)->get();

                // If color or guaranty is not selected, set them to null
                $color = $request->color ?? null;
                $guaranty = $request->guaranty ?? null;

                // Initialize a variable to track whether the product is already in the cart
                $productInCart = false;

                foreach ($cartItems as $cartItem) {
                    if ($cartItem->product_color_id == $color && $cartItem->guaranty_id == $guaranty) {
                        $productInCart = true;
                        // Update the existing cart item with the new number
                        $newNumber = $cartItem->number + $request->number;
                        $cartItem->update(['number' => $newNumber]);
                        break; // Exit the loop since we found the product in the cart
                    }
                }

                if (!$productInCart) {
                    // Product not found in cart, create a new cart item
                    $add_to_cart_process = CartItem::create([
                        'user_id' => Auth::user()->id,
                        'product_id' => $product->id,
                        'product_color_id' => null,
                        'guaranty_id' => null,
                        'number' => 1, // This should ensure it's not null
                    ]);

                }

                // Update the product's numbers outside the loop
                $product->update([
                    'marketable_number' => $product->marketable_number - 1,
                    'frozen_number' => $product->frozen_number + 1
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'محصول با موفقیت به سبد خرید شما افزوده شد.',
                    'alertType' => 'success'
                ]);
            }else{
                return response()->json([
                    'status' => true,
                    'message' => 'اتمام موجودی کالا در انبار',
                    'alertType' => 'info'
                ]);
            }

        }
        else {
            return response()->json([
                'status' => true,
                'message' => 'ابتدا وارد حساب کاربری خود شوید',
                'alertType' => 'warning'
            ]);
        }
    }



    public function updateCart(Request $request)
    {
        $inputs = $request->all();
        $cart_items = CartItem::where('user_id',Auth::user()->id)->get();
        foreach ($cart_items as $cart_item){
            if(isset($inputs['number'][$cart_item->id])){
                $cart_item->update([
                    'number' => $inputs['number'][$cart_item->id]
                ]);
                // TODO : update the marketable_number and frozen number after updating number or cart item
            }
        }

        return redirect()->route('customer.address-and-delivery');
    }

    public function removeFromCart(CartItem $cartItem)
    {
        try{
            Auth::user();
            $cartItem->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'کالا با موفقیت از سبد خرید حذف شد.',
                'alertType' => 'success'
            ]);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'مشکلی پیش آمده است!',
                'alertType' => 'warning'
            ]);
        }

    }
}
