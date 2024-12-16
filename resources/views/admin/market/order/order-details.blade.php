@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | سفارشات</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.order.all') }}">سفارشات</a></li>
                        <li class="breadcrumb-item active">جزئیات سفارش</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="content-header text-right">
        <div class="pad margin no-print">
            <div class="callout callout-success" style="margin-bottom: 0!important;">
                <h4><i class="fa fa-info"></i> توجه:</h4>
                اینجا می توانید جزئیات مربوط به سفارش را مشاهده و در صورت نیاز خروجی PDF بگیرید.
            </div>
        </div>

    </div>

    <section class="invoice printableArea">
        <!-- title row -->
        <div class="row text-right">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="d-inline"><span
                            class="font-size-30">جزئیات سفارش {{ $order->user->fullname ?? '' }}_{{ persianDateTime(now()) }}</span>
                    </h2>
                    <div class="pull-right text-right">
                        <h3>{{ persianDateTime($order->created_at) }}</h3>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info text-right">
            <div class="col-md-6 invoice-col">
                <strong>خرید از :</strong>
                <address>
                    <strong class="text-blue font-size-24">راسته فرش</strong><br>
                    <strong class="d-inline">ایران، آذربایجان غربی،ارومیه</strong><br>
                    <strong>شماره تماس : 09149736292 &nbsp;&nbsp;&nbsp;&nbsp; ایمیل: info@raastehfarsh@com</strong>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-md-6 invoice-col text-right">
                <strong>خرید توسط :</strong>
                <address>
                    <strong class="text-blue font-size-24">{{ $order->user->full_name ?? '-' }}</strong><br>
                    {{ $order->address->province->name ?? '' }}-{{ $order->address->city->name ?? '' }}
                    -{{ $order->address->address ?? '' }}<br>
                    <strong>شماره تماس: {{ $order->user->mobile ??'' }} &nbsp;&nbsp;&nbsp;&nbsp; ایمیل
                        : {{ $order->user->email ?? '' }}</strong>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-12 invoice-col mb-15">
                <div class="invoice-details row no-margin">
                    <div class="col-md-6 col-lg-3"><b>شماره پیگیری :</b>{{ $order->tracking_number ?? '-' }}</div>
                    <div class="col-md-6 col-lg-3"><b>شماره سفارش: </b>{{ $order->order_number }}</div>
                    <div class="col-md-6 col-lg-3"><b>تاریخ پرداخت:</b> {{ persianDateTime($order->created_at) }}</div>
                    <div class="col-md-6 col-lg-3"><b>شماره تماس مشتری:</b> {{ $order->user->mobile }}</div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>#</th>
                        <th>نام کالا</th>
                        <th>قیمت کالا</th>
                        <th>میزان تخفیف روی کالا</th>
                        <th>مبلغ فروش فوق العاده</th>
                        <th>تعداد</th>
                        <th>جمع قیمت محصول</th>
                        <th>مبلغ نهایی با تخفیف</th>
                        <th>رنگ</th>
                        <th>گارانتی</th>
                        <th>ویژگی ها</th>
                    </tr>
                    @if($order->items->count() >= 1)
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td> {{-- شناسه --}}
                                <td>{{ $item->single_product->name }}</td> {{-- نام کالا --}}
                                <td>{{ number_format($item->single_product->price) }} تومان</td> {{-- قیمت کالا --}}
                                <td>
                                    @if($item->single_product->amazing_sale)
                                        {{ $item->amazing_sale->percentage }}
                                        % {{-- درصد فروش شگفت انگیز اگر این کالا مشمول باشد --}}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->amazing_sale ? number_format($item->amazing_sale_discount_amount) : '0' }} تومان</td> {{-- مبلغ فروش فوق العاده روی این آیتم --}}
                                <td class="text-right">{{ $item->number }} عدد</td> {{-- تعداد این کالا --}}
                                <td class="text-right">{{ $item->final_product_price ? number_format($item->final_product_price) : '0' }} تومان</td> {{-- مبلغ نهایی این آیتم --}}
                                <td class="text-right">{{ $item->final_total_price ? number_format($item->final_total_price * $item->number) : '0' }} تومان</td> {{-- مبلغ با احتساب تعداد این آیتم --}}
                                <td class="text-right">{{ $item->color->name ?? '-' }} </td> {{-- رنگ این آیتم --}}
                                <td class="text-right">{{ $item->color->color_name ?? '-' }} </td> {{-- رنگ این آیتم --}}
                                <td class="text-right">{{ $item->guaranty->name ?? '-' }} </td> {{-- گارانتی این آیتم --}}
                                <td class="text-right">
                                    @if($item->order_item_attributes)
                                        <ul>
                                            @foreach($item->order_item_attributes as $attribute)
                                                <li>{{ $attribute->category_attribute->name ?? '-' }} : {{ $attribute->category_value->value ?? '-' }} </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td> {{-- ویژگی مثلا حاظه، رم، اندازه، متراژ و غیره --}}
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-12 text-right">
                <p class="lead"><b>پرداخت در تاریخ : </b><span
                        class="text-danger"> {{ persianDateTime($order->created_at) }} </span></p>
                @php
                    $couponValue = 0; // Initialize $couponValue to 0
                    $commonDiscountValue = 0; // Initialize $commonDiscountValue to 0
                    $amazingSaleValue = 0;

                    if ($order->coupon && $order->coupon->amount_type == \App\Constants\CouponTypeValue::PERCENTAGE) {
                    $couponValue = $order->order_final_amount * ($order->coupon->amount)/100; // مقدار تخفیف در کوپن تخفیف اگر تخفیف درصدی باشد
                    } elseif ($order->coupon && $order->coupon->amount_type == \App\Constants\CouponTypeValue::PRICE_UNIT) {
                    $couponValue = $order->order_final_amount - $order->coupon->amount; // مقدار تخفیف کوپن تخفیف اکر مقدار تومان
                    // باشد
                    }

                    if ($order->common_discount && $order->order_final_amount > $order->common_discount->minimum_order_amount) {
                    $commonDiscountValue = $order->order_final_amount * ($order->common_discount->percentage)/100;
                    }

                    $sumOfDiscounts = $couponValue + $commonDiscountValue;
                    $sumOfOrderAmount = $order->order_final_amount - $sumOfDiscounts + $order->delivery_method->amount;//  یمبلغ کل خرید منهای کل تخفیفات بعلاوه هزینه ارسال کالا
                @endphp
                <div>
                    <p>مجموع سبد خرید بدون تخفیف : {{ number_format($order->order_final_amount) }} تومان</p>
                    <p>مجموع تخفیفات : {{ number_format($sumOfDiscounts) }} تومان</p>
                    <p>روش ارسال : {{ $order->delivery_method->name }}</p>
                    <p>هزینه ارسال : {{ number_format($order->delivery_method->amount) }} تومان</p>

                </div>
                <div class="total-payment">
                    <h3><b>کل مبلغ قابل پرداخت :</b> {{ number_format($sumOfOrderAmount) }} تومان</h3>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                <button id="print" class="btn btn-warning" type="button"><span><i class="fa fa-print"></i> چاپ</span>
                </button>

            </div>
        </div>
    </section>

    <script type="text/javascript">

        function changeStatus(id) {
            const url = $("#" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        $("#" + id).prop("checked", response.checked); // Update checkbox state
                        showToastrMessage(response.message, response.alertType); // Display toast message
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                    }
                },
                error: function () {
                    showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                }
            });
        }

    </script>

@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

