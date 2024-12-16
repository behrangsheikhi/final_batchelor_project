@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | فرم کالا | مقدار | ویرایش</title>
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
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش مقدار برای ویژگی <span class="text-success font-weight-bold">{{ $attribute->name }}</span> برای محصول <span class="text-success font-weight-bold">{{ $value->product->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.property.value.update',['attribute' => $attribute->id,'value' => $value->id]) }} "
                  id="form"
                  method="post"
                  class="border rounded p-4"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="product_id" class="text-sm text-muted">انتخاب کالا</label>
                                <select name="product_id" id="product_id" class="form-control form-group-sm">
                                    {{-- getting the products of this selected category --}}
                                    @foreach($attribute->category->products as $product)
                                        @if($product->category !== null)
                                            <option value="{{ $product->id }}"
                                                    @if(old('product_id',$value->product->id) == $product->id) selected @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            @error('product_id')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="value" class="text-sm text-muted">مقدار</label>
{{--                                @dd($value)--}}
                                <input type="text"
                                       name="value"
                                       id="value"
                                       value="{{ old('value',json_decode($value->value)->value) }}"
                                       autofocus
                                       class="form-control form-control-sm">
                            </div>
                            @error('value')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="type" class="text-sm text-muted">نوع مقدار</label>
                                <select name="type" id="type" class="form-control form-group-sm">
                                    <option value="1" @if(old('type',$value->type) == 1) selected @endif>متغیر</option>
                                    <option value="0" @if(!old('type',$value->type)) selected @endif>ثابت</option>
                                </select>
                            </div>
                            @error('type')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="price_increase" class="text-sm text-muted">افزایش قیمت</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="price_increase"
                                           id="price_increase"
                                           value="{{ old('price_increase',number_format(json_decode($value->value)->price_increase)) }}"
                                           autofocus
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           class="form-control form-control-sm">
                                    <div class="input-group-addon text-sm">تومان</div>
                                </div>
                            </div>
                            @error('price_increase')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
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

