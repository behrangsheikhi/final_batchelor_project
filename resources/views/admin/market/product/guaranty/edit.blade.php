@extends('admin.layout.master')

@section('head-tag')
    <title>بخش فروشگاه | مدیریت گارانتی | ویرایش</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.index') }}">محصولات</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.market.product.guaranty.index',$product->id) }}">گارانتی</a>
                        </li>
                        <li class="breadcrumb-item active">ویرایش گارانتی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش گارانتی با عنوان <span
                            class="text-success font-weight-bold">{{ $guaranty->name }}</span> برای محصول <span
                            class="text-success font-weight-bold">{{ $product->name }}</span> هستید
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form
                action="{{ route('admin.market.product.guaranty.update',['product' => $product->id,'guaranty' => $guaranty->id]) }}"
                method="post" id="form">
                @csrf
                @method('PUT')
                <section class="row">
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="name" class="text-sm text-muted">عنوان گارانتی</label>
                            <input type="text" autofocus name="name" id="name" class="form-control form-control-sm"
                                   value="{{ old('name',$guaranty->name) }}">
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
                            <label for="price_increase" class="text-sm text-muted">میزان افزایش قیمت</label>
                            <div class="input-group">
                                <input type="text"
                                       id="price_increase"
                                       name="price_increase"
                                       onchange="this.value=addCommas(this.value)"
                                       onkeyup="this.value=addCommas(this.value)"
                                       value="{{ old('price_increase',$guaranty->price_increase) }}"
                                       class="form-control form-control-sm">
                                <div class="input-group-addon text-sm">تومان</div>
                            </div>
                        </div>
                        @error('price_increase')
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
    <script>
        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

