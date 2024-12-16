@extends('app.layouts.master.master-one-col')
@section('head-tag')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

    {{--        @dd(auth()->user()->has_role('super-admin'))--}}
    <!-- start slideshow -->
    <section class="container-xxl my-4">

        {{-- show errors --}}
        @if(session('error'))
            <div id="alert-danger" class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div id="alert-success" class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- show errors --}}

        <section class="row">
            <section class="col-12 pe-md-1 ">
                <section id="slideshow" class="owl-carousel owl-theme">
                    @foreach($slideshow_images as $slideshow_image)
                        <section class="item">
                            <a class="w-100 d-block h-auto text-decoration-none" style="max-height: 450px;"
                               href="{{ urldecode($slideshow_image->url) ?? '' }}">
                                <img class="w-100 rounded-2 d-block h-auto"
                                     src="{{ asset($slideshow_image->image) }}"
                                     alt="{{ $slideshow_image->title }}">
                            </a>
                        </section>
                    @endforeach

                </section>
            </section>
        </section>
    </section>
    <!-- end slideshow -->

    <!-- start product lazy load -->
    <section class="mb-3">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start content header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>دسته های برتر</span>
                                </h2>
                                <section class="content-header-link">
                                    <a href="{{ route('home.products') }}">مشاهده همه محصولات</a>
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->
                        <section class="brands-wrapper py-4">
                            <section class="brands dark-owl-nav owl-carousel owl-theme">
                                @foreach($product_categories as $product_category)
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section>
                                                <a href="{{ route('home.products',['category' => $product_category->slug]) }}">
                                                    <section>
                                                        <a class="product-link"
                                                           href="{{ route('home.products',['category' => $product_category->slug]) }}">
                                                            <section class="product-category-image">
                                                                <img
                                                                    src="{{  asset($product_category->image['indexArray'][$product_category->image['currentImage']]) }}"
                                                                    alt="{{ $product_category->name }}">
                                                            </section>
                                                            <section class="product-category-name">
                                                                <h3 class="product-category-name">{{ $product_category->name }}</h3>
                                                            </section>
                                                        </a>
                                                    </section>
                                                </a>
                                            </section>
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

    <!-- end product lazy load -->


    <!-- start ads section -->
    <section class="mb-3">
        <section class="container-xxl">
            <!-- two column-->
            <section class="row py-4">
                @foreach($middle_banners as $banner)
                    <section class="col-12 col-md-6 mt-2 mt-md-0">
                        <img style="max-height: 300px;max-width: 100%;"
                             class="d-block rounded-2 w-100"
                             src="{{ asset($banner->image) }}"
                             alt="{{ $banner->title }}">
                    </section>
                @endforeach
            </section>

        </section>
    </section>
    <!-- end ads section -->



    <!-- start product lazy load -->
    <section class="mb-3">
        <section class="container-xxl">
            <section class="row">
                <section class="col">

                    @if($most_visited_products->count() > 0)
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>پربازدیدترین کالاها</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <a href="{{ route('home.products',['sort' => 5]) }}">مشاهده همه</a>
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="brands-wrapper py-4">
                                <section class="brands dark-owl-nav owl-carousel owl-theme">
                                    @foreach($most_visited_products as $product)
                                        <section class="item">
                                            <section class="lazyload-item-wrapper">
                                                <a class="product-link"
                                                   href="{{ route('market.product',$product->slug) }}">
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
                                                                                 style="background-color: {{ $color->color }};">
                                                                        </section>
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
                                                                        data-bs-placement="right"
                                                                        title="هر وقت موجود شد خبر بده">
                                                                        <i class="fa fa-bell"></i>
                                                                    </button>
                                                                </section>
                                                            @endif

                                                        </section>
                                                    </section>
                                                </a>

                                            </section>
                                        </section>
                                    @endforeach
                                </section>
                            </section>
                        </section>
                    @endif

                </section>
            </section>
        </section>
    </section>
    <!-- end product lazy load -->





    <!-- start product lazy load -->
    <section class="mb-3">
        <section class="container-xxl">
            <section class="row">
                <section class="col">

                    @if($suggested_products->count() > 0)
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>پیشنهاد راسته فرش</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <a href="{{ route('home.products',['sort' => 1]) }}">مشاهده
                                            همه</a> {{-- نمایش جدیدترین محصولات --}}
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="brands-wrapper py-4">
                                <section class="brands dark-owl-nav owl-carousel owl-theme">
                                    @foreach($suggested_products as $product)
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
                                                                        class="btn btn-primary btn-sm text-decoration-none"
                                                                        data-url="{{ route('customer.ajax-add-to-cart',$product) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="right"
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
                                                                        data-bs-placement="right"
                                                                        title="هر وقت موجود شد خبر بده">
                                                                        <i class="fa fa-bell"></i>
                                                                    </button>
                                                                </section>
                                                            @endif


                                                        </section>
                                                    </section>
                                                </a>

                                            </section>
                                        </section>
                                    @endforeach
                                </section>
                            </section>
                        </section>
                    @endif

                </section>
            </section>
        </section>
    </section>
    <!-- end product lazy load -->


    <!-- start ads section -->
    <section class="mb-3">
        <section class="container-xxl">
            <!-- one column -->
            @if(!empty($bottom_banner))
                <section class="row py-4">
                    @if($bottom_banner)
                        <section class="col">
                            <img class="d-block rounded-2 w-100 h-20"
                                 style="max-height: 450px;"
                                 src="{{ asset($bottom_banner->image) }}"
                                 alt="{{ $bottom_banner->title }}"></section>
                    @endif
                </section>
            @endif

        </section>
    </section>
    <!-- end ads section -->



    <!-- start brand part-->
    <section class="brand-part mb-4 py-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex align-items-center">
                            <h2 class="content-header-title">
                                <span>برندها</span>
                            </h2>
                        </section>
                    </section>
                    <!-- start vontent header -->
                    <section class="brands-wrapper py-4">
                        <section class="brands dark-owl-nav owl-carousel owl-theme">
                            @foreach($brands as $brand)
                                <section class="item">
                                    <section class="brand-item">
                                        <a href="{{ route('home.products',['brands[]' => $brand->id]) }}">
                                            @if(empty($brand->logo))
                                                <h4 class="font-weight-bold">
                                                    {{ $brand->persian_name }}
                                                </h4>
                                            @else
                                                <img class="rounded-2"
                                                     src="{{ asset($brand->logo['indexArray'][$brand->logo['currentImage']]) }}"
                                                     alt="{{ $brand->original_name }}"
                                                     style="max-height : 4rem;"
                                                >
                                            @endif
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
    <!-- end brand part-->

@endsection
@section('script')

    <script type="text/javascript">

        $(document).ready(function () {
            // Hide error message after 5 seconds
            setTimeout(function () {
                $('#error-alert').fadeOut('slow');
            }, 5000);

            // Hide success message after 5 seconds
            setTimeout(function () {
                $('#success-alert').fadeOut('slow');
            }, 5000);
        });

        $('.product-add-to-cart button').click(function (event) {
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
                        } else {
                            element.children().first().removeClass('text-danger');
                            element.attr('data-original-title', 'افزودن به علاقه مندی ها');
                            element.attr('data-bs-original-title', 'افزودن به علاقه مندی ها');
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

    <script type="text/javascript">
        $(document).ready(function () {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                items: 1,
                autoplay: true,
                autoPlaySpeed: 5000,
                autoPlayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            })
        });



    </script>
    @php $data = ['className' => "delete"] @endphp
    {{--    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))--}}
@endsection
