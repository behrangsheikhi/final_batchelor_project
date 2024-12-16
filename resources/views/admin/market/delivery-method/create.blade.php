@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | روش ارسال</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ایجاد روش ارسال</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                       در این قسمت میتوانید اطلاعات مربوط به روش ارسال مورد نظر را ایجاد و ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.delivery-method.store') }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">نام روش ارسال</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           id="name"
                                           autofocus
                                           placeholder="مثلا پیک، اسنپ باکس، تیپاکش،پست اکسپرس و ..."
                                           value="{{ old('name') }}">
                                </div>
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
                                <label for="amount">هزینه روش ارسال</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="amount"
                                           id="amount"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           placeholder="ورودی عددی، مثلا 1000 یا 2000 یا ..."
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon">
                                       تومان
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            @error('amount')
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
                                <label for="delivery_time" class="text-sm text-muted">مدت زمان ارسال</label>
                                <input type="number"
                                       name="delivery_time"
                                       class="form-control"
                                       id="delivery_time"
                                       placeholder="ورودی عددی ..."
                                       value="{{ old('delivery_time') }}">
                            </div>
                            @error('delivery_time')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="delivery_time_unit" class="text-sm text-muted">واحد زمانی</label>
                                <input type="text"
                                       name="delivery_time_unit"
                                       class="form-control"
                                       id="delivery_time_unit"
                                       placeholder="مثلا ساعت،روز،هفته،ماه و ..."
                                       value="{{ old('delivery_time_unit') }}">
                            </div>
                            @error('delivery_time_unit')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                    </div>
                  <div class="row">
                      <section class="col-12 mb-4">
                          <div class="form-group">
                              <label for="status" class="text-sm text-muted">وضعیت</label>
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
                    <div class="row">
                        <section class="col-12 mb-4">
                            <div class="form-group">
                                <label for="description" class="text-sm
                                    text-muted">توضیحات روش ارسال</label>

                                <textarea cols="60"
                                          rows="4"
                                          class="form-control form-control-sm"
                                          name="description"
                                          id="description"
                                          placeholder="توضیحات روش ارسال را در صورت نیاز اینج بنویسید...">{{ old('description') }}</textarea>
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
    <script src="{{ asset('admin-asset/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description')

        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

