@extends('admin.layout.master')

@section('head-tag')
    <title>اطلاعیه ها | اطلاعیه ایمیلی | ویرایش فایل </title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left" style="font-size: 0.8rem">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notify.email.index') }}">اطلاعیه ایمیلی</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notify.email-file.index',$email->id) }}">فایل های ایمیل</a></li>
                        <li class="breadcrumb-item active">ویرایش فایل ایمیل</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش فایل الصاقی به ایمیل با عنوان <span class="text-success font-weight-bold">{{ $email->subject }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.notify.email-file.update',$file->id) }}"
                  method="post"
                  enctype="multipart/form-data"
                  id="form">
                @csrf
                @method('PUT')

                <section class="row">
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label class="text-sm text-muted" for="file">فایل</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file"
                                           name="file"
                                           class="custom-file-input form-control form-control-sm"
                                           id="file">
                                    <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                           class="custom-file-label text-right font-weight-bold"
                                           for="file">انتخاب
                                        فایل</label>
                                </div>
                                <div class="input-group-append">
                                        <span style="border-top-right-radius: 0;border-bottom-right-radius: 0;
                                        background-color: #138496;color: #dcdcdc;"
                                              class="input-group-text"
                                              id="file">بارگزاری فایل</span>
                                </div>
                            </div>
                        </div>
                        @error('file')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="status" class="text-sm text-muted">وضعیت فایل</label>
                            <select name="status" id="status" class="form-control form-control-sm">
                                <option value="1" @if(old('status',$file->status) == 1) selected @endif>فعال</option>
                                <option value="0" @if(!old('status',$file->status)) selected @endif>غیر فعال</option>
                            </select>
                        </div>
                        @error('status')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="store_to" class="text-sm text-muted">نوع ذخیره سازی</label>
                            <select name="store_to" id="store_to" class="form-control form-group-sm">
                                <option value="1" @if(old('store_to',$file->store_to) == 1) selected @endif>خصوصی</option>
                                <option value="0" @if(!old('store_to',$file->store_to)) selected @endif>عمومی</option>
                            </select>
                        </div>
                        @error('store_to')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                </section>
                <section class="">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-save"></i> ذخیره
                    </button>
                </section>
            </form>
        </div>
    </section>
@endsection


@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

