@extends('admin.layout.master')

@section('head-tag')
    <title>تیکت | همه تیکت ها</title>
@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button"
                       href="#"
                       type="button"
                       class="btn btn-primary btn-sm disabled">
                        <i class="fa fa-plus-circle"></i> ایجاد تیکت جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">تیکت ها</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید تیکت های سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل تیکت ها
                            : {{ $tickets->count() != 0 ? $tickets->count() : 'صفر' }}</strong>
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
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                    <th scope="col">تاریخ</th>
                                    <th scope="col">نویسنده</th>
                                    <th scope="col">موضوع</th>
                                    <th scope="col">اولویت</th>
                                    <th scope="col">دسته</th>
                                    <th scope="row">فایل</th>
                                    <th scope="col">ارجاع شده از</th>
                                    <th scope="col">تیکت مرجع</th>
                                    <th class="text-center" scope="col"><i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tickets as $ticket)
                                    <tr style="font-size: 0.65rem;">
                                        <th>{{ persianDate($ticket->created_at) }}</th>
                                        <td>{{ $ticket->user->fullname }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->priority->name }}</td>
                                        <td>{{ $ticket->category->name }}</td>
                                        <td class="text-{{ $ticket->file ? 'success' : 'danger' }} font-weight-bold">
                                            {{ $ticket->file ? 'دارد' : 'ندارد' }}
                                        </td>
                                        <td>{{ $ticket->admin->user->fullname }}</td>
                                        <td>{{ $ticket->reference->subject ?? '-' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.ticket.show',$ticket->id) }}"
                                               class="btn btn-xs btn-info"><i
                                                    class="fa fa-eye"></i> نمایش</a>

                                            <a
                                                href="{{ route('admin.ticket.change',$ticket->id) }}"
                                                class="btn btn-xs btn-{{ $ticket->status == 1 ? 'danger' : 'success' }} text-white"><i
                                                    class="fa fa-{{ $ticket->status == 1 ? 'times-circle' : 'check-circle' }}"></i>
                                                {{ $ticket->status == 1 ? 'بستن' : 'بازکردن' }}
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

