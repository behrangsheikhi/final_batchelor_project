<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\PermissionRequest;
use App\Models\Admin\User\Permission;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $permissions = Permission::orderByDesc('created_at')->get();
        return view('admin.user.permission.index',compact('permissions'));
    }

    public function status(Permission $permission)
    {

        $permission->status = $permission->status === 0 ? 1 : 0;
        $result = $permission->save();

        if ($result) {
            $message = $permission->status === 0 ? 'مجوز مورد نظر غیرفعال شد' : 'مجوز مورد نظر فعال شد';
            $alertType = $permission->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $permission->status,
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        $inputs = $request->all();
        Permission::create($inputs);

        return redirect()->route('admin.user.permission.index')->with('swal-success','مجوز مورد نظر ب موفقیت ایجاد شد.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.user.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $inputs = $request->all();
        $permission->update($inputs);

        return redirect()->route('admin.user.permission.index')->with('swal-success','سطح دسترسی مورد نظر با موفقیت ویرایش و ذخیره شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.user.permission.index')->with('swal-success','مجوز مورد نظر با موفقیت حذف شد.');
    }
}
