@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | فرم کالا</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.property.create') }}"
                       type="button"
                       class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> ایجاد فرم کالای جدید</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">فرم کالا</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید فرم های محصولات فروشگاه خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل فرم محصولات
                            : {{ $category_attributes->count() != 0 ? $category_attributes->count() : 'صفر' }}</strong>
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
                       <table id="example" class="display table table-striped table-bordered table-responsive-md table-hover" style="width:100%">
                           <style>
                               th {
                                   text-align: right !important;
                               }
                           </style>
                           <thead>
                           <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                               <th>شناسه</th>
                               <th scope="col">نام</th>
                               <th scope="col">واحد اندازه گیری</th>
                               <th scope="col">دسته بندی</th>
                               <th class="max-width-16-rem text-center" scope="col">
                                   <i class="fa fa-cogs"></i>
                                   تنظیمات
                               </th>
                           </tr>
                           </thead>
                           <tbody>
                           @foreach($category_attributes as $category_attribute)
                               <tr>
                                   <td>{{ $loop->iteration }}</td>
                                   <td>{{ $category_attribute->name ?? '-' }}</td>
                                   <td>{{ $category_attribute->unit ?? '-' }}</td>
                                   <td>{{ $category_attribute->category->name ?? '-' }}</td>
                                   <td class="text-center width-22-rem">
                                       <div class="row justify-content-around">
                                           <a href="{{ route('admin.market.property.value.index',$category_attribute->id) }}"
                                              type="submit" class="btn btn-xs btn-success" title="نمایش"><i
                                                   class="fa fa-check-circle"></i>
                                               ویژگی ها </a>
                                           <a href="{{ route('admin.market.property.edit',$category_attribute->id) }}"
                                              class="btn btn-xs btn-warning" title="باطل کردن"><i
                                                   class="fa fa-edit"></i> ویرایش </a>
                                           <form action="{{ route('admin.market.property.destroy',$category_attribute->id) }}"
                                                 method="post">
                                               @csrf
                                               @method('delete')

                                               <button class="btn btn-xs btn-danger delete" title="حذف"><i
                                                       class="fa fa-trash"></i> حذف
                                               </button>
                                           </form>
                                       </div>
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

