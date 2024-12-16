@extends('app.layouts.master.master-two-col')

@section('head-tag')
    <title>سبد خرید شما</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                                <span>سبد خرید شما</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9 mb-3">
                            <form action=""
                                  id="cart-items"
                                  class="content-wrapper bg-white p-3 rounded-2"
                                  method="post">
                                @csrf
                                @php
                                    $total_product_price = 0;
                                    $total_discount = 0;
                                @endphp

                                @if($cart_items->count() !== 0)
                                    @foreach($cart_items as $cart_item)
                                        @php
                                            $total_product_price += $cart_item->cart_item_product_price();
                                            $total_discount += $cart_item->cart_item_product_discount();
                                        @endphp
                                        <section class="cart-item d-md-flex py-3">
                                            <section class="cart-img align-self-start flex-shrink-1">
                                                <a href="{{ route('market.product',$cart_item->product) }}">
                                                    <img
                                                        src="{{  asset($cart_item->product->image['indexArray'][$cart_item->product->image['currentImage']]) }}"
                                                        alt="{{ convertEnglishToPersian($cart_item->product->name) }}">
                                                </a>
                                            </section>
                                            <section class="align-self-start w-100">
                                                <a class="text-decoration-none text-dark"
                                                   href="{{ route('market.product',$cart_item->product) }}">
                                                    <p class="fw-bold">{{ convertEnglishToPersian($cart_item->product->name) }}</p>
                                                </a>
                                                <p>
                                                    @if(!empty($cart_item->color))
                                                        <span style="background-color: {{ $cart_item->color->color }}"
                                                              class="cart-product-selected-color me-1">
                                                        </span>
                                                        <span>{{ $cart_item->color->color_name }}</span>
                                                    @endif

                                                </p>
                                                <p>
                                                    @if(!empty($cart_item->guaranty))
                                                        <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                        <span>{{ $cart_item->guaranty->name }}</span>
                                                    @else
                                                        <span class="fw-bold text-info">گارانتی انتخاب نشده است</span>
                                                    @endif

                                                </p>
                                                <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span>
                                                </p>
                                                <section>
                                                    {{-- TODO : SET THIS BUTTONS TO HAVE LIMITS ON MARKETABLE NUMBER(MAIN.JS) --}}
                                                    <section class="cart-product-number d-inline-block ">
                                                        <button class="cart-number-down cart-number" type="button">-</button>
                                                        <input class="number"
                                                               data-product-price="{{ $cart_item->cart_item_product_price() }}"
                                                               data-product-discount="{{ $cart_item->cart_item_product_discount() }}"
                                                               type="number"
                                                               min="1"
                                                               max="5"
                                                               step="1"
                                                               name="number[{{ $cart_item->id }}]"
                                                               value="{{ $cart_item->number }}"
                                                               readonly="readonly">
                                                        <button class="cart-number-up cart-number" type="button">+</button>
                                                    </section>
                                                    <a class="text-decoration-none ms-4 cart-delete fw-bolder cart-actions"
                                                       href="{{ route('customer.remove-from-cart',$cart_item) }}">
                                                        <i class="fa fa-trash-alt"></i>
                                                        حذف از سبد
                                                    </a>

                                                    {{-- delete modal --}}
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                                         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">تایید حذف</h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    آیا مطمئنید که می‌خواهید این مورد را از سبد خرید حذف کنید؟
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">لغو</button>
                                                                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">حذف</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <style>
                                                        /* Center the modal */
                                                        .modal-dialog {
                                                            margin: auto;
                                                        }

                                                        /* Adjust z-index to ensure modal appears above other elements */
                                                        .modal {
                                                            z-index: 1050; /* Adjust as needed */
                                                        }
                                                    </style>


                                                    {{-- delete modal --}}

                                                </section>
                                            </section>

                                            <section class="align-self-end flex-shrink-1">
                                                @php
                                                    $activeSale = $cart_item->product->active_amazing_sales()->exists();
                                                @endphp
                                                @if($activeSale)
                                                    <section
                                                        class="cart-item-discount text-danger text-nowrap mb-1 fw-bolder">
                                                        تخفیف {{ convertEnglishToPersian(priceFormat($cart_item->cart_item_product_discount())) }}
                                                        تومان
                                                    </section>
                                                @endif
                                                <section class="text-nowrap fw-bolder">
                                                    قیمت
                                                    کالا: {{ convertEnglishToPersian(priceFormat($cart_item->cart_item_product_price())) }}
                                                    تومان
                                                </section>
                                            </section>


                                        </section>
                                    @endforeach

                                @else
                                    <span class="fw-bolder text-info">
                                        <i class="fa fa-info-circle"></i> سبد خرید شما خالی است
                                    </span>
                                @endif

                            </form>


                        </section>
                        {{-- TODO : fix the ui bug here. if there is no items in the cart, left side sidebar should be empty and info should be 100% width --}}
                        @if($cart_items->count() !== 0)
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
                                        <p class="text-muted">قیمت کالا ({{ $cart_items->count() }})</p>
                                        <p class="text-muted">
                                            <span id="total-product-price">{{ priceFormat($totalProductPrice) }}</span>
                                            تومان
                                        </p>
                                    </section>

                                    @if($totalDiscount !== 0)
                                        <section class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted">تخفیف کالاها</p>
                                            <p class="text-danger fw-bolder"><span
                                                    id="total-discount-price">{{ priceFormat($totalDiscount) }}</span> تومان
                                            </p>
                                        </section>
                                    @endif
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">جمع سبد خرید</p>
                                        <p class="fw-bolder">
                                            <span id="total-price">{{ priceFormat($totalProductPrice - $totalDiscount) }}</span>
                                            تومان</p>
                                    </section>

                                    <p class="my-3">
                                        <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است.
                                        برای
                                        ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را
                                        انتخاب
                                        کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
                                        پرداخت این سفارش صورت میگیرد.
                                    </p>


                                    <section class="">
                                        <button type="button"
                                                onclick="document.getElementById('cart-items').submit();"
                                                class="btn custom-btn d-block w-100">تکمیل فرآیند خرید
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


    <!-- start product lazy load -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>کالاهای مرتبط</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- start vontent header -->
                        <section class="brands-wrapper">
                            <section class="brands light-owl-nav owl-carousel owl-theme">
                                @foreach($related_products as $product)
                                    <section class="item">

                                        <section class="lazyload-item-wrapper">
                                            <a class="product-link" href="#">
                                                <section class="product">
                                                    <a class="product-link"
                                                       href="{{ route('market.product',$product->slug) }}">
                                                        <section
                                                            class="product-image">
                                                            <img
                                                                src="{{  asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                                                                alt="{{ $product->name }}">
                                                        </section>
                                                        <section class="product-colors"></section>

                                                        <section class="product-name">
                                                            <h3 class="product-name">{{ $product->name }}</h3>
                                                        </section>
                                                        <section class="product-price-wrapper">
                                                            @if ($product->active_amazing_sales->isNotEmpty())
                                                                <section class="product-discount">
                                                                          <span class="product-old-price">
                                                                            {{ convertEnglishToPersian(priceFormat($product->price)) }} تومان
                                                                          </span>
                                                                    <span class="product-discount-amount">
                                                                            {{ convertEnglishToPersian($product->active_amazing_sales->first()->percentage) }}% تخفیف
                                                                        </span>
                                                                </section>
                                                            @endif
                                                            <section class="product-price">
                                                                {{ convertEnglishToPersian(priceFormat(calculateFinalPrice($product))) }}
                                                                تومان
                                                            </section>
                                                        </section>


                                                        @php
                                                            $colors = $product->colors()->get();
                                                        @endphp
                                                        <section class="product-colors">
                                                            @if($colors->count() > 0)
                                                                @foreach($colors as $color)
                                                                    <section class="product-colors-item"
                                                                             style="background-color: {{ $color->color }};"></section>
                                                                @endforeach
                                                            @endif
                                                        </section>
                                                    </a>
                                                    <section class="d-flex flex-row justify-content-between">
                                                        @if($product->marketable_number > 0)
                                                            <section class="product-add-to-cart">
                                                                <button
                                                                    class="btn custom-btn btn-sm text-decoration-none"
                                                                    data-url="{{ route('customer.ajax-add-to-cart',$product) }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="left"
                                                                    title="افزودن به سبد خرید">
                                                                    <i class="fa fa-cart-plus"></i>
                                                                </button>
                                                            </section>
                                                        @else
                                                            <section class="product-validation-notify">
                                                                <button
                                                                    class="btn custom-btn btn-sm text-decoration-none"
                                                                    data-url="#"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="left"
                                                                    title="هر وقت موجود شد خبر بده">
                                                                    <i class="fa fa-bell"></i>
                                                                </button>
                                                            </section>
                                                        @endif
                                                        @guest
                                                            <section class="product-add-to-favorite">
                                                                <button
                                                                    class="btn custom-btn btn-sm text-decoration-none"
                                                                    data-url="{{ route('market.add-to-favorite', $product) }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="left"
                                                                    title="افزودن به علاقه مندی ها">
                                                                    <i class="fa fa-heart"></i>
                                                                </button>
                                                            </section>
                                                        @endguest
                                                        @auth
                                                            @if ($product->users->contains(auth()->user()->id))
                                                                <section class="product-add-to-favorite">
                                                                    <button
                                                                        class="btn custom-btn btn-sm text-decoration-none"
                                                                        data-url="{{ route('market.add-to-favorite', $product) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        title="حذف از علاقه مندی ها">
                                                                        <i class="fa fa-heart text-danger"></i>
                                                                    </button>
                                                                </section>
                                                            @else
                                                                <section class="product-add-to-favorite">
                                                                    <button
                                                                        class="btn custom-btn btn-sm text-decoration-none"
                                                                        data-url="{{ route('market.add-to-favorite', $product) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        title="فزودن به علاقه مندی ها">
                                                                        <i class="fa fa-heart"></i>
                                                                    </button>
                                                                </section>
                                                            @endif

                                                            <section class="product-add-to-compare">
                                                                <button
                                                                    class="btn custom-btn btn-sm text-decoration-none"
                                                                    data-url="{{ route('market.add-to-compare', $product) }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="left"
                                                                    title="افزودن به مقایسه ها">
                                                                    <i class="fa fa-chart-bar"></i></button>
                                                            </section>
                                                        @endauth

                                                    </section>
                                                </section>
                                            </a>

                                        </section>

                                    </section>
                                @endforeach


                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end product lazy load -->

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
@section('script')
    <script type="text/javascript">

        // Function to handle the delete confirmation
        function handleDeleteConfirmation(url, element) {
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Remove the product item from the DOM
                        const productItem = element.closest('.cart-item');
                        productItem.remove();
                        // Show notification message
                        showToastrMessage(response.message, response.alertType);
                        // Close the modal
                        $('#confirmDeleteModal').modal('hide');
                    } else {
                        showToastrMessage(response.message, response.alertType);
                        console.error(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                    console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                }
            });
        }

        // Click event listener for the delete button
        $('.cart-delete').click(function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            const element = $(this);

            // Show the confirmation modal
            $('#confirmDeleteModal').modal('show');

            // Handle delete confirmation when the modal delete button is clicked
            $('#confirmDeleteButton').off('click').on('click', function () {
                // Call the function to handle delete confirmation
                handleDeleteConfirmation(url, element);
                // Manually trigger the modal hide event
                $('#confirmDeleteModal').modal('hide');
            });

        });

        // Close the modal when clicking outside of it
        $('#confirmDeleteModal').on('hidden.bs.modal', function () {
            const form = $(this).find('form');
            if (form.length > 0) {
                form[0].reset(); // Reset form fields if needed
            }
        });


        $(document).ready(function() {
            bill();

            $('.cart-number').click(function() {
                bill();
            })
        })

        function bill() {
            let totalProductPrice = 0;
            let totalDiscount = 0;
            let totalPrice;

            $('.number').each(function() {
                let productPrice = parseFloat($(this).data('product-price'));
                let productDiscount = parseFloat($(this).data('product-discount'));
                let number = parseFloat($(this).val());

                totalProductPrice += productPrice * number;
                totalDiscount += productDiscount * number;
            });

            // Calculate the total price by subtracting the total discount from the total product price
            totalPrice = totalProductPrice - totalDiscount;
            // Format and display the total product price, total discount, and total price
            $('#total-product-price').html(toFarsiNumber(totalProductPrice));
            $('#total-discount-price').html(toFarsiNumber(totalDiscount));
            $('#total-price').html(toFarsiNumber(totalPrice));

        }


        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }

        $('.ajax-add-to-cart button').click(function (event) {
            event.preventDefault();
            const url = $(this).data('url');
            const element = $(this);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        if (response.added) {
                            element.children().first().addClass('text-danger');
                            element.attr('data-original-title', 'حذف از سبد خرید');
                            element.attr('data-bs-original-title', 'حذف از سبد خرید');
                        } else {
                            element.children().first().removeClass('text-danger');
                            element.attr('data-original-title', 'افزودن به سبد خرید');
                            element.attr('data-bs-original-title', 'افزودن به سبد خرید');
                        }

                        showToastrMessage(response.message, response.alertType);
                    } else {
                        showToastrMessage(response.message, response.alertType);
                        console.error(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                    console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                }
            });
        });


        $('.product-add-to-compare button').click(function (event) {
            event.preventDefault();
            const url = $(this).data('url');
            const element = $(this);

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        if (response.added) {
                            element.children().first().addClass('text-danger');
                            element.attr('data-original-title', 'حذف از مقایسه');
                            element.attr('data-bs-original-title', 'حذف از مقایسه');
                        } else {
                            element.children().first().removeClass('text-danger');
                            element.attr('data-original-title', 'افزودن به مقایسه');
                            element.attr('data-bs-original-title', 'افزودن به مقایسه');
                        }

                        showToastrMessage(response.message, response.alertType);
                    } else {
                        showToastrMessage(response.message, response.alertType);
                        console.error(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                    console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                }
            });
        });



        // add product to favorites list
        $('.product-add-to-favorite button').click(function (event) {
            event.preventDefault(); // Prevent default form submission (if applicable)
            const url = $(this).data('url');
            const element = $(this);

            $.ajax({
                url: url,
                type: 'GET', // Use POST for modifying data
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        // Update button/icon based on response: 'added' or 'removed'
                        if (response.added) {
                            element.children().first().addClass('text-danger');
                            element.attr('data-original-title', 'حذف از علاقه مندی ها');
                            element.attr('data-bs-original-title', 'حذف از علاقه مندی ها');
                            // Change the text content of the span to indicate the product is in favorites
                            element.closest('.product-add-to-favorite').find('.fw-bolder').text('حذف از علاقه مندی ها');
                        } else {
                            element.children().first().removeClass('text-danger');
                            element.attr('data-original-title', 'افزودن به علاقه مندی ها');
                            element.attr('data-bs-original-title', 'افزودن به علاقه مندی ها');
                            // Change the text content of the span to indicate the product is not in favorites
                            element.closest('.product-add-to-favorite').find('.fw-bolder').text('افزودن به علاقه مندی ها');
                        }

                        showToastrMessage(response.message, response.alertType);
                    } else {
                        // Handle server-side errors gracefully
                        showToastrMessage(response.message, response.alertType);
                        console.error(response.message); // Log detailed error for debugging
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle network errors and unexpected server responses
                    showToastrMessage('مشکلی پیش آمده است. لطفا اتصال به اینترنت را بررسی کنید.', 'error');
                    console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                }
            });
        });

    </script>
@endsection
