@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | محصولات</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.product.create') }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد کالای جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">
                            <i class="fa fa-plus-circle"></i> ایجاد کالای جدید
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید محصولات فروشگاه خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل محصولات
                            : {{ $products->count() != 0 ? $products->count() : 'صفر' }}</strong>
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
                                    <th scope="col">نام کالا</th>
                                    <th scope="col">موجودی</th>
                                    <th scope="col">رزرو</th>
                                    <th scope="col">فروخته شده</th>
                                    <th scope="col">تصویر</th>
                                    <th scope="col">قیمت</th>
                                    <th scope="col">دسته بندی</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">امکان خرید</th>
                                    <th scope="col">گالری</th>
                                    <th class="max-width-16-rem text-left" scope="col">
                                        <i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->marketable_number }}</td>
                                        <td>{{ $product->frozen_number }}</td>
                                        <td>{{ $product->sold_number }}</td>
                                        <td>
                                            <img style="width: 50px;height: 50px;"
                                                 src="{{ asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                                                 alt="تصویر کالا">
                                        </td>
                                        <td>{{ number_format($product->price) }} تومان</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td class="">
                                            <label for="status">
                                                <input
                                                    data-url="{{ route('admin.market.product.status',$product->id) }}"
                                                    type="checkbox"
                                                    name="status"
                                                    id="status_{{ $product->id }}"
                                                    onchange="changeStatus('{{ $product->id }}')"
                                                    @if($product->status === 1)
                                                        checked
                                                    @endif
                                                >
                                            </label>
                                        </td>
                                        <td class="">
                                            <label for="marketable">
                                                <input
                                                    data-url="{{ route('admin.market.product.marketable',$product->id) }}"
                                                    type="checkbox"
                                                    name="marketable"
                                                    id="marketable_{{ $product->id }}"
                                                    onchange="changeMarketable('{{ $product->id }}')"
                                                    @if($product->marketable === 1)
                                                        checked
                                                    @endif
                                                >
                                            </label>
                                        </td>
                                        <td>{{ $product->images->count() > 0 ? $product->images->count() : 'صفر' }}</td>
                                        <td class="text-left">
                                            <div class="dropdown">
                                            <span class="btn btn-success btn-sm btn-block dropdown-toggle"
                                                  role="button"
                                                  id="dropdown-menu-link" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-cog"></i> عملیات
                                            </span>
                                                <style>
                                                    .dropdown-menu a:hover {
                                                        background-color: #2EA08C;
                                                        color: #FFFFFF !important;
                                                    }
                                                </style>
                                                <div aria-label="dropdown-menu-link" class="dropdown-menu">
                                                    <a href="{{ route('admin.market.product.gallery.index',$product->id) }}"
                                                       class="dropdown-item text-right text-sm text-muted"><i
                                                            class="fa fa-image"></i> گالری تصاویر </a>

                                                    <a href="{{ route('admin.market.product.guaranty.index',$product->id) }}"
                                                       class="dropdown-item text-right text-sm text-muted"><i
                                                            class="mdi mdi-shield-outline"></i> گارانتی </a>

                                                    <a href="{{ route('admin.market.product.color.index',$product->id) }}"
                                                       class="dropdown-item text-right  text-sm text-muted"><i
                                                            class="fa fa-book"></i> مدیریت رنگ ها</a>

                                                    <a href="{{ route('admin.market.product.edit',$product->id) }}"
                                                       class="dropdown-item text-right  text-sm text-muted"><i
                                                            class="fa fa-edit"></i> ویرایش</a>

                                                    <a href="{{ route('admin.market.product.show',$product->id) }}"
                                                       class="dropdown-item text-right  text-sm text-muted"><i
                                                            class="fa fa-eye"></i> مشاهده </a>

                                                    <form
                                                        action="{{ route('admin.market.product.destroy',$product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <a type="submit"
                                                           id="delete"
                                                           class="btn btn-xs dropdown-item text-right text-sm text-muted delete">
                                                            <i class="fa fa-trash"></i> حذف
                                                        </a>
                                                    </form>

                                                </div>
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
            const url = $("#status_" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    if (response.status) {
                        $("#status_" + id).prop("checked", response.checked); // Update checkbox state
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

