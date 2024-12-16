@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | ویرایش برند کالا</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.brand.index') }}">برند</a></li>
                        <li class="breadcrumb-item active">ویرایش برند کالا</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعات مربوط به برند با عنوان <span class="text-success font-weight-bold">{{ $brand->original_name }} یا {{ $brand->persian_name }}</span>
                        هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.brand.update',$brand->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="persian_name" class="text-sm text-muted">نام فارسی</label>
                                <input type="text"
                                       name="persian_name"
                                       class="form-control"
                                       id="persian_name"
                                       value="{{ old('persian_name',$brand->persian_name) }}">
                            </div>
                            @error('persian_name')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="original_name" class="text-sm text-muted">نام لاتین</label>
                                <input type="text"
                                       name="original_name"
                                       class="form-control"
                                       id="original_name"
                                       value="{{ old('original_name',$brand->original_name ?? '') }}">
                            </div>
                            @error('name')
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
                                <label for="tags" class="text-sm text-muted">تگ ها</label>
                                <input type="hidden"
                                       name="tags"
                                       class="form-control"
                                       id="tags"
                                       value="{{ old('tags',$brand->tags) }}">
                                <select
                                    id="select_tags"
                                    class="select2 form-control form-control-sm"
                                    multiple>
                                </select>
                            </div>
                            @error('tags')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label class="text-sm text-muted" for="logo">لوگوی برند</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="logo"
                                               class="custom-file-input form-control form-control-sm" id="logo">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label text-right" for="logo">انتخاب
                                            فایل</label>
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

                        <section class="row d-flex justify-content-between" style="margin-bottom: 10rem;">
                            @if(empty($brand->logo))
                                فاقد لوگو می باشد
                            @else
                                @php
                                    $number = 1;
                                @endphp
                                @foreach ($brand->logo['indexArray'] as $key => $value )
                                    <section class="col-md-{{ 6 / $number }}">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="currentImage"
                                                   value="{{ $key }}" id="{{ $number }}"
                                                   @if($brand->logo['currentImage'] == $key) checked @endif>
                                            <label for="{{ $number }}" class="form-check-label mx-2">
                                                <img src="{{ asset($value) }}" class="" alt="">
                                            </label>
                                        </div>
                                    </section>
                                    @php
                                        $number++;
                                    @endphp
                                @endforeach
                            @endif
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 mb-4">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت</label>
                                <select name="status" id="status" class="form-control form-group-sm">
                                    <option value="1" @if(old('status',$brand->status) == 1) selected @endif>فعال
                                    </option>
                                    <option value="0" @if(!old('status',$brand->status)) selected @endif>غیر فعال
                                    </option>
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

