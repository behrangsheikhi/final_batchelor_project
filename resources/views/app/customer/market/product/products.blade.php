@extends('app.layouts.master.master-two-col')

@section('head-tag')
    @php
        if (request()->search)
            $page_title =' جستجو برای : ' .request()->search ;
        elseif(request()->category)
            $page_title = ' جستجو برای دسته بندی : ' .request()->category->name;
        elseif(request()->brands)
            $page_title = ' جستجو برای برند : ' .implode(' ، ',$selected_brands_array);
        else
            $page_title = '';

    @endphp
    <title>{{ $page_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')

    <section class="container-xxl">
        <section class="row">


            @include('app.partials.sidebar')


            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                    <section class="filters mb-3">
                        @if(request()->search)
                            <span class="d-inline-block border p-1 rounded bg-light">نتیجه جستجو برای : <span
                                    class="badge bg-info text-dark">{{ request()->search }}</span></span>
                        @endif

                        @if(request()->brands)
                            <span class="d-inline-block border p-1 rounded bg-light">برند : <span
                                    class="badge bg-info text-dark">
                                    {{ implode(' ، ',$selected_brands_array) }}
                                </span></span>
                        @endif
                        @if(request()->categories)
                            <span class="d-inline-block border p-1 rounded bg-light">دسته : <span
                                    class="badge bg-info text-dark">"کتاب"</span></span>
                        @endif

                        @if(request()->min_price)
                            <span class="d-inline-block border p-1 rounded bg-light">قیمت از : <span
                                    class="badge bg-info text-dark">{{ convertEnglishToPersian(priceFormat(request()->min_price)) }} تومان </span></span>
                        @endif

                        @if(request()->max_price)
                            <span class="d-inline-block border p-1 rounded bg-light">قیمت تا : <span
                                    class="badge bg-info text-dark">{{ convertEnglishToPersian(priceFormat(request()->max_price)) }} تومان </span></span>

                        @endif
                    </section>
                    <section class="sort ">
                        <span>مرتب سازی بر اساس : </span>
                        <a class="btn {{ request()->sort == 1 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                           href="{{ route('home.products',['category' => request()->category->slug ?? '','search' => request()->search,'sort' => 1,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands]) }}">جدیدترین</a>
                        {{--                        <a class="btn {{ request()->sort == 2 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"--}}
                        {{--                           href="{{ route('home.products',['category' => request()->category->slug ?? '','search' => request()->search,'sort' => 2,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands]) }}">محبوب--}}
                        {{--                            ترین</a>--}}
                        <a class="btn {{ request()->sort == 3 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                           href="{{ route('home.products',['category' => request()->category->slug ?? '','search' => request()->search,'sort' => 3,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands]) }}">گران
                            ترین</a>
                        <a class="btn {{ request()->sort == 4 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                           href="{{ route('home.products',['category' => request()->category->slug ?? '','search' => request()->search,'sort' => 4,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands]) }}">ارزان
                            ترین</a>
                        <a class="btn {{ request()->sort == 5 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                           href="{{ route('home.products',['category' => request()->category->slug ?? '','search' => request()->search,'sort' => 5,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands]) }}">پربازدیدترین</a>
                        <a class="btn {{ request()->sort == 6 ? 'btn-info' : 'btn-light' }} btn-sm px-1 py-0"
                           href="{{ route('home.products',['category' => request()->category->slug ?? '','search' => request()->search,'sort' => 6,'min_price' => request()->min_price,'max_price' => request()->max_price,'brands' => request()->brands]) }}">پرفروش
                            ترین</a>
                    </section>


                    <section class="main-product-wrapper row my-4">

                        @forelse($products as $product)
                            <section class="item col-12 col-md-4 col-lg-3">
                                <section class="lazyload-item-wrapper">
                                    <section class="product">
                                        <a class="product-link"
                                           href="{{ route('market.product',$product->slug) }}">
                                            <section class="product-image">
                                                <img class=""
                                                     src="{{ asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                                                     alt="{{ $product->name }}">
                                            </section>

                                            <section class="product-name"><h3>{{ $product->name }}</h3>
                                            </section>
                                            <section class="product-price-wrapper">
                                                @if ($product->active_amazing_sales->isNotEmpty())
                                                    <section class="product-discount d-flex justify-content-between fw-bold">
                                                        <span class="product-old-price text-danger">
                                                            {{ convertEnglishToPersian(priceFormat($product->price)) }} تومان
                                                        </span>
                                                        <span class="product-discount-amount">
                                                            {{ convertEnglishToPersian($product->active_amazing_sales->first()->percentage) }}% تخفیف
                                                        </span>
                                                    </section>
                                                @endif
                                                    <section class="product-price text-success fw-bolder" style="right: 1.5rem;position: absolute;">
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

                                        @if($product->marketable_number > 0)
                                            <section class="ajax-add-to-cart product-add-to-cart">
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
                                                        title="حذف از علاقه مندی">
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
                                                        title="افزودن به علاقه مندی ها">
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
                            </section>

                        @empty
                            <h3 class="text-danger">محصولی یافت نشد!</h3>
                        @endforelse

                        <section class="d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </section>


                    </section>


                </section>
            </main>
        </section>
    </section>

@endsection

@section('script')

    <script type="text/javascript">
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

        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }


        //start product introduction, features and comment
        $(document).ready(function () {
            var s = $("#introduction-features-comments");
            $(window).scroll(function () {
                var windowpos = $(window).scrollTop();
                var pos = s.position();
                if (windowpos >= pos.top) {
                    s.addClass("stick");
                } else {
                    s.removeClass("stick");
                }
            });
        });
        //end product introduction, features and comment
    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
