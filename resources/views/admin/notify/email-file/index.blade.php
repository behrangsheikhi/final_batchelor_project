@extends('admin.layout.master')

@section('head-tag')
    <title>اطلاعیه ها | اطلاعیه ایمیلی | فایل</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">
                    <a role="button" href="{{ route('admin.notify.email-file.create',$email->id) }}" type="button"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-plus-circle"></i> ایجاد فایل اطلاعیه ایمیلی جدید
                    </a>
                </div><!-- /.col -->

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notify.email.index') }}">اطلاعیه
                                ایمیلی</a></li>
                        <li class="breadcrumb-item active">ایجاد اطلاعیه ایمیلی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید فایلهای الصاقی به <span
                            class="text-success font-weight-bold">{{ $email->subject }}</span> خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل فایلها
                            : {{ $files->count() != 0 ? $files->count() : 'صفر' }}</strong>
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
                                  <th scope="col">عنوان ایمیل</th>
                                  <th scope="col">سایز فایل</th>
                                  <th scope="col">نوع فایل</th>
                                  <th scope="col">وضعیت</th>
                                  <th scope="col">نوع ذخیره سازی</th>
                                  <th class="max-width-16-rem text-left" scope="col">
                                      <i class="fa fa-cogs"></i>
                                      تنظیمات
                                  </th>
                              </tr>
                              </thead>
                              <tbody>

                              @foreach($files as $file)
                                  <tr>
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $email->subject }}</td>
                                      <td>{{ number_format((($file->file_size)/1024)/1024,2) }} مگابایت</td>
                                      <td>{{ $file->file_type }}</td>
                                      <td class="d-flex justify-content-start">
                                          <label for="status">
                                              <input
                                                  data-url="{{ route('admin.notify.email-file.status',$file->id) }}"
                                                  type="checkbox"
                                                  name="status"
                                                  id="{{ $file->id }}" onchange="changeStatus('{{ $file->id }}')"
                                                  @if($file->status === 1)
                                                      checked
                                                  @endif
                                              >
                                          </label>
                                      </td>
                                      @if($file->store_to === \App\Constants\FileTypeValue::PRIVATE_FILE)
                                          <td class="font-weight-bold text-danger">خصوصی</td>
                                      @else
                                          <td class="font-weight-bold text-success">عمومی</td>
                                      @endif
                                      <td class="width-16-rem text-left">
                                          <form class="d-inline"
                                                action="{{ route('admin.notify.email-file.destroy',$file->id) }}"
                                                method="post">
                                              @csrf
                                              @method('delete')
                                              <button type="submit"
                                                      id="delete"
                                                      class="btn btn-sm btn-danger delete">
                                                  <i class="fa fa-trash"></i>
                                              </button>
                                          </form>

                                          <a href="{{ route('admin.notify.email-file.edit',$file->id)
                                     }}" class="btn btn-sm btn-primary"><i class="fa
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

