@extends('admin.layout.master')

@section('head-tag')
    <title>کاربران | مشتریان</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.user.app.create') }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد مشتری جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">مشتریان</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید مشتریان سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل مشتریان
                            : {{ $customers->count() != 0 ? $customers->count() : 'صفر' }}</strong>
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
                                <tr class="font-weight-bold">
                                    <th scope="col">نمایه</th>
                                    <th scope="col">ایمیل</th>
                                    <th scope="col">موبایل</th>
                                    <th scope="col">نام</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">فعالسازی</th>
                                    <th scope="col"> دسترسی</th>
                                    <th scope="col">تاریخ عضویت</th>
                                    <th class="text-center" scope="col"><i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers as $customer)
                                    <tr style="font-size: 0.75rem;">
                                        <td>
                                            @if($customer->profile_photo_path != null)
                                                <img src="{{ asset($customer->profile_photo_path)  }}" width="40px"
                                                     height="40px" alt="پروفایل">
                                                {{--                                        @else--}}
                                                {{--                                            <img src="{{ asset()  }}" width="40px"--}}
                                                {{--                                                 height="40px" alt="پروفایل">--}}
                                            @endif
                                        </td>
                                        <td>{{ $customer->email ?? '-' }}</td>
                                        <td>{{ $customer->mobile ?? '-' }}</td>
                                        <td>{{ $customer->full_name ?? '-' }}</td>
                                        <td class="">
                                            <label for="status">
                                                <input
                                                    data-url="{{ route('admin.user.app.status', $customer->id) }}"
                                                    type="checkbox"
                                                    name="status"
                                                    id="status_{{ $customer->id }}"
                                                    onchange="changeStatus('{{ $customer->id }}')"
                                                    {{ $customer->status ? 'checked' : '' }}
                                                >
                                            </label>
                                        </td>
                                        <td class="">
                                            <label for="commentable">
                                                <input
                                                    data-url="{{ route('admin.user.app.activation', $customer->id) }}"
                                                    type="checkbox"
                                                    name="commentable"
                                                    id="activation_{{ $customer->id }}"
                                                    onchange="changeActivation('{{ $customer->id }}')"
                                                    {{ $customer->activation ? 'checked' : '' }}
                                                >
                                            </label>
                                        </td>

                                        @if($customer->user_type === \App\Constants\UserTypeValue::CUSTOMER)
                                            <td class="text-success font-weight-bold">مشتری</td>
                                        @elseif($customer->user_type === \App\Constants\UserTypeValue::ADMIN)
                                            <td class="text-success font-weight-bold">ادمین</td>
                                        @elseif($customer->user_type === \App\Constants\UserTypeValue::SUPER_ADMIN)
                                            <td class="text-success font-weight-bold">مدیر</td>
                                        @elseif($customer->user_type === \App\Constants\UserTypeValue::VENDOR)
                                            <td class="text-success font-weight-bold">فروشنده</td>
                                        @endif
                                        <td>{{ persianDate($customer->created_at) }}</td>
                                        <td class="text-left width-16-rem">
                                            <form class="d-inline"
                                                  action="{{ route('admin.user.app.destroy',$customer->id) }}"
                                                  method="post">
                                                @csrf
                                                @method('delete')

                                                <button type="submit"
                                                        id="delete"
                                                        class="btn btn-xs btn-danger delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                            <a href="{{ route('admin.user.app.edit',$customer->id)
                                     }}" class="btn btn-xs btn-primary"><i class="fa
                                    fa-edit"></i> </a>
                                            <a href="#" class="btn btn-xs btn-warning text-white" title="مدیریت نقش ها"><i
                                                    class="fa fa-shield"></i></a>
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


        function changeActivation(id) {
            const url = $("#activation_" + id).data("url"); // Get the URL from the data attribute
            console.log(url)
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    if (response.status) {
                        $("#activation_" + id).prop("checked", response.checked); // Update checkbox state
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

