@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | ویرایش مقاله </title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ویرایش مقاله</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                       شما در حال ویرایش اطلاعات مربوط به پست با عنوان <span class="text-success font-weight-bold">{{ $post->title }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.content.post.update',$post->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="title" class="text-sm text-muted">عنوان مقاله</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       id="title"
                                       placeholder="عنوان مقاله خود را وارد کنید..."
                                       value="{{ old('title',$post->title) }}">
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
                                <label for="tags" class="text-sm text-muted">تگ ها</label>
                                <input type="hidden"
                                       name="tags"
                                       class="form-control"
                                       id="tags"
                                       value="{{ old('tags',$post->tags) }}">
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

{{--                        <section class="col-12 col-md-6">--}}
{{--                            <div class="form-group">--}}
{{--                                <label for="published_at" class="text-sm text-muted">تاریخ انتشار</label>--}}
{{--                                <input type="hidden"--}}
{{--                                       class="form-control form-control-sm"--}}
{{--                                       name="published_at"--}}
{{--                                       id="published_at">--}}
{{--                                <input--}}
{{--                                    type="text"--}}
{{--                                    class="form-control form-control-sm"--}}
{{--                                    id="published_at_view"--}}
{{--                                    data-old-value="{{ old('published_at', $post->published_at) }}">--}}
{{--                            </div>--}}
{{--                            @error('published_at')--}}
{{--                            <span class="alert_required text-danger" role="alert">--}}
{{--                                <strong>--}}
{{--                                    {{ $message }}--}}
{{--                                </strong>--}}
{{--                            </span>--}}
{{--                            @enderror--}}
{{--                        </section>--}}
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت دسته بندی</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status',$post->status) == 1) selected @endif>فعال
                                    </option>
                                    <option value="0" @if(!old('status',$post->status)) selected @endif>غیر فعال
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
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="commentable" class="text-sm text-muted">قابلیت درج نظر</label>
                                <select name="commentable" id="commentable" class="form-control form-control-sm">
                                    <option value="1" @if(old('commentable',$post->commentable) == 1) selected @endif>
                                        فعال
                                    </option>
                                    <option value="0" @if(!old('commentable',$post->commentable)) selected @endif>غیر
                                        فعال
                                    </option>
                                </select>
                            </div>
                            @error('commentable')
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
                                <label class="text-sm text-muted" for="image">تصویر شاخص</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image"
                                               class="custom-file-input form-control form-control-sm" id="image">
                                        <label style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                               class="custom-file-label text-left font-weight-bold text-right"
                                               for="image">جهت انتخاب تصویر اینجا کلیک کنید</label>
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
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="post_category_id" class="text-sm text-muted">دسته بندی پست</label>
                                <select name="post_category_id" id="post_category_id"
                                        class="form-control form-group-sm">
                                    <option value="">انتخاب دسته بندی پست</option>
                                    @foreach($postCategories as $postCategory)
                                        <option value="{{ $postCategory->id }}"
                                                @if(old('post_category_id',$post->post_category_id) == $postCategory->id) selected @endif>{{ $postCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('post_category_id')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <section class="row d-flex justify-content-between" style="margin-bottom: 10rem;">
                        @php
                            $number = 1;
                        @endphp
                        @foreach ($post->image['indexArray'] as $key => $value )
                            <section class="col-md-{{ 6 / $number }}">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="currentImage"
                                           value="{{ $key }}" id="{{ $number }}"
                                           @if($post->image['currentImage'] == $key) checked @endif>
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

                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="summary" class="text-sm
                                    text-muted">چکیده پست</label>

                            <textarea cols="60"
                                      rows="4"
                                      class="form-control form-control-sm"
                                      name="summary"
                                      id="summary"
                                      placeholder="خلاصه پست را در این بخش بنویسید ...">{{ old('summary',$post->summary) }}</textarea>
                        </div>
                        @error('summary')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="body"
                                   class="text-sm
                                    text-muted">بدنه پست</label>

                            <textarea cols="60"
                                      rows="4"
                                      class="form-control form-control-sm"
                                      name="body"
                                      id="body"
                                      placeholder="خلاصه پست را در این بخش بنویسید ...">{{ old('body',$post->body) }}</textarea>
                        </div>
                        @error('body')
                        <span class="text-sm custom-alert p-2 mb-4 rounded"
                              role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                    <section class="">
                        <button type="submit" class="btn btn-primary">ثبت</button>
                    </section>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('script')
    <script src="{{ asset('admin-asset/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('summary')
        CKEDITOR.replace('body')
    </script>

    {{--  select2 usage   --}}
    <script type="text/javascript">

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

        // $(document).ready(function () {
        //     let initialDate = $('#published_at_view').val();
        //     alert(initialDate)
        //     $('#published_at_view').persianDatepicker({
        //         formatDate: "YYYY/MM/DD",
        //         cellWidth: 40,
        //         cellHeight: 40,
        //         fontSize: 12,
        //         altField: initialDate,
        //         // initialValue : $('#published_at').val()
        //     });
        // });


    </script>
    {{--  select2 usage   --}}


    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

