@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | تخفیف | ایجاد تخفیف عمومی</title>

    <link rel="stylesheet" href="{{ asset('admin-asset/datepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.discount.common-discount-index') }}">تخفیف عمومی</a></li>
                        <li class="breadcrumb-item active">ایجاد</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                       اطلاعات مورد نیاز برای تخفیف عمومی مورد نظرتان را وارد و ذخیره کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.discount.common-discount-store') }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="title" class="text-sm text-muted">عنوان</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       id="title"
                                       placeholder="عنوان تخفیف ..."
                                       value="{{ old('title') }}">
                            </div>
                            @error('title')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="percentage" class="text-sm text-muted">درصد تخفیف</label>
                                <input type="number"
                                       name="percentage"
                                       class="form-control"
                                       id="percentage"
                                       placeholder="باید عدد بین صفر تا 100 وارد کنید..."
                                       value="{{ old('percentage') }}">
                            </div>
                            @error('percentage')
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
                                <label for="discount_ceiling" class="text-sm text-muted">حداکثر مقدار تخفیف(تومان)</label>
                                <input type="text"
                                       name="discount_ceiling"
                                       class="form-control"
                                       id="discount_ceiling"
                                       onchange="this.value = addCommas(this.value)"
                                       onkeyup="this.value = addCommas(this.value)"
                                       placeholder="مبلغ بر اساس تومان خواهد بود..."
                                       value="{{ old('discount_ceiling') }}">
                            </div>
                            @error('discount_ceiling')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="minimum_order_amount" class="text-sm text-muted">حداقل مقدار سفارش(تومان)</label>
                                <input type="text"
                                       name="minimum_order_amount"
                                       class="form-control"
                                       id="minimum_order_amount"
                                       onchange="this.value = addCommas(this.value)"
                                       onkeyup="this.value = addCommas(this.value)"
                                       placeholder="مبلغ بر اساس ریال خواهد بود..."
                                       value="{{ old('minimum_order_amount') }}">
                            </div>
                            @error('minimum_order_amount')
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
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
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
                                <select name="status" id="status" class="form-control form-group-sm">
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
    <script>
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
                autoClose:true,
                todayHighlight:true,
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
                autoClose:true,
                todayHighlight:true,
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

