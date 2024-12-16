@extends('admin.layout.master')

@section('head-tag')
    <title>کاربران | ایجاد مشتری</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.app.index') }}">مشتریان</a></li>
                        <li class="breadcrumb-item active">ایجاد مشتری</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                       در این قسمت میتوانید در صورت نیاز کاربر مشتری جدید ایجاد کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('admin.user.app.store') }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="firstname" class="text-sm text-muted">نام</label>
                                <input type="text"
                                       name="firstname"
                                       class="form-control"
                                       id="firstname"
                                       placeholder="نام مشتری را وارد کنید..."
                                       value="{{ old('firstname') }}">
                            </div>
                            @error('firstname')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="lastname" class="text-sm text-muted">نام خانوادگی</label>
                                <input type="text"
                                       name="lastname"
                                       class="form-control"
                                       id="lastname"
                                       placeholder="نام خانوادگی مشتری را وارد کنید..."
                                       value="{{ old('lastname') }}">
                            </div>
                            @error('lastname')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="email" class="text-sm text-muted">ایمیل</label>
                                <input type="text"
                                       name="email"
                                       class="form-control"
                                       id="email"
                                       placeholder="ایمیل مشتری را وارد کنید..."
                                       value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="mobile" class="text-sm text-muted">موبایل</label>
                                <input type="text"
                                       name="mobile"
                                       class="form-control"
                                       id="mobile"
                                       placeholder="موبایل مشتری را وارد کنید..."
                                       value="{{ old('mobile') }}">
                            </div>
                            @error('mobile')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="password" class="text-sm text-muted">کلمه عبور</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       id="password"
                                       placeholder="کلمه عبور مشتری را وارد کنید..."
                                       value="{{ old('password') }}">
                            </div>
                            @error('password')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="password_confirmation" class="text-sm text-muted">تکرار کلمه عبور</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       id="password_confirmation"
                                       placeholder="کلمه عبور مشتری را تکرار کنید..."
                                       value="{{ old('password_confirmation') }}">
                            </div>
                            @error('password_confirmation')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label class="text-sm text-muted" for="profile_photo_path">پروفایل</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="profile_photo_path"
                                               class="custom-file-input form-control form-control-sm" id="profile_photo_path">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label font-weight-bold text-right"
                                               for="profile_photo_path">جهت انتخاب تصویر اینجا کلیک کنید</label>
                                    </div>

                                </div>
                            </div>
                            @error('profile_photo_path')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت مشتری</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status')) selected @endif>غیر فعال</option>
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
                    </div>
                    <section class="">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-save"></i> ذخیره
                        </button>
                    </section>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

