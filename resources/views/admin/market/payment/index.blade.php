@extends('admin.layout.master')

@section('head-tag')
    @if(Route::is('admin.market.payment.index'))
        <title>فروشگاه | پرداخت ها | لیست تمام پرداخت ها</title>
    @elseif(Route::is('admin.market.payment.online'))
        <title>فروشگاه | پرداخت ها | لیست پرداخت های آنلاین</title>
    @elseif(Route::is('admin.market.payment.offline'))
        <title>فروشگاه | پرداخت ها | لیست پرداخت های کارت به کارت</title>
    @elseif(Route::is('admin.market.payment.cash'))
        <title>فروشگاه | پرداخت ها | لیست پرداخت های حضوری</title>
    @endif
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.payment.payment-print') }}" type="button"
                       class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> پرینت تراکنش ها
                    </a>


                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">پرداخت ها</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">

                    <small>
                        @if(Route::is('admin.market.payment.index'))
                            در این قسمت می توانید لیست تمام پرداخت ها را مشاهده کنید.
                            <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل پرداخت ها
                                : {{ $payments->count() != 0 ? $payments->count() : 'صفر' }}</strong>
                        @elseif(Route::is('admin.market.payment.offline'))
                            در این قسمت می توانید لیست پرداخت های کارت به کارت را مشاهده کنید.
                            <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل پرداخت های کارت به کارت
                                : {{ $payments->count() != 0 ? $payments->count() : 'صفر' }}</strong>
                        @elseif(Route::is('admin.market.payment.cash'))
                            در این قسمت می توانید لیست پرداخت های حضوری را مشاهده کنید.
                            <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل پرداخت های حضوری
                                : {{ $payments->count() != 0 ? $payments->count() : 'صفر' }}</strong>
                        @elseif(Route::is('admin.market.payment.online'))
                            در این قسمت می توانید لیست پرداخت های آنلاین را مشاهده کنید.
                            <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل پرداخت های آنلاین
                                : {{ $payments->count() != 0 ? $payments->count() : 'صفر' }}</strong>
                        @endif
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
                                   style="width:100%">
                                <style>
                                    th {
                                        text-align: right !important;
                                    }
                                </style>
                                <thead>
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                    @if(Route::is('admin.market.payment.index'))
                                        <th scope="col">روش پرداخت</th>
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">پرداخت کننده</th>
                                        <th scope="col">تاریخ پرداخت</th>
                                        <th scope="col">وضعیت پرداخت</th>
                                        <th class="text-center" scope="col"><i class="fa fa-cogs"></i> تنظیمات</th>

                                    @elseif(Route::is('admin.market.payment.offline'))
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">پرداخت کننده</th>
                                        <th scope="col">کد تراکنش</th>
                                        <th scope="col">تاریخ پرداخت</th>
                                        <th scope="col">وضعیت</th>
                                        <th class="text-center" scope="col"><i class="fa fa-cogs"></i> تنظیمات</th>

                                    @elseif(Route::is('admin.market.payment.online'))
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">پرداخت کننده</th>
                                        <th scope="col">درگاه</th>
                                        <th scope="col">کد تراکنش</th>
                                        <th scope="col">وضعیت</th>
                                        <th class="text-center" scope="col"><i class="fa fa-cogs"></i> تنظیمات</th>

                                    @elseif(Route::is('admin.market.payment.cash'))
                                        <th scope="col">مبلغ</th>
                                        <th scope="col">پرداخت کننده</th>
                                        <th scope="col">دریافت کننده وجه</th>
                                        <th scope="col">تاریخ پرداخت</th>
                                        <th scope="col">وضعیت</th>
                                        <th class="text-center" scope="col"><i class="fa fa-cogs"></i> تنظیمات</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        @if(Route::is('admin.market.payment.index'))
                                            <td>{{ $payment->paymentTypeValue }}</td>
                                            <td>{{ priceFormat($payment->amount) }} تومان</td>
                                            <td>{{ $payment->user->fullname ?? '-' }}</td>
                                            <td>{{ persianDateTime($payment->created_at) }}</td>
                                            <td>
                                                @if($payment->status == \App\Constants\PaymentStatusType::RETURNED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> مرجوعی
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::PAYED)
                                                    <button class="btn btn-xs btn-success text-xs">
                                                        <i class="fa fa-check-circle"></i> پرداخت شده
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                    <button class="btn btn-xs btn-warning text-xs">
                                                        <i class="fa fa-clock-o"></i> در انتظار پرداخت
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> لغو پرداخت شده
                                                    </button>
                                                @endif
                                            </td>

                                            <td class="text-left">
                                                <div class="dropdown">
                                                <span role="button" class="btn btn-success btn-xs btn-block dropdown-toggle"
                                                      id="dropdown-menu-link" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i> عملیات
                                                </span>
                                                    <style>
                                                        .dropdown-menu a:hover {
                                                            background-color: #2EA08C;
                                                            color: #ffffff !important;
                                                        }
                                                    </style>
                                                    <div aria-label="dropdown-menu-link" class="dropdown-menu">
                                                        <a href="{{ route('admin.market.payment.show',$payment->id) }}"
                                                           type="submit" class="dropdown-item text-right text-sm text-muted"
                                                           title="نمایش"><i class="fa fa-eye"></i> نمایش </a>

                                                        @if($payment->status == \App\Constants\PaymentStatusType::PAYED)
                                                            <a href="{{ route('admin.market.payment.payed-or-pending',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-clock-o"></i> تغییر به در انتظار پرداخت </a>
                                                        @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                            <a href="{{ route('admin.market.payment.payed-or-pending',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-check-circle"></i> تایید پرداخت
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        @elseif(Route::is('admin.market.payment.offline'))
                                            <td>{{ number_format($payment->amount) }} تومان</td>
                                            <td>{{ $payment->user->fullname ?? '-' }}</td>
                                            <td>{{ $payment->paymentable->transaction_id ?? '-' }}</td>
                                            <td>{{ persianDateTime($payment->created_at) }}</td>
                                            <td>
                                                @if($payment->status == \App\Constants\PaymentStatusType::RETURNED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> مرجوعی
                                                    </button>
                                                @elseif($payment->status === \App\Constants\PaymentStatusType::PAYED)
                                                    <button class="btn btn-xs btn-success text-xs">
                                                        <i class="fa fa-check-circle"></i> پرداخت شده
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                    <button class="btn btn-xs btn-warning text-xs">
                                                        <i class="fa fa-clock-o"></i> در انتظار پرداخت
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> لغو پرداخت شده
                                                    </button>
                                                @endif
                                            </td>


                                            <td class="text-left">
                                                <div class="dropdown">
                                                <span role="button" class="btn btn-warning btn-sm btn-block dropdown-toggle"
                                                      id="dropdown-menu-link" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i> عملیات
                                                </span>
                                                    <style>
                                                        .dropdown-menu a:hover {
                                                            background-color: #2EA08C;
                                                            color: #ffffff !important;
                                                        }
                                                    </style>
                                                    <div aria-label="dropdown-menu-link" class="dropdown-menu">
                                                        <a href="{{ route('admin.market.payment.show',$payment->id) }}"
                                                           type="submit" class="dropdown-item text-right text-sm text-muted"
                                                           title="نمایش"><i class="fa fa-eye"></i> نمایش </a>

                                                        @if($payment->status == \App\Constants\PaymentStatusType::PAYED)
                                                            <a href="{{ route('admin.market.payment.canceled',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-clock"></i> لغو کردن </a>
                                                        @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                            <a href="{{ route('admin.market.payment.canceled',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-check-circle"></i> تایید پرداخت
                                                            </a>
                                                        @endif

                                                        @if($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                            <a href="{{ route('admin.market.payment.returned',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               title="برگرداندن"><i class="fa fa-reply"></i> برگرداندن </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- TODO : HAVE BUG HERE, THE INDEX VIEW DOES NOT SHOW SOME DATA IN ADMIN/VENDOR PANEL --}}
                                        @elseif(Route::is('admin.market.payment.online'))
                                            <td>{{ number_format($payment->paymentable->amount) }} تومان</td>
                                            <td>{{ $payment->paymentable->user->fullname ?? '-' }}</td>
                                            <td>{{ $payment->paymentable->gateway ?? '-' }}</td>
                                            <td>{{ $payment->paymentable->transaction_id ?? '-' }}</td>
                                            <td>
                                                @if($payment->status == \App\Constants\PaymentStatusType::RETURNED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> مرجوعی
                                                    </button>
                                                @elseif($payment->status === \App\Constants\PaymentStatusType::PAYED)
                                                    <button class="btn btn-xs btn-success text-xs">
                                                        <i class="fa fa-check-circle"></i> پرداخت شده
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                    <button class="btn btn-xs btn-warning text-xs">
                                                        <i class="fa fa-clock-o"></i> در انتظار پرداخت
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> لغو پرداخت شده
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                <div class="dropdown">
                                                <span role="button" class="btn btn-warning btn-sm btn-block dropdown-toggle"
                                                      id="dropdown-menu-link" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i> عملیات
                                                </span>
                                                    <style>
                                                        .dropdown-menu a:hover {
                                                            background-color: #2EA08C;
                                                            color: #ffffff !important;
                                                        }
                                                    </style>
                                                    <div aria-label="dropdown-menu-link" class="dropdown-menu">
                                                        <a href="{{ route('admin.market.payment.show',$payment->id) }}"
                                                           type="submit" class="dropdown-item text-right text-sm text-muted"
                                                           title="نمایش"><i class="fa fa-eye"></i> نمایش </a>

                                                        @if($payment->status == \App\Constants\PaymentStatusType::PAYED)
                                                            <a href="{{ route('admin.market.payment.cancel-or-returned',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-clock"></i> لغو کردن </a>
                                                        @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                            <a href="{{ route('admin.market.payment.cancel-or-returned',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-check-circle"></i> تایید پرداخت
                                                            </a>
                                                        @endif

                                                        @if($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                            <a href="{{ route('admin.market.payment.cancel-or-returned',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               title="برگرداندن"><i class="fa fa-reply"></i> برگرداندن </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                        @elseif(Route::is('admin.market.payment.cash'))
                                            <td>{{ number_format($payment->paymentable->amount) }} تومان</td>
                                            <td>{{ $payment->paymentable->user->fullname ?? '-' }}</td>
                                            <td>{{ $payment->paymentable->cash_receiver ?? '-' }}</td>
                                            <td>{{ persianDateTime($payment->paymentable->pay_date) }}</td>
                                            <td>
                                                @if($payment->status == \App\Constants\PaymentStatusType::RETURNED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> مرجوعی
                                                    </button>
                                                @elseif($payment->status === \App\Constants\PaymentStatusType::PAYED)
                                                    <button class="btn btn-xs btn-success text-xs">
                                                        <i class="fa fa-check-circle"></i> پرداخت شده
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                    <button class="btn btn-xs btn-warning text-xs">
                                                        <i class="fa fa-clock-o"></i> در انتظار پرداخت
                                                    </button>
                                                @elseif($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                    <button class="btn btn-xs btn-danger text-xs">
                                                        <i class="fa fa-times-circle"></i> لغو پرداخت شده
                                                    </button>
                                                @endif
                                            </td>
                                            <td class="text-left">
                                                <div class="dropdown">
                                                <span role="button" class="btn btn-warning btn-sm btn-block dropdown-toggle"
                                                      id="dropdown-menu-link" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-cogs"></i> عملیات
                                                </span>
                                                    <style>
                                                        .dropdown-menu a:hover {
                                                            background-color: #2EA08C;
                                                            color: #ffffff !important;
                                                        }
                                                    </style>
                                                    <div aria-label="dropdown-menu-link" class="dropdown-menu">
                                                        <a href="{{ route('admin.market.payment.show',$payment->id) }}"
                                                           type="submit" class="dropdown-item text-right text-sm text-muted"
                                                           title="نمایش"><i class="fa fa-eye"></i> نمایش </a>

                                                        @if($payment->status == \App\Constants\PaymentStatusType::PAYED)
                                                            <a href="{{ route('admin.market.payment.canceled',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-clock"></i> لغو کردن </a>
                                                        @elseif($payment->status == \App\Constants\PaymentStatusType::PENDING)
                                                            <a href="{{ route('admin.market.payment.canceled',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               type="submit"><i class="fa fa-check-circle"></i> تایید پرداخت
                                                            </a>
                                                        @endif

                                                        @if($payment->status == \App\Constants\PaymentStatusType::CANCELED)
                                                            <a href="{{ route('admin.market.payment.returned',$payment->id) }}"
                                                               class="dropdown-item text-right text-sm text-muted"
                                                               title="برگرداندن"><i class="fa fa-reply"></i> برگرداندن </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
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
@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

