<?php

namespace App\Http\Controllers\Admin\Content;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\PostCategory;
use App\Models\Admin\User\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

//use Website\Http\Services\Image\ImageToolsService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $postCategories = PostCategory::orderByDesc('created_at')->get();
        return view('admin.content.category.index', compact('postCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.content.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCategoryRequest $request, ImageService $imageService): RedirectResponse
    {

        if (auth()->user() && (auth()->user()->user_type == UserTypeValue::SUPER_ADMIN || auth()->user()->user_type == UserTypeValue::ADMIN)) {
            $inputs = $request->all();
            if ($request->hasFile('image')) {
                $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
                $result = $imageService->createIndexAndSave($request->file('image'));
                if ($result === false) {
                    return redirect()->route('admin.content.category.index')->with('swal-error', 'بازگزاری تصویر دسته بندی با خطا مواجه شد');
                }
                $inputs['image'] = $result;
            }

            PostCategory::create($inputs);
            return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی جدید با موفقیت ثبت شد');
        }
        return redirect()->route('app.home')->with('swal-error', 'شما مجاز به این عملیات نیستید.');
    }

    public function edit(PostCategory $postCategory)
    {

        return view('admin.content.category.edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService): RedirectResponse
    {

        $inputs = $request->all();
        if ($request->hasFile('image')) {
            if (!empty($postCategory->image)) {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.category.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($postCategory->image)) {
                $inputs['image'] = $postCategory->image;
                $inputs['image']['currentImage'] = $inputs['currentImage'];
            }
        }
        // for change automatically change the slug by updating the name
        //        $postCategory['slug'] = $request['slug'];

        $postCategory->update($inputs);

        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory): RedirectResponse
    {

        $postCategory->delete();
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف شد');
    }

    public function status(PostCategory $postCategory): JsonResponse
    {

        $postCategory->status = $postCategory->status === 0 ? 1 : 0;
        $result = $postCategory->save();

        if ($result) {
            $message = $postCategory->status === 0 ? 'دسته بندی غیرفعال شد' : 'دسته بندی فعال شد';
            $alertType = $postCategory->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $postCategory->status,
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
