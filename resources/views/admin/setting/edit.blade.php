@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | ویرایش تنظیمات سایت</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ویرایش تنظیمات</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعات مربوط به تنظیمات سایت خود هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.setting.update',$setting->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="title" class="text-sm text-muted">عنوان سایت</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       id="title"
                                       value="{{ old('title',$setting->title) }}">
                            </div>
                            @error('title')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="keywords" class="text-sm text-muted">کلمات کلیدی</label>
                                <input type="hidden"
                                       name="keywords"
                                       class="form-control"
                                       id="keywords"
                                       value="{{ old('keywords',$setting->keywords) }}">
                                <select
                                    id="select_keywords"
                                    class="select2 form-control form-control-sm"
                                    multiple>
                                </select>
                            </div>
                            @error('keywords')
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
                                <label for="phone" class="text-sm text-muted">شماره تماس</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       id="phone"
                                       value="{{ old('phone',$setting->phone) }}">
                            </div>
                            @error('phone')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="email" class="text-sm text-muted">ایمیل</label>
                                <input type="text"
                                       name="email"
                                       class="form-control"
                                       id="email"
                                       value="{{ old('email',$setting->email) }}">
                            </div>
                            @error('email')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row mx-3">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label class="text-sm text-muted" for="logo">لوگو</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="logo"
                                               class="custom-file-input form-control form-control-sm" id="logo">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label text-left font-weight-bold text-right"
                                               for="logo">جهت انتخاب لوگو اینجا کلیک کنید</label>
                                    </div>

                                </div>
                            </div>
                            @error('logo')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label class="text-sm text-muted" for="icon">آیکون</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="icon"
                                               class="custom-file-input form-control form-control-sm" id="icon">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label text-left font-weight-bold text-right"
                                               for="icon">جهت انتخاب آیکون اینجا کلیک کنید</label>
                                    </div>

                                </div>
                            </div>
                            @error('icon')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="address" class="text-sm
                                    text-muted">آدرس</label>
                            <input class="form-control form-control-sm" type="text" name="address" id="address" value="{{ $setting->address }}">
                        </div>
                        @error('description')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="description" class="text-sm
                                    text-muted">توضیحات</label>

                            <textarea cols="60" rows="4" class="form-control form-control-sm"
                                      name="description" id="description"
                                      placeholder="توضیحات دسته بندی را اینجا بنویسید ...">
                                    {{ old('description',$setting->description) }}</textarea>
                        </div>
                        @error('description')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

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
    <script src="{{ asset('admin-asset/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description')
    </script>

    {{--  select2 usage   --}}
    <script>

        $(document).ready(function () {
            let keywords_input = $('#keywords');
            let select_keywords = $('#select_keywords');
            let default_keywords = keywords_input.val();
            let default_data = null;

            if (keywords_input.val() !== null && keywords_input.val().length > 0) {
                default_data = default_keywords.split(',');
            }

            select_keywords.select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
                tags: true,
                data: default_data,
                dir: "rtl"
            });
            select_keywords.children('option').attr('selected', true).trigger('change');


            $('#form').submit(function (event) {
                if (select_keywords.val() !== null && select_keywords.val().length > 0) {
                    let selectedSource = select_keywords.val().join(',');
                    keywords_input.val(selectedSource);
                }
            })
        });


    </script>
    {{--  select2 usage   --}}

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

