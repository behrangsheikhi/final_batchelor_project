@extends('admin.layout.master')

@section('head-tag')
    <title>اطلاعیه ها | اطلاعیه پیامکی</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.notify.sms.create') }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-commenting"></i> ایجاد اطلاعیه پیامکی جدید
                    </a> <a role="button" href="{{ route('admin.notify.email.index') }}" type="button"
                            class="btn btn-primary btn-sm">
                        <i class="fa fa-envelope"></i> بخش اطلاعیه ایمیلی
                    </a>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ایجاد اطلاعیه پیامکی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید پیامک های سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل پیامک ها
                            : {{ $messages->count() != 0 ? $messages->count() : 'صفر' }}</strong>
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
                               <thead class="text-right" style="text-align: right">
                               <tr class="font-weight-bold" style="font-size: 0.75rem;">
                                   <th scope="col">شناسه</th>
                                   <th scope="col">عنوان</th>
                                   <th scope="col">متن پیامک</th>
                                   <th scope="col">تاریخ انتشار</th>
                                   <th scope="col">وضعیت</th>
                                   <th class="max-width-16-rem text-left" scope="col">
                                       <i class="fa fa-cogs"></i>
                                       تنظیمات
                                   </th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($messages as $message)
                                   <tr role="row" class="odd">
                                       <td class="sorting_1">{{ $loop->iteration }}</td>
                                       <td>{{ $message->title }}</td>
                                       <td title="{{ strip_tags(html_entity_decode($message->body)) }}">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($message->body)),50) }}</td>
                                       <td>{{ persianDate($message->published_at) }}</td>
                                       <td class="">
                                           <label for="status">
                                               <input
                                                   data-url="{{ route('admin.notify.sms.status',$message->id) }}"
                                                   type="checkbox"
                                                   name="status"
                                                   id="{{ $message->id }}"
                                                   onchange="changeStatus('{{ $message->id }}')"
                                                   {{ $message->status ? 'checked' : '' }}
                                               >
                                           </label>
                                       </td>

                                       <td class="text-left">
                                           <form class="d-inline"
                                                 action="{{ route('admin.notify.sms.destroy',$message->id) }}"
                                                 method="post">

                                               @csrf
                                               @method('delete')
                                               <button type="submit"
                                                       id="delete"
                                                       class="btn btn-xs btn-danger delete">
                                                   <i class="fa fa-trash"></i>
                                               </button>

                                           </form>

                                           <a href="{{ route('admin.notify.sms.edit',$message->id)
                                     }}" class="btn btn-xs btn-primary"><i class="fa
                                    fa-edit"></i> </a>
                                           <a href="{{ route('admin.notify.sms.send-sms',$message->id) }}"
                                              title="ارسال"
                                              class="btn btn-success btn-xs"><i class="fa fa-send"></i>
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

