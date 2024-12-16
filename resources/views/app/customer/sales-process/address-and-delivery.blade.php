@extends('app.layouts.master.master-two-col')

@section('head-tag')
    <title>مدیریت آدرس ها</title>
@endsection

@section('content')

    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        @if($errors->any())
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li style="list-style: none;"
                                        class="alert alert-danger text-decoration-none">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تکمیل اطلاعات ارسال کالا (آدرس گیرنده، مشخصات گیرنده، نحوه ارسال) </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب آدرس و مشخصات گیرنده
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>

                                <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                                         role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    @if(auth()->user()->addresses->count() == 0)
                                        <secrion>
                                            پس از ایجاد آدرس، آدرس را انتخاب کنید.
                                        </secrion>
                                    @else
                                        <secrion class="fw-bolder">
                                            یک آدرس را انتخاب کنید و یا در صورت نیاز آدرس جدید ایجاد کنید.
                                        </secrion>
                                    @endif
                                </section>


                                <section class="address-select">

                                    @foreach(auth()->user()->addresses as $address)
                                        <input type="radio" form="myForm" name="address_id" value="{{ $address->id }}"
                                               id="a-{{ $address->id }}"/> <!--checked="checked"-->
                                        <label for="a-{{ $address->id }}" class="address-wrapper mb-2 p-2">
                                            <section class="mb-2 fw-bolder">
                                                <i class="fa fa-map-marker-alt mx-1"></i>
                                                آدرس : {{ $address->address ?? '-' }}
                                            </section>
                                            <section class="mb-2 fw-bolder">
                                                <i class="fa fa-user-tag mx-1"></i>
                                                گیرنده : {{ $address->user->fullname }}
                                            </section>
                                            <section class="mb-2 fw-bolder">
                                                <i class="fa fa-mobile-alt mx-1"></i>
                                                موبایل گیرنده
                                                : {{ convertEnglishToPersian($address->user->mobile) }}
                                            </section>
                                            <a class="" data-bs-toggle="modal"
                                               data-bs-target="#update-address-{{ $address->id }}"><i
                                                    class="fa fa-edit"></i> ویرایش و حذف آدرس </a>
                                            <span class="address-selected">کالاها به این آدرس ارسال می شوند</span>
                                        </label>

                                        <!-- start update address Modal -->
                                        <section class="modal fade" id="update-address-{{ $address->id }}" tabindex="-1"
                                                 aria-labelledby="update-address-label" aria-hidden="true">
                                            <section class="modal-dialog">
                                                <section class="modal-content">
                                                    <section class="modal-header">
                                                        <h5 class="modal-title" id="update-address-label"><i
                                                                class="fa fa-edit"></i> ویرایش آدرس</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </section>
                                                    <section class="modal-body">

                                                        <form class="row"
                                                              action="{{ route('customer.update-address',$address->id) }}"
                                                              id="addressForm"
                                                              method="post">
                                                            @csrf
                                                            @method('PUT')

                                                            <section class="col-6 mb-2">
                                                                <label for="update-province-{{ $address->id }}"
                                                                       class="form-label mb-1 text-sm text-muted">استان</label>
                                                                <select
                                                                    name="province_id"
                                                                    class="form-select form-select-sm"
                                                                    id="update-province-{{ $address->id }}">
                                                                    @foreach($provinces as $province)
                                                                        <option
                                                                            {{ $address->province_id == $province->id ? 'selected' : '' }}
                                                                            data-update-url={{ route('customer.get-cities',$province->id) }}
                                                                            value="{{ $province->id }}">
                                                                            {{ $province->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="city"
                                                                       class="form-label mb-1 text-sm text-muted">شهر</label>
                                                                <select name="city_id"
                                                                        class="form-select form-select-sm"
                                                                        id="update-city-{{ $address->id }}">
                                                                    <option selected>شهر را انتخاب کنید</option>

                                                                </select>
                                                            </section>
                                                            <section class="col-12 mb-2">
                                                                <label for="address"
                                                                       class="form-label mb-1 text-sm text-muted">نشانی</label>
                                                                <textarea name="address"
                                                                          class="form-control form-control-sm"
                                                                          id="address"
                                                                          placeholder="آدرس را بصورت دقیق وارد کنید...">{{ $address->address ?? '' }}</textarea>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="postal_code"
                                                                       class="form-label mb-1 text-sm text-muted">کد
                                                                    پستی</label>
                                                                <input name="postal_code"
                                                                       value="{{ convertEnglishToPersian($address->postal_code) ?? '' }}"
                                                                       type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="postal_code" placeholder="کد پستی">
                                                            </section>


                                                            <section class="col-3 mb-2">
                                                                <label for="no"
                                                                       class="form-label mb-1 text-sm text-muted">پلاک</label>
                                                                <input name="no"
                                                                       value="{{ convertEnglishToPersian($address->no) ?? '' }}"
                                                                       type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="no" placeholder="پلاک">
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="unit"
                                                                       class="form-label mb-1 text-sm text-muted">واحد</label>
                                                                <input name="unit"
                                                                       value="{{ convertEnglishToPersian($address->unit) ?? '' }}"
                                                                       type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="unit" placeholder="واحد">
                                                            </section>

                                                            <section class="border-bottom mt-2 mb-3"></section>

                                                            <section class="col-12 mb-2">
                                                                <section class="form-check">
                                                                    <input
                                                                        {{ $address->recipient_first_name ? 'checked' : '' }}
                                                                        class="form-check-input"
                                                                        type="checkbox"
                                                                        name="receiver"
                                                                        id="update-receiver">
                                                                    <label
                                                                        class="form-check-label text-danger text-sm fw-bolder"
                                                                        for="update-receiver">
                                                                        سفارش برای شخص دیگری است (اطلاعات زیر تکمیل شود)
                                                                    </label>
                                                                </section>
                                                            </section>


                                                            <section class="col-6 mb-2">
                                                                <label for="first_name"
                                                                       class="form-label mb-1 text-sm text-muted">نام
                                                                    گیرنده</label>
                                                                <input name="recipient_first_name"
                                                                       value="{{ ($address->recipient_first_name) ?? '' }}"
                                                                       type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="update-first_name" disabled
                                                                       placeholder="نام گیرنده">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="last_name"
                                                                       class="form-label mb-1 text-sm text-muted">نام
                                                                    خانوادگی گیرنده</label>
                                                                <input name="recipient_last_name"
                                                                       type="text"
                                                                       value="{{ $address->recipient_last_name ?? '' }}"
                                                                       class="form-control form-control-sm"
                                                                       id="update-last_name"
                                                                       placeholder="نام خانوادگی گیرنده"
                                                                       disabled>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="mobile"
                                                                       class="form-label mb-1 text-sm text-muted">شماره
                                                                    موبایل</label>
                                                                <input name="mobile"
                                                                       type="text"
                                                                       value="{{ convertEnglishToPersian($address->mobile) ?? '' }}"
                                                                       class="form-control form-control-sm"
                                                                       id="update-mobile"
                                                                       placeholder="09..." disabled>
                                                            </section>
                                                            <section class="modal-footer py-1">
                                                                <button type="submit"
                                                                        class="btn btn-sm btn-primary">ذخیره
                                                                </button>
                                                            </section>
                                                        </form>
                                                        <form
                                                            action="{{ route('customer.remove-address',$address->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="row">
                                                                <button type="submit"
                                                                        style="margin: 0 auto;max-width : 90%;"
                                                                        class="mx-4 btn btn-sm btn-danger">
                                                                    <i class="fa fa-trash-alt"></i> حذف آدرس
                                                                </button>
                                                            </div>
                                                        </form>

                                                    </section>

                                                </section>
                                            </section>
                                        </section>
                                        <!-- end update address Modal -->

                                    @endforeach

                                    <section class="address-add-wrapper">
                                        <button class="address-add-button fw-bolder"
                                                type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس جدید
                                        </button>
                                        <!-- start add address Modal -->
                                        <section class="modal fade" id="add-address" tabindex="-1"
                                                 aria-labelledby="add-address-label" aria-hidden="true">
                                            <section class="modal-dialog">
                                                <section class="modal-content">
                                                    <section class="modal-header">
                                                        <h5 class="modal-title" id="add-address-label"><i
                                                                class="fa fa-plus"></i> ایجاد آدرس جدید</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </section>
                                                    <section class="modal-body">

                                                        <form class="row"
                                                              action="{{ route('customer.add-address') }}"
                                                              id="addressForm"
                                                              method="post">
                                                            @csrf

                                                            <section class="col-6 mb-2">
                                                                <label for="province"
                                                                       class="form-label mb-1 text-sm text-muted">استان</label>
                                                                <select
                                                                    name="province_id"
                                                                    class="form-select form-select-sm"
                                                                    id="province">
                                                                    <option selected>استان را انتخاب کنید</option>
                                                                    @foreach($provinces as $province)
                                                                        <option
                                                                            data-url={{ route('customer.get-cities',$province->id) }}
                                                                            value="{{ $province->id }}">{{ $province->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="city"
                                                                       class="form-label mb-1 text-sm text-muted">شهر</label>
                                                                <select name="city_id"
                                                                        class="form-select form-select-sm" id="city">
                                                                    <option selected>شهر را انتخاب کنید</option>

                                                                </select>
                                                            </section>
                                                            <section class="col-12 mb-2">
                                                                <label for="address"
                                                                       class="form-label mb-1 text-sm text-muted">نشانی</label>
                                                                <textarea name="address"
                                                                          class="form-control form-control-sm"
                                                                          id="address"
                                                                          placeholder="آدرس را بصورت دقیق وارد کنید..."></textarea>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="postal_code"
                                                                       class="form-label mb-1 text-sm text-muted">کد
                                                                    پستی</label>
                                                                <input name="postal_code" type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="postal_code" placeholder="کد پستی">
                                                            </section>


                                                            <section class="col-3 mb-2">
                                                                <label for="no"
                                                                       class="form-label mb-1 text-sm text-muted">پلاک</label>
                                                                <input name="no" type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="no" placeholder="پلاک">
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="unit"
                                                                       class="form-label mb-1 text-sm text-muted">واحد</label>
                                                                <input name="unit" type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="unit" placeholder="واحد">
                                                            </section>

                                                            <section class="border-bottom mt-2 mb-3"></section>

                                                            <section class="col-12 mb-2">
                                                                <section class="form-check">
                                                                    <input class="form-check-input"
                                                                           type="checkbox"
                                                                           name="receiver"
                                                                           id="receiver">
                                                                    <label
                                                                        class="form-check-label text-danger text-sm fw-bolder"
                                                                        for="receiver">
                                                                        سفارش برای شخص دیگری است (اطلاعات زیر تکمیل شود)
                                                                    </label>
                                                                </section>
                                                            </section>


                                                            <section class="col-6 mb-2">
                                                                <label for="first_name"
                                                                       class="form-label mb-1 text-sm text-muted">نام
                                                                    گیرنده</label>
                                                                <input name="recipient_first_name" type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="first_name" disabled
                                                                       placeholder="نام گیرنده">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="last_name"
                                                                       class="form-label mb-1 text-sm text-muted">نام
                                                                    خانوادگی گیرنده</label>
                                                                <input name="recipient_last_name" type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="last_name" placeholder="نام خانوادگی گیرنده"
                                                                       disabled>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="mobile"
                                                                       class="form-label mb-1 text-sm text-muted">شماره
                                                                    موبایل</label>
                                                                <input name="mobile"
                                                                       type="text"
                                                                       class="form-control form-control-sm"
                                                                       id="mobile"
                                                                       placeholder="09..." disabled>
                                                            </section>
                                                            <section class="modal-footer py-1">
                                                                <button type="submit"
                                                                        class="btn btn-sm btn-primary">ذخیره
                                                                </button>

                                                            </section>
                                                        </form>
                                                    </section>

                                                </section>
                                            </section>
                                        </section>
                                        <!-- end add address Modal -->


                                    </section>

                                </section>
                            </section>


                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب نحوه ارسال
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="delivery-select ">

                                    <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                                             role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            نحوه ارسال کالا را انتخاب کنید. هنگام انتخاب لطفا مدت زمان ارسال را در نظر
                                            بگیرید.
                                        </secrion>
                                    </section>

                                    @foreach($delivery_methods as $delivery_method)
                                        <input type="radio"
                                               form="myForm"
                                               name="delivery_id"
                                               value="{{ $delivery_method->id }}"
                                               id="d-{{ $delivery_method->id }}"
                                               data-delivery-price="{{ $delivery_method->amount }}"
                                               onchange="updateDeliveryPrice({{ $delivery_method->amount }})"/>
                                        <label for="d-{{ $delivery_method->id }}"
                                               class="col-12 col-md-4 delivery-wrapper mb-2 pt-2">
                                            <section class="mb-2 text-sm">
                                                <i class="fa fa-shipping-fast mx-1"></i>
                                                {{ $delivery_method->name }}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-clock mx-1"></i>
                                                ارسال کالا
                                                تا {{ convertEnglishToPersian($delivery_method->delivery_time) }} {{ $delivery_method->delivery_time_unit }}
                                                کاری آینده
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-info-circle mx-1"></i>
                                                {{ strip_tags($delivery_method->description) }}
                                            </section>
                                        </label>
                                    @endforeach


                                </section>
                            </section>


                        </section>

                        @if($cart_items->count() !== 0)

                            <section class="col-md-3">
                                <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                    @php
                                        $totalProductPrice = 0;
                                        $totalDiscount = 0;
                                        $delivery_method_price = isset($delivery_method_price) ? $delivery_method_price : 0;

                                    @endphp

                                    @foreach($cart_items as $cart_item)
                                        @php
                                            $totalProductPrice += $cart_item->cart_item_product_price() * $cart_item->number;
                                            (float)$totalDiscount += $cart_item->cart_item_product_discount() * $cart_item->number;

                                        @endphp
                                    @endforeach
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">قیمت کالا ({{ $cart_items->count() }})</p>
                                        <p class="text-muted">
                                        <span
                                            data-total-product-price="{{ $totalProductPrice }}"
                                            id="total-product-price">{{ priceFormat($totalProductPrice) }}</span>
                                            تومان
                                        </p>

                                    </section>

                                    @if($totalDiscount !== 0)
                                        <section class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted">مجموع تخفیف</p>
                                            <p class="text-danger fw-bolder">
                                                <span
                                                    data-total-discount-price="{{ $totalDiscount }}"
                                                    id="total-discount-price">{{ priceFormat($totalDiscount) }}</span>
                                                تومان
                                            </p>
                                        </section>
                                    @endif

                                    <section class="border-bottom mb-3"></section>
                                    @php
                                        $final_price = $totalProductPrice - $totalDiscount;
                                    @endphp

                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">جمع سبد خرید</p>
                                        <p class="fw-bolder">
                                            <span
                                                data-total-price="{{ $final_price }}"
                                                id="total-price">{{ priceFormat($final_price) }}</span>
                                            تومان</p>
                                    </section>

                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">هزینه ارسال</p>
                                        <p class="text-warning">
                                            <span id="delivery-method-price" >0</span> تومان
                                        </p>
                                    </section>

                                    <p class="my-3">
                                        <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که
                                        انتخاب می کنید در مدت زمان ذکر شده ارسال می شود.
                                    </p>

                                    <section class="border-bottom mb-3"></section>


                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">مبلغ قابل پرداخت</p>
                                        <p class="fw-bold">
                                            <span id="final-price-with-delivery">{{ priceFormat($final_price) }}</span>
                                            تومان
                                        </p>
                                    </section>

                                    <form action="{{ route('customer.select-address-and-delivery') }}" method="post"
                                          id="myForm">
                                        @csrf
                                    </form>

                                    <section class="">
                                        <section id="address-button" href="address.html"
                                                 class="text-warning border border-warning text-center py-2 pointer rounded-2 d-block">
                                            آدرس و نحوه ارسال را انتخاب کن
                                        </section>
                                        <button id="next-level" type="button"
                                                onclick="document.getElementById('myForm').submit()"
                                                style="width: 100%;" class="fw-bolder btn custom-btn d-none">ادامه
                                            فرآیند خرید
                                        </button>
                                    </section>

                                </section>
                            </section>
                        @endif

                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->

@endsection

@section('script')

    <script type="text/javascript">


        function updateDeliveryPrice(price) {
            // Update the displayed delivery price
            document.getElementById("delivery-method-price").innerText = toFarsiNumber(price);

            // Trigger the update of the total price
            updateTotalPrice(price);
        }

        function updateTotalPrice(deliveryPrice) {
            let totalProductPrice = parseFloat(document.getElementById("total-product-price").dataset.totalProductPrice);
            let totalDiscount = parseFloat(document.getElementById("total-discount-price").dataset.totalDiscountPrice);

            // Calculate the total price by adding the delivery price to the total product price and subtracting the total discount
            let totalPrice = totalProductPrice + deliveryPrice - totalDiscount;

            // Format and display the total price
            document.getElementById("final-price-with-delivery").innerText = toFarsiNumber(totalPrice);
        }


        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }

        $(document).ready(function () {

            function clearModalFields() {
                $('#add-address').find('form')[0].reset(); // Update selector to target the form inside the modal
            }

            $('#add-address').on('shown.bs.modal', function () { // Change event from 'show.bs.modal' to 'shown.bs.modal'
                clearModalFields();
            });

            $('#receiver').change(function () {
                if ($(this).is(':checked')) {
                    $('#first_name').prop('disabled', false);
                    $('#last_name').prop('disabled', false);
                    $('#mobile').prop('disabled', false);
                } else {
                    $('#first_name').prop('disabled', true);
                    $('#last_name').prop('disabled', true);
                    $('#mobile').prop('disabled', true);
                }
            });

            $('#update-receiver').change(function () {
                if ($(this).is(':checked')) {
                    $('#update-first_name').prop('disabled', false);
                    $('#update-last_name').prop('disabled', false);
                    $('#update-mobile').prop('disabled', false);
                } else {
                    $('#update-first_name').prop('disabled', true);
                    $('#update-last_name').prop('disabled', true);
                    $('#update-mobile').prop('disabled', true);
                }
            });

            // for adding address
            $('#province').change(function () {
                let province = $('#province option:selected');
                let path = province.attr('data-url');
                $.ajax({
                    url: path,
                    type: "GET",
                    success: function (response) {
                        console.log(response)
                        if (response.status) {
                            let cities = response.cities;
                            $('#city').empty();
                            cities.map((city) => {
                                $('#city').append($('<option/>').val(city.id).text(city.name));
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                        console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                    }
                });
            });

            // for update address
            $('#update-province').change(function () {
                let province = $('#update-province option:selected');
                let path = province.attr('data-url');

                $.ajax({
                    url: path,
                    type: "GET",
                    success: function (response) {
                        if (response.status) {
                            let cities = response.cities;
                            $('#update-city').empty();
                            cities.map((city) => {
                                $('#update-city').append($('<option/>').val(city.id).text(city.name));
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                        console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                    }
                });
            });
        });


        let addresses = {!! auth()->user()->addresses !!};
        addresses.map(function (address) {
            let id = address.id;
            let target = `#update-province-${id}`;
            let selected = `${target} option:selected`

            $(target).change(function () {
                var element = $(selected);
                let path = element.attr('data-update-url');
                $.ajax({
                    url: path,
                    type: "GET",
                    success: function (response) {
                        if (response.status) {
                            let cities = response.cities;
                            $(`#update-city-${id}`).empty();
                            cities.map((city) => {
                                $(`#update-city-${id}`).append($('<option/>').val(city.id).text(city.name));
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                        console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                    }
                });
            });
        });


    </script>


    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
