@extends('app.layouts.master.master-two-col')

@section('app.layouts.head-tag')
    <title>حساب کاربری | ویرایش اطلاعات</title>
@endsection

@section('content')

    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تایید شماره موبایل</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9">
                            <form id="profile-confirm"
                                  action="{{ route('customer.profile.confirm',$token) }}"
                                  method="post"
                                  class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                @csrf

                                <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                         role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <section class="fw-bolder">
                                        کد تایید شش رقمی ارسالی به {{ convertEnglishToPersian($identity) }} را وارد کنید.
                                    </section>
                                </section>

                                <section class="row pb-3">
                                    @if(auth()->check())
                                        <section class="col-12 col-md-6 my-2">
                                            <div class="form-group">
                                                <label for="otp">

                                                </label>
                                                <input type="number"
                                                       class="form-control form-control-sm text-center"
                                                       name="otp"
                                                       autofocus
                                                       placeholder="برای مثال : 123456"
                                                       id="otp"
                                                       value="{{ old('otp') }}">
                                            </div>
                                            @error('otp')
                                            <span class="alert_required text-danger text-sm" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                            @enderror
                                        </section>
                                    @endif
                                </section>
                                <button class="btn btn-success" type="submit">ثبت</button>
                            </form>

                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                @php
                                    $totalProductPrice = 0;
                                    $totalDiscount = 0;
                                @endphp

                                @foreach($cart_items as $cart_item)
                                    @php
                                        $totalProductPrice += $cart_item->cart_item_product_price() * $cart_item->number;
                                        $totalDiscount += $cart_item->cart_item_product_discount() * $cart_item->number;
                                    @endphp
                                @endforeach

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{ $cart_items->count() }})</p>
                                    <p class="text-muted"><span
                                            id="total_product_price">{{ priceFormat($totalProductPrice) }}</span> تومان
                                    </p>
                                </section>

                                @if($totalDiscount != 0)
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">تخفیف کالاها</p>
                                        <p class="text-danger fw-bolder"><span
                                                id="total_discount">{{ priceFormat($totalDiscount) }}</span> تومان</p>
                                    </section>
                                @endif
                                <section class="border-bottom mb-3"></section>
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder"><span
                                            id="total_price">{{ priceFormat($totalProductPrice - $totalDiscount) }}</span>
                                        تومان</p>
                                </section>

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای
                                    ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب
                                    کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
                                    پرداخت این سفارش صورت میگیرد.
                                </p>


                                <section class="">
                                    <button type="button"
                                            disabled
                                            class="btn custom-btn d-block w-100">تکمیل فرآیند خرید
                                    </button>
                                </section>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->

@endsection
@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
