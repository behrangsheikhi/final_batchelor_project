<?php

namespace App\Http\Controllers\Admin\Market;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Market\Brand;
use App\Models\Admin\Market\Product;
use App\Models\Admin\Market\ProductCategory;
use App\Models\Admin\Market\ProductMeta;
use App\Models\Admin\Market\Vendor;
use App\Models\User;
use App\Notifications\NewProductCreated;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::orderByDesc('created_at')->get();
        return view('admin.market.product.index', compact(['products']));
    }

    public function create()
    {

        $categories = ProductCategory::whereStatus(1)->get();
        $brands = Brand::whereStatus(1)->get();
        $products = Product::whereStatus(1)->get();

        return view('admin.market.product.create',compact(['categories','brands']));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request, ImageService $service)
    {

        $inputs = $request->all();
        // date fix
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);

        if ($request->hasFile('image')) {
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $service->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.market.product.index')->with('swal-error', 'بارگزاری تصویر محصول با مشکل مواجه شد.');
            }
            $inputs['image'] = $result;
        }
//        dd($inputs);

        // here we use transaction, so it should make records both not one of them!
        DB::transaction(function () use ($inputs, $request) {
            $product = Product::create($inputs);
            // when product created insert into product_meta table
            $metas = array_combine($request->meta_key, $request->meta_value);
            foreach ($metas as $key => $meta) {
                ProductMeta::create([
                    'meta_key' => $key,
                    'meta_value' => $meta,
                    'product_id' => $product->id
                ]);
            }
        });
        $details = [
            'message' => 'محصول جدید در سایت بارگزاری شد.'
        ];
        $super_admin = User::where('user_type',UserTypeValue::SUPER_ADMIN)->first();
        $super_admin->notify(new NewProductCreated($details));

        return redirect()->route('admin.market.product.index')->with('swal-success', 'کالای مورد نظر با موفقیت ایجاد شد.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $categories = ProductCategory::whereStatus(1)->get();
        $brands = Brand::whereStatus(1)->get();

        return view('admin.market.product.edit', compact(['product', 'brands', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product, ImageService $service)
    {

        $inputs = $request->all();
        // date fix
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);
        if ($request->hasFile('image')) {
            if (!empty($product->image)) {
                $service->deleteDirectoryAndFiles($product->image['directory']);
            }
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product');
            $result = $service->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.market.product.index')->with('swal-error', 'بارگزاری تصویر با مشکل مواجه شد.');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($product->image)) {
                $image = $product->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        DB::transaction(function () use ($inputs, $request, $product) {
            // Remove meta fields that were not in the updated list
            $meta_keys = $request->meta_key;
            $existing_meta_keys = $product->metas->pluck('meta_key')->toArray();
            if ($meta_keys != null){
                $meta_keys_to_remove = array_diff($existing_meta_keys, $meta_keys);
                ProductMeta::whereIn('meta_key', $meta_keys_to_remove)->delete();

                // Update/Insert meta fields
                $metas = array_combine($request->meta_key, $request->meta_value);
                foreach ($metas as $key => $meta) {
                    if ($meta != null) { // Skip empty meta fields
                        $product->metas()->updateOrCreate(
                            ['meta_key' => $key],
                            ['meta_value' => $meta]
                        );
                    }
                }
            }

            $product->update($inputs);
        });
        return redirect()->route('admin.market.product.index')->with('swal-success', 'کالای مورد نظر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        if ($product->metas())
            $product->metas()->delete();
        $product->delete();

        return redirect()->route('admin.market.product.index')->with('swal-success', 'کالای مورد نظر با موفقیت حذف شد.');
    }

    public function status(Product $product)
    {

        $product->status = $product->status === 0 ? 1 : 0;
        $result = $product->save();

        if ($result) {
            $message = $product->status === 0 ? 'کالا غیرفعال شد' : 'کالا فعال شد';
            $alertType = $product->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $product->status,
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

    public function marketable(Product $product)
    {

        $product->marketable = $product->marketable === 0 ? 1 : 0;
        $result = $product->save();

        if ($result) {
            $message = $product->marketable === 0 ? 'امکان خرید غیرفعال شد.' : 'امکان خرید فعال شد';
            $alertType = $product->marketable === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $product->marketable,
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
