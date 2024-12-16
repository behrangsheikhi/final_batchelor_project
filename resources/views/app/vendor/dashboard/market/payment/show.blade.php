@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | پرداخت ها | جزئیات پرداخت</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.payment.index') }}" type="button"
                       class="btn btn-success btn-sm">
                        <i class="fa fa-print"></i> جزئیات پرداخت
                    </a>


                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.payment.index') }}">خانه</a>
                        </li>
                        <li class="breadcrumb-item active">جزئیات</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت شما می توانید جزئیات پرداخت مربوط به مشتری را دیده و خروجی بگیرید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card-body" style="border: 1px solid #cdcdcd;border-radius: 5px;">
                <div class="row">
                    <section class="col-4">
                        <label for="">نام پرداخت کننده:</label>
                        <span class="font-weight-bold">{{ $user->full_name }}</span>
                    </section>
                    <section class="col-4">
                        <label for="">مبلغ کل:</label>
                        <span class="font-weight-bold">{{ number_format($payment->amount) }} تومان</span>
                    </section>
                    <section class="col-4">
                        <label for="">وضعیت:</label>
                        <span class="font-weight-bold">
                            @if($payment->status === \App\Constants\PaymentStatusType::PAYED)
                                پرداخت شده
                            @elseif($payment->status === \App\Constants\PaymentStatusType::CANCELED)
                                لغو شده
                            @elseif($payment->status === \App\Constants\PaymentStatusType::PENDING)
                                در انتظار تایید
                            @elseif($payment->status == \App\Constants\PaymentStatusType::RETURNED)
                                مرجوعی
                            @endif
                        </span>
                    </section>
                </div>
                <div class="row">
                    <section class="col-4">
                        <label for="">تاریخ تراکنش:</label>
                        <span class="font-weight-bold">{{ persianDate($payment->created_at) }}</span>
                    </section>
                    <section class="col-4">
                        <label for="">نوع پرداخت:</label>
                        <span class="font-weight-bold">
                            @if($payment->paymentable_type === \App\Constants\PaymentTypeValue::OFFLINE_PAYMENT)
                                پرداخت کارت به کارت
                            @elseif($payment->paymentable_type === \App\Constants\PaymentTypeValue::CASH_PAYMENT)
                                پرداخت در محل
                            @elseif($payment->paymentable_type === \App\Constants\PaymentTypeValue::ONLINE_PAYMENT)
                                ({{ $payment->paymentable->gateway ?? '-' }})   - پرداخت آنلاین
                            @endif
                        </span>
                    </section>
                    <section class="col-4">
                        <label for="">دریافت کننده:</label>
                        <span class="font-weight-bold">{{ $payment->paymentable->cash_receiver ?? '-' }}</span>
                    </section>
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

