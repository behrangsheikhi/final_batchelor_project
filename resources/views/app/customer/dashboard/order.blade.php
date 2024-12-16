@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>پنل مشتری | سفارشات</title>
@endsection

@section('content')

    {{--  orders  --}}
    <!-- start body -->

    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
        <!-- start vontent header -->
        <section class="content-header mb-4">
            <section class="d-flex justify-content-between align-items-center">
                <h2 class="content-header-title">
                    <span>لیست علاقه های من</span>
                </h2>
                <section class="content-header-link">
                    <!--<a href="#">مشاهده همه</a>-->
                </section>
            </section>
        </section>
        <!-- end vontent header -->


        <section class="d-flex justify-content-center my-4">
            <a class="btn btn-outline-success btn-sm mx-1" href="{{ route('customer.dashboard.profile.order') }}">همه
                سفارشات</a>
            <a class="btn btn-info btn-sm mx-1 text-light"
               href="{{ route('customer.dashboard.profile.order','type=1') }}">در انتظار تایید</a>
            <a class="btn btn-warning btn-sm mx-1 text-light"
               href="{{ route('customer.dashboard.profile.order','type=2') }}">تایید نشده</a>
            <a class="btn btn-success btn-sm mx-1 text-light"
               href="{{ route('customer.dashboard.profile.order','type=3') }}">پرداخت شده</a>
            <a class="btn btn-dark btn-sm mx-1 text-light"
               href="{{ route('customer.dashboard.profile.order','type=4') }}">لغو شده</a>
            <a class="btn btn-danger btn-sm mx-1 text-light"
               href="{{ route('customer.dashboard.profile.order','type=5') }}">مرجوع شده</a>
            <a class="btn btn-primary btn-sm mx-1 text-light"
               href="{{ route('customer.dashboard.profile.order','type=6') }}">بررسی نشده</a>
        </section>


        <!-- start content header -->
        <section class="content-header mb-3">
            <section class="d-flex justify-content-between align-items-center">
                <h2 class="content-header-title content-header-title-small">
                    لیست سفارشات شما
                </h2>
                <section class="content-header-link">
                    <!--<a href="#">مشاهده همه</a>-->
                </section>
            </section>
        </section>
        <!-- end content header -->



        <section class="order-wrapper">
            @if($orders->count() != 0)
                @foreach($orders as $order)
                    <section class="order-item fw-bolder">
                        <section class="d-flex justify-content-between">
                            <section>
                                <section class="order-item-date"><i
                                        class="fa fa-calendar-alt"></i>{{ convertEnglishToPersian(persianDateTime($order->created_at)) }}
                                </section>
                                <section class="order-item-id">
                                    <i class="fa fa-info-circle"></i>کد سفارش
                                    : {{ convertEnglishToPersian($order->order_number) }}
                                </section>
                                <section class="order-item-payment-type">
                                    <i class="fa fa-credit-card"></i>
                                   {{ $order->paymentTypeValue }}
                                </section>
                                <section class="order-item-payment-type">
                                    <i class="fa fa-{{ $order->orderStatusValue !== 3 ? 'check-circle' : 'times' }}"></i>
                                    {{ $order->orderStatusValue }}
                                </section>
                                <section class="order-item-payment-type">
                                    <i class="fa fa-shipping-fast"></i>
                                    {{ $order->deliveryStatusValue }}
                                </section>


                                <section class="order-item-products">
                                    @foreach($order->items as $item)

                                        <a href="{{ route('market.product',$item->single_product->slug) }}">
                                            <img src="{{ asset(json_decode($item->product_object)->image->indexArray->small) }}"
                                                 alt="{{ json_decode($item->product_object)->name }}">
                                        </a>
                                    @endforeach
                                </section>
                                <button class="btn btn-success btn-sm"
                                        style="border-radius: 50%;height: 50px;width: 50px;" type="button">
                                    <i class="fa fa-print text-light"></i>
                                </button>
                            </section>
                            <section class="order-item-link">
                                <a href="#"
                                   class="text-danger fw-bolder">
                                    {{ $order->payment_status != \App\Constants\PaymentStatusType::PAYED ? 'در انتظار تایید' : 'دریافت فاکتور' }}
                                </a>
                            </section>
                        </section>
                    </section>
                @endforeach

            @else
                <section class="order-item">
                    <section class="d-flex align-items-baseline">
                        <i class="fa fa-info-circle"></i>
                        <span class="fw-bolder">  سفارشی یافت نشد!</span>
                    </section>
                </section>
            @endif
        </section>
        {{ $orders->links() }}
    </section>


    <!-- end body -->

    {{--  orders  --}}

@endsection
@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
