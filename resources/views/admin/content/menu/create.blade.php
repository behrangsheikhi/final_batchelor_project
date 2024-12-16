@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | ایجاد منو</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ایجاد منو</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این صفحه می توانید منو مورد نظر را ایجاد و ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.content.menu.store') }}" method="post" id="form">
                @csrf
                <section class="row">
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="name" class="text-sm text-muted">نام منو</label>
                            <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{ old('name') }}" placeholder="نام منو را وارد کنید...">
                        </div>
                        @error('name')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="parent_id" class="text-sm text-muted">منو والد</label>
                            <select name="parent_id" id="parent_id" class="form-control form-group-sm">
                                <option value="">منو اصلی</option>
                                @foreach($menus as $menu)
                                    <option value="{{ $menu->id }}" @if(old('parent_id') == $menu->parent_id) selected @endif >{{ $menu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('parent_id')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="url" class="text-sm text-muted"> لینک منو</label>
                            <input type="text"
                                   name="url"
                                   id="url"
                                   class="form-control form-control-sm"
                                   value="{{ old('url') }}"
                                   placeholder="مثال : https://example.com/test">
                        </div>
                        @error('url')
                        <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </section>

                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="status" class="text-sm text-muted">وضعیت پست</label>
                            <select name="status" id="status" class="form-control form-group-sm">
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

