@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | فرم کالا | مقدار فرم کالا</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.property.value.create',$attribute->id) }}"
                       type="button"
                       class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> ایجاد مقدار جدید برای فرم</a>
                    <a role="button" href="{{ route('admin.market.property.index') }}"
                       type="button"
                       class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> بازگشت</a>

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.property.index') }}">خانه</a>
                        </li>
                        <li class="breadcrumb-item active">مقدار برای فرم</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید مقادیر فروشگاه خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل مقادیر
                            : {{ $values->count() != 0 ? $values->count() : 'صفر' }}</strong>
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
                                  <th scope="col">شناسه</th>
                                  <th scope="col">نام فرم</th>
                                  <th scope="col">نام کالا</th>
                                  <th scope="col">مقدار</th>
                                  <th scope="col">افزایش قیمت</th>
                                  <th scope="col">نوع</th>
                                  <th class="" scope="col"><i class="fa fa-cogs"></i>
                                      تنظیمات
                                  </th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($values as $value)
                                  <tr>
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $attribute->name }}</td>
                                      <td>{{ $value->product->name }}</td>
                                      <td>{{ json_decode($value->value)->value }}</td>
                                      <td>{{ number_format(json_decode($value->value)->price_increase) }} تومان</td>
                                      <td class="text-{{ $value->type === 1 ? 'success' : 'danger' }}">{{ $value->type === 0 ? 'ساده' : 'انتخابی' }}</td>
                                      <td class="">
                                          <div class="row">
                                              <a href="{{ route('admin.market.property.value.edit',['attribute' => $attribute->id,'value' => $value->id]) }}"
                                                 class="btn btn-xs btn-primary text-white mx-3" title="ویرایش"><i
                                                      class="fa fa-edit"></i> ویرایش </a>
                                              <form
                                                  action="{{ route('admin.market.property.value.destroy',['attribute' => $attribute->id,'value' => $value->id]) }}"
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

