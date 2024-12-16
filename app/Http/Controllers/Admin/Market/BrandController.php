<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\BrandRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Market\Brand;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Console\Application;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BrandController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $brands = Brand::orderByDesc('created_at')->simplePaginate(15);
        return view('admin.market.brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.market.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.market.brand.index')->with('swal-error', 'بازگزاری لوگوی برند خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        }

        Brand::create($inputs);
        return redirect()->route('admin.market.brand.index')->with('swal-success', 'برند جدید با موفقیت ثبت شد');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {

        return view('admin.market.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand, ImageService $imageService): RedirectResponse
    {

        $inputs = $request->all();
        if ($request->hasFile('logo')) {
            if (!empty($brand->logo)) {
                $imageService->deleteDirectoryAndFiles($brand->logo['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'brand');
            $result = $imageService->createIndexAndSave($request->file('logo'));
            if ($result === false) {
                return redirect()->route('admin.market.brand.index')->with('swal-error', 'آپلود لوگوی برند با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($brand->logo)) {
                $inputs['logo'] = $brand->logo;
                $inputs['logo']['currentImage'] = $inputs['currentImage'];
            }
        }

        $brand->update($inputs);

        return redirect()->route('admin.market.brand.index')->with('swal-success', 'برند جدید با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand): RedirectResponse
    {

        $brand->delete();
        return redirect()->route('admin.market.brand.index')->with('swal-success', 'برند انتخابی با موفقیت حذف شد');
    }

    public function status(Brand $brand)
    {

        $brand->status = $brand->status === 0 ? 1 : 0;
        $result = $brand->save();

        if ($result) {
            $message = $brand->status === 0 ? 'برند غیرفعال شد' : 'برند فعال شد';
            $alertType = $brand->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $brand->status,
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
