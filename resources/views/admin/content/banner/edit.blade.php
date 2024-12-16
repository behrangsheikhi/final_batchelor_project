@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | بنر | ویرایش</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.content.banner.index') }}">بنرها</a></li>
                        <li class="breadcrumb-item active">ویرایش بنر</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش بنر با عنوان <small class="text-succes font-weight-bold">{{ $banner->title }}</small> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.content.banner.update',$banner->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="title" class="text-sm text-muted">عنوان</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       id="title"
                                       autofocus
                                       value="{{ old('title',$banner->title) }}">
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
                                <label class="text-sm text-muted" for="image">تصویر</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image"
                                               class="custom-file-input form-control form-control-sm" id="image">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label text-right" for="logo">انتخاب
                                            فایل</label>
                                    </div>
                                </div>
                            </div>
                            @error('image')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
{{--                        <section class="row d-flex justify-content-between" style="margin-bottom: 10rem;">--}}
{{--                            @php--}}
{{--                                $number = 1;--}}
{{--                            @endphp--}}
{{--                            @foreach ($banner->image['indexArray'] as $key => $value )--}}
{{--                                <section class="col-md-{{ 6 / $number }}">--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input type="radio" class="form-check-input" name="currentImage"--}}
{{--                                               value="{{ $key }}" id="{{ $number }}"--}}
{{--                                               @if($banner->image['currentImage'] == $key) checked @endif>--}}
{{--                                        <label for="{{ $number }}" class="form-check-label mx-2">--}}
{{--                                            <img src="{{ asset($value) }}" class="" alt="">--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </section>--}}
{{--                                @php--}}
{{--                                    $number++;--}}
{{--                                @endphp--}}
{{--                            @endforeach--}}
{{--                        </section>--}}

                    </div>
                    <div class="row">
                        <section class="col-12 mb-4">
                            <div class="form-group">
                                <label for="url" class="text-sm text-muted">لینک</label>
                                <input type="url"
                                       name="url"
                                       class="form-control"
                                       id="url"
                                       value="{{ old('url',$banner->url) }}">
                            </div>
                            @error('url')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 mb-4">
                            <div class="form-group">
                                <label for="banner_position_id" class="text-sm text-muted">مکان قرارگیری</label>
                                <select name="position" id="position" class="form-control form-group-sm">
                                    @foreach($positions as $key => $value)
                                        <option value="{{ $key }}" @if(old('position',$banner->position) == $key) selected @endif>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('banner_position_id')
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
                                <label for="status" class="text-sm text-muted">وضعیت</label>
                                <select name="status" id="status" class="form-control form-group-sm">
                                    <option value="1" @if(old('status',$banner->status) == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status',$banner->status)) selected @endif>غیر فعال</option>
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

                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="description" class="text-sm
                                    text-muted">توضیحات</label>

                                <textarea cols="60" rows="4" class="form-control form-control-sm"
                                          name="description" id="description"
                                          placeholder="توضیحات بنر را اینجا بنویسید ...">{{ old('description',$banner->description) }}</textarea>
                            </div>
                            @error('description')
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

    {{--  select2 usage   --}}
    <script>

        $(document).ready(function () {
            let tags_input = $('#tags');
            let select_tags = $('#select_tags');
            let default_tags = tags_input.val();
            let default_data = null;


            if (tags_input.val() !== null && tags_input.val().length > 0) {
                default_data = default_tags.split(',');
            }

            select_tags.select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
                tags: true,
                data: default_data,
                dir: "rtl"
            });
            select_tags.children('option').attr('selected', true).trigger('change');


            $('#form').submit(function (event) {
                if (select_tags.val() !== null && select_tags.val().length > 0) {
                    let selectedSource = select_tags.val().join(',');
                    tags_input.val(selectedSource);
                }
            })
        });


    </script>
    {{--  select2 usage   --}}

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

