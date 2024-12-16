<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\PostCategory;
use App\Models\Admin\Market\ProductCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = ProductCategory::orderByDesc('created_at')->get();
        return view('admin.market.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = ProductCategory::whereParentId(null)->whereDeletedAt(null)->get();
        return view('admin.market.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request, ImageService $service)
    {

        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $service->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.market.category.index')->with('swal-error', 'بارگزاری تصویر با مشکل مواجه شد.');
            }
            $inputs['image'] = $result;
        }

        ProductCategory::create($inputs);
        return redirect()->route('admin.market.category.index')->with('swal-success','دسته بندی جدید با موفقیت ایجاد شد.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {

        $categories = ProductCategory::all()->except($category->id);
        return view('admin.market.category.edit', compact(['category','categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, ProductCategory $category, ImageService $service)
    {

        $inputs = $request->all();

        if ($request->hasFile('image')) {
            if (!empty($category->image)) {
                $service->deleteDirectoryAndFiles($category->image['directory']);
            }
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $service->createIndexAndSave($request->file('image'));

            if ($result === false) {
                return redirect()->route('admin.market.category.index')->with('swal-error', 'بارگزاری تصویر با مشکل مواجه شد.');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($category->image)) {
                $inputs['image'] = $category->image;
                $inputs['image']['currentImage'] = $inputs['currentImage'];
            }
        }

        $category->update($inputs);
        return redirect()->route('admin.market.category.index')->with('swal-success', 'عملیات ویرایش دسته بندی با موفقیت انجام شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {

        $category->delete();
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته بندی انتخابی با موفقیت حذف شد.');
    }

    public function status(ProductCategory $category): JsonResponse
    {

        $category->status = $category->status === 0 ? 1 : 0;
        $result = $category->save();

        if ($result) {
            $message = $category->status === 0 ? 'وضعیت غیرفعال شد' : 'وضعیت فعال شد';
            $alertType = $category->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $category->status,
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

    public function showInMenu(ProductCategory $category): JsonResponse
    {

        $category->show_in_menu = $category->show_in_menu === 0 ? 1 : 0;
        $result = $category->save();

        if ($result) {
            $message = $category->show_in_menu === 0 ? 'دسته بندی کالا از منو حذف شد' : 'دسته بندی کالا در منو قرار گرفت';
            $alertType = $category->show_in_menu === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $category->show_in_menu,
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
