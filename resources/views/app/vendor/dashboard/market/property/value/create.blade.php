@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | فرم کالا | مقدار | ایجاد</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.market.property.value.index',$attribute->id) }}">مقدار فرم
                                کالا</a></li>
                        <li class="breadcrumb-item active">ایجاد</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید اطلاعات مربوط به مقدار برای ویژگی <span class="text-success font-weight-bold">{{ $attribute->name }}</span> را وارد و ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.property.value.store',$attribute->id) }} "
                  id="form"
                  method="post"
                  class="border rounded p-4"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
{{--                    @dd($attribute)--}}

                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="product_id" class="text-sm text-muted">انتخاب کالا</label>
                                <select name="product_id" id="product_id" class="form-control form-group-sm">
                                    {{-- getting the products of this selected category --}}
                                    @foreach($attribute->category->products as $product)
                                        @if($product->category !== null)
                                            <option value="{{ $product->id }}"
                                                    @if(old('product_id') == $product->id) selected @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('product_id')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="value" class="text-sm text-muted">مقدار</label>
                                <input type="text"
                                       name="value"
                                       id="value"
                                       value="{{ old('value') }}"
                                       autofocus
                                       placeholder="نام مقدار را وارد کنید ..."
                                       class="form-control form-control-sm">
                            </div>
                            @error('value')
                            <span class="alert_required text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="type" class="text-sm text-muted">نوع مقدار</label>
                                <select name="type" id="type" class="form-control form-group-sm">
                                    <option value="1" @if(old('type') == 1) selected @endif>متغیر</option>
                                    <option value="0" @if(!old('type')) selected @endif>ثابت</option>
                                </select>
                            </div>
                            @error('type')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="price_increase" class="text-sm text-muted">افزایش قیمت</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="price_increase"
                                           id="price_increase"
                                           value="{{ old('price_increase') }}"
                                           autofocus
                                           placeholder="افزایش قیمت..."
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">تومان</div>
                                </div>
                            </div>
                            @error('price_increase')
                            <span class="alert_required text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </section>
                    </div>

                    <section class="">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-save"></i>
                            ذخیره
                        </button>
                    </section>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('script')
    <script type="text/javascript">
        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

