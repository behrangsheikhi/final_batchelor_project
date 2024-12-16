<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;

//use Website\Http\Requests\Admin\Market\ProductGalleryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Market\Gallery;
use App\Models\Admin\Market\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product, Gallery $gallery)
    {

        return view('admin.market.product.gallery.index', compact(['product', 'gallery']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {

        return view('admin.market.product.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ImageService $service, Product $product)
    {

        $messages = [
            'image.*.required' => 'وارد کردن تصویر الزامی است.',
            'image.*.image' => 'فایل باید تصویر باشد.',
            'image.*.mimes' => 'فرمت تصویر باید یکی از jpg، jpeg، png یا gif باشد.',
            'product_id.exists' => 'محصول مورد نظر یافت نشد.',
        ];

        $validator = Validator::make($request->all(), [
            'image.*' => 'required|image|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml|max:4096',
            'product_id' => 'exists:' . Product::class . ',id'
        ], $messages);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'status' => false,
                'message' => 'لطفاً اطلاعات ورودی را چک کنید.',
                'errors' => $validator->errors(),
                'alertType' => 'error'
            ]);
        }

        $images = [];
        $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-gallery');
        if ($request->hasFile('image')) {
            $files = $request->file('image.*');
            foreach ($files as $file) {
                $result = $service->createGalleryImages($file);
                if ($result === false) {
                    return response()->json([
                        'status' => false,
                        'message' => 'آپلود تصویر با مشکل مواجه شد.',
                        'alertType' => 'error'
                    ]);
                }
                $inputs['product_id'] = $product->id;
                $inputs['image'] = $result;
                $gallery = Gallery::create($inputs);
                $images[] = $gallery;
            }

            return response()->json([
                'status' => true,
                'message' => 'آپلود تصاویر با موفقیت انجام شد.',
                'images' => $images,
                'alertType' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'هنوز تصویری انتخاب نکرده اید.',
                'alertType' => 'warning'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {

        $gallery->delete();
        return redirect()->route('admin.market.product.gallery.index', $gallery->product->id)->with('swal-success', 'تصویر انتخابی با موفقیت حذف شد.');
    }
}
