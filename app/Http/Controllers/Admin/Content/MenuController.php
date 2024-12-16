<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\MenuRequest;
use App\Models\Admin\Content\Menu;
use http\Env\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $menus = Menu::orderByDesc('id')->get();
        return view('admin.content.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $menus = Menu::where('parent_id',null)->get();
        return view('admin.content.menu.create', compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Menu $menu, MenuRequest $request): RedirectResponse
    {

        $inputs = $request->all();
        Menu::create($inputs);

        return redirect()->route('admin.content.menu.index')->with('swal-success', 'منو با موفقیت اضافه شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {

        $items = Menu::where('parent_id',null)->get()->except($menu->id);
        return view('admin.content.menu.edit',compact(['menu','items']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRequest $request,Menu $menu): RedirectResponse
    {

        $inputs = $request->all();
        $menu->update($inputs);

        return redirect()->route('admin.content.menu.index')->with('swal-success','منو با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {

        $menu->delete();

        return redirect()->route('admin.content.menu.index')->with('swal-success', 'منو با موفقیت حذف شد');
    }

    public function status(Menu $menu): JsonResponse
    {

        $menu->status = $menu->status === 0 ? 1 : 0;
        $result = $menu->save();

        if ($result) {
            $message = $menu->status === 0 ? 'منو غیرفعال شد' : 'منو فعال شد';
            $alertType = $menu->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $menu->status,
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
