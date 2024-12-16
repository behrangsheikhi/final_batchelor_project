@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>پنل مشتری | علاقه مندی ها</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')

    {{-- favorites --}}
    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

        <!-- start content header -->
        <section class="content-header mb-4">
            <section class="d-flex justify-content-between align-items-center">
                <h2 class="content-header-title">
                    <span>لیست مقایسه های من ({{ convertEnglishToPersian($user_compare_list->count()) }})</span>
                </h2>
                <section class="content-header-link">
                    <!--<a href="#">مشاهده همه</a>-->
                </section>
            </section>
        </section>
        <!-- end content header -->

        <div class="table-responsive">
            @if($user_compare_list->count() > 0)
                <table class="table table-bordered">
                    <tbody>
                    @foreach($user_compare_list as $product)
                        <tr>
                            <td class="fw-bolder cart-actions" style="font-size: 0.75rem;">

                                @if($product->marketable_number > 0)
                                    <button
                                        class="btn btn-sm custom-btn"
                                        title="اضافه به سبد خرید"
                                        type="button"
                                        data-url="{{ route('customer.ajax-add-to-cart',$product) }}">
                                        <i class="fa fa-cart-plus"></i>
                                    </button>
                                @endif

                                <a class="btn btn-sm btn-danger cart-delete text-white"
                                   title="حذف"
                                   href="{{ route('customer.dashboard.profile.delete-from-compare', $product->id) }}"
                                   data-product-id="{{ $product->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>

                                {{-- delete modal --}}
                                <!-- Modal -->
                                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
                                     aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">تایید
                                                    حذف</h5>

                                            </div>
                                            <div class="modal-body">
                                                آیا مطمئنید که می‌خواهید این مورد را از لیست مقایسه ها حذف کنید؟
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    لغو
                                                </button>
                                                <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                                                    حذف
                                                </button>
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


                            </td>
                            <td>
                                <a href="{{ route('market.product',$product->slug) }}" title="{{ $product->name }}">
                                    <img src="{{ asset($product->image['indexArray']['medium']) }}"
                                         alt="{{ $product->name }}" width="50"
                                         height="50">
                                </a>
                            </td>

                            <td class="fw-bolder" style="font-size: 0.75rem;">قیمت محصول</td>
                            <td class="text-sm" style="font-size: 0.9rem;">{{ priceFormat($product->price) }}</td>

                            <td class="fw-bolder" style="font-size: 0.75rem;">نام محصول</td>
                            <td title="{{ convertEnglishToPersian($product->name) }}" class="text-sm"
                                style="font-size: 0.9rem;">
                                {{ Str::limit(convertEnglishToPersian($product->name), 20) }}
                            </td>

                            <td class="fw-bolder" style="font-size: 0.75rem;">ویژگی ها</td>
                            <td>
                                <table style="font-size: 0.75rem;font-weight: 500;" class="table">
                                    @foreach($product->values as $value)
                                        <tr>
                                            <td class="mx-1">{{ $value->attribute()->first()->name }}</td>
                                            <td>{{ convertEnglishToPersian(json_decode($value->value)->value) }} {{ $value->attribute()->first()->unit }}</td>
                                        </tr>
                                    @endforeach

                                    @foreach($product->metas as $meta)
                                        <tr>
                                            <td class="mx-1">{{ $meta->meta_key }}</td>
                                            <td>{{ convertEnglishToPersian($meta->meta_value) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h2>محصولی برای مقایسه یافت نشد</h2>
            @endif
        </div>


    </section>
    {{-- favorites --}}

@endsection
@section('script')

    <script>

        $(document).ready(function () {
            $('.cart-delete').click(function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                const productId = $(this).data('product-id'); // Get the product ID from the data attribute
                const element = $(this);

                $('#confirmDeleteModal').modal('show');

                $('#confirmDeleteButton').off('click').on('click', function () {
                    $.ajax({
                        url: url,
                        type: 'DELETE', // Use DELETE method for removal
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {productId: productId}, // Send the product ID along with the request
                        success: function (response) {
                            if (response.success) {
                                // Remove the product item from the DOM
                                const productItem = element.closest('.cart-item');
                                productItem.remove();
                                // Show notification message
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

        });

        $('.custom-btn').click(function (event) {
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
                        showToastrMessage(response.message, response.alertType);
                    } else {
                        showToastrMessage(response.message, response.alertType);
                        console.error(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Handle AJAX errors
                    console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                }
            });
        });


    </script>



    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
