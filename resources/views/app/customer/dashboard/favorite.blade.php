@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>پنل مشتری | علاقه مندی ها</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')

    {{-- favorites --}}
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

        @forelse(auth()->user()->products as $product)
            <section class="cart-item d-flex py-3">
                <section class="cart-img align-self-start flex-shrink-1">
                    <a href="{{ route('market.product',$product->slug) }}">
                        <img src="{{ asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                             alt="{{ $product->name }}">
                    </a>
                </section>
                <section class="align-self-start w-100">
                    <p class="fw-bold">{{ $product->name }}</p>
                    {{-- Display product colors in one line --}}
                    @if($product->colors->isNotEmpty())
                        <p>
                            @foreach($product->colors as $color)
                                <span style="background-color: {{ $color->color }};"
                                      class="cart-product-selected-color me-1"></span>
                                {{ $color->name }}
                            @endforeach
                        </p>
                    @endif
                    {{-- Display product guarantee --}}
                    @foreach($product->guaranties as $guaranty)
                        <p>
                            <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                            <span>{{ $guaranty->name }}</span>
                        </p>
                    @endforeach
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

                    <section class="cart-actions">
                        <a href="{{ route('customer.dashboard.profile.delete-from-favorite', $product->id) }}"
                           class="text-decoration-none cart-delete">
                            <i class="fa fa-trash-alt"></i> حذف از لیست
                        </a>
                    </section>

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
                                    آیا مطمئنید که می‌خواهید این مورد را از لیست علاقه‌مندی‌ها حذف کنید؟
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
                <section class="justify-content-between flex-shrink-1">
                    <section class="fw-bolder favorite-to-cart">

                        <button
                            data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            data-url="{{ route('customer.ajax-add-to-cart',$product)}}"
                            class="btn custom-btn btn-sm">
                            <i class="fa fa-cart-plus"></i>
                        </button>

                    </section>
                    <section
                        class="mt-4 text-nowrap fw-bold @if($product->active_amazing_sales()->first() !== null) text-danger text-decoration-line-through @endif">
                        {{-- Original price --}}
                        {{ convertEnglishToPersian(priceFormat($product->price)) }} تومان
                    </section>

                    @php
                        $amazingSale = $product->active_amazing_sales()->first();
                    @endphp
                    @if ($amazingSale)
                        {{-- Display discounted price and details if the product is in the amazing price list --}}
                        <section class="d-flex justify-content-between align-items-center">
                            {{-- New discounted price --}}
                            <p class="text-success fw-bolder" id="product-discounted-price"
                               data-product-discount-price="{{ $product->price * (1 - ($amazingSale->percentage / 100)) }}">
                                {{ priceFormat($product->price * (1 - ($amazingSale->percentage / 100))) }} <span
                                    class="small">تومان</span>
                            </p>
                        </section>
                    @endif
                </section>


            </section>

        @empty
            <section class="">
                <span class="fw-bolder">شما هیچ علاقه مندی ثبت نکرده اید!</span>
            </section>
        @endforelse


    </section>
    {{-- favorites --}}

@endsection
@section('script')

    <script>

        $('.favorite-to-cart button').click(function (event){
            event.preventDefault();
            const url = $(this).data('url');
            const element = $(this);

            $.ajax({
                url : url,
                type : 'POST',
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                success : function (response){
                    if(response.status){
                        if(response.added){
                            element.children().first().addClass('text-danger');
                            element.attr('data-original-title','حذف از سبد خرید');
                            element.attr('data-bs-original-title','حذف از سبد خرید');
                        }else{
                            element.children().first().removeClass('text-danger');
                            element.attr('data-original-title','افزودن به سبد خرید');
                            element.attr('data-bs-original-title','افزودن به سبد خرید');
                        }

                        showToastrMessage(response.message,response.alertType);
                    }else{
                        showToastrMessage(response.message,response.alertType);
                        console.error(response.message);
                    }
                },
                error:function (jqXHR,textStatus,errorThrown){
                    showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                    console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                }
            });
        });


        // Function to handle the delete confirmation
        function handleDeleteConfirmation(url, element) {
            alert('hello0')
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

    </script>



    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
