<?php

namespace App\Http\Controllers\Website\Customer\SalesProcess;

use App\Constants\CouponTypeValue;
use App\Constants\OrderStatusValue;
use App\Constants\PaymentableTypeValue;
use App\Constants\PaymentStatusType;
use App\Constants\PaymentTypeValue;
use App\Constants\UserTypeValue;
use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
use App\Models\Admin\Market\CartItem;
use App\Models\Admin\Market\CashPayment;
use App\Models\Admin\Market\Coupon;
use App\Models\Admin\Market\Delivery;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\OnlinePayment;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\OrderItem;
use App\Models\Admin\Market\Payment;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\NewOrderCreated;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $delivery_method_id = $request->inputs['delivery_id'];
        $delivery = Delivery::where('id', $delivery_method_id)->first();

        $user = Auth::user();
        $cart_items = CartItem::where('user_id', $user->id)->get();
        $order = Order::where('user_id', Auth::user()->id)
            ->where('order_status', OrderStatusValue::PENDING_FOR_VERIFY)
            ->first();
        return view('app.customer.sales-process.payment', compact(['order', 'cart_items', 'delivery']));
    }

    public function couponDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:' . Coupon::class . ',code'
        ], [
            'code.required' => 'کد تخفیف الزامی است.',
            'code.exists' => 'کد تخفیف معتبر نیست.'
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->whereStatus(1)
            ->where('end_date', '>', Carbon::now())
            ->where('start_date', '<', Carbon::now())
            ->first();

        if ($coupon !== null) {
            if ($coupon->user_id !== null) { // private coupon
                $coupon = Coupon::where('code', $request->code)
                    ->whereStatus(1)
                    ->where('end_date', '>', Carbon::now())
                    ->where('start_date', '<', Carbon::now())
                    ->where('user_id', Auth::user()->id)
                    ->first();

                if (!$coupon) {
                    return redirect()->back()->withErrors(['coupon' => 'کد تخفیف موجود نیست']);
                }
            }

            // public coupon
            $order = Order::where('user_id', Auth::user()->id)
                ->where('order_status', OrderStatusValue::PENDING_FOR_VERIFY)
                ->whereCouponId(null)
                ->first();

            if ($order) {
                if ($coupon->amount_type == CouponTypeValue::PERCENTAGE) { // کوپن تخفیف درصدی باشد
                    $coupon_discount_amount = $order->order_final_amount * ($coupon->amount / 100);

                    if ($coupon_discount_amount > $coupon->discount_ceiling) {
                        $coupon_discount_amount = $coupon->discount_ceiling;
                    }
                } elseif ($coupon->amount_type == CouponTypeValue::PRICE_UNIT) { // کوپن تخفیف تومانی است
                    $coupon_discount_amount = $coupon->amount;
                }

                $order->order_final_amount = $order->order_final_amount - $coupon_discount_amount; // مبلغ نهایی با احتساب کوپن تخفیف

                $final_discount = $order->order_total_products_discount_amount + $coupon_discount_amount; // مبلغ کل تخفیف با احتساب انواع تخفیف ها که از قبل از جدول سفارش ها ثبت شده اند

                $order->update([
                    'coupon_id' => $coupon->id,
                    'order_coupon_discount_amount' => $coupon_discount_amount,
                    'order_total_products_discount_amount' => $final_discount
                ]);
                return redirect()->back()->with('swal-success', 'کد تخفیف با موفقیت اعمال شد.');
            } else {
                return redirect()->back()->withErrors(['coupon' => 'کد تخفیف معتبر نیست']);
            }
        } else {
            return redirect()->back()->withErrors(['coupon' => 'کد تخفیف معتبر نیست']);

        }
    }

    public function paymentSubmit(Request $request, PaymentService $service)
    {

        $request->validate([
            'type' => 'required',
        ], [
            'type.required' => 'روش پرداخت معتبر نیست'
        ]);

        $order = Order::whereUserId(Auth::user()->id)
            ->first();
            
        $cart_items = CartItem::whereUserId(Auth::user()->id)->get();
        $cash_receiver = null;

        switch ($request->type) {
            case '1':
                // online payment
                $target_model = OnlinePayment::class;
                $paymentable_type = PaymentableTypeValue::ONLINE;
                $type = 1;
                break;

            case '2':
                // offline payment
                $target_model = OfflinePayment::class;
                $paymentable_type = PaymentableTypeValue::OFFLINE;
                $type = 2;
                break;

            case '3':
                // cash payment
                $target_model = CashPayment::class;
                $paymentable_type = PaymentableTypeValue::CASH;
                $type = 3;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;

            default:
                return redirect()->back()->withErrors(['payment' => 'روش پرداخت معتبر نیست.']);
        }

        if ($type == PaymentTypeValue::ONLINE_PAYMENT) {
            // online payment actions
            $paid = $target_model::create([
                'amount' => $order->order_final_amount + $order->delivery_amount,
                'user_id' => Auth::id(),
                'gateway' => 'زرین پال',
                'transaction_id' => rand(10000, 99999),
                'bank_first_response' => null,
                'bank_second_response' => null,
                'status' => PaymentStatusType::PENDING,
            ]);

            $order->update([
                'payment_type' => PaymentTypeValue::ONLINE_PAYMENT,
                'order_status' => OrderStatusValue::PENDING_FOR_VERIFY,
            ]);
            // create a record in payments table
            $payment = Payment::create([
                'amount' => $order->order_final_amount + $order->delivery_amount,
                'user_id' => Auth::id(),
                'status' => PaymentStatusType::PENDING,
                'type' => $type,
                'paymentable_type' => $paymentable_type,
                'paymentable_id' => $paid->id,
            ]);

            $final_payable_amount = $order->order_final_amount + $order->delivery_amount;
            // go to the payment service class
            $service->zarinpal($final_payable_amount, $order, $paid);

        } elseif ($type == PaymentTypeValue::OFFLINE_PAYMENT) {
            // offline payment actions
            $paid = $target_model::create([
                'amount' => $order->order_final_amount + $order->delivery_amount,
                'user_id' => Auth::id(),
                'transaction_id' => rand(10000, 99999),
                'pay_date' => Carbon::now(),
                'status' => PaymentStatusType::PENDING
            ]);

        } else {
            // cash payment actions
            $paid = $target_model::create([
                'amount' => $order->order_final_amount + $order->delivery_amount,
                'user_id' => Auth::id(),
                'cash_receiver' => $request->cash_receiver ?? null,
                'pay_date' => Carbon::now(),
                'status' => PaymentStatusType::PENDING
            ]);
        }

        $payment = Payment::create([
            'amount' => $order->order_final_amount + $order->delivery_amount,
            'user_id' => Auth::id(),
            'status' => PaymentStatusType::PENDING,
            'type' => $type,
            'paymentable_type' => $paymentable_type,
            'paymentable_id' => $paid->id,
        ]);

        // TODO : here is for the cash or offline payment ( should be verified after checking the payment and check it in admin panel to paid )
        $order->update([
            'order_status' => OrderStatusValue::VERIFIED,
            'payment_status' => PaymentStatusType::PENDING,
            'payment_type' => $type,
            'payment_id' => $payment->id
        ]);

        foreach ($cart_items as $cart_item) {

            // add all items to the order_items table
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart_item->product_id,
                'product_object' => $cart_item->product,
                'amazing_sale_id' => optional($cart_item->product->active_amazing_sales()->first())->id,
                'amazing_sale_object' => $cart_item->product->active_amazing_sales,
                'amazing_sale_discount_amount' => ($cart_item->product->active_amazing_sales()->count() === 0) ? 0 : ($cart_item->cart_item_product_price() * ($cart_item->product->active_amazing_sales()->first()->percentage / 100)),
                'number' => $cart_item->number,
                'final_product_price' => ($cart_item->cart_item_product_price() - optional($cart_item->product->active_amazing_sales()->first())->percentage / 100),
                'final_total_price' => $cart_item->number * ($cart_item->cart_item_product_price() - optional($cart_item->product->active_amazing_sales()->first())->percentage / 100),
                'color_id' => $cart_item->color_id,
                'guaranty_id' => $cart_item->guaranty_id
            ]);
            // remove items from the cart_items table
            $cart_item->delete();

            // notify super admin that the user has been registered
            $super_admin = User::where('user_type', UserTypeValue::SUPER_ADMIN)->first();
            $details = [
                'message' => 'سفارش جدید ثبت شد و منتظر تایید شماست!'
            ];
            \Illuminate\Support\Facades\Notification::sendNow($super_admin, new NewOrderCreated($details));
        }

        return redirect()->route('app.home')->with('success', 'سفارش شما با موفقیت ثبت شد.');

    }

    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $service)
    {
        try {
            // Validate input data
            $userId = Auth::id();
            $cart_items = CartItem::where('user_id', $userId)->get();
            if (!$userId) {
                throw new \Exception('شما مجاز به انجام این عملیات نیستید!');
            }

            $amount = $onlinePayment->amount;
            if (!is_numeric($amount) || $amount <= 0) {
                throw new \InvalidArgumentException('مقدار پرداختی نامعتبر است!');
            }

            // Perform payment verification
            $result = $service->zarinpal_verify($amount, $onlinePayment);

            // Start a database transaction
            DB::beginTransaction();

            if ($result['success']) {
                // Update order status to verify
                $order->update([
                    'order_status' => OrderStatusValue::VERIFIED,
                    'payment_status' => PaymentStatusType::PAYED
                ]);
                // update online payment status
                $onlinePayment->update([
                    'status' => PaymentStatusType::PAYED
                ]);
                // update payment status
                $payment = Payment::where('paymentable_id', $onlinePayment->id)->first();
                if ($onlinePayment->status == PaymentStatusType::PAYED) {
                    $payment->status = 2; // set status to paid
                    $payment->save();
                }

                // notify super admin that the user has been registered
                $super_admin = User::whereUserType(UserTypeValue::SUPER_ADMIN)->first();
                $details = [
                    'message' => 'سفارش جدید و پرداخت آنلاین!'
                ];
                $super_admin?->notify(new NewOrderCreated($details));


                foreach ($cart_items as $cart_item) {
                    // add all items to the order_items table
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cart_item->product_id,
                        'product_object' => $cart_item->product,
                        'amazing_sale_id' => optional($cart_item->product->active_amazing_sales()->first())->id,
                        'amazing_sale_object' => $cart_item->product->active_amazing_sales,
                        'amazing_sale_discount_amount' => ($cart_item->product->active_amazing_sales()->count() === 0) ? 0 : ($cart_item->cart_item_product_price() * ($cart_item->product->active_amazing_sales()->first()->percentage / 100)),
                        'number' => $cart_item->number,
                        'final_product_price' => ($cart_item->cart_item_product_price() - optional($cart_item->product->active_amazing_sales()->first())->percentage / 100),
                        'final_total_price' => $cart_item->number * ($cart_item->cart_item_product_price() - optional($cart_item->product->active_amazing_sales()->first())->percentage / 100),
                        'color_id' => $cart_item->color_id,
                        'guaranty_id' => $cart_item->guaranty_id
                    ]);

                    $cart_item->delete();
                }

                // Commit the transaction
                DB::commit();

                return redirect()->route('app.home')->with('success', 'پرداخت شما با موفقیت انجام شد.');
            } else {
                // Update order status to cancel
                $order->update([
                    'order_status' => OrderStatusValue::CANCELED,
                    'payment_status' => PaymentStatusType::PENDING
                ]);

                // Rollback the transaction
                DB::rollback();

                // Develop errors based on the documentation (use codes to show error)
                return redirect()->route('app.home')->with('error', 'سفارش توسط مشتری لغو شد یا خطا در اتصال به اینترنت وجود دارد.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of any exception
            DB::rollback();

            // Log the exception for further investigation
            Log::error(' خطا در عملیات پرداخت : ' . $e->getMessage());

            return redirect()->route('app.home')->with('error', 'مشکلی پیش آمده است.');

        }
    }


}
