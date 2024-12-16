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
                        <section class="brands light-owl-nav owl-carousel owl-theme" data-loop="false">
                            @forelse($related_products as $related_product)
                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            <a class="product-link"
                                               href="{{ route('market.product',$related_product->slug) }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ asset($related_product->image['indexArray'][$related_product->image['currentImage']]) }}"
                                                         alt="{{ $related_product->name }}">
                                                </section>

                                                <section class="product-name"><h3>{{ $related_product->name }}</h3>
                                                </section>
                                                <section class="product-price-wrapper">
                                                    <section
                                                        class="product-price">{{ convertEnglishToPersian(priceFormat($related_product->price)) }}
                                                        تومان
                                                    </section>
                                                </section>
                                                @php
                                                    $colors = $related_product->colors()->get();
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

                                            @if($related_product->marketable_number > 0)
                                                <section class="ajax-add-to-cart product-add-to-cart">
                                                    <button
                                                        class="btn custom-btn btn-sm text-decoration-none"
                                                        data-url="{{ route('customer.ajax-add-to-cart',$related_product) }}"
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
                                                        data-url="{{ route('market.add-to-favorite', $related_product) }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="left"
                                                        title="افزودن به علاقه مندی ها">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if ($related_product->users->contains(auth()->user()->id))
                                                    <section class="product-add-to-favorite">
                                                        <button
                                                            class="btn custom-btn btn-sm text-decoration-none"
                                                            data-url="{{ route('market.add-to-favorite', $related_product) }}"
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
                                                            data-url="{{ route('market.add-to-favorite', $related_product) }}"
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
                                
                            @endforelse


                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end product lazy load -->
