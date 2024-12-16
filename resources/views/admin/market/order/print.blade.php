<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>فاکتور سفارش</title>

    @include('admin.layout.head-tag')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: right;
            font-size: 0.9rem;
        }

        body {
            padding: 25px;
            font-family: "B Nazanin";
            font-weight: bold;
        }

        .header_info_container {
            font-size: 15px;
            width: 210px;
            height: 0;
        }

        .header_info_label {
            text-align: left;
            float: right;
            width: 120px;
            padding: 1px 0;
        }

        .header_info {
            float: left;
            width: 77px;
            padding: 0 3px;
            height: 25px;
            /*border: 1px solid #000;*/
        }

        .section_header {
            font-size: 18px;
            border: 1px solid #000;
            text-align: center;
            padding: 3px 0;
            /*background-color: #ffdacb;*/
            margin: 3px 0;
            border-radius: 5px;
        }

        .section_body {
            padding: 5px 10px;
            /*background-color: #fbefe7;*/
            height: 113px;
            border: 1px solid #000;
            border-radius: 7px;
        }

        .info_item {
            margin: 12px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            border: 0.11em solid #000;
            padding: 6px 4px;
            border-collapse: collapse;
        }

        .table th {
            font-size: 13px;
        }

        .table td {
            /*background-color: #fbefe7;*/
        }

        .table tbody td {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 0;
            font-size: 13px;
            text-align: center;
        }

        .table .sum td {
            font-size: 13px;
            text-align: center;
            border-top: 1px solid #000;
        }
    </style>
</head>
{{-- TODO : THIS PRINT PAGE SHOULD BE COMPLETED AFTER VENDOR PART ADDED --}}
<body lang="fa">
<button class="btn btn-info btn-xs" style="float: right;"><i class="fa fa-download">دانلود</i></button>

<div class="main_container" style="font-family: 'B Nazanin'; font-weight: bold">
    <section style="height: 40px;">
        <div style="float: left; width: 210px; padding-top: 12px">
            @php
                $currentDate = now();
            @endphp
            <h3 class="header_info_container">
                {{--                <p class="header_info_label">{{ jalaliDate($currentDate,'Y-m-d H:i:s') }}_فاکتور_سفارش:</p>--}}
                {{--                <p class="header_info" style="font-family: 'B Nazanin'">شماره صورتحساب:</p>--}}
                {{--                <p class="header_info" style="font-family: 'B Nazanin'">{{ $currentDate }}</p>--}}
            </h3>
            <h3 class="header_info_container mt-4 pt-2">
                <span class="font-weight-bold">تاریخ : {{ persianDate(\Carbon\Carbon::now()) }}</span>
            </h3>
        </div>
        <h1 style="text-align: center;color: #e14343; font-size: 22px; padding: 10px 180px 0 0; margin: 0;">
            فاکتور سفارش مشتری
        </h1>
        <span
                class="mx-1">شماره ثبت : {{ persianDate(\Carbon\Carbon::now()) }}_{{ $order->user->full_name ?? '' }}_سفارش_مشتری</span>

    </section>
    <div class="main">
        <section style="height: 160px">
            <h2 class="section_header font-weight-bold">مشخصات فروشنده</h2>
            <div class="section_body">
                <div style="float: right; width: 32%;">
                    <h4 class="info_item">
                        <span class="font-weight-bold">نام و نام خانوادگی:</span>
                        <span>
                          fullname
                        </span>
                    </h4>
                    <h4 class="info_item">
                        <span class="font-weight-bold">نشانی کامل:</span>
                        <span class="font-weight-bold">استان:</span>
                        <span>user address</span>
                        <span class="font-weight-bold">شهرستان:</span>
                        <span>city name</span>
                    </h4>
                    {{--                    <h4 class="info_item">--}}
                    {{--                        <span>نشانی:</span>--}}
                    {{--                    </h4>--}}
                </div>
                <div style="float: right; width: 32%;">
                    <h4 class="info_item">
                        <span class="font-weight-bold">نام فروشگاه:</span>
                        <span>onlineshop</span>
                    </h4>
                    <h4 class="info_item">
                        <span class="font-weight-bold">کد پستی:</span>
                        <span>hello3</span>
                    </h4>
                </div>
                <div style="float: right; width: 32%;">
                    <h4 class="info_item">
                        <span class="font-weight-bold">تلفن:</span>
                        <span>hello5</span>
                    </h4>
                </div>
            </div>
        </section>
        <section style="height: 160px;">
            <h2 class="section_header font-weight-bold">مشخصات مشتری</h2>
            <div class="section_body">

                <div style="float: right; width: 32%;">
                    <h4 class="info_item">
                        <span class="font-weight-bold">نام و نام خانوادگی:</span>
                        <span>{{ $order->user->fullname ?? $order->user_id->mobile }}</span>
                    </h4>
                    <h4 class="info_item">
                        <span class="font-weight-bold">شماره همراه:</span>
                        <span>{{ $order->user->mobile }}</span>
                    </h4>

                </div>
                <div style="float: right; width: 32%;">
                    <h4 class="info_item">
                        <span class="font-weight-bold">کد پستی:</span>
                        <span>{{ $order->address->postal_code ?? '-' }}</span>
                    </h4>
                    <h4 class="info_item">
                        <span class="info_item font-weight-bold">نشانی:</span>
                        <span>{{ $order->address->province->name }}،
                            {{ $order->address->city->name }}،
                            {{ $order->address->postal_code ??'' }},
                            واحد {{ $order->address->unit ??'' }},
                            شماره {{ $order->address->no ??'' }},
                            {{ $order->address->address ?? '' }},
                            {{ $order->full_name ??'' }}
                        </span>
                    </h4>
                </div>
                <div style="float: right; width: 32%;">
                    <h4 class="info_item">
                        <span class="font-weight-bold">کد ملی:</span>
                        <span>{{ $order->user->national_code ?? '-' }}</span>
                    </h4>

                </div>
            </div>
        </section>
        <section style="font-family: bnazanin">
            <h2 class="section_header font-weight-bold">مشخصات کالاهای سفارش</h2>
            <table class="display table table-striped table-bordered table-responsive-md table-hover">
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
                    <td>{{ number_format($order->order_final_amount ?? '-') }} تومان</td>
                    <td>{{ number_format($order->order_discount_amount ?? '-') }} تومان</td>
                    <td>{{ $order->coupon->code ?? '-' }}</td>
                    <td>{{ number_format($order->coupon->amount ?? '-') }} تومان</td>
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
                            بررسی شده
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::RETURNED)
                            مرجوعی
                        @elseif($order->order_status == \App\Constants\OrderStatusValue::CANCELED)
                            باطل شده
                        @endif
                    </td>
                </tr>

                </tbody>
            </table>
        </section>
        <div style="margin: 30px 0">
            <p style="float: right; width: 50%">مهر و امضاء فروشنده</p>
            <p style="float: right">مهر و امضاء خریدار</p>
        </div>
    </div>
</div>


@include('admin.layout.scripts')

</body>
</html>
