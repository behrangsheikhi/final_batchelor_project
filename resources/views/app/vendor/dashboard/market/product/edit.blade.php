@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | ویرایش اطلاعات کالا</title>

    <link rel="stylesheet" href="{{ asset('admin-asset/datepicker/persian-datepicker.min.css') }}">

@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.index') }}">محصولات</a></li>
                        <li class="breadcrumb-item active">ویرایش کالا</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعات کالا با نام <span
                            class="text-success font-weight-bold">{{ $product->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.product.update',$product->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">نام کالا</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name',$product->name) }}"
                                       class="form-control form-control-sm">
                            </div>
                            @error('name')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="marketable_number" class="text-sm text-muted">موجودی این کالا</label>
                                <input type="number"
                                       id="marketable_number"
                                       name="marketable_number"
                                       value="{{ old('marketable_number',$product->marketable_number) }}"
                                       class="form-control form-control-sm">
                            </div>
                            @error('marketable_number')
                            <span class="alert_required text-danger">
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
                                <label for="product_category_id" class="text-sm text-muted">دسته بندی </label>
                                <select name="category_id" id="category_id"
                                        class="form-control form-group-sm">
                                    <option value="">انتخاب دسته بندی</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id ?? '' }}"
                                                @if(old('category_id',$product->category->id ?? '') == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="brand_id" class="text-sm text-muted">برند </label>
                                <select name="brand_id" id="brand_id" class="form-control form-group-sm">
                                    <option value="">انتخاب برند</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                                @if(old('brand_id',$product->brand->id) == $brand->id) selected @endif>
                                            {{ $brand->original_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('brand_id')
                            <span class="alert_required text-danger">
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
                                <label for="status" class="text-sm text-muted">وضعیت</label>
                                <select name="status" id="status" class="form-control form-group-sm">
                                    <option value="1" @if(old('status',$product->status) == 1) selected @endif>فعال
                                    </option>
                                    <option value="0" @if(!old('status',$product->status)) selected @endif>غیرفعال
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
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="marketable" class="text-sm text-muted">قابلیت فروش</label>
                                <select name="marketable" id="marketable" class="form-control form-group-sm">
                                    <option value="1" @if(old('marketable',$product->marketable) == 1) selected @endif>
                                        بله
                                    </option>
                                    <option value="0" @if(!old('marketable',$product->marketable)) selected @endif>خیر
                                    </option>
                                </select>
                            </div>
                            @error('marketable')
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
                                <label class="text-sm text-muted" for="image">تصویر کالا</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file"
                                               name="image"
                                               class="custom-file-input"
                                               id="image">
                                        <label
                                            style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                                            class="custom-file-label text-right"
                                            for="image">انتخاب
                                            فایل</label>
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
                            @foreach ($product->image['indexArray'] as $key => $value )
                                <section class="col-md-{{ 6 / $number }}">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="currentImage"
                                               value="{{ $key }}" id="{{ $number }}"
                                               @if($product->image['currentImage'] == $key) checked @endif>
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
                                <label for="weight" class="text-sm text-muted">وزن کالا</label>
                                <div class="input-group">
                                    <input type="text"
                                           id="weight"
                                           name="weight"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('weight',$product->weight) }}"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">
                                        گرم
                                    </div>
                                </div>

                            </div>
                            @error('weight')
                            <span class="alert_required text-danger">
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
                                <label for="length" class="text-sm text-muted">طول کالا</label>
                                <div class="input-group">
                                    <input type="text"
                                           id="length"
                                           name="length"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('length',$product->length) }}"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">
                                        سانتی متر
                                    </div>
                                </div>
                            </div>
                            @error('length')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="width" class="text-sm text-muted">عرض کالا</label>
                                <div class="input-group">
                                    <input type="text"
                                           id="width"
                                           name="width"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('width',$product->width) }}"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">
                                        سانتی متر
                                    </div>
                                </div>
                            </div>
                            @error('width')
                            <span class="alert_required text-danger">
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
                                <label for="height" class="text-sm text-muted">ارتفاع کالا</label>
                                <div class="input-group">
                                    <input type="text"
                                           id="height"
                                           name="height"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('height',$product->height) }}"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">
                                        سانتی متر
                                    </div>
                                </div>
                            </div>
                            @error('height')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="price" class="text-sm text-muted">قیمت کالا
                                    (تومان)</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="price"
                                           id="price"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('price',$product->price) }}"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">
                                        تومان
                                    </div>
                                </div>
                            </div>
                            @error('price')
                            <span class="alert_required text-danger">
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
                                <label for="published_at" class="text-sm text-muted">تاریخ انتشار</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="hidden"
                                           class="form-control form-control-sm"
                                           name="published_at"
                                           id="published_at"
                                           value="{{ old('published_at') }}">

                                    <input type="text" class="form-control pull-right" id="published_at_view">
                                </div>
                                <!-- /.input group -->
                            </div>

                            @error('published_at')
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
                                <div class="input-group">
                                    <input type="hidden" class="form-control form-control-sm"
                                           name="tags" id="tags" value="{{ old('tags',$product->tags) }}">
                                    <div class="input-group-addon text-sm">
                                        #
                                    </div>
                                    <select name="" id="select_tags"
                                            class="select2 form-control form-control-sm" multiple>

                                    </select>

                                </div>
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
                        <section class="col-12">
                            <div class="form-group">
                                <label for="introduction" class="text-sm text-muted">توضیحات
                                    کالا</label>
                                <textarea id="introduction" name="introduction" rows="5"
                                          class="form-control form-control-sm">{{ old('introduction',$product->introduction) }}</textarea>
                            </div>
                            @error('introduction')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 border-bottom py-4 my-4">
{{--                            @if($product->metas->count() > 0)--}}
                                @foreach($product->metas as $meta)
                                    <section class="row">
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <label class="mb-2 text-sm text-muted">ویژگی</label>
                                                <input type="text"
                                                       name="meta_key[]"
                                                       id="meta_key[{{ $meta->id ?? '' }}]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $meta->meta_key ?? '' }}">
                                            </div>
                                        </section>
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <label class="mb-2 text-sm text-muted">مقدار</label>
                                                <input type="text"
                                                       name="meta_value[]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $meta->meta_value ?? '' }}">
                                            </div>
                                        </section>
                                    </section>
                            @endforeach
                            <section class="row">
                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 text-sm text-muted">ویژگی</label>
                                        <input type="text"
                                               name="meta_key[]"
                                               class="form-control form-control-sm"
                                               placeholder="ویژگی...">
                                    </div>
                                    @error('meta_key.*')
                                    <span class="alert_required text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 text-sm text-muted">مقدار</label>
                                        <input type="text"
                                               name="meta_value[]"
                                               class="form-control form-control-sm"
                                               placeholder="مقدار...">
                                    </div>
                                    @error('meta_value.*')
                                    <span class="alert_required text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                            </section>

                            <section>
                                        <button type="button" id="btn-copy" class="btn btn-sm btn-success mb-4">افزودن</button>
                                    </section>

