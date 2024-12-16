@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | روش ارسال | ویرایش</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.delivery-method.index') }}">روش
                                ارسال</a></li>
                        <li class="breadcrumb-item active">ویرایش روش ارسال</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعات مربوط به روش ارسال <span class="text-success font-weight-bold">{{ $delivery->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.delivery-method.update',$delivery->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">نام روش ارسال</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           id="name"
                                           autofocus
                                           value="{{ old('name',$delivery->name) }}">
                                </div>
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
                                <label for="amount">هزینه روش ارسال</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="amount"
                                           id="amount"
                                           value="{{ old('amount',$delivery->amount) }}"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon">
                                       تومان
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            @error('amount')
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
                                <label for="delivery_time" class="text-sm text-muted">مدت زمان ارسال</label>
                                <input type="number"
                                       name="delivery_time"
                                       class="form-control"
                                       id="delivery_time"
                                       value="{{ old('delivery_time',$delivery->delivery_time) }}">
                            </div>
                            @error('delivery_time')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="delivery_time_unit" class="text-sm text-muted">واحد زمانی</label>
                                <input type="text"
                                       name="delivery_time_unit"
                                       class="form-control"
                                       id="delivery_time_unit"
                                       value="{{ old('delivery_time_unit',$delivery->delivery_time_unit) }}">
                            </div>
                            @error('delivery_time_unit')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                    </div>
                    <div class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status',$delivery->status) == 1) selected @endif>فعال
                                    </option>
                                    <option value="0" @if(!old('status',$delivery->status)) selected @endif>غیر فعال
                                    </option>
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
                    </div>
                    <div class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="description" class="text-sm
                                    text-muted">توضیحات روش ارسال</label>
                                <textarea cols="60"
                                          rows="4"
                                          class="form-control form-control-sm"
                                          name="description"
                                          id="description"
                                          placeholder="توضیحات روش ارسال را در صورت نیاز اینج بنویسید...">{{ old('description',$delivery->description) }}</textarea>
                            </div>
                            @error('description')
                            <span class="alert_required text-danger" role="alert">
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

        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>
    {{--  select2 usage   --}}


    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

