<?php

namespace App\Http\Controllers\Admin\User;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\AdminUserRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\User\Permission;
use App\Models\Admin\User\Role;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // get management or super admin ( for now it is just one super admin )
        $admins = User::where('user_type', UserTypeValue::SUPER_ADMIN)
            ->orWhere('user_type', UserTypeValue::ADMIN)
            ->orderByDesc('created_at')->get();
        return view('admin.user.admin-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.user.admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminUserRequest $request, ImageService $service): RedirectResponse
    {

        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'admins');
            $result = $service->save($request->file('profile_photo_path'));

            if ($result === false) {
                return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        } else {
            $inputs['profile_photo_path'] = asset('images/users/user-avatar.png');
        }
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = UserTypeValue::SUPER_ADMIN;
        $inputs['activation'] = 0;
        $user = User::create($inputs);

        $details = [
            'message' => 'ادمین جدید در سایت ثبت شد.'
        ];
        $super_admin = User::where('user_type', UserTypeValue::SUPER_ADMIN)
            ->whereMobile('09149736292')
            ->first();
        $super_admin->notify(new NewUserRegistered($details));
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین جدید با موفقیت ثبت شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $admin)
    {

        return view('admin.user.admin-user.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUserRequest $request, ImageService $service, User $admin)
    {

        $inputs = $request->except('password');
        if ($request->hasFile('profile_photo_path')) {
            if (!empty($admin->profile_photo_path)) {
                $service->deleteImage($admin->profile_photo_path);
            }
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'admins');
            $result = $service->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
        if ($request->filled('password')) {
            $inputs['password'] = Hash::make($request->input('password'));
        }
        $admin->update($inputs);

        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'کاربر ادمین با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin, ImageService $service): RedirectResponse
    {

        if ($admin->profile_photo_path) {
            $service->deleteImage($admin->profile_photo_path);
        }
        $admin->forceDelete();

        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'کاربر ادمین با موفقیت حذف شد');
    }

    public function status(User $admin)
    {

        $admin->status = $admin->status === 0 ? 1 : 0;
        $result = $admin->save();

        if ($result) {
            $message = $admin->status === 0 ? 'وضعیت غیرفعال شد' : 'وضعیت فعال شد';
            $alertType = $admin->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $admin->status,
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

    public function activation(User $admin)
    {

        $admin->activation = $admin->activation === 0 ? 1 : 0;
        if ($admin->activation_date == null) {
            $admin->activation_date = now();
        } else {
            $admin->activation_date = null;
        }
        $result = $admin->save();

        if ($result) {
            $message = $admin->activation === 0 ? 'مجوز مدیر غیر فعال شد' : 'مجوز مدیر فعال شد';
            $alertType = $admin->activation === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $admin->activation,
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

    public function roles(User $admin)
    {

        $roles = Role::whereStatus(1)->orderByDesc('name')->get();
        return view('admin.user.admin-user.roles', compact(['admin', 'roles']));
    }

    public function rolesStore(User $admin, Request $request)
    {
        $validated = $request->validate([
            'roles' => 'required|array|exists:' . Role::class . ',id',
        ], [
            'roles.required' => 'نقش معتبر نیست.',
            'roles.exists' => 'نقش معتبر نیست.',
            'roles.array' => 'نقش معتبر نیست.'
        ]);

        try {
            $admin->roles()->sync($request->roles);
            return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'تغییرات با موفقیت ذخیره شد.');
        } catch (AuthorizationException $exception) {
            return redirect()->back()->with('swal-error', 'مشکلی پیش آمده است.');
        }
    }

    public function permissions(User $admin)
    {

        $permissions = Permission::whereStatus(1)->orderByDesc('name')->get();
        return view('admin.user.admin-user.permissions', compact(['admin', 'permissions']));
    }

    public function permissionsStore(User $admin, Request $request)
    {

        $validated = $request->validate([
            'permissions' => 'sometimes|array|exists:' . Permission::class . ',id'
        ], [
            'permissions.array' => 'نوع ورودی معتبر نیست.',
            'permissions.exists' => 'نوع ورودی معتبر نیست.'
        ]);
        try {
            $admin->permissions()->sync($request->permissions);
            return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'تغییرات با موفقیت ذخیره شد.');
        } catch (AuthorizationException $exception) {
            return redirect()->back()->with('swal-error', 'مشکلی پیش آمده است.');
        }

    }

}
