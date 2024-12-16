@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | کالا | گالری</title>

    <link rel="stylesheet" href="{{ asset('admin-asset/datepicker/persian-datepicker.min.css') }}">

@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.index') }}">محصول</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.gallery.index',$product->id) }}">گالری محصول</a></li>
                        <li class="breadcrumb-item active">ایجاد عکس</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 py-4 px-3 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <h5>
                       در این قسمت به هر تعداد که می خواهید برای کالای <span class="text-success font-weight-bold">{{ $product->name }}</span> میتوانید عکس ذخیره کنید، یعنی ایجاد گالری محصول.
                    </h5>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.product.gallery.store',$product->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div id="gallery">
                    <div class="gallery-item form-group">
                        <div class="row">
                            <input type="file"
                                   id="image[]"
                                   name="image[]"
                                   data-url="{{ route('admin.market.product.gallery.store',$product->id) }}"
                                   class="form-group-item">
                            <button type="button" class="btn btn-sm btn-danger remove-item"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="btn btn-sm btn-success my-4"><i class="fa fa-plus-circle"></i> افزودن تصویر </button>
                <button class="btn btn-primary btn-sm"><i class="fa fa-save"></i> ثبت تصویر کالا </button>
                <a class="btn btn-sm btn-warning" href="{{ route('admin.market.product.gallery.index',$product->id) }}"> <i class="fa fa-undo"></i> بازگشت</a>
            </form>
        </div>
    </section>
@endsection


@section('script')
    <script type="text/javascript">
        // for duplicating the button
        $(function () {
            $('#btn-copy').on('click', function () {
                let element = $(this).parent().prev().clone(true,false);
                element.find('input[type="text"]').val(''); // Clear the cloned input values
                $(this).before(element);

                // focus on the closed input fields
                element.find('input[type="text"').first().focus();
            });
        });

        // add images
        $(function () {
            // Handle adding new items to the gallery
            $('#add-item').on('click', function () {
                let newItem = $('.gallery-item').first().clone();
                newItem.find('input').val('');
                $('#gallery').append(newItem);
            });

            // Handle removing items from the gallery
            $(document).on('click', '.remove-item', function () {
                $(this).closest('.gallery-item').remove();
            });

            // Handle form submission
            $('#form').on('submit', function (e) {
                e.preventDefault();

                let formData = new FormData(this);
                let url = $(this).attr('action');

                $.ajax({
                    url: url,
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Handle success response
                        console.log(response);

                        // Clear the input fields
                        $('.gallery-item input').val('');

                        // Show success message using custom Toastr function
                        showToastrMessage(response.message, response.alertType);

                        // TODO : ADD A FEATURE TO SHOW INSERTED IMAGE BELLOW OF THE INPUTS
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        console.log(xhr);
                        console.log(status);
                        console.log(error);

                        // Show error message using custom Toastr function
                        showToastrMessage('خطا در افزودن تصاویر.', 'error');
                    }
                });
            });
        });

    </script>
    {{--  select2 usage   --}}

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

