<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\BannerRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\Banner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $banners = Banner::orderByDesc('created_at')->get();
        $positions = Banner::$position;
        return view('admin.content.banner.index',compact(['banners','positions']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $positions = Banner::$position;
        return view('admin.content.banner.create',compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request,ImageService $service)
    {

        $inputs = $request->all();
        if($request->hasFile('image')){
            $service->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'banner');
//            $result = $service->createIndexAndSave($request->file('image'));
            $result = $service->save($request->file('image'));
            if(!$result){
                return redirect()->route('admin.content.banner.index')->with('swal-error','آپلود تصویر با خطا مواجه شد.');
            }
            $inputs['image'] = $result;
        }
        Banner::create($inputs);
        return redirect()->route('admin.content.banner.index')->with('swal-success','بنر با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {

        return view('admin.content.banner.show',compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {

        $positions = Banner::$position;
        return view('admin.content.banner.edit',compact(['banner','positions']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request,ImageService $service,Banner $banner)
    {

        $inputs = $request->all();
        if($request->hasFile('image')){
            if (!empty($banner->image)){
                $service->deleteImage($banner->image);
            }
            $service->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'banner');
//            $result = $service->createIndexAndSave($request->file('image'));
            $result = $service->save($request->file('image'));
            if(!$result){
                return redirect()->route('admin.content.banner.index')->with('swal-error','آپلود تصویر با خطا مواجه شد.');
            }
            $inputs['image'] = $result;
        }else{
            if (isset($inputs['currentImage']) && !empty($banner->image)){
                $image = $banner->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $banner->update($inputs);
        return redirect()->route('admin.content.banner.index')->with('swal-success','بنر با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {

        $banner->delete();
        return redirect()->route('admin.content.banner.index')->with('swal-success', 'بنر با موفقیت حذف شد');

    }

    public function status(Banner $banner)
    {

        $banner->status = $banner->status === 0 ? 1 : 0;
        $result = $banner->save();

        if ($result) {
            $message = $banner->status === 0 ? 'بنر غیرفعال شد' : 'بنر فعال شد';
            $alertType = $banner->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $banner->status,
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