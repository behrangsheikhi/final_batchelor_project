@extends('admin.layout.master')

@section('head-tag')
    <title>بخش فروشگاه | مدیریت گارانتی | ایجاد</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.guaranty.index',$product->id) }}">گارانتی</a>
                        </li>
                        <li class="breadcrumb-item active">ایجاد گارانتی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این صفحه می توانید گارانتی مورد نظر را ایجاد و ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.product.guaranty.store',$product->id) }}" method="post" id="form">
                @csrf
                <section class="row">
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="name" class="text-sm text-muted">عنوان گارانتی</label>
                            <input type="text" autofocus name="name" id="name" class="form-control form-control-sm"
                                   value="{{ old('name') }}" placeholder="عنوان گارانتی را وارد کنید ...">
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
                                       value="{{ old('price_increase') }}"
                                       placeholder="میزان افزایش قیمت..."
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

