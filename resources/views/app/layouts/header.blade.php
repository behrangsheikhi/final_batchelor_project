<!-- start header -->
<header class="header mb-4">
    <!-- start top-header logo, searchbox and cart -->
    <section class="top-header">


        <section class="container-xxl ">
            <section class="d-md-flex justify-content-md-between align-items-md-center py-3">

                <section class="d-flex justify-content-between align-items-center d-md-block">
                    <a class="text-decoration-none d-flex" href="{{ route('app.home') }}">
                        {{--                        <img src="{{ asset($setting->logo) }}" alt="{{ $setting->title }}" style="max-height: 3rem;">--}}
                        <h2 class="d-flex justify-center" style="font-family: 'mj_yalda'">راسته فرش</h2>

                    </a>
                    <button class="btn btn-link text-dark d-md-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <i class="fa fa-bars me-1"></i>
                    </button>
                </section>

                <section class="mt-3 mt-md-auto search-wrapper">
                    <section class="search-box">
                        <section class="search-textbox">
                            <span><i class="fa fa-search"></i></span>

                            <form
                                id="search-form"
                                data-url="{{ route('market.ajax-product-search') }}"
                                method="get">

                                <input onkeyup="ajaxProductSearch()"
                                       id="search"
                                       type="text"
                                       class=""
                                       name="search"
                                       placeholder="جستجوی محصول . . ." autocomplete="off">

                                <ul id="search-results" class="list-group mt-2"
                                    style="display: none; position: absolute; z-index: 1000;"></ul>

                            </form>
                            <script type="text/javascript">
                                function ajaxProductSearch() {
                                    // Get the input value
                                    let query = $('#search').val();

                                    // Hide results if the input is empty
                                    if (query === '') {
                                        $('#search-results').hide();
                                        return;
                                    }

                                    // Get the AJAX URL from the form's data attribute
                                    let path = $('#search-form').data('url');

                                    // Perform the AJAX request
                                    $.ajax({
                                        url: path, // Use the correct route URL
                                        method: 'GET',
                                        data: {
                                            q: query
                                        }, // Pass the query parameter
                                        success: function (response) {
                                            let results = $('#search-results');
                                            results.empty(); // Clear previous results

                                            if (response.length > 0) {
                                                // Append each product to the list
                                                response.forEach(product => {
                                                    results.append(`<li class="list-group-item">${product.name}</li>`);
                                                });
                                            } else {
                                                // Show a "no results" message
                                                results.append('<li class="list-group-item">هیچ محصولی یافت نشد</li>');
                                            }

                                            // Display the results
                                            results.show();
                                        },
                                        error: function () {
                                            console.error('خطا در دریافت اطلاعات');
                                        }
                                    });
                                }
                            </script>


                        </section>

                    </section>
                </section>

                <section class="mt-3 mt-md-auto text-end">

                    @auth
                        <section class="d-inline px-md-3">
                            <button class="btn btn-link text-decoration-none text-dark dropdown-toggle profile-button"
                                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </button>
                            <section class="dropdown-menu dropdown-menu-end custom-drop-down"
                                     aria-labelledby="dropdownMenuButton1">

                                @if(auth()->user()->user_type == \App\Constants\UserTypeValue::CUSTOMER)
                                    <section><a class="dropdown-item" href="{{ route('customer.dashboard.index') }}">
                                            <i class="fa fa-user-circle"></i>
                                            پنل کاربری
                                        </a>
                                    </section>

                                @elseif(auth()->user()->user_type == \App\Constants\UserTypeValue::ADMIN ||auth()->user()->user_type == \App\Constants\UserTypeValue::SUPER_ADMIN)
                                    <section><a class="dropdown-item" href="{{ route('admin.admin') }}">
                                            <i class="fa fa-user-circle"></i>
                                            پنل ادمین
                                        </a>
                                    </section>

                                @endif


                                <section>
                                    <hr class="dropdown-divider">
                                </section>
                                <section><a class="dropdown-item" href="{{ route('auth.logout') }}"><i
                                            class="fa fa-sign-out-alt"></i>خروج</a>
                                </section>
                            </section>
                        </section>
                    @endauth
                    @guest
                        <section class="d-inline px-md-3">
                            <button class="btn btn-link text-decoration-none text-dark dropdown-toggle profile-button"
                                    type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </button>
                            <section class="dropdown-menu dropdown-menu-end custom-drop-down"
                                     aria-labelledby="dropdownMenuButton1">
                                <section><a class="dropdown-item" href="{{ route('auth.form') }}">
                                        <i class="fa fa-user-circle"></i>
                                        ورود
                                    </a>
                                </section>
                                @auth()
                                    <section><a class="dropdown-item" href="{{ route('auth.logout') }}"><i
                                                class="fa fa-sign-out-alt"></i>خروج</a>
                                    </section>
                                @endauth
                            </section>
                        </section>
                    @endguest


                    <section class="header-cart d-inline ps-3 border-start position-relative">
                        <a class="btn btn-link position-relative text-dark header-cart-link"
                           href="{{ route('customer.cart') }}">
                            <i class="fa fa-shopping-cart"></i>
                            @auth()
                                <span style="top: 80%;"
                                      class="position-absolute start-0 translate-middle badge rounded-pill bg-danger">
                                {{ convertEnglishToPersian($cart_items->count()) ?? '' }}
                            </span>

                            @endauth
                        </a>
                        <section class="header-cart-dropdown">
                            <section class="border-bottom d-flex justify-content-between p-2">
                                <span class="text-muted">{{ convertEnglishToPersian($cart_items->count()) }} کالا</span>
                                <a class="text-decoration-none text-info" href="{{ route('customer.cart') }}">مشاهده
                                    سبد خرید </a>
                            </section>
                            <section class="header-cart-dropdown-body">

                                @php
                                    $total_product_price = 0;
                                    $final_product_price = 0;
                                    $total_product_discount = 0;
                                @endphp

                                @foreach($cart_items as $cart_item)
                                    @php
                                        $total_product_price += $cart_item->number * $cart_item->cart_item_product_price(); // Use cart_item_final_price instead of cart_item_product_price
                                        $final_product_price += $cart_item->cart_item_final_price(); // Use cart_item_final_price instead of cart_item_product_price
                                        $total_product_discount += $cart_item->cart_item_product_discount() * $cart_item->number;
                                    @endphp
                                    <section
                                        class="header-cart-dropdown-body-item d-flex justify-content-start align-items-center"
                                        style="width=300px">
                                        <img class="flex-shrink-1 text-sm"
                                             src="{{ asset($cart_item->product->image['indexArray'][$cart_item->product->image['currentImage']]) }}"
                                             alt="{{ convertEnglishToPersian($cart_item->product->name) }}">
                                        <section class="w-100 text-truncate">
                                            <a class="text-decoration-none text-dark"
                                               title="{{ convertEnglishToPersian($cart_item->product->name) }}"
                                               href="{{ route('market.product',$cart_item->product) }}">
                                                {{ convertEnglishToPersian($cart_item->product->name) }}
                                            </a>
                                        </section>
                                        <section class="flex-shrink-1">
                                            <a class="text-muted text-decoration-none p-1"
                                               id="cartItem_{{ $cart_item->id }}"
                                               onclick="removeFromCart('cartItem_{{ $cart_item->id }}')"
                                               data-url-remove="{{ route('customer.remove-from-cart',$cart_item) }}">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </section>
                                    </section>
                                @endforeach

                            </section>

                            @auth()
                                @if($cart_items->count() == 0)
                                    <div class="fw-bolder my-2 text-center">
                                        <i class="fa fa-info-circle"></i> سبد خرید شما خالی است!
                                    </div>
                                @else
                                    <section class="header-cart-dropdown-footer border-top p-2">
                                        <div class="row"> <!-- Start of first row -->
                                            <div
                                                class="d-flex flex-row justify-content-between align-items-center w-100 fw-bolder">
                                                <div class="text-right flex-grow-1">
                                                    <!-- This div is for the Persian text -->
                                                    <span>مبلغ کالاهای انتخابی :</span>
                                                </div>
                                                <div class="text-left mr-auto"> <!-- This div is for the price -->
                                                    <span>{{ convertEnglishToPersian(priceFormat($total_product_price)) }}تومان</span>
                                                </div>
                                            </div>
                                        </div> <!-- End of first row -->
                                        <hr>
                                        <div class="row"> <!-- Start of second row -->
                                            <div
                                                class="d-flex flex-row justify-content-between align-items-center w-100 fw-bolder text-danger">
                                                <div class="text-right flex-grow-1">
                                                    <!-- This div is for the Persian text -->
                                                    <span>مجموع تخفیفات :</span>
                                                </div>
                                                <div class="text-left mr-auto"> <!-- This div is for the price -->
                                                    <span>{{ convertEnglishToPersian(priceFormat($total_product_discount)) }}تومان</span>
                                                </div>
                                            </div>
                                        </div> <!-- End of second row -->
                                        <hr>
                                        <div class="row"> <!-- Start of second row -->
                                            <div
                                                class="d-flex flex-row justify-content-between align-items-center w-100 fw-bolder text-success">
                                                <div class="text-right flex-grow-1">
                                                    <!-- This div is for the Persian text -->
                                                    <span>مبلغ قابل پرداخت :</span>
                                                </div>
                                                <div class="text-left mr-auto"> <!-- This div is for the price -->
                                                    <span>{{ convertEnglishToPersian(priceFormat($final_product_price)) }}تومان</span>
                                                </div>
                                            </div>
                                        </div> <!-- End of second row -->
                                        <hr>
                                    </section>
                                @endif

                            @endauth
                            @guest()
                                <div class="fw-bolder my-2 text-center">
                                    <i class="fa fa-info-circle"></i> سبد خرید شما خالی است!
                                </div>
                            @endguest
                            <a style="width: 100%;" href="{{ route('customer.cart') }}"
                               class="btn custom-btn btn-sm btn-block fw-bolder">ثبت سفارش</a>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end top-header logo, searchbox and cart -->


    <!-- start menu -->
    <nav class="top-nav">
        <section class="container-xxl ">
            <nav class="">
                <section class="justify-content-md-start position-relative">

                    {{-- Mega menu removed from here and I can add it to here in the future --}}
                    @foreach($menus as $menu)
                        <section class="navbar-item"><a
                                href="{{ route('market.product-category',$menu->slug) }}">{{ $menu->name }}</a>
                        </section>
                    @endforeach




                </section>


                <!--mobile view-->
                <section class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                         aria-labelledby="offcanvasExampleLabel" style="z-index: 9999999;">
                    <section class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a class="text-decoration-none"
                                                                                  href="index.html"><img
                                    src="{{ asset('assets/images/logo/8.png') }}" alt="logo"></a></h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                    </section>
                    <section class="offcanvas-body">

                        {{-- here is for showing in mobile size(responsive for small screens) --}}
                        @foreach($menus as $menu)
                            <section class="navbar-item"><a href="{{ $menu->url }}">{{ $menu->name }}</a></section>
                        @endforeach

                        <hr class="border-bottom">
                        <section class="navbar-item"><a href="javascript:void(0)">دسته بندی</a></section>
                        <!-- start sidebar nav-->
                        <ul>
                            @foreach($product_categories as $category)
                                <li style="list-style: none;">
                                    <a style="text-decoration: none" href="#">{{ $category->name }}</a>
                                    <!-- Parent category name -->
                                    @if($category->children->isNotEmpty())
                                        <ul>
                                            @foreach($category->children as $child)
                                                <li>
                                                    <a style="text-decoration: none;" href="#">{{ $child->name }}</a>
                                                    <!-- Child category name -->
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <!--end sidebar nav-->


                    </section>
                </section>

            </nav>
        </section>
    </nav>
    <!-- end menu -->


</header>
<!-- end header -->
