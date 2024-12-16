@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | صفحه ساز</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.content.page.create') }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد صفحه جدید
                    </a>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">صفحه ساز</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید صفحات سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل صفحات
                            : {{ $pages->count() != 0 ? $pages->count() : 'صفر' }}</strong>
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
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
                                   <th scope="col">شناسه</th>
                                   <th scope="col">عنوان صفحه</th>
                                   <th scope="col">بدنه صفحه</th>
                                   <th scope="col">تگ ها</th>
                                   <th scope="col">وضعیت</th>
                                   <th scope="col">نمایش در منو</th>
                                   <th class="max-width-16-rem text-left" scope="col">
                                       <i class="fa fa-cogs"></i>
                                       تنظیمات
                                   </th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($pages as $page)
                                   <tr role="row" class="odd">
                                       <td class="sorting_1">{{ $loop->iteration }}</td>
                                       <td>{{ $page->title }}</td>
                                       <td title="{{ strip_tags($page->body) }}">{{ strip_tags(Str::limit($page->body,50)) }}</td>
                                       <td>{{ $page->tags }}</td>
                                       <td class="">
                                           <label for="status">
                                               <input
                                                   data-url="{{ route('admin.content.page.status',$page->id) }}"
                                                   type="checkbox"
                                                   name="status"
                                                   id="status_{{ $page->id }}"
                                                   onchange="changeStatus('{{ $page->id }}')"
                                                   {{ $page->status ? 'checked' : '' }}
                                               >
                                           </label>
                                       </td>
                                       <td class="">
                                           <label for="show_in_menu">
                                               <input
                                                   data-url="{{ route('admin.content.page.show-in-menu',$page->id) }}"
                                                   type="checkbox"
                                                   name="show_in_menu"
                                                   id="show_in_menu_{{ $page->id }}"
                                                   onchange="changeShowInMenu('{{ $page->id }}')"
                                                   {{ $page->show_in_menu ? 'checked' : '' }}
                                               >
                                           </label>
                                       </td>


                                       <td class="text-left">
                                           <form class="d-inline"
                                                 action="{{ route('admin.content.page.destroy',$page->id) }}"
                                                 method="post">

                                               @csrf
                                               @method('delete')
                                               <button type="submit"
                                                       id="delete"
                                                       class="btn btn-xs btn-danger delete">
                                                   <i class="fa fa-trash"></i>
                                               </button>

                                           </form>

                                           <a href="{{ route('admin.content.page.edit',$page->id)
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

        function changeShowInMenu(id) {
            const url = $("#show_in_menu_" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    if (response.status) {
                        $("#show_in_menu_" + id).prop("checked", response.checked); // Update checkbox state
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

