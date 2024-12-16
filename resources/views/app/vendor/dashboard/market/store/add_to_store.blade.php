@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | انبار | افزایش موجودی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.product.index') }}">محصولات</a>
                        </li>
                        <li class="breadcrumb-item active">افزایش موجودی کالا</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                       اطلاعات مربوط به تنظیم موجودی کالای <span class="text-success font-weight-bold">{{ $product->name }}</span> را وارد و سپس ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.store.store',$product->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="receiver" class="text-sm text-muted">نام تحویل گیرنده</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="receiver"
                                           class="form-control"
                                           id="receiver"
                                           autofocus
                                           placeholder="چه کسی کالا را تحویل می گیرد؟"
                                           value="{{ old('receiver') }}">
                                </div>
                            </div>

                            @error('receiver')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="deliverer" class="text-sm text-muted">نام تحویل دهنده</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="deliverer"
                                           class="form-control"
                                           id="deliverer"
                                           autofocus
                                           placeholder="چه کسی کالا را تحویل می دهد؟"
                                           value="{{ old('deliverer') }}">
                                </div>
                            </div>
                            @error('deliverer')
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
                                <label for="marketable_number" class="text-sm text-muted">تعداد</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="marketable_number"
                                           class="form-control"
                                           id="marketable_number"
                                           onchange="this.value = addCommas(this.value)"
                                           onkeyup="this.value = addCommas(this.value)"
                                           placeholder="تعداد، مثلا 10 ..."
                                           value="{{ old('marketable_number') }}">
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
                        <section class="col-12">
                            <div class="form-group">
                                <label for="details" class="text-sm text-muted">جزئیات</label>
                                <textarea name="details" id="details" class="form-control form-control-sm" rows="5"
                                          placeholder="جزئیات این عملیات..."></textarea>
                            </div>
                            @error('details')
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

