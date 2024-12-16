<?php

namespace App\Http\Controllers\Admin\Market;

use App\Constants\OrderStatusValue;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\AddressRequest;
use App\Http\Requests\Website\Customer\SelectAddressAndDeliveryRequest;
use App\Models\Admin\Market\Address;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\City;
use App\Models\Admin\Market\CommonDiscount;
use App\Models\Admin\Market\Delivery;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\Province;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Config\Exception\ValidationException;

class AddressController extends Controller
{
    public function getProvinces(Request $request)
    {
        $provinces = Province::whereStatus(1)->orderByDesc('name')->get();
        return view('app.customer.sales-process.address-and-delivery', compact(['provinces']));
    }

    public function getCities(Province $province)
    {
        $cities = City::where('province_id', $province->id)->get(['name', 'id']);
        if ($cities) {
            return response()->json([
                'status' => true,
                'cities' => $cities
            ]);
        }
        return response()->json([
            'status' => false,
            'cities' => null
        ]);
    }

    public function addressAndDelivery()
    {
        // dd('address & delivery');
        $user = Auth::user();
        $cart_items = CartItem::where('user_id', $user->id)->get();
        $delivery_methods = Delivery::whereStatus(1)->orderByDesc('name')->get();

        if (empty(CartItem::where('user_id', Auth::user()->id)->count())) {
            return redirect()->route('customer.cart');
        }

        return view('app.customer.sales-process.address-and-delivery', compact(['cart_items', 'delivery_methods']));
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
        $inputs = $request->all();
        $inputs['user_id'] = Auth::user()->id;
        $inputs['address'] = convertPersianToEnglish($request->address);
        $inputs['no'] = convertPersianToEnglish($request->no);
        $inputs['unit'] = convertPersianToEnglish($request->unit);
        $inputs['postal_code'] = convertPersianToEnglish($request->postal_code);
        if ($request->mobile != '') {
            $inputs['mobile'] = convertPersianToEnglish($request->mobile);
        } else {
            $inputs['mobile'] = convertPersianToEnglish(Auth::user()->mobile);
        }
        $address->update($inputs);

        return redirect()->back()->with('swal-success', 'ویرایش آدرس با موفقیت انجام شد.');
    }

    public function selectAddressAndDelivery(SelectAddressAndDeliveryRequest $request)
    {
        $user = Auth::user();
        $inputs = $request->all();

        // calculate prices
        $cart_items = CartItem::where('user_id', $user->id)->get();
        $total_product_price = 0;
        $total_discount = 0;
        $total_final_price = 0;
        $total_final_discount_price_with_numbers = 0;

        foreach ($cart_items as $cart_item) {
            $total_product_price += $cart_item->cart_item_product_price();
            $total_discount += $cart_item->cart_item_product_discount();
            $total_final_price += $cart_item->cart_item_final_price();
            $total_final_discount_price_with_numbers += $cart_item->cart_final_discount();
        }

        // common discount
        $common_discount = CommonDiscount::whereStatus(1)
            ->where('end_date', '>', Carbon::now())
            ->where('start_date', '<', Carbon::now())
            ->first();

        if ($common_discount && $total_final_price > $common_discount->minimum_order_amount) {
            $inputs['common_discount_id'] = $common_discount->id;
            $common_discount_amount_with_percentage = $total_final_price * ($common_discount->percentage / 100);
            if ($common_discount_amount_with_percentage > $common_discount->discount_ceiling) {
                $common_discount_amount_with_percentage = $common_discount->discount_ceiling;
            }
            if ($total_final_price >= $common_discount->minimum_order_amount) {

                $final_price = $total_final_price - $common_discount_amount_with_percentage;
            } else {
                $final_price = $total_final_price;
            }
        } else {
            $common_discount_amount_with_percentage = 0;
            $final_price = $total_final_price;
        }

        $inputs['user_id'] = $user->id;
        $inputs['order_final_amount'] = $final_price; // price with discount
        $inputs['order_discount_amount'] = $total_final_discount_price_with_numbers; // related to amazing sale products
        $inputs['order_common_discount_amount'] = $common_discount_amount_with_percentage; //  تخفیف عمومی با توجه به درصد و سقف و کف خرید
        $inputs['order_total_products_discount_amount'] = $inputs['order_discount_amount'] + $inputs['order_common_discount_amount']; // مجموع تخفیف عمومی و شگفت انگیز کالاهای انتخابی

        $delivery_method = Delivery::whereId($request->delivery_id)->first();
        $user_address = Address::whereId($request->address_id)->first();
        // TODO : change delivery_id to delivery_method_id in address-and-delivery view blade
        $inputs['tracking_number'] = 'order_' . rand(100000, 999999);
        $inputs['order_number'] = rand(100000, 999999);
        $inputs['delivery_method_id'] = $delivery_method->id;
        $inputs['delivery_amount'] = $delivery_method->amount;
        $inputs['delivery_method_object'] = $delivery_method;



        Order::updateOrCreate(
            [
                'user_id' => $user->id,
                'order_status' => OrderStatusValue::PENDING_FOR_VERIFY,
            ],
           $inputs
        );
        return redirect()->route('customer.payment', compact('inputs'));
    }

    public function removeAddress(Address $address)
    {
        $address->delete();

        return redirect()->back()->with('swal-success', 'آدرس آنتخاب شده با موفقیت حذف شد.');
    }


}
