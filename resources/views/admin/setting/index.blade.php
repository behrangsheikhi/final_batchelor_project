@extends('admin.layout.master')

@section('head-tag')
    <title>تنظیمات سایت</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.setting.edit',$setting->id) }}" type="button"
                       class="btn btn-primary btn-sm">ویرایش تنظیمات سایت</a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <h5>
                        در این قسمت می توانید تنظیمات سایت خود را ایجاد و یا مدیریت کنید.
                    </h5>
                </strong>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        {{-- removed id="example" from below table because we do not have more that one setting --}}
                        <div class="table-responsive">
                            <table id=""
                                   class="display table table-striped table-bordered table-responsive-md table-hover"
                                   style="width:100%">
                                <style>
                                    th {
                                        text-align: right !important;
                                    }
                                </style>
                                <thead>
                                <tr class="font-weight-bold">
                                    <th scope="col">عنوان سایت</th>
                                    <th scope="col">توضیحات</th>
                                    <th scope="col">لوگو</th>
                                    <th scope="col">آیکون</th>
                                    <th scope="col">شماره تماس</th>
                                    <th scope="col">ایمیل</th>
                                    <th scope="col">آدرس</th>
                                    <th scope="col">کلمات کلیدی</th>
                                    <th class="text-left" scope="col"><i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $setting->title }}</td>
                                    <td title="{{ strip_tags(html_entity_decode($setting->description)) }}">{{ strip_tags(html_entity_decode(Str::limit($setting->description,50))) }}</td>
                                    <td><img src="{{ asset($setting->logo) }}" alt="logo" width="100" height="50"></td>
                                    <td><img src="{{ asset($setting->icon) }}" alt="icon" width="100" height="50"></td>
                                    <td>{{ $setting->phone }}</td>
                                    <td>{{ $setting->email }}</td>
                                    <td>{{ $setting->address }}</td>
                                    <td>{{ $setting->keywords }}</td>
                                    <td class="text-left">
                                        <a href="{{ route('admin.setting.edit',$setting->id) }}"
                                           class="text-white btn btn-xs btn-warning"><i
                                                class="fa fa-edit"></i> ویرایش </a>
                                    </td>
                                </tr>
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

