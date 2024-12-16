@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | سفارشات</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="#"
                       type="button"
                       class="btn btn-primary btn-sm disabled">
                        <i class="fa fa-plus-circle"></i> ایجاد سفارش جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">سفارش</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید سفارشات فروشگاه خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل سفارشات
                            : {{ $orders->count() != 0 ? $orders->count() : 'صفر' }}</strong>
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="example"
                                   class="display table table-striped table-bordered table-responsive-md table-hover"
                                   style="width:100%;font-size: 0.75rem;">
                                <style>
                                    th {
                                        text-align: right !important;
                                    }
                                </style>
                                <thead>
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                    <th scope="col">شماره سفارش</th>
                                    <th scope="col">مجموع مبلغ سفارش(بدون تخفیف و غیره)</th>
                                    <th scope="col">مجموع کل تخفیف</th>
                                    <th scope="col">مجموع کل تخفیف کالاهای سفارش داده شده</th>
                                    <th scope="col">مبلغ نهایی</th>
                                    <th scope="col">وضعیت پرداخت</th>
                                    <th scope="col">روش پرداخت</th>
                                    <th scope="col">بانک</th>
                                    <th scope="col">وضعیت ارسال</th>
                                    <th scope="col">روش ارسال</th>
                                    <th scope="col">وضعیت سفارش</th>
                                    <th class="max-width-16-rem text-left" scope="col">
                                        <i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr role="row" class="odd">
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ number_format($order->order_final_amount) ?? '0' }} تومان</td>
                                        <td>{{ number_format($order->order_discount_amount) ?? '0' }} تومان</td>
                                        <td>{{ number_format($order->order_total_products_discount_amount) ?? '0' }}
                                            تومان
                                        </td>
                                        <td>{{ number_format($order->order_final_amount -  $order->order_discount_amount) ?? '0' }}
                                            تومان
                                        </td>
                                        <td>{{ $order->payment_status_value }}</td>
                                        <td>{{ $order->payment_type_value }}</td>
                                        <td>{{ $order->payment->paymentable->gateway ?? '-' }}</td>
                                        <td>
                                            @if($order->delivery_status == \App\Constants\DeliveryStatusValue::DELIVERED)
                                                <button class="btn btn-xs btn-success"><i
                                                            class="fa fa-check-circle"></i> تحویل داده شده
                                                </button>
                                            @elseif($order->delivery_status == \App\Constants\DeliveryStatusValue::NOT_SENT)
                                                <button class="btn btn-xs btn-info"><i class="fa fa-times-circle"></i>
                                                    ارسال نشده
                                                </button>
                                            @elseif($order->delivery_status == \App\Constants\DeliveryStatusValue::SENT)
                                                <button class="btn btn-xs btn-warning"><i class="fa fa-check"></i> ارسال
                                                    شده
                                                </button>
                                            @elseif($order->delivery_status == \App\Constants\DeliveryStatusValue::SENDING)
                                                <button class="btn btn-xs btn-primary"><i class="fa fa-clock-o"></i> در
                                                    حال ارسال
                                                </button>
                                            @endif
                                        </td>
                                        <td>{{ $order->delivery_method->name ?? '-' }}</td>
                                        <td>
                                            @if($order->order_status == \App\Constants\OrderStatusValue::DECLINED)
                                                <button class="btn btn-xs btn-danger"><i class="fa fa-times-circle"></i>
                                                    تایید نشده
                                                </button>
                                            @elseif($order->order_status == \App\Constants\OrderStatusValue::PENDING_FOR_VERIFY)
                                                <button class="btn btn-xs btn-warning"><i class="fa fa-clock-o"></i> در
                                                    انتظار تایید
                                                </button>
                                            @elseif($order->order_status == \App\Constants\OrderStatusValue::VERIFIED)
                                                <button class="btn btn-xs btn-success"><i
                                                            class="fa fa-check-circle"></i> تایید شده
                                                </button>
                                            @elseif($order->order_status == \App\Constants\OrderStatusValue::NOT_CHECKED)
                                                <button class="btn btn-warning btn-xs"><i class="fa fa-clock-o"></i>
                                                    بررسی نشده
                                                </button>
                                            @elseif($order->order_status == \App\Constants\OrderStatusValue::RETURNED)
                                                <button class="btn btn-xs btn-danger"><i class="fa fa-undo"></i> مرجوعی
                                                </button>
                                            @elseif($order->order_status == \App\Constants\OrderStatusValue::CANCELED)
                                                <button class="btn btn-xs btn-danger"><i class="fa fa-times-circle"></i>
                                                    باطل شده
                                                </button>
                                            @endif
                                        </td>
                                        <td class="text-left">
                                            <div class="dropdown">
                                            <span class="btn btn-success btn-xs btn-block dropdown-toggle"
                                                  role="button"
                                                  id="dropdown-menu-link" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-cog"></i> عملیات
                                            </span>
                                                <style>
                                                    .dropdown-menu a:hover {
                                                        background-color: #2EA08C;
                                                        color: #FFFFFF !important;
                                                    }
                                                </style>
                                                <div aria-label="dropdown-menu-link" class="dropdown-menu">
                                                    <a href="{{ route('admin.market.order.order-details',$order->id) }}"
                                                       class="dropdown-item text-right text-sm text-muted"><i
                                                                class="fa fa-print"></i> جزئیات و پرینت </a>
                                                    <a href="{{ route('admin.market.order.change-delivery-status',$order->id) }}"
                                                       class="dropdown-item text-right  text-sm text-muted"><i
                                                                class="fa fa-window-close"></i> تغییر وضعیت ارسال</a>
                                                    <a href="{{ route('admin.market.order.change-order-status',$order->id) }}"
                                                       class="dropdown-item text-right  text-sm text-muted"><i
                                                                class="fa fa-close"></i> تغییر وضعیت سفارش</a>
                                                    <a href="{{ route('admin.market.order.cancel-order',$order->id) }}"
                                                       class="dropdown-item text-right text-sm text-muted"><i
                                                                class="fa fa-{{ $order->order_status==4 ? 'check' : 'undo' }}"></i>
                                                        {{ $order->order_status==4 ? 'خروج از حالت باطل شده' : 'باطل کردن سفارش' }}
                                                    </a>
                                                    <form
                                                            action="{{ route('admin.market.order.destroy',$order->id) }}"
                                                            method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <a type="submit"
                                                           id="delete"
                                                           class="btn btn-xs dropdown-item text-right text-sm text-muted delete">
                                                            <i class="fa fa-trash"></i> حذف
                                                        </a>
                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
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

