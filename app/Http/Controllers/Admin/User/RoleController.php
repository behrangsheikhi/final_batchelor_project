<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\RoleRequest;
use App\Models\Admin\User\Permission;
use App\Models\Admin\User\Role;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderByDesc('created_at')->get();
        return view('admin.user.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::where('status', '=', 1)->get();
        return view('admin.user.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $inputs = $request->all();
        // create the roles
        $role = Role::create($inputs);

        // if permissions are empty send empty
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        // create the selected permissions for this role by sync method(saved in permission_role table)
        $role->permissions()->sync($inputs['permissions']);

        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش مورد نظر با موفقیت ایجاد شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.user.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $inputs = $request->all();
        $role->update($inputs);

        return redirect()->route('admin.user.role.index')->with('swal-success', 'عنوان و توضیحات نقش با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();
        return redirect()->route('admin.user.role.index')->with('swal-success', 'نقش مورد نظر با موفقیت حذف شد');
    }

    public function status(Role $role)
    {
        $role->status = $role->status === 0 ? 1 : 0;
        $result = $role->save();

        if ($result) {
            $message = $role->status === 0 ? 'نقش مورد نظر غیرفعال شد' : 'نقش مورد نظر فعال شد';
            $alertType = $role->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $role->status,
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


    public function permissionForm(Role $role)
    {
        $permissions = Permission::whereStatus(1)->get();
        return view('admin.user.role.setPermission', compact(['role', 'permissions']));
    }

    public function permissionUpdate(RoleRequest $request, Role $role)
    {
        $inputs = $request->only('permissions');
        $inputs['permissions'] = $inputs['permissions'] ?? [];
        $role->permissions()->sync($inputs['permissions']);

        return redirect()->route('admin.user.role.index')->with('swal-success', 'نوع مجوزهای نقش انتخابی با موفقیت ویرایش شد');
    }
}
