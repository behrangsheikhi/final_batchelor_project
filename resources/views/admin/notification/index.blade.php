@extends('admin.layout.master')

@section('head-tag')
    <title>داشبور | اعلانات</title>

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-right mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">اعلانات</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید اعلانات سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل اعلانات
                            : {{ $notifications->count() != 0 ? $notifications->count() : 'صفر' }}</strong>
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
                                    <th scope="col">شناسه</th>
                                    <th scope="col">نوع اعلان</th>
                                    <th scope="col">پیام</th>
                                    <th scope="col">تاریخ ایجاد</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- TODO : FIX THIS PART TO SHOW NOTIFICATIONS LISTED IN THIS VIEW(Problem: I can't get notifications in foreach loop) --}}
                                @foreach($notifications as $notification)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $loop->iteration }}</td>
                                        <td>
                                            @if($notification['type'] == \App\Constants\NotificationTypeValue::NEW_USER_REGISTERED)
                                                عضویت کاربر جدید
                                            @elseif($notification['type'] == \App\Constants\NotificationTypeValue::NEW_ADMIN_CREATED)
                                                ایجاد ادمین جدید
                                            @elseif($notification['type'] == \App\Constants\NotificationTypeValue::NEW_PRODUCT_CREATED)
                                                ثبت محصول جدید
                                            @elseif($notification['type'] == \App\Constants\NotificationTypeValue::NEW_ORDER_CREATED)
                                                ثبت سفارش جدید
                                            @endif
                                        </td>
                                        <td>{{ optional($notification['data'])['message'] }}</td>
                                        <td>{{ persianDateTime($notification['created_at']) }}</td>
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
                        $("#" + id).prop("checked", response.checked);
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

        function changeApprove(id) {
            event.preventDefault();
            const url = $("#approve_" + id).data("url");
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        const button = $("#approve_" + id); // Get the button element
                        if (response.checked === 0) {
                            button.toggleClass("btn-success");
                        }
                        button.toggleClass("btn-warning"); // Toggle button classes
                        button.text((response.buttonText === "عدم تایید") ? " تایید" : "عدم تایید");

                        showToastrMessage(response.message, response.alertType);
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error");
                    }
                },
                error: function () {
                    showToastrMessage("مشکلی پیش آمده است.", "error");
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

