<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>مشاهده سفارش {{ $order->user->fullname }}_{{ persianDateTime(\Carbon\Carbon::now()) }}</title>

    @include('admin.layout.head-tag')
</head>

<body>

<section class="card d-flex flex-col"
         style="border: 1px solid #cdcdcd; margin: 1rem; padding: 2rem; text-align: right; font-size: 0.75rem; overflow-x: auto;">
    <span class="card-header font-weight-bold text-center">
        <h2 class="text-center">جزئیات سفارش</h2>
    </span>
    <span class="">
        <a href="{{ route('admin.market.order.print',$order->id) }}" class="mx-1 btn btn-sm btn-primary"><i
                    class="fa fa-print"></i> چاپ </a>
        <a href="{{ route('admin.market.order.order-details',$order->id) }}" class="mx-1 btn btn-sm btn-info"><i
                    class="fa fa-question-circle"></i> جزئیات سفارش</a>
    </span>
    <div class="card-header font-weight-bold">
        <div class="table-responsive">
            <table class="display table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th scope="col">نوع پرداخت</th>
                    <th scope="col">وضعیت پرداخت</th>
                    <th scope="col">روش ارسال</th>
                    <th scope="col">هزینه ارسال</th>
                    <th scope="col">وضعیت ارسال</th>
                    <th scope="col">تاریخ تحویل</th>
                    <th scope="col">مقدار کل سفارش</th>
                    <th scope="col">مقدار تخفیف</th>
                    <th scope="col">کد تخفیف</th>
                    <th scope="col">مقدار تخفیف کد تخفیف</th>
                    <th scope="col">تخفیف عمومی</th>
                    <th scope="col">مقدار تخفیف عمومی</th>
                    <th scope="col">کل تخفیفات</th>
                    <th scope="col">وضعیت سفارش</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        @if($order->payment_type == \App\Constants\PaymentTypeValue::ONLINE_PAYMENT)
                            آنلاین
                        @elseif($order->payment_type == \App\Constants\PaymentTypeValue::OFFLINE_PAYMENT)
                            کارت به کارت
                        @elseif($order->payment_type == \App\Constants\PaymentTypeValue::CASH_PAYMENT)
                            پرداخت در محل
                        @endif
                    </td>
                    <td>
                        @if($order->payment_status == \App\Constants\PaymentStatusType::PAYED)
                            پرداخت شده
                        @elseif($order->payment_status == \App\Constants\PaymentStatusType::CANCELED)
                            باطل شده
                        @elseif($order->payment_status == \App\Constants\PaymentStatusType::PENDING)
                            در انتظار پرداخت
                        @elseif($order->payment_status == \App\Constants\PaymentStatusType::RETURNED)
                            مرجوعی
                        @endif
                    </td>
                    <td>{{ $order->delivery_method->name ?? '-' }}</td>
                    <td>{{ number_format($order->delivery_method->amount ?? '-') }} تومان</td>
                    <td>
                        @if($order->delivery_status == \App\Constants\DeliveryStatusValue::DELIVERED)
                            تحویل داده شده
                        @elseif($order->delivery_status == \App\Constants\DeliveryStatusValue::NOT_SENT)
                            ارسال نشده
                        @elseif($order->delivery_status == \App\Constants\DeliveryStatusValue::SENT)
                            ارسال شده
                        @elseif($order->delivery_status == \App\Constants\DeliveryStatusValue::SENDING)
                            در حال ارسال
                        @endif
                    </td>
                    <td>{{ persianDate($order->delivery_date) }}</td>
                    <td>{{ $order->order_final_amount ? number_format($order->order_final_amount) : '0' }} تومان</td>
                    <td>{{ $order->order_discount_amount ? number_format($order->order_discount_amount) : '0' }}تومان
                    </td>
                    <td>{{ $order->coupon->code ?? '-' }}</td>
                    <td>{{ $order->coupon->amount ? number_format($order->coupon->amount) : '0' }} تومان</td>
                    <td>{{ $order->common_discount->title ?? '-' }}</td>

                    @php
                        $common_discount_amount = 0; // Initialize $common_discount_amount to 0

                        if ($order->common_discount){
                        $common_discount_amount = $order->common_discount->percentage * $order->order_final_amount;
                        }
                    @endphp

                    <td>{{ number_format($common_discount_amount) }}</td>
                    @php
                        $couponValue = 0; // Initialize $couponValue to 0
                        $commonDiscountValue = 0; // Initialize $commonDiscountValue to 0

                        if ($order->coupon && $order->coupon->amount_type == \App\Constants\CouponTypeValue::PERCENTAGE) {
                        $couponValue = $order->order_final_amount * $order->coupon->amount;
                        } elseif ($order->coupon && $order->coupon->amount_type == \App\Constants\CouponTypeValue::PRICE_UNIT) {
                        $couponValue = $order->order_final_amount - $order->coupon->amount;
                        }

                        if ($order->common_discount && $order->order_final_amount > $order->common_discount->minimum_order_amount) {
                        $commonDiscountValue = $order->order_final_amount * $order->common_discount->percentage;
                        }

                        $sumOfDiscounts = $couponValue + $commonDiscountValue;
                    @endphp

                    <td>{{ number_format($sumOfDiscounts) }} تومان</td>

                    <td>
                        @if($order->order_status == \App\Constants\OrderStatusValue::DECLINED)
                            تایید نشده
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::PENDING_FOR_VERIFY)
                            در انتظار تایید
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::VERIFIED)
                            تایید شده
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::NOT_CHECKED)
                            بررسی نشده
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::RETURNED)
                            مرجوعی
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::CANCELED)
                            باطل شده
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    {{--    </div>--}}
</section>

@include('admin.layout.scripts')

</body>

</html>
