<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Requests\Admin\Content\PostRequest;
use App\Http\Services\File\FileService;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\Content\Post;
use App\Models\Admin\Content\PostCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $posts = Post::with(['author','category','comments'])->orderByDesc('created_at')->get();
        return view('admin.content.post.index', compact('posts'));
    }

    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $postCategories = PostCategory::orderby('name','asc')->get();
        return view('admin.content.post.create', compact('postCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $postRequest, ImageService $imageService): RedirectResponse
    {


        $user = auth()->user();
        $inputs = $postRequest->all();
        // date fix
        $realTimeStampStart = substr($postRequest->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);

        // upload image
        if ($postRequest->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
        }
        $result = $imageService->createIndexAndSave($postRequest->file('image'));

        if ($result === false) {
            return redirect()->route('admin.content.category.index')->with('swal-error', 'بازگزاری تصویر با خطا مواجه شد');
        }

        $inputs['user_id'] = $user->id;
        Post::create($inputs);
        return redirect()->route('admin.content.post.index')
            ->with('swal-success', 'پست جدید با موفقیت ثبت شد');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        $postCategories = PostCategory::with(['posts'])->orderBy('name', 'asc')->get();
        return view('admin.content.post.edit', compact(['post', 'postCategories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post, ImageService $imageService): RedirectResponse
    {
        try {
            $this->authorize('update-post');
        }catch (AuthorizationException $exception){
            return redirect()->back()->with('swal-error','عملیات غیر مجاز');
        }
        $user = auth()->user();
        $inputs = $request->all();
        // date fix
        $realTimeStampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimeStampStart);

        if ($request->hasFile('image')) {
            if (!empty($post->image)) {
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('admin.content.post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($post->image)) {
                $inputs['image'] = $post->image;
                $inputs['image']['currentImage'] = $inputs['currentImage'];
            }
        }
        $inputs['user_id'] = $user->id;
        // for change automatically change the slug by updating the name
//        $post['slug'] = $request['slug'];
        $post->update($inputs);

        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        try {
            $this->authorize('delete-post');
        }catch (AuthorizationException $exception){
            return redirect()->back()->with('swal-error','عملیات غیر مجاز');
        }
        $post->delete();
        return redirect()->route('admin.content.post.index')->with('swal-success', 'پست با موفقیت حذف شد');
    }

    public function status(Post $post): JsonResponse
    {
        try {
            $this->authorize('status-post', $post);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'status' => true,
                'message' => 'شما مجوز این عملیات را ندارید.',
                'alertType' => 'error'
            ]);
        }

        $post->status = $post->status === 0 ? 1 : 0;
        $result = $post->save();

        if ($result) {
            $message = $post->status === 0 ? 'وضعیت غیرفعال شد' : 'وضعیت فعال شد';
            $alertType = $post->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $post->status,
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

    public function commentable(Post $post): JsonResponse
    {
        try {
            $this->authorize('commentable-post', $post);
        } catch (AuthorizationException $exception) {
            return response()->json([
                'status' => true,
                'message' => 'شما مجوز این عملیات را ندارید.',
                'alertType' => 'error'
            ]);
        }

        $post->commentable = $post->commentable === 0 ? 1 : 0;
        $result = $post->save();

        if ($result) {
            $message = $post->commentable === 0 ? 'ثبت نظر غیرفعال شد' : 'ثبت نظر فعال شد';
            $alertType = $post->commentable === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $post->commentable,
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
