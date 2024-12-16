@extends('admin.layout.master')

@section('head-tag')
    <title>کاربران | مدیران</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.user.admin-user.create') }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد مدیر جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">کاربران</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید مدیران سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل مدیران سایت
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
                                   <th scope="col"> نقش</th>
                                   <th scope="col">دسترسی</th>
                                   <th class="text-center" scope="col"><i class="fa fa-cogs"></i>
                                       تنظیمات
                                   </th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($admins as $admin)
                                   <tr style="font-size: 0.75rem;">
                                       <td>
                                           @if($admin->profile_photo_path != null)
                                               <img src="{{ asset($admin->profile_photo_path)  }}" width="40px"
                                                    height="40px" alt="پروفایل">
                                           @endif
                                       </td>
                                       <td>{{ $admin->email ?? '-' }}</td>
                                       <td>{{ $admin->mobile ?? '-' }}</td>
                                       <td>{{ $admin->full_name ?? '-' }}</td>
                                       <td class="">
                                           <label for="status">
                                               <input
                                                   data-url="{{ route('admin.user.admin-user.status', $admin->id) }}"
                                                   type="checkbox"
                                                   name="status"
                                                   id="status_{{ $admin->id }}"
                                                   onchange="changeStatus('{{ $admin->id }}')"
                                                   {{ $admin->status ? 'checked' : '' }}
                                               >
                                           </label>
                                       </td>
                                       <td class="">
                                           <label for="commentable">
                                               <input
                                                   data-url="{{ route('admin.user.admin-user.activation', $admin->id) }}"
                                                   type="checkbox"
                                                   name="commentable"
                                                   id="activation_{{ $admin->id }}"
                                                   onchange="changeActivation('{{ $admin->id }}')"
                                                   {{ $admin->activation ? 'checked' : '' }}
                                               >
                                           </label>
                                       </td>
                                       <td>
                                           @forelse($admin->roles as $role)
                                               <div class="text-sm text-success">{{ $role->name }}</div>
                                               <hr>
                                           @empty
                                               <span class="text-sm text-danger">نقشی تعریف نشده است.</span>
                                           @endforelse
                                       </td>
                                       <td>
                                           @forelse($admin->permissions as $permission)
                                               <div class="text-sm text-success">{{ $permission->name }}</div>
                                               <hr>
                                           @empty
                                               <span class="text-sm text-danger">دسترسی ای تعریف نشده است.</span>
                                           @endforelse
                                       </td>

                                       <td class="text-left width-16-rem">
                                           <form class="d-inline"
                                                 action="{{ route('admin.user.admin-user.destroy',$admin->id) }}"
                                                 method="post">
                                               @csrf
                                               @method('delete')

                                               <button type="submit"
                                                       id="delete"
                                                       class="btn btn-xs btn-danger delete">
                                                   <i class="fa fa-trash"></i>
                                               </button>
                                           </form>

                                           <a href="{{ route('admin.user.admin-user.edit',$admin->id)
                                     }}" class="btn btn-xs btn-primary"><i class="fa
                                    fa-edit"></i> </a>
                                           <a href="{{ route('admin.user.admin-user.roles',$admin->id) }}" class="btn btn-xs btn-warning text-white" title="مدیریت نقش ها"><i
                                                   class="fa fa-user"></i></a>
                                           <a href="{{ route('admin.user.admin-user.permissions',$admin->id) }}"
                                               class="btn btn-xs btn-success text-white" title="مدیریت دسترسی ها"><i class="fa fa-lock"></i></a>
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

