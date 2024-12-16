@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | تخفیف ها | کد تخفیف</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.market.discount.coupon-create') }}"
                       type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد کد تخفیف جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active"> کد تخفیف</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید کوپن های تخفیف فروشگاه خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل کوپن تخفیف
                            : {{ $coupons->count() != 0 ? $coupons->count() : 'صفر' }}</strong>
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
                                  <th scope="col">کد </th>
                                  <th scope="col">مقدار </th>
                                  <th scope="col">نوع مقدار </th>
                                  <th scope="col">نوع (عمومی/خصوصی)</th>
                                  <th scope="col">تاریخ شروع</th>
                                  <th scope="col">تاریخ پایان</th>
                                  <th scope="col">کاربر</th>
                                  <th scope="col">وضعیت</th>
                                  <th class="max-width-16-rem text-left" scope="col">
                                      <i class="fa fa-cogs"></i>
                                      تنظیمات
                                  </th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach($coupons as $coupon)
                                  <tr role="row" class="odd">
                                      <td class="sorting_1">{{ $loop->iteration }}</td>
                                      <td>{{ $coupon->code ?? '-' }}</td>
                                      <td>
                                          @if($coupon->amount_type == 0)
                                              {{ $coupon->amount ?? '' }} %
                                          @elseif($coupon->amount_type == 1)
                                              {{ number_format($coupon->amount) ?? '' }} ریال
                                          @endif
                                      </td>
                                      <td>
                                          @if($coupon->amount_type == 0)
                                              درصدی
                                          @elseif($coupon->amount_type == 1)
                                              ریالی
                                          @endif
                                      </td>
                                      <td>
                                          @if($coupon->type == 1)
                                              اختصاصی
                                          @elseif($coupon->type == 0)
                                              عمومی
                                          @endif
                                      </td>
                                      <td>{{ persianDate($coupon->start_date) }}</td>
                                      <td>{{ persianDate($coupon->end_date) }}</td>
                                      <td>{{ $coupon->user->full_name ?? '-' }}</td>
                                      <td class="">
                                          <label for="status">
                                              <input
                                                  data-url="{{ route('admin.market.discount.coupon-status',$coupon->id) }}"
                                                  type="checkbox"
                                                  name="status"
                                                  id="{{ $coupon->id }}" onchange="changeStatus('{{ $coupon->id }}')"
                                                  @if($coupon->status === 1)
                                                      checked
                                                  @endif
                                              >
                                          </label>
                                      </td>
                                      <td class="width-16-rem text-left">
                                          <form class="d-inline"
                                                action="{{ route('admin.market.discount.coupon-destroy',$coupon->id) }}"
                                                method="post">
                                              @csrf
                                              @method('delete')
                                              <button type="submit"
                                                      id="delete"
                                                      class="btn btn-xs btn-danger delete">
                                                  <i class="fa fa-trash"></i>
                                              </button>
                                          </form>
                                          <a href="{{ route('admin.market.discount.coupon-edit',$coupon->id)
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

