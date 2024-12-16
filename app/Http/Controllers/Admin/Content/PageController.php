<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PageRequest;
use App\Models\Admin\Content\Page;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pages = Page::orderByDesc('created_at')->get();
        return view('admin.content.page.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.content.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PageRequest $request): RedirectResponse
    {

        $inputs = $request->all();
        Page::create($inputs);

        return redirect()->route('admin.content.page.index')->with('swal-success','صفحه با موفقیت ایجاد شد');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {

        return view('admin.content.page.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PageRequest $request,Page $page): RedirectResponse
    {

        $inputs = $request->all();
        $page->update($inputs);

        return redirect()->route('admin.content.page.index')->with('swal-success','صفحه مورد نظر با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {

        $page->delete();
        return redirect()->route('admin.content.page.index')->with('swal-success','صفحه با موفقیت حذف شد');
    }

    public function status(Page $page): JsonResponse
    {

        $page->status = $page->status === 0 ? 1 : 0;
        $result = $page->save();

        if ($result) {
            $message = $page->status === 0 ? 'صفحه مورد نظر غیرفعال شد' : 'صفحه مورد نظر فعال شد';
            $alertType = $page->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $page->status,
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

    public function showInMenu(Page $page): JsonResponse
    {

        $page->show_in_menu = $page->show_in_menu === 0 ? 1 : 0;
        $result = $page->save();

        if ($result) {
            $message = $page->show_in_menu === 0 ? 'صفحه مورد نظر از منو حذف گردید' : 'صفحه مورد نظر در منو قرار گرفت';
            $alertType = $page->show_in_menu === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $page->show_in_menu,
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
