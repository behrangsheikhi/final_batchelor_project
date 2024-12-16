@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | ویرایش دسته بندی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.category.index') }}">دسته بندی محصولات</a></li>
                        <li class="breadcrumb-item active">ویرایش دسته بندی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعات مربوط به دسته بندی <span class="text-success font-weight-bold">{{ $category->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.category.update',$category->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">نام دسته بندی</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       id="name"
                                       value="{{ old('name',$category->name) }}">
                            </div>
                            @error('name')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="tags" class="text-sm text-muted">تگ ها</label>
                                <input type="hidden"
                                       name="tags"
                                       class="form-control"
                                       id="tags"
                                       value="{{ old('tags',$category->tags) }}">
                                <select
                                    id="select_tags"
                                    class="select2 form-control form-control-sm"
                                    multiple>
                                </select>
                            </div>
                            @error('tags')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت دسته بندی</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status',$category->status) == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status',$category->status)) selected @endif>غیر فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="show_in_menu" class="text-sm text-muted">وضعیت نمایش در منو</label>
                                <select name="show_in_menu" id="show_in_menu" class="form-control form-control-sm">
                                    <option value="1" @if(old('show_in_menu',$category->show_in_menu) == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('show_in_menu',$category->show_in_menu)) selected @endif>غیر فعال</option>
                                </select>
                            </div>
                            @error('show_in_menu')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="text-sm text-muted" for="image">تصویر شاخص</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image"
                                               class="custom-file-input form-control form-control-sm" id="image">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label font-weight-bold text-right"
                                               for="image">جهت انتخاب تصویر اینجا کلیک کنید</label>
                                    </div>

                                </div>
                            </div>
                            @error('image')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="row d-flex justify-content-between" style="margin-bottom: 10rem;">
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($category->image['indexArray'] as $key => $value )
                                <section class="col-md-{{ 6 / $number }}">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="currentImage"
                                               value="{{ $key }}" id="{{ $number }}"
                                               @if($category->image['currentImage'] == $key) checked @endif>
                                        <label for="{{ $number }}" class="form-check-label mx-2">
                                            <img src="{{ asset($value) }}" class="" alt="">
                                        </label>
                                    </div>
                                </section>
                                @php
                                    $number++;
                                @endphp
                            @endforeach
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="parent_id" class="text-sm text-muted">دسته والد</label>
                                <select name="parent_id" id="parent_id" class="form-control form-group-sm">
                                    <option value="">منو اصلی</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if(old('parent_id') == $category->parent_id) selected @endif >{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                    </div>
                    <section class="col-12">
                        <div class="form-group">
                            <label for="description" class="text-sm
                                    text-muted">توضیحات</label>

                            <textarea cols="60" rows="4" class="form-control form-control-sm"
                                      name="description" id="description">{{ old('description',$category->description) }}</textarea>
                        </div>
                        @error('description')
                        <span class="alert_required text-danger" role="alert">
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
                dir:"rtl"
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