{{--                            @endif--}}

{{--                            @if($product->metas->count() == 0)
                                    <section class="row">
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <label class="mb-2 text-sm text-muted">ویژگی</label>
                                                <input type="text"
                                                       name="meta_key[]"
                                                       class="form-control form-control-sm"
                                                       placeholder="ویژگی...">
                                            </div>
                                            @error('meta_key.*')
                                            <span class="alert_required text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                            @enderror
                                        </section>
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <label class="mb-2 text-sm text-muted">مقدار</label>
                                                <input type="text"
                                                       name="meta_value[]"
                                                       class="form-control form-control-sm"
                                                       placeholder="مقدار...">
                                            </div>
                                            @error('meta_value.*')
                                            <span class="alert_required text-danger">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                            @enderror
                                        </section>
                                    </section>
                                    <section><button type="button" id="btn-copy" class="btn btn-xs btn-success mb-4">افزودن</button></section>

                            @endif
                            --}}


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
    <script src="{{ asset('admin-asset/datepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-asset/datepicker/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-asset/vendor_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('admin-asset/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('introduction')
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

        // for persian date picker and reformat it
        $(document).ready(function () {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at',
                cellHeight: 30,
                cellWidth: 30,
                fontSize: 10,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                }
            })
        });

        // for duplicating the button
        $(function () {
            $('#btn-copy').on('click', function () {
                let element = $(this).parent().prev().clone(true, false);
                element.find('input[type="text"]').val(''); // Clear the cloned input values
                $(this).before(element);

                // focus on the closed input fields
                element.find('input[type="text"').first().focus();
            });
        });

        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    {{--  select2 usage   --}}

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

