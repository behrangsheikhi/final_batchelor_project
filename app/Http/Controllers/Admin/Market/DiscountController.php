<?php

namespace App\Http\Controllers\Admin\Market;

use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AmazingSaleRequest;
use App\Http\Requests\Admin\Market\CommonDiscountRequest;
use App\Http\Requests\Admin\Market\CouponRequest;
use App\Models\Admin\Market\AmazingSale;
use App\Models\Admin\Market\CommonDiscount;
use App\Models\Admin\Market\Coupon;
use App\Models\Admin\Market\Product;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
{


    // COMMON DISCOUNTS METHODS START HERE
    public function commonDiscountIndex()
    {

        $commonDiscounts = CommonDiscount::orderByDesc('created_at')->get();
        return view('admin.market.discount.common-discount.index', compact('commonDiscounts'));
    }

    public function commonDiscountCreate()
    {

        return view('admin.market.discount.common-discount.create');
    }

    public function commonDiscountStore(CommonDiscountRequest $request)
    {
        $inputs = $request->all();
        // change date to normal
        if ($request->end_date < $request->start_date) {
            return redirect()->back()->with('swal-error', 'لطفا تاریخ پایان تخفیف را درست انتخاب کنید.');
        }
        $inputs['start_date'] = date('Y-m-d H:i:s', (int)$request->start_date);
        $inputs['end_date'] = date('Y-m-d H:i:s', (int)$request->end_date);
        $result = CommonDiscount::create($inputs);
        if ($result) {
            return redirect()->route('admin.market.discount.common-discount-index')->with('swal-success', 'کد تخفیف عمومی با موفقیت ایجاد شد.');
        }
    }

    public function commonDiscountEdit(CommonDiscount $discount)
    {

        return view('admin.market.discount.common-discount.edit', compact('discount'));
    }

    public function commonDiscountUpdate(CommonDiscount $discount, CommonDiscountRequest $request)
    {

        $inputs = $request->all();
        // change date to normal
        $inputs['start_date'] = date('Y-m-d H:i:s', (int)$request->start_date);
        $inputs['end_date'] = date('Y-m-d H:i:s', (int)$request->end_date);
        $result = $discount->update($inputs);
        if ($result) {
            return redirect()->route('admin.market.discount.common-discount-index')->with('swal-success', 'کد تخفیف عمومی با موفقیت ویرایش شد.');
        }
        return redirect()->back()->with('swal-error', 'عملیات مورد نظر با خطا همراه بود، لطفا دوباره امتخان کنید.');
    }

    public function commonDiscountDestroy(CommonDiscount $discount)
    {

        $result = $discount->delete();
        if ($result) {
            return redirect()->back()->with('swal-success', 'تخفیف مورد نظر با موفقیت حذف شد.');
        }
        return redirect()->back()->with('swal-error', 'عملیات مورد نظر با مشکل همراه بود، لطفا دوباره امتحان کنید.');
    }

    public function commonDiscountStatus(CommonDiscount $discount): JsonResponse
    {

        $discount->status = $discount->status === 0 ? 1 : 0;
        $result = $discount->save();

        if ($result) {
            $message = $discount->status === 0 ? 'تخفیف عمومی غیرفعال شد' : 'تخفیف عمومی فعال شد';
            $alertType = $discount->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $discount->status,
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

    // COMMON DISCOUNTS METHODS END HERE

    // **********************************************************************************************************************************

    // COUPON METHODS START HERE
    public function couponIndex()
    {

        $coupons = Coupon::orderByDesc('created_at')
            ->with(['user'])
            ->get();
        return view('admin.market.discount.coupon.index', compact('coupons'));
    }

    public function couponCreate()
    {

        $users = User::where('status', '=', 1)->orderByDesc('created_at')->get();
        return view('admin.market.discount.coupon.create', compact('users'));
    }

    public function searchUser(Request $request): JsonResponse
    {
        if ($request->json()){
            $data = User::where('user_type', '=', UserTypeValue::CUSTOMER)
                ->whereStatus(1)
                ->get(['id', 'firstname', 'lastname']);
            // Add a new attribute 'full_name' to the data
            $data->transform(function ($user) {
                $user->fullname = $user->getFullNameAttribute();
                return $user;
            });
            return response()->json($data);
        }
        abort(403);
    }

    public function couponStore(CouponRequest $request)
    {

        $inputs = $request->all();
        // change date to normal
        if ($request->end_date < $request->start_date) {
            return redirect()->back()->with('swal-error', 'لطفا تاریخ پایان تخفیف را درست انتخاب کنید.');
        }
        $inputs['start_date'] = date('Y-m-d H:i:s', (int)$request->start_date);
        $inputs['end_date'] = date('Y-m-d H:i:s', (int)$request->end_date);
        $result = Coupon::create($inputs);
        if ($result) {
            return redirect()->route('admin.market.discount.coupon-index')->with('swal-success', 'کد تخفیف با موفقیت ایجاد شد.');
        }
    }

    public function couponEdit(CouponRequest $request,Coupon $coupon)
    {

        return view('admin.market.discount.coupon.edit',compact('coupon'));
    }

    public function couponUpdate(CouponRequest $request,Coupon $coupon)
    {

        $inputs = $request->all();
        // change date to normal
        $inputs['start_date'] = date('Y-m-d H:i:s', (int)$request->start_date);
        $inputs['end_date'] = date('Y-m-d H:i:s', (int)$request->end_date);

        // if user select common type as coupon type user_id should be null.
        if ($inputs['type'] == 0){
            $inputs['user_id'] = null;
        }
        $result = $coupon->update($inputs);
        if ($result) {
            return redirect()->route('admin.market.discount.coupon-index')->with('swal-success', 'کد تخفیف با موفقیت ویرایش شد.');
        }
        return redirect()->back()->with('swal-error', 'عملیات مورد نظر با خطا همراه بود، لطفا دوباره امتخان کنید.');
    }

    public function couponDestroy(Coupon $coupon)
    {

        $result = $coupon->delete();
        if ($result) {
            return redirect()->back()->with('swal-success', 'کد تخفیف با موفقیت حذف شد.');
        }
        return redirect()->back()->with('swal-error', 'عملیات مورد نظر با مشکل همراه بود، لطفا دوباره امتحان کنید.');
    }


    public function couponStatus(Coupon $coupon): JsonResponse
    {

        $coupon->status = $coupon->status === 0 ? 1 : 0;
        $result = $coupon->save();

        if ($result) {
            $message = $coupon->status === 0 ? 'کد تخفیف غیرفعال شد' : 'کد تخفیف فعال شد';
            $alertType = $coupon->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $coupon->status,
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
    // COUPON METHODS END HERE

    // **********************************************************************************************************************************

    // AMAZING SALE METHODS START HERE
    public function amazingSaleIndex()
    {

        $amazing_sales = AmazingSale::orderByDesc('created_at')->get();
        return view('admin.market.discount.amazing-sale.index', compact('amazing_sales'));
    }

    public function searchProduct(Request $request): JsonResponse
    {
        $data = Product::where('name', 'like', '%' . $request->q . '%')->whereStatus(1)->get();
        return response()->json($data);
    }

    public function amazingSaleCreate()
    {

        $products = Product::where('status', '=', 1)->orderByDesc('name')->get();
        return view('admin.market.discount.amazing-sale.create', compact('products'));
    }

    public function amazingSaleStore(AmazingSaleRequest $request)
    {

        $inputs = $request->all();
        // change date to normal
        if ($request->end_date < $request->start_date) {
            return redirect()->back()->with('swal-error', 'لطفا تاریخ پایان تخفیف را درست انتخاب کنید.');
        }
        $inputs['start_date'] = date('Y-m-d H:i:s', (int)$request->start_date);
        $inputs['end_date'] = date('Y-m-d H:i:s', (int)$request->end_date);
        $result = AmazingSale::create($inputs);
        if ($result) {
            return redirect()->route('admin.market.discount.amazing-sale-index')->with('swal-success', 'کد تخفیف عمومی با موفقیت ایجاد شد.');
        }
    }

    public function amazingSaleEdit(AmazingSale $amazingSale)
    {

        $products = Product::where('status', '=', 1)->orderByDesc('name')->get();
        return view('admin.market.discount.amazing-sale.edit', compact('products', 'amazingSale'));
    }

    public function amazingSaleUpdate(AmazingSaleRequest $request, AmazingSale $amazingSale)
    {

        $inputs = $request->all();
        // change date to normal
        $inputs['start_date'] = date('Y-m-d H:i:s', (int)$request->start_date);
        $inputs['end_date'] = date('Y-m-d H:i:s', (int)$request->end_date);
        $result = $amazingSale->update($inputs);
        if ($result) {
            return redirect()->route('admin.market.discount.amazing-sale-index')->with('swal-success', 'کد تخفیف عمومی با موفقیت ویرایش شد.');
        }
        return redirect()->back()->with('swal-error', 'عملیات مورد نظر با خطا همراه بود، لطفا دوباره امتخان کنید.');
    }

    public function amazingSaleDestroy(AmazingSale $amazingSale)
    {

        $result = $amazingSale->delete();
        if ($result) {
            return redirect()->back()->with('swal-success', 'تخفیف مورد نظر با موفقیت حذف شد.');
        }
        return redirect()->back()->with('swal-error', 'عملیات مورد نظر با مشکل همراه بود، لطفا دوباره امتحان کنید.');
    }

    public function amazingSaleStatus(AmazingSale $amazingSale): JsonResponse
    {

        $amazingSale->status = $amazingSale->status === 0 ? 1 : 0;
        $result = $amazingSale->save();

        if ($result) {
            $message = $amazingSale->status === 0 ? 'کالا از شگفت انگیز حذف شد' : 'کالا به شگفت انگیز افزوده شد';
            $alertType = $amazingSale->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $amazingSale->status,
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

    // AMAZING SALE METHODS END HERE

}
