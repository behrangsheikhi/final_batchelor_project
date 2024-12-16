@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | گارانتی</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.product.guaranty.create',$product->id) }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد گارانتی جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ایجاد گارانتی جدید</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center" style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید گارانتی های محصول فروشگاه خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل گارانتی
                            : {{ $product->guaranties->count() != 0 ? $product->guaranties->count() : 'صفر' }}</strong>
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
                                th{
                                    text-align: right !important;
                                }
                            </style>
                            <thead>
                            <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                <th scope="col">شناسه</th>
                                <th scope="col">عنوان</th>
                                <th scope="col">کالا</th>
                                <th scope="col">افزایش قیمت</th>
                                <th scope="col">وضعیت</th>
                                <th class="max-width-16-rem text-left" scope="col">
                                    <i class="fa fa-cogs"></i>
                                    تنظیمات
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product->guaranties as $guaranty)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ $loop->iteration }}</td>
                                    <td>{{ $guaranty->name }}</td>
                                    <td>{{ $guaranty->product->name }}</td>
                                    <td>{{ convertEnglishToPersian(priceFormat($guaranty->price_increase)) }} تومان</td>
                                    <td class="">
                                        <label for="status">
                                            <input
                                                data-url="{{ route('admin.market.product.guaranty.status',$guaranty->id) }}"
                                                type="checkbox"
                                                name="status"
                                                id="{{ $guaranty->id }}"
                                                onchange="changeStatus('{{ $guaranty->id }}')"
                                                {{ $guaranty->status ? 'checked' : '' }}
                                            >
                                        </label>
                                    </td>

                                    <td class="text-left">
                                        <form class="d-inline"
                                              action="{{ route('admin.market.product.guaranty.destroy',['product' => $product->id,'guaranty' => $guaranty->id]) }}"
                                              method="post">

                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    id="delete"
                                                    class="btn btn-xs btn-danger delete">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                        <a href="{{ route('admin.market.product.guaranty.edit',['product' => $product->id,'guaranty' => $guaranty])
                                     }}" class="btn btn-xs btn-primary"><i class="fa
                                    fa-edit"></i> </a>
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
                    console.log(response)
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


    </script>
@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

