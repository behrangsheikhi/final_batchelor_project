@extends('app.layouts.master.master-two-col')

@section('head-tag')
    <title>نهایی سازی سفارش و پرداخت</title>
@endsection

@section('content')

    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">

            @if(session('coupon'))
                <div class="alert alert-success">{{ session('coupon') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif


            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li class="list-unstyled alert alert-danger">
                            <i class="fa fa-info-circle"></i> {{ $error }}
                        </li>
                    @endforeach
                </ul>
            @endif

            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>انتخاب نوع پرداخت </span>
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
                                            کد تخفیف
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>

                                <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                         role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <secrion>
                                        کد تخفیف خود را در این بخش وارد کنید.
                                    </secrion>
                                </section>

                                <form action="{{ route('customer.coupon-discount') }}" method="post">
                                    @csrf

                                    <section class="row">
                                        <section class="col-md-5">
                                            <section class="input-group input-group-sm">
                                                <input id="code" name="code" type="text" class="form-control"
                                                       placeholder="کد تخفیف را وارد کنید">
                                                <button class="btn btn-primary" type="submit">اعمال کد</button>
                                            </section>
                                        </section>

                                    </section>
                                </form>


                            </section>


                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب نوع پرداخت
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="payment-select">

                                    <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                             role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            <span class="fw-bolder text-decoration-underline">پرداخت اینترنتی</span> از
                                            طریق درگاه پرداخت امن و معتبر انجام می شود.
                                        </secrion>
                                    </section>
                                    <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                             role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            <span class="fw-bolder text-decoration-underline">پرداخت آفلاین</span> به
                                            صورت کارت به کارت صورت می گیرد که بصورت امن و قابل پیگیری است.
                                        </secrion>
                                    </section>

                                    <div class="col-12">

                                        <section class="row mb-2">

                                            <form action="{{ route('customer.payment-submit') }}"
                                                  method="post"
                                                  id="payment-submit">
                                                @csrf

                                                <input type="radio" name="type" value="1" id="d1"/>
                                                <label for="d1" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                                    <section class="mb-2">
                                                        <i class="fa fa-credit-card mx-1"></i>
                                                        پرداخت آنلاین
                                                    </section>
                                                    <section class="mb-2">
                                                        <i class="fa fa-info-circle mx-1"></i>
                                                        درگاه پرداخت زرین پال
                                                    </section>
                                                </label>

                                                <input type="radio" name="type" value="2" id="d2"/>
                                                <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                                    <section class="mb-2">
                                                        <i class="fa fa-credit-card mx-1"></i>
                                                        پرداخت آفلاین
                                                    </section>
                                                    <section class="mb-2">
                                                        <i class="fa fa-info-circle mx-1"></i>
                                                        پرداخت به صورت کارت به کارت
                                                    </section>
                                                </label>

                                                <input type="radio" name="type" value="3" id="d3"/>
                                                <label for="d3" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                                    <section class="mb-2">
                                                        <i class="fa fa-credit-card mx-1"></i>
                                                        پرداخت در محل
                                                    </section>
                                                    <section class="mb-2">
                                                        <i class="fa fa-info-circle mx-1"></i>
                                                        پرداخت بصورت در حضوری
                                                    </section>
                                                </label>
                                            </form>


                                        </section>

                                    </div>


                                </section>
                            </section>


                        </section>


                        @if($cart_items->count() !== 0)

                            <section class="col-md-3">
                                <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                    @php
                                        $totalProductPrice = 0;
                                        $totalDiscount = 0;
                                        $common_discount =0;
                                    @endphp

                                    @foreach($cart_items as $cart_item)
                                        @php
                                            $totalProductPrice += $cart_item->cart_item_product_price() * $cart_item->number;
                                            $totalDiscount += $cart_item->cart_item_product_discount() * $cart_item->number;
                                            $total_product_price_with_discount = $totalProductPrice - $totalDiscount;

                                        @endphp
                                    @endforeach
                                    <section
                                        class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                        <p class="text-muted">قیمت کالاها
                                            ({{ convertEnglishToPersian($cart_items->count()) }})</p>
                                        <p id="total-product-price" class="fw-bolder">
                                            <span>{{ priceFormat($totalProductPrice) }}</span> تومان</p>
                                    </section>

                                    @if($totalDiscount !== 0)
                                        <section class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="text-muted">تخفیف شگفت انگیز</p>
                                            <p class="fw-bolder text-danger">
                                                <span>{{ priceFormat($totalDiscount) }}</span> تومان
                                            </p>
                                        </section>
                                    @endif

                                    @if($order->common_discount !== null)
                                        <section class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="text-muted">میزان تخفیف عمومی</p>
                                            <p class="fw-bolder text-danger">
                                                <span>{{ priceFormat($order->common_discount->percentage) }}</span> درصد
                                            </p>
                                        </section>

                                        <section class="d-flex justify-content-between align-items-center mb-2">
                                            <p class="text-muted">میزان حداکثر تخفیف عمومی</p>
                                            <p class="fw-bolder text-danger">
                                                <span>{{ priceFormat($order->common_discount->discount_ceiling) }}</span>
                                                تومان
                                            </p>
                                        </section>

                                        <section
                                            class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                            <p class="text-muted">حداقل میزان سفارش</p>
                                            <p class="fw-bolder text-danger">
                                                <span>{{ priceFormat($order->common_discount->minimum_order_amount) }}</span>
                                                تومان
                                            </p>
                                        </section>
                                    @endif

                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">جمع سبد خرید</p>
                                        <p class="fw-bolder text-success">
                                            <span
                                                id="total-price">{{ priceFormat($total_product_price_with_discount) }}</span>
                                            تومان</p>
                                    </section>

                                    <section
                                        class="d-flex justify-content-between align-items-center border-bottom mb-2">
                                        <p class="text-muted">هزینه ارسال</p>
                                        <p class="text-warning fw-bolder">{{ priceFormat($delivery->amount) }} تومان </p>
                                    </section>

                                    <p class="my-3">
                                        <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که
                                        انتخاب می کنید در مدت زمان ذکر شده ارسال می شود.
                                    </p>

                                    <section class="border-bottom mb-3"></section>

                                    @php
                                        $final_price = $totalProductPrice - $totalDiscount + $delivery->amount + ($common_discount ?? 0);
                                    @endphp

                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">مبلغ قابل پرداخت</p>
                                        <p class="fw-bold">{{ priceFormat($final_price) }} تومان </p>
                                    </section>

                                    <section class="">
                                        <button id="final-level"
                                                class="btn custom-btn fw-bolder"
                                                onclick="document.getElementById('payment-submit').submit()"
                                                style="width: 100%;">
                                            ثبت نهایی و پرداخت
                                        </button>
                                    </section>

                                </section>
                            </section>
                        @endif

                        <style>
                            .alert-message {
                                color: green;
                                margin-top: 5px;
                                transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
                            }

                            .alert-message.hide {
                                opacity: 0;
                                transform: translateY(-20px);
                            }

                        </style>


                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->

@endsection

@section('script')

    <script type="text/javascript">

        $(document).ready(function () {

            // پرداخت در محل
            $('#d3').click(function(){
                // Check if the div element already exists
                if ($('#cash_receiver').length === 0) {
                    let newDiv = document.createElement('div');
                    newDiv.innerHTML = `
                        <span autofocus class="input-group input-group-sm">
                            <input type="text" name="cash_receiver" id="cash_receiver" class="form-control form-control-sm" form="payment-submit" placeholder="نام و نام خانوادگی دریافت کننده...">
                        </span>`;
                    document.getElementsByClassName('content-wrapper')[1].appendChild(newDiv);
                }
            });

            // پرداخت کارت به کارت
            $('#d2').click(function () {
                // Check if the div element already exists
                if ($('#card_to_card').length === 0) {
                    let newDiv = document.createElement('div');
                    newDiv.innerHTML = `
                    <span autofocus class="input-group input-group-sm">
                        <input class="form-control form-control-sm" id="card_to_card" type="text" disabled placeholder="{{ convertEnglishToPersian(6219861914490874) }}"/>
                        <button class="btn btn-sm btn-primary copy-btn"><i class="fa fa-copy"></i></button>
                    </span>`;
                    document.getElementsByClassName('content-wrapper')[1].appendChild(newDiv);

                    // Attach click event handler to the copy button
                    $('.copy-btn').click(function() {
                        copyToClipboard('#card_to_card');
                    });
                }
            });

            // Function to copy text to clipboard and display a message
            function copyToClipboard(element) {
                var copyText = $(element).val();
                var input = document.createElement('input');
                input.setAttribute('value', copyText);
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);

                // Show a message to inform the user that the text is copied
                var messageDiv = document.createElement('div');
                messageDiv.innerHTML = 'با موفقیت کپی شد!';
                messageDiv.className = 'alert-message';
                document.getElementsByClassName('content-wrapper')[1].appendChild(messageDiv);

                // Automatically remove the message after 2 seconds
                setTimeout(function() {
                    messageDiv.classList.add('hide');
                    setTimeout(function() {
                        messageDiv.parentNode.removeChild(messageDiv);
                    }, 500); // Adjust duration based on CSS transition
                }, 2000);
            }



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

