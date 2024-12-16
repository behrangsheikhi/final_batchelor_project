@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | ایجاد سوال متداول</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ایجاد سوال متداول</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این صفحه می توانید اطلاعات مربوط به سوال متداول و پاسخ مورد نظرتان را وارد کرده و ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.content.faq.store') }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="question" class="text-sm text-muted">سوال</label>
                            <input type="text"
                                   name="question"
                                   class="form-control"
                                   id="question"
                                   placeholder="لطفا متن سوال مورد نظر را اینجا بنویسید..."
                                   value="{{ old('question') }}">
                        </div>
                        @error('question')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="tags" class="text-sm text-muted">تگ ها</label>
                                <input type="hidden"
                                       name="tags"
                                       class="form-control"
                                       id="tags"
                                       value="{{ old('tags') }}">
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
                                <label for="status" class="text-sm text-muted">وضعیت سوال</label>
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
                </div>
                <section class="col-12 mb-4">
                    <div class="form-group">
                        <label for="answer" class="text-sm
                                    text-muted">پاسخ سوال</label>

                        <textarea cols="60"
                                  rows="4"
                                  class="form-control form-control-sm"
                                  name="answer" id="answer">{{ old('answer') }}</textarea>
                    </div>
                    @error('answer')
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
            </form>
        </div>
    </section>
@endsection


@section('script')
    <script src="{{ asset('admin-asset/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('answer')
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

