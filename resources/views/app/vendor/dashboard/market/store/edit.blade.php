@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | انبار | اصلاح موجودی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.index') }}">محصولات</a>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.store.index',$product->id) }}">کالا</a>
                        </li>
                        <li class="breadcrumb-item active">اصلاح موجودی کالا</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعات مربوط به موجودی کالای <span class="text-success font-weight-bold">{{ $product->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.store.update',$product->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="marketable_number" class="text-sm text-muted">تعداد قابل فروش</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="marketable_number"
                                           class="form-control"
                                           id="marketable_number"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           placeholder="تعداد، مثلا 10 ..."
                                           value="{{ old('marketable_number',$product->marketable_number) }}">
                                    <div class="input-group-addon bg-primary">عدد</div>
                                </div>
                            </div>
                            @error('marketable_number')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="frozen_number" class="text-sm text-muted">تعداد رزرو شده</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="frozen_number"
                                           class="form-control"
                                           id="frozen_number"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('frozen_number',$product->frozen_number) }}">
                                    <div class="input-group-addon bg-primary">عدد</div>
                                </div>
                            </div>
                            @error('frozen_number')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="sold_number" class="text-sm text-muted">تعداد فروخته شده</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="sold_number"
                                           class="form-control"
                                           id="sold_number"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           value="{{ old('sold_number',$product->sold_number) }}">
                                    <div class="input-group-addon bg-primary">عدد</div>
                                </div>
                            </div>
                            @error('sold_number')
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
    <script>
        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

