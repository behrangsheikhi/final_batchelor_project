<?php

namespace App\Http\Controllers\Admin\User;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CustomerUserRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Admin\User\CustomerUser;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $customers = CustomerUser::orderBy('user_type','asc')->get();
        return view('admin.user.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.user.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerUserRequest $request, ImageService $service)
    {

        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'customers');
            $result = $service->save($request->file('profile_photo_path'));

            if ($result === false) {
                return redirect()->route('admin.user.app.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        } else {
            $inputs['profile_photo_path'] = asset('images/users/user-avatar.png');
        }

        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = UserTypeValue::CUSTOMER;

        User::create($inputs);
        $details = [
            'message' => 'یک کاربر جدید در سایت ثبت نام کرد.'
        ];
        $super_admin = User::where('user_type',UserTypeValue::SUPER_ADMIN)->first();
        $super_admin->notify(new NewUserRegistered($details));
        return redirect()->route('admin.user.app.index')->with('swal-success', 'کاربر مشتری جدید با موفقیت ثبت شد');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {

        return view('admin.user.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerUserRequest $request, ImageService $service, User $customer)
    {

        $inputs = $request->except('password');
        if ($request->hasFile('profile_photo_path')) {
            if (!empty($customer->profile_photo_path)) {
                $service->deleteImage($customer->profile_photo_path);
            }
            $service->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . 'customers');
            $result = $service->save($request->file('profile_photo_path'));
            if ($result === false) {
                return redirect()->route('admin.user.app.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
        if ($request->filled('password')){
            $inputs['password'] = Hash::make($request->input('password'));
        }
        $customer->update($inputs);

        return redirect()->route('admin.user.app.index')->with('swal-success', 'کاربر ادمین با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer,ImageService $service): RedirectResponse
    {

        if ($customer->profile_photo_path){
            $service->deleteImage($customer->profile_photo_path);
        }
        $customer->forceDelete();

        return redirect()->route('admin.user.app.index')->with('swal-success', 'مشتری مورد نظر با موفقیت حذف شد');
    }

    public function status(User $customer)
    {

        $customer->status = $customer->status === 0 ? 1 : 0;
        $result = $customer->save();

        if ($result) {
            $message = $customer->status === 0 ? 'وضعیت غیرفعال شد' : 'وضعیت فعال شد';
            $alertType = $customer->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $customer->status,
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


    public function activation(User $customer)
    {

        $customer->activation = $customer->activation === 0 ? 1 : 0;
        if ($customer->activation_date == null) {
            $customer->activation_date = now();
        } else {
            $customer->activation_date = null;
        }
        $result = $customer->save();

        if ($result) {
            $message = $customer->activation === 0 ? 'مجوز مشتری غیر فعال شد' : 'مجوز مشتری فعال شد';
            $alertType = $customer->activation === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $customer->activation,
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
