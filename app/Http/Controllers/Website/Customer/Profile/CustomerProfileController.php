<?php

namespace App\Http\Controllers\Website\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AddressRequest;
use App\Models\Admin\Market\Address;
use App\Models\Admin\Market\Compare;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\Product;
use App\Rules\NationalCodeRule;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use League\Config\Exception\ValidationException;
use Mockery\Exception;

class CustomerProfileController extends Controller
{
    public function order()
    {
        $query = Order::whereUserId(Auth::id())->orderByDesc('created_at');
        if (request()->has('type')) { // to list and show specific order type
            $query->whereOrderStatus(request()->type);
        }
        $orders = $query->with('items')->simplePaginate(5); // Adjust the pagination limit as needed

        return view('app.customer.dashboard.order', compact('orders'));
    }

    public function address()
    {
        return view('app.customer.dashboard.address');
    }

    public function addAddress(AddressRequest $request)
    {
        try {
            $user = Auth::user();

            $inputs = $request->all();
            $inputs['user_id'] = $user->id;
            $inputs['address'] = convertPersianToEnglish($request->address);
            $inputs['no'] = convertPersianToEnglish($request->no);
            $inputs['unit'] = convertPersianToEnglish($request->unit);
            $inputs['postal_code'] = convertPersianToEnglish($request->postal_code);
            $inputs['mobile'] = convertPersianToEnglish($request->mobile);

            if (!empty($request->receiver)) {
                $inputs['mobile'] = $request->mobile;
            }
            Address::create($inputs);

            // Redirect back with success message
            return redirect()->back()->with('swal-success', 'آدرس مورد نظر با موفقیت ثبت شد.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }


    public function updateAddress(AddressRequest $request, Address $address)
    {
        try {
            $inputs = $request->all();
            $inputs['user_id'] = Auth::user()->id;
            $inputs['address'] = convertPersianToEnglish($request->address);
            $inputs['no'] = convertPersianToEnglish($request->no);
            $inputs['unit'] = convertPersianToEnglish($request->unit);
            $inputs['postal_code'] = convertPersianToEnglish($request->postal_code);
            if ($request->receiver != 'on') {
                $inputs['recipient_first_name'] = null;
                $inputs['recipient_last_name'] = null;
                $inputs['mobile'] = null;
            }
            $address->update($inputs);

            return redirect()->back()->with('swal-success', 'ویرایش آدرس با موفقیت انجام شد.');
        } catch (Exception $exception) {
            return redirect()->back()->with('error', 'لطفا اطلاعات را دوباره بررسی کرده و سپس امتحان کنید.');
        }
    }

    public function favorite()
    {
        $user = Auth::user();
        $products = $user->products;

        return view('app.customer.dashboard.favorite', compact('products'));
    }

    public function compare()
    {
        $user = Auth::user();
        $compare = Compare::where('user_id', $user->id)->first();
        $user_compare_list = $compare->products;

        return view('app.customer.dashboard.compare', compact('user_compare_list'));
    }

    public function editProfile()
    {
        return view('app.customer.dashboard.index');
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'national_code' => [
                    'required',
                    Rule::unique('users', 'national_code')->ignore(auth()->user()->id),
                    new NationalCodeRule()
                ],
            ], [
                'firstname.required' => 'نام الزامی است.',
                'lastname.required' => 'نام خانوادگی الزامی است.',
                'national_code' => 'کد ملی معتبر نیست.'
            ]);

            // Get validated data from the request
            $validatedData = $request->only(['firstname', 'lastname', 'national_code']);

            // Update user information
            $user = Auth::user();
            $user->update($validatedData);

            return redirect()->back()->with('success', 'مشخصات شما با موفقیت ویرایش شد');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'عملیات ویرایش با خطا مواجه شد، لطفا اطلاعات وارد شده را بررسی کرده و دوباره امتحان کنید!');
        }
    }


    public function deleteFromFavorites(Product $product)
    {
        try {
            // Assuming the user's favorites are stored in a pivot table
            $user = Auth::user();
            $user->products()->detach($product->id);

            // If you need to perform additional actions or validations, you can do so here

            return response()->json([
                'success' => true,
                'message' => 'کالا با موفقیت از لیست علاقه مندی حذف شد.',
                'alertType' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'مشکلی پیش آمده است!',
                'alertType' => 'warning'
            ]);
        }
    }

    public function deleteFromCompare(Request $request)
    {
        try {
            $productId = $request->input('productId');
            $toggle = Auth::user()->compares()->first()->products()->toggle($productId);
            $isAdded = in_array($productId, $toggle['attached']); // Check if product was added

            $message = $isAdded ? 'محصول به لیست مقایسه افزوده شد.' : 'محصول از لیست مقایسه حذف شد.';
            $alertType = $isAdded ? 'success' : 'info';

            return response()->json([
                'status' => true,
                'added' => $isAdded,
                'message' => $message,
                'alertType' => $alertType
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'ابتدا وارد حساب کاربری خود شوید',
                'alertType' => 'warning',
            ]);
        }
    }

}
