<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductColor;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{

    public function index(Product $product)
    {

        $product = Product::with(['colors' => function ($query) {
            $query->orderByDesc('created_at');
        }])->find($product->id);
        return view('admin.market.product.color.index', compact('product'));
    }

    public function create(Product $product)
    {

        return view('admin.market.product.color.create', compact('product'));
    }

    protected function prepareForValidation(Request $request)
    {
        $request->merge([
            'price_increase' => str_replace(',','',$request->input('price_increase'))
        ]);
    }
    public function store(Request $request, Product $product)
    {

        $this->prepareForValidation($request);
        $request->validate([
            'color_name' => 'required|unique:product_colors,id|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'color' => [
                'nullable',
                'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'
            ],
            'price_increase' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ], [
            'color_name.required' => 'نام رنگ الزامی است.',
            'color_name.unique' => 'نام رنگ تکراری است.',
            'color_name.max' => 'نام رنگ بزرگ تر است از :max characters.',
            'color_name.min' => 'نام رنگ کوچک تر است از :min characters.',
            'color_name.regex' => 'نام رنگ معتبر نیست.',
            'price_increase.required' => 'مقدار افزایش قیمت الزامی است.',
            'price_increase.numeric' => 'مقدار افزایش قیمت باید عدد باشد.',
            'status.required' => 'وضعیت الزامی است.',
            'status.numeric' => 'وضعیت معتبر نیست.',
            'status.in' => 'وضعیت معتبر نیست.',
            'color.regex' => 'رنگ انتخاب شده معتبر نیست.'
        ]);

        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        ProductColor::create($inputs);

        return redirect()->route('admin.market.product.color.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت ایجاد شد.');
    }

    public function edit(Product $product, ProductColor $color)
    {

        return view('admin.market.product.color.edit', compact(['product', 'color']));
    }

    public function update(Request $request, Product $product, ProductColor $color)
    {

        $this->prepareForValidation($request);
        $request->validate([
            'color_name' => 'required|unique:product_colors,id|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'color' => [
                'nullable',
                'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i'
            ],
            'price_increase' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ], [
            'color_name.required' => 'نام رنگ الزامی است.',
            'color_name.unique' => 'نام رنگ تکراری است.',
            'color_name.max' => 'نام رنگ بزرگ تر است از :max characters.',
            'color_name.min' => 'نام رنگ کوچک تر است از :min characters.',
            'color_name.regex' => 'نام رنگ معتبر نیست.',
            'price_increase.required' => 'مقدار افزایش قیمت الزامی است.',
            'price_increase.numeric' => 'مقدار افزایش قیمت باید عدد باشد.',
            'status.required' => 'وضعیت الزامی است.',
            'status.numeric' => 'وضعیت معتبر نیست.',
            'status.in' => 'وضعیت معتبر نیست.',
            'color.regex' => 'رنگ انتخاب شده معتبر نیست.'
        ]);


        $inputs = $request->all();
        $inputs['product_id'] = $product->id;
        $color->update($inputs);
        return redirect()->route('admin.market.product.color.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت ویرایش شد.');
    }

    public function destroy(Product $product, ProductColor $color,)
    {

        $color->delete();

        return redirect()->route('admin.market.product.color.index', $product->id)->with('swal-success', 'رنگ مورد نظر با موفقیت حذف شد.');
    }

    public function status(ProductColor $color)
    {

        $color->status = $color->status === 0 ? 1 : 0;
        $result = $color->save();

        if ($result) {
            $message = $color->status === 0 ? 'رنگ غیرفعال شد' : 'رنگ فعال شد';
            $alertType = $color->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $color->status,
                'message' => $message,
                'alertType' => $alertType
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'مشکلی پیش آمده است.',
                'alertType' => 'error'
            ]);
        }
    }
}
