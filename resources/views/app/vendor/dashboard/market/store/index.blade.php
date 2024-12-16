@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | انبار</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.store.index') }}"
                       type="button"
                       class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> ایجاد انبار جدید</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">انبار</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید جزئیات انبار و موجودی محصولات را مشاهده یا مدیریت کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table id="example"
                                   class="display table table-striped table-bordered table-responsive-md table-hover"
                                   style="width:100%">
                                <style>
                                    th {
                                        text-align: right !important;
                                    }
                                </style>
                                <thead>
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                    <th>شناسه</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">تصویر</th>
                                    <th scope="col">قابل فروش</th>
                                    <th scope="col">رزرو شده</th>
                                    <th scope="col">فروخته شده</th>
                                    <th class="max-width-16-rem text-center" scope="col">
                                        <i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->name ?? '-' }}</td>
                                        <td>
                                            <img style="width: 50px;height: 50px;"
                                                 src="{{ asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                                                 alt="تصویر کالا">
                                        </td>
                                        <td class="text-{{ $product->marketable_number > 0 ? 'success' : 'danger'  }}">{{ $product->marketable_number > 0 ? $product->marketable_number : 'اتمام موجودی' }}</td>
                                        <td>{{ $product->frozen_number }}</td>
                                        <td>{{ $product->sold_number }}</td>

                                        <td class="text-left">
                                            <a href="{{ route('admin.market.store.add-to-store',$product->id)}}"
                                               class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i> افزایش
                                                موجودی </a>

                                            <a href="{{ route('admin.market.store.edit',$product->id)}}"
                                               class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> اصلاح
                                                موجودی </a>


                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">

        function changeStatus(id) {
            const url = $("#" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        $("#" + id).prop("checked", response.checked); // Update checkbox state
                        showToastrMessage(response.message, response.alertType); // Display toast message
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                    }
                },
                error: function () {
                    showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                }
            });
        }

        function changeMarketable(id) {
            const url = $("#marketable_" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    if (response.status) {
                        $("#marketable_" + id).prop("checked", response.checked); // Update checkbox state
                        showToastrMessage(response.message, response.alertType); // Display toast message
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                    }
                },
                error: function () {
                    showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                }
            });
        }

    </script>
@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

