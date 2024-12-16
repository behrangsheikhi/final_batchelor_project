@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | تخفیف | ویرایش تخفیف شگفت انگیز</title>

    <link rel="stylesheet" href="{{ asset('admin-asset/datepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.market.discount.amazing-sale-index') }}">تخفیف شگفت انگیز</a>
                        </li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش کالای شگفت انگیز <span
                            class="text-success font-weight-bold">{{ $amazingSale->product->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.discount.amazing-sale-update',$amazingSale->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label class="text-label d-flex flex-column" for="product_id">کالا</label>
                                <select id="product_id_select"
                                        data-old-value="{{ old('product_id') }}"
                                        data-old-name="{{ old('product_id') ? \App\Models\Admin\Market\Product::find(old('product_id'))->name : '' }}"
                                        class="form-select text-right select2 form-control"
                                        name="product_id">
                                    @foreach($products as $product)
                                        <option
                                            value="{{ $product->id }}"
                                            @if($amazingSale->product->id==$product->id) selected @endif>{{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_id')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="percentage" class="text-sm text-muted">درصد تخفیف</label>
                                <input type="number"
                                       name="percentage"
                                       class="form-control"
                                       id="percentage"
                                       value="{{ old('percentage',$amazingSale->percentage) }}">
                            </div>
                            @error('percentage')
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
                                <label for="start_date" class="text-sm text-muted">تاریخ شروع</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="hidden"
                                           class="form-control form-control-sm"
                                           name="start_date"
                                           id="start_date"
                                           value="{{ old('start_date') }}">

                                    <input type="text" class="form-control pull-right" id="start_date_view">
                                </div>
                                <!-- /.input group -->
                            </div>

                            @error('start_date')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="end_date" class="text-sm text-muted">تاریخ پایان</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="hidden"
                                           class="form-control form-control-sm"
                                           name="end_date"
                                           id="end_date"
                                           value="{{ old('end_date') }}">

                                    <input type="text" class="form-control pull-right" id="end_date_view">
                                </div>
                                <!-- /.input group -->
                            </div>

                            @error('end_date')
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
                                <select name="status" id="status" class="form-control form-group-sm">
                                    <option value="1" @if(old('status',$amazingSale->status) == 1) selected @endif>
                                        فعال
                                    </option>
                                    <option value="0" @if(!old('status',$amazingSale->status)) selected @endif>غیر
                                        فعال
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
    <script src="{{ asset("admin-asset/vendor_components/moment/min/moment.min.js") }}"></script>
    <script src="{{ asset("admin-asset/vendor_components/select2/dist/js/i18n/fa.js") }}"></script>

    <script type="text/javascript">

        // section for search product group in product create view
        let path = "{{ route('admin.market.discount.search-product') }}";
        $('#product_id').select2({
            placeholder: ' کالا را انتخاب کنید',
            language: "fa",
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        let oldProductId = $('#product_id_select').data('old-value');
        let oldName = $('#product_id_select').data('old-name');
        if (oldProductId) {
            $('#product_id_select').append(new Option(oldName, oldProductId, true, true)).trigger('change');
        }
        // Function to compare dates

        // function compareDates(startDate, endDate) {
        //     if (startDate > endDate) {
        //         toastr.error('End date must be after the start date');
        //         return false; // Return false to indicate validation failure
        //     }
        //     return true; // Return true if validation passes
        // }
        // for persian date picker and reformat it
        $(document).ready(function () {
            $('#start_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#start_date',
                autoClose: true,
                todayHighlight: true,
                cellHeight: 30,
                cellWidth: 30,
                fontSize: 10,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                },
                // onSelect: function (unixDate) {
                //     // Call the compareDates function when the start date changes
                //     const startDate = moment(unixDate, 'X');
                //     const endDate = moment($('#end_date_view').persianDatepicker('getDate'), 'X');
                //     compareDates(startDate, endDate);
                // }
            })
        });

        $(document).ready(function () {
            $('#end_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#end_date',
                autoClose: true,
                todayHighlight: true,
                cellHeight: 30,
                cellWidth: 30,
                fontSize: 10,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                },
                // onSelect: function (unixDate) {
                //     // Call the compareDates function when the end date changes
                //     const startDate = moment($('#start_date_view').persianDatepicker('getDate'), 'X');
                //     const endDate = moment(unixDate, 'X');
                //     compareDates(startDate, endDate);
                // }
            })
        });

        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

