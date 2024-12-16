@extends('app.layouts.master.master-one-col')

@section('head-tag')
    <title>{{ $product->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- rating styles --}}
    <style>
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

        .starrating > input {
            display: none;
        }

        /* Remove radio buttons */

        .starrating > label:before {
            content: "\f005";
            /* Star */
            margin: 2px;
            font-size: 2em;
            font-family: FontAwesome;
            display: inline-block;
        }

        .starrating > label {
            color: #222222;
            /* Start color when not clicked */
        }

        .starrating > input:checked ~ label {
            color: #ffca08;
        }

        /* Set yellow color when star checked */

        .starrating > input:hover ~ label {
            color: #ffca08;
        }

    </style>
    {{-- rating styles --}}
@endsection

@section('content')

    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            {{-- show errors --}}
            @if(session('error'))
                <div id="alert-danger" class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div id="alert-success" class="alert alert-success">{{ session('success') }}</div>
            @endif
            {{-- show errors --}}
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{ $product->name }}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <!-- start image gallery -->
                        <section class="col-md-4">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                <section class="product-gallery">

                                    <section class="product-gallery-selected-image mb-3">
                                        <img
                                            src="{{ asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                                            alt="{{ $product->name }}">
                                    </section>
                                    <section class="product-gallery-thumbs">
                                        @if($product->images->count() > 0)
                                            @foreach($product->images as $key => $image)
                                                <img class="product-gallery-thumb"
                                                     src="{{ asset($image->image['indexArray'][$image->image['currentImage']]) }}"
                                                     alt="تصویر {{ $product->name }}"
                                                     title="{{ $product->name }}"
                                                     data-input="{{ asset($image->image['indexArray'][$image->image['currentImage']]) }}">
                                            @endforeach
                                        @endif

                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- end image gallery -->

                        <!-- start product info -->

                        <section class="col-md-5">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            {{ $product->name }}
                                        </h2>
                                        <section class="content-header-link">
                                            {{--                                            <a href="#">مشاهده همه</a>--}}
                                        </section>
                                    </section>
                                </section>
                                <section class="product-info">
                                    <form action="{{ route('customer.add-to-cart',$product) }}"
                                          id="add-to-cart"
                                          method="post"
                                          class="product-info">
                                        @csrf

                                        @php
                                            $colors = $product->colors()->get();
                                        @endphp

                                        @if($colors->count() > 0)
                                            <p class="fw-bold">
                                            <span>رنگ انتخابی :  <span
                                                    id="selected_color_name">{{ $colors->first()->color_name }}</span></span>
                                            </p>
                                            <p>
                                                @foreach($product->colors as $key => $color)
                                                    <label for="color_{{ $color->id }}"
                                                           style="background-color: {{ $color->color ?? '' }};"
                                                           class="product-info-colors me-1"
                                                           data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                           title="{{ $color->color_name ?? '' }}"></label>
                                                    <input type="radio"
                                                           name="color"
                                                           id="color_{{ $color->id }}"
                                                           value="{{ $color->id }}"
                                                           data-color-name="{{ $color->color_name }}"
                                                           data-color-price="{{ $color->price_increase }}"
                                                           @if($key == 0) selected @endif
                                                           class="d-none">
                                                @endforeach
                                            </p>
                                        @endif
                                        @if($product->guaranties()->count() > 0)

                                            <p><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                گارانتی :
                                                <select name="guaranty" id="guaranty" class="p-1">

                                                    @foreach($product->guaranties as $key => $guaranty)
                                                        <option value="{{ $guaranty->id }}"
                                                                data-guaranty-price="{{ $guaranty->price_increase }}"
                                                                @if($key == 0) selected @endif>
                                                            {{ $guaranty->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            </p>

                                        @endif

                                        @if($product->marketable_number < 10 && $product->marketable_number !== 0)
                                            <p>
                                                <i class="fa fa-exclamation-triangle text-danger fw-bolder cart-product-selected-store me-1"></i>
                                                <span class="text-danger fw-bolder">تعداد {{ convertEnglishToPersian($product->marketable_number) }} عدد موجود در انبار</span>
                                            </p>
                                        @elseif($product->marketable_number === 0)
                                            <p>
                                                <a class="btn btn-light btn-sm text-decoration-none text-success"
                                                   href="#">
                                                    <i class="fa fa-bell text-danger"></i>
                                                    <span class="fw-bolder">در صورت موجود شدن خبرم کن</span>
                                                </a>
                                            </p>
                                        @endif
                                        {{--                                    <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span>--}}
                                        <section class="">
                                            @guest
                                                <section class="product-add-to-favorite position-relative"
                                                         style="display: inline;top:0;">
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
                                                @if ($product->users->contains(auth()->id()))
                                                    <section
                                                        class="product-add-to-favorite position-relative d-flex justify-content-start align-items-baseline"
                                                        style="display: inline;top:0;">
                                                        <span class="fw-bolder mx-1"> حذف از علاقه مندی ها </span>
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
                                                    <section
                                                        class="product-add-to-favorite position-relative d-flex justify-content-start align-items-baseline"
                                                        style="display: inline;top:0;">
                                                        <span class="fw-bolder mx-1"> افزودن به علاقه مندی ها </span>
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
                                            @endauth
                                        </section>

                                        @if($product->marketable_number > 0 )
                                            <section class="d-flex justify-content-start align-items-baseline">
                                                <section class="fw-bolder m-2"> تعداد کالا :</section>
                                                <section class="cart-product-number d-inline-block">
                                                    <select name="number" id="number" onchange="changePrice()">
                                                        @for ($i = 1; $i <= $product->marketable_number; $i++)
                                                            <option value="{{ $i }}"
                                                                    class="w-100">{{ convertEnglishToPersian($i) }}</option>
                                                        @endfor
                                                    </select>
                                                </section>
                                            </section>

                                            @error('number')
                                            <span class="alert_required text-danger" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                            @enderror

                                        @endif

                                        <p class="mb-3 mt-5 border p-2 rounded">
                                            <i class="fa fa-exclamation-triangle text-danger"></i>
                                            <span class="fw-bolder text-muted">
                                            کاربر گرامی، قیمت ها بر اساس رنگ، ویژگی، گارانتی و دیگر موارد ذکر شده متغیر خواهد بود.
                                        </span>
                                        </p>
                                        <p class="mb-3 mt-5">
                                            <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز
                                            نهایی
                                            نشده
                                            است.
                                            برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس
                                            نحوه
                                            ارسال
                                            را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه
                                            شده
                                            خواهد
                                            شد.
                                            و در نهایت پرداخت این سفارش صورت میگیرد. پس از ثبت سفارش کالا بر
                                            اساس
                                            نحوه
                                            ارسال
                                            که شما انتخاب کرده اید کالا برای شما در مدت زمان مذکور ارسال می
                                            گردد.
                                        </p>
                                </section>

                            </section>

                        </section>
                        <!-- end product info -->

                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted font-weight-bold">قیمت کالا</p>
                                    <p class="text-muted fw-bolder">
                                        <span data-product-original-price="{{ $product->price }}"
                                              id="product_original_price">
                                            {{ convertEnglishToPersian(priceFormat($product->price)) }}
                                        </span>
                                        <span class="small">تومان</span>
                                    </p>
                                </section>

                                @php
                                    $amazing_sale = $product->active_amazing_sales()->first();
                                    if ($amazing_sale){
                                        $product_discount_price = $product->price * ($amazing_sale->percentage/100);
                                    }

                                @endphp
                                @if ($amazing_sale != null)
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">تخفیف کالا</p>
                                        <p class="text-danger fw-bolder"
                                           id="product_discount_price"
                                           data-product-discount-price="{{ $product_discount_price }}">
                                            {{ convertEnglishToPersian(priceFormat($product_discount_price)) }}
                                            <span class="small">تومان</span>
                                        </p>
                                    </section>
                                @endif


                                <section class="border-bottom mb-3"></section>

                                <section
                                    class="d-flex justify-content-between align-items-center fw-bolder text-success">
                                    <p>مبلغ قابل پرداخت</p>
                                    <p>
                                        <span
                                            id="product_final_price">{{ convertEnglishToPersian(priceFormat(calculateFinalPrice($product))) }}</span>
                                        <span class="small">تومان</span></p>
                                </section>

                                <section class="add-to-cart">
                                    @if($product->marketable_number > 0)
                                        <button id="next-level"
                                                onclick="document.getElementById('add-to-cart').submit();"
                                                class="btn custom-btn d-block fw-bolder w-100">
                                            افزودن به سبد خرید
                                            خرید
                                        </button>
                                    @else
                                        <button id="next-level" class="btn btn-secondary d-block disabled w-100"
                                                disabled="on">
                                            <i class="fa fa-exclamation-triangle"></i> کالا ناموجود
                                        </button>
                                    @endif
                                </section>
                                </form>


                            </section>

                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
    </section>
    <!-- end cart -->



    @include('app.partials.related-products')

    <!-- start description, features and comments -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">

                        <!-- start content header -->
                        <section id="introduction-features-comments" class="introduction-features-comments">
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                              href="#introduction">معرفی</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#features">ویژگی ها</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#comments">دیدگاه ها</a></span>
                                        <span class="me-2"><a class="text-decoration-none text-dark" href="#rating">امتیازات</a></span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- start content header -->

                        <section class="py-4">


                            <!-- start vontent header -->
                            <section id="introduction" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        معرفی
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-introduction mb-4">
                                {{ strip_tags($product->introduction) }}
                            </section>


                            <!-- start vontent header -->
                            <section id="features" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        ویژگی ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>

                            <section class="product-features mb-4 table-responsive">
                                <table class="table table-bordered border-white">

                                    @if($product->values()->count() > 0)
                                        @foreach($product->values as $value)
                                            <tr>
                                                <td>{{ $value->attribute()->first()->name }}</td>
                                                <td>{{ convertEnglishToPersian(json_decode($value->value)->value) }} {{ $value->attribute()->first()->unit }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @foreach($product->metas->toArray() as $meta)
                                        <tr>
                                            <td>{{ $meta['meta_key'] }}</td>
                                            <td>{{ convertEnglishToPersian($meta['meta_value']) }}</td>
                                        </tr>
                                    @endforeach


                                </table>
                            </section>

                            <!-- start vontent header -->
                            <section id="comments" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        دیدگاه ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-comments mb-4">

                                <section class="comment-add-wrapper">
                                    <button class="comment-add-button"
                                            type="button"
                                            style="background-color: beige;font-size: 1.2rem;font-weight: 600;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#add-comment"><i class="fa fa-plus"></i>
                                        {{ auth()->check() ? 'افزودن نظر' : 'برای افزوودن نظر ابتدا به حساب کاربری وارد شوید' }}
                                    </button>
                                    <!-- start add comment Modal -->
                                    @auth()

                                        <section class="modal fade" id="add-comment" tabindex="-1"
                                                 aria-labelledby="add-comment-label" aria-hidden="true">
                                            <section class="modal-dialog">
                                                <section class="modal-content">
                                                    <section class="modal-header">
                                                        <h5 class="modal-title" id="add-comment-label"><i
                                                                class="fa fa-plus"></i> افزودن دیدگاه</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </section>


                                                    <section class="modal-body">
                                                        <form class="row"
                                                              action="{{ route('market.add-comment',$product) }}"
                                                              method="post">
                                                            @csrf


                                                            <section class="col-12 mb-2">
                                                                <label for="body" class="form-label mb-1">دیدگاه
                                                                    شما</label>
                                                                <textarea class="form-control form-control-sm"
                                                                          name="body" id="body"
                                                                          placeholder="دیدگاه شما ..."
                                                                          rows="8" cols="15"></textarea>
                                                            </section>
                                                            <section class="modal-footer py-1">
                                                                <button type="submit" class="btn btn-sm btn-primary">ثبت
                                                                    دیدگاه
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                        data-bs-dismiss="modal">بستن
                                                                </button>
                                                            </section>
                                                        </form>

                                                    </section>


                                                </section>
                                            </section>
                                        </section>

                                    @endauth

                                </section>

                                <section class="product-comment">
                                    @foreach($product->approved_comments() as $comment)
                                        <section class="product-comment-header d-flex justify-content-start">
                                            <section
                                                class="product-comment-title">{{ $comment->author->fullname ?? 'کاربر ناشناس' }}
                                            </section>
                                            <section
                                                class="product-comment-date mx-2 "> ثبت شده
                                                در {{ convertEnglishToPersian(persianDate($comment->created_at)) }}
                                            </section>
                                        </section>
                                        <section class="product-comment-body mr-3 mb-4">
                                            {{ strip_tags($comment->body) }}
                                        </section>

                                        @if($comment->children)
                                            @foreach($comment->children as $child)
                                                <section class="comment-reply" style="margin-right: 1.5rem">
                                                    <section
                                                        class="product-comment-header d-flex justify-content-start">
                                                        <section
                                                            class="product-comment-title text-success">{{ $child->author->fullname ?? 'کاربر ناشناس' }}
                                                        </section>
                                                        <section
                                                            class="product-comment-date mx-2 "> ثبت شده
                                                            در {{ convertEnglishToPersian(persianDate($child->created_at)) }}
                                                        </section>
                                                    </section>
                                                    <section class="product-comment-body mr-3 mb-4">
                                                        {{ strip_tags($child->body) }}
                                                    </section>
                                                </section>
                                            @endforeach
                                        @endif
                                    @endforeach

                                </section>

                                @auth

                                    @if(auth()->user()->is_user_purchased_this_product($product->id)->count() > 0)
                                        <section id="rating" class="content-header mt-2 mb-4">
                                            <section class="d-flex justify-content-between align-items-center">
                                                <h2 class="content-header-title content-header-title-small">
                                                    امتیازات
                                                </h2>
                                                <section class="content-header-link">
                                                    <!--<a href="#">مشاهده همه</a>-->
                                                </section>
                                            </section>
                                        </section>

                                        <section class="product-rating mb-4">
                                            <div class="container">
                                                <h5 class="text-info text-sm fw-bolder">
                                                    امتیاز خود را به این محصول انتخاب نمایید
                                                </h5>
                                                <form
                                                    class="starrating risingstar d-flex justify-content-end flex-row-reverse align-items-center"
                                                    action="{{ route('customer.product.rating', $product->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="radio" id="star5" name="rating" value="5"/>
                                                    <label for="star5" title="5 star"></label>
                                                    <input type="radio" id="star4" name="rating" value="4"/>
                                                    <label for="star4" title="4 star"></label>
                                                    <input type="radio" id="star3" name="rating" value="3"/>
                                                    <label for="star3" title="3 star"></label>
                                                    <input type="radio" id="star2" name="rating" value="2"/>
                                                    <label for="star2" title="2 star"></label>
                                                    <input type="radio" id="star1" name="rating" value="1"/>
                                                    <label for="star1" title="1 star"></label>

                                                </form>

                                                <h6>
                                                    @if($product->ratingsCount() == 0)
                                                        به این محصول شما اولین نفری باشید که رای می دهید.
                                                    @else
                                                        تعداد کل امتیازات این محصول
                                                        : {{ convertEnglishToPersian($product->ratingsCount()) }} <br>
                                                        میانگین امتیازات
                                                        :  {{ convertEnglishToPersian(number_format($product->ratingsAvg(),1,'/')) }}

                                                    @endif
                                                </h6>
                                            </div>

                                        </section>

                                    @endif

                                @endauth


                            </section>
                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end description, features and comments -->

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


        $(document).ready(function () {
            changePrice();

            // input color
            $('input[name="color"]').change(function () {
                changePrice();
            });

            // guaranty change
            $('select[name="guaranty"]').change(function () {
                changePrice();
            });

            // number change
            $('#number').change(function () {
                changePrice();
            });
        });

        function changePrice() {
            // Calculate the price based on selected options
            let selected_color_price = parseFloat($('input[name="color"]:checked').attr('data-color-price') || 0);
            let selected_guaranty_price = parseFloat($('select[name="guaranty"] option:selected').attr('data-guaranty-price') || 0);
            let number = parseFloat($('#number').val() || 1);
            let product_discount_price = parseFloat($('#product_discount_price').attr('data-product-discount-price') || 0);
            let product_original_price = parseFloat($('#product_original_price').attr('data-product-original-price'));
            // alert(product_discount_price)
            // Calculate the final price
            let product_price = product_original_price + selected_color_price + selected_guaranty_price;
            let total_discount = product_discount_price * number; // Calculate total discount
            let product_final_price = (product_price * number) - total_discount; // Adjust final price calculation

            // Update the displayed prices
            $('#product_original_price').html(toFarsiNumber(product_price));
            $('#product_discount_price').html(toFarsiNumber(product_discount_price) + ' تومان ');
            $('#product_final_price').html(toFarsiNumber(product_final_price));
        }


        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            // alert(number)
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }
    </script>

    <script type="text/javascript">

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

    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}

    <script>
        $(document).ready(function () {
            $('.starrating input').on('change', function () {
                var rating = $(this).val(); // Get the selected rating value
                var url = $(this).closest('form').attr('action'); // Get the form action URL

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        rating: rating,
                        _token: "{{ csrf_token() }}" // Add CSRF token
                    },
                    success: function (response) {
                        // Handle success response
                        var message = response.message;
                        var alertType = response.alertType;
                        // Show an alert to the user
                        showToastrMessage(message, alertType);
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        var errorMessage = xhr.responseJSON.message;
                        var alertType = xhr.responseJSON.alertType;
                        // Show an alert to the user
                        showToastrMessage(errorMessage, alertType);
                    }
                });
            });

            function showAlert(message, alertType) {
                // Show a Bootstrap alert with the provided message and alert type
                var alertDiv = $('<div>').addClass('alert alert-' + alertType).text(message);
                $('.alert-container').empty().append(alertDiv);
                // Hide the alert after 3 seconds
                setTimeout(function () {
                    $('.alert').alert('close');
                }, 3000);
            }
        });


    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
