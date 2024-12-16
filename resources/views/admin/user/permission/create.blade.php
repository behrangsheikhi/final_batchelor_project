@extends('admin.layout.master')

@section('head-tag')
    <title>مدیریت کاربران و نقش ها | ایجاد سطح دسترسی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.permission.index') }}">سطوح دسترسی</a></li>
                        <li class="breadcrumb-item active">ایجاد سطح دسترسی جدید</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید مجوز های سایت خود را مشاهده یا مدیریت کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.user.permission.store') }}"
                  method="post"
                  id="form">
                @csrf

                <section class="row">
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="name"
                                   class="text-sm text-muted">عنوان مجوز</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control form-control-sm"
                                   placeholder="عنوان مجوز مورد نظر ..."
                                   autofocus
                                   value="{{ old('name') }}">
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
                            <label for="status"
                                   class="text-sm text-muted">وضعیت مجوز</label>
                            <select name="status"
                                    id="status"
                                    class="form-control form-group-sm">
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
                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="description" class="text-sm text-muted">توضیح مجوز</label>
                            <input type="text"
                                   id="description"
                                   name="description"
                                   class="form-control form-control-sm"
                                   placeholder="توضیحات..."
                                   value="{{ old('description') }}">
                        </div>
                        @error('description')
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
        CKEDITOR.replace('body')
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

