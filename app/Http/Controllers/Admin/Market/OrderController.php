<?php

namespace App\Http\Controllers\Admin\Market;

use App\Constants\DeliveryStatusValue;
use App\Constants\OrderStatusValue;
use App\Constants\PaymentStatusType;
use App\Constants\PaymentTypeValue;
use App\Http\Controllers\Controller;
use App\Models\Admin\Market\OfflinePayment;
use App\Models\Admin\Market\Order;
use App\Models\Admin\Market\OrderItem;
use App\Models\Admin\Market\Payment;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use const Sodium\CRYPTO_BOX_NONCEBYTES;

class OrderController extends Controller
{

    public function newOrder()
    {

        $orders = Order::where('created_at', '<',Carbon::now()) // Filter for orders created after 24 hours ago
            ->orderByDesc('created_at')
            ->get();

        return view('admin.market.order.index', compact('orders'));
    }

    public function sending()
    {
        $orders = Order::where('delivery_status', '=', DeliveryStatusValue::SENDING)->orderByDesc('created_at')->get();
        return view('admin.market.order.index', compact('orders'));
    }

    public function unpaid()
    {
        $orders = Order::where('payment_status', '=', PaymentStatusType::PENDING)->orderByDesc('created_at')->get();
        return view('admin.market.order.index', compact('orders'));
    }

    public function canceled()
    {
        $orders = Order::where('order_status', '=', PaymentStatusType::CANCELED)->orderByDesc('created_at')->get();
        return view('admin.market.order.index', compact('orders'));
    }

    public function returned()
    {
        $orders = Order::where('order_status', '=', PaymentStatusType::RETURNED)->orderByDesc('created_at')->get();
        return view('admin.market.order.index', compact('orders'));
    }

    public function all()
    {
        $orders = Order::orderByDesc('created_at')->get();
        return view('admin.market.order.index',compact('orders'));
    }

    public function approveOfflinePayment(Order $order)
    {
        $message = '';
        $order->payment_status = $order->payment_status === 2 ? 3 : 2;
        $order->save();

        // update payment
        $payment = $order->payment;
        $payment->update([
            'status' => PaymentStatusType::PAYED
        ]);

        if ($order->payment_status == 2) {
            $message = "پرداخت تایید شد.";
        } elseif ($order->payment_status == 3) {
            $message = "پرداخت لغو شد.";
        }

        return redirect()->back()->with('swal-success', $message);
    }

    public function changeDeliveryStatus(Order $order)
    {
        $message = '';
        switch ($order->delivery_status) {
            case 0:
                $order->delivery_status = 1;
                $message = 'وضعیت ارسال به در حال ارسال تغییر کرد';
                break;
            case 1:
                $order->delivery_status = 2;
                $message = 'وضعیت ارسال به ارسال شده تغییر کرد';
                break;
            case 2:
                $order->delivery_status = 3;
                $message = 'وضعیت ارسال به تحویل داده شده تغییر کرد';
                break;
            default:
                $order->delivery_status = 0;
                $message = 'وضعیت ارسال به ارسال نشده تغییر کرد';
                break;
        }
        $order->save();
        return redirect()->back()->with('swal-success', $message);
    }

    public function changeOrderStatus(Order $order)
    {
        // Define an associative array for the order status changes
        $statusChanges = array(
            0 => array('status' => 1, 'message' => 'وضعیت سفارش به در انتظار تایید تغییر کرد'),
            1 => array('status' => 2, 'message' => 'وضعیت سفارش به تایید نشده تغییر کرد'),
            2 => array('status' => 3, 'message' => 'وضعیت سفارش به تایید شده تغییر کرد '),
            3 => array('status' => 4, 'message' => 'وضعیت سفارش به باطل شده تغییر کرد'),
            4 => array('status' => 5, 'message' => 'وضعیت سفارش به مرجوعی تغییر کرد'),
            // Use the default case as the fallback value
            'default' => array('status' => 0, 'message' => 'وضعیت سفارش به بررسی نشده تغییر کرد')
        );

        // Get the current order status
        $currentStatus = $order->order_status;

        // Check if the current status exists in the array
        if (array_key_exists($currentStatus, $statusChanges)) {
            // Get the new status and message from the array
            $newStatus = $statusChanges[$currentStatus]['status'];
            $message = $statusChanges[$currentStatus]['message'];
        } else {
            // Use the default values if the current status is not valid
            $newStatus = $statusChanges['default']['status'];
            $message = $statusChanges['default']['message'];
        }

        // Update the order status and save the order
        $order->order_status = $newStatus;
        $order->save();

        // Return the redirect response with the message
        return redirect()->back()->with('swal-success', $message);
    }

    public function cancelOrder(Order $order)
    {
        $message = '';
        $order->order_status = $order->order_status === 4 ? 0 : 4;
        $order->save();
        if ($order->order_status == 4) {
            $message = "سفارش مورد نظر با موفقیت باطل شد.";
        } elseif ($order->order_status == 0) {
            $message = "سفارش مورد نظر با موفقیت به بررسی نشده تغییر یافت.";
        }

        return redirect()->back()->with('swal-success', $message);
    }

    public function print(Order $order)
    {
        return view('admin.market.order.print', compact('order'));
    }

    public function orderDetails(Order $order)
    {
        $items = OrderItem::where('order_id', $order->id)->orderByDesc('created_at')->get();
        return view('admin.market.order.order-details', compact(['order', 'items']));
    }

    public function show(Order $order)
    {
//        $order = Order::with(['delivery_method', 'payment'])->orderByDesc('created_at')->get();
        return view('admin.market.order.show', compact('order'));
    }


    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->back()->with('swal-success', 'سفارش مورد نظر با موفقیت حذف شد.');
    }


}
