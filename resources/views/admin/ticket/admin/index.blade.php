@extends('admin.layout.master')

@section('head-tag')
    <title>تیکت | ادمین تیکت</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.ticket.priority.create') }}" type="button"
                       class="btn btn-primary btn-sm disabled">
                        <i class="fa fa-plus-circle"></i> ایجاد ادمین تیکت جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ادمین تیکت</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید ادمین های بخش تیکت سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل ادمین
                            : {{ $admins->count() != 0 ? $admins->count() : 'صفر' }}</strong>
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
                          <table id="example" class="display table table-striped table-bordered table-responsive-md table-hover"
                                 style="width:100%">
                              <style>
                                  th {
                                      text-align: right !important;
                                  }
                              </style>
                              <thead>
                              <tr class="font-weight-bold">
                                  <th scope="col">نمایه</th>
                                  <th scope="col">ایمیل</th>
                                  <th scope="col">نام</th>
                                  <th class="text-left" scope="col"><i class="fa fa-cogs"></i>
                                      تنظیمات
                                  </th>
                              </tr>
                              </thead>
                              <tbody>
                              @foreach($admins as $admin)
                                  <tr style="font-size: 0.75rem;">
                                      <td><img src="{{ asset($admin->profile_photo_path) }}" width="40px" height="40px"
                                               alt="پروفایل"></td>
                                      <td>{{ $admin->email }}</td>
                                      <td>{{ $admin->fullname }}</td>
                                      <td class="text-left width-16-rem">
                                          <a href="{{ route('admin.ticket.admin.set',$admin->id)
                                     }}"
                                             class="btn btn-sm btn-{{ $admin->ticketAdmin == null ? 'success' : 'danger' }}">
                                              <i class="fa fa-{{ $admin->ticketAdmin == null ? 'check-circle' : 'times-circle' }}"></i>
                                              {{ $admin->ticketAdmin == null ? ' اضافه به تیکت ادمین ' : 'حذف از تیکت ادمین ' }}
                                          </a>
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

    </script>
@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

