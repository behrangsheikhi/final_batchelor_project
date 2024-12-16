@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | تخفیف | ویرایش کد تخفیف</title>

    <link rel="stylesheet" href="{{ asset('admin-asset/datepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.discount.coupon-index') }}">کد تخفیف</a></li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش کد تخفیف <span class="text-success font-weight-bold">{{ $coupon->code }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.discount.coupon-update',$coupon->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="code" class="text-sm text-muted">کد</label>
                                <input type="text"
                                       name="code"
                                       class="form-control"
                                       id="code"
                                       value="{{ old('code',$coupon->code ?? '') }}">
                            </div>
                            @error('code')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="amount" class="text-sm text-muted">مقدار</label>
                                <input type="text"
                                       name="amount"
                                       class="form-control"
                                       id="amount"
                                       onchange="this.value = addCommas(this.value)"
                                       onkeyup="this.value = addCommas(this.value)"
                                       value="{{ old('amount',$coupon->amount ?? '') }}">
                            </div>
                            @error('amount')
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
                                <label for="amount_type" class="text-sm text-muted">درصدی/ریالی</label>
                                <select name="amount_type" id="amount_type" class="form-control form-group-sm">
                                    <option value="1" @if(old('amount_type',$coupon->amount_type) == \App\Constants\CouponTypeValue::PRICE_UNIT) selected @endif>ریال</option>
                                    <option value="0" @if(old('amount_type',$coupon->amount_type) == \App\Constants\CouponTypeValue::PERCENTAGE) selected @endif>درصد</option>
                                </select>
                            </div>
                            @error('amount_type')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="discount_ceiling" class="text-sm text-muted">حداکثر مقدار تخفیف(تومان)</label>
                                <input type="text"
                                       name="discount_ceiling"
                                       class="form-control"
                                       id="discount_ceiling"
                                       onchange="this.value = addCommas(this.value)"
                                       onkeyup="this.value = addCommas(this.value)"
                                       value="{{ old('discount_ceiling',$coupon->discount_ceiling ?? '') }}">
                            </div>
                            @error('discount_ceiling')
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
                                <label for="type" class="text-sm text-muted">عمومی/خصوصی</label>
                                <select name="type" id="type" class="form-control form-group-sm">
                                    <option value="1" @if(old('type',$coupon->type) == 1) selected @endif>خصوصی</option>
                                    <option value="0" @if(!old('type',$coupon->type)) selected @endif>عمومی</option>
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
                                <label for="status" class="text-sm text-muted">وضعیت</label>
                                <select name="status" id="status" class="form-control form-group-sm">
                                    <option value="1" @if(old('status',$coupon->status) == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status',$coupon->status)) selected @endif>غیر فعال</option>
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
                                           value="{{ old('start_date',$coupon->start_date) }}">

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
                                           value="{{ old('end_date',$coupon->end_date) }}">

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
                            <div class="form-group" id="userSelectGroup" @if(old('type', $coupon->type) != 1) style="display: none;" @endif>
                                <label class="text-label d-flex flex-column" for="user_id">کاربر</label>
                                <select name="user_id"
                                        id="user_id"
                                        data-old-value="{{ old('user_id', $coupon->user_id) }}"
                                        data-old-name="{{ old('user_id', $coupon->user_id) ? \App\Models\User::find(old('user_id', $coupon->user_id))->full_name : '' }}"
                                        class="form-select text-right select2 form-control">
                                </select>
                            </div>

                            @error('user_id')
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
    <script src="{{ asset('admin-asset/vendor_components/select2/dist/js/i18n/fa.js') }}"></script>
    <script type="text/javascript">
        // section for search product group in product create view

        let oldUserId = $('#user_id').data('old-value');
        let oldName = $('#user_id').data('old-name');
        if (oldUserId) {
            let option = new Option(oldName, oldUserId, true, true);
            $('#user_id').append(option).trigger('change');
        }

        let path = "{{ route('admin.market.discount.search-user') }}";
        $('#user_id').select2({
            placeholder: ' مشتری را انتخاب کنید',
            language : "fa",
            allowClear: true,
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.fullname,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#type').change(function () {
            if ($('#type').find(':selected').val() === '1') {
                $('#userSelectGroup').show();
                $('#user_id').removeAttr('disabled');
            } else {
                $('#userSelectGroup').hide();
                $('#user_id').prop('disabled', true);
            }
        }).change(); // Trigger the change event on page load

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
            })
        });

        function addCommas(number) {
            return number.toString().replace(/[^0-9.]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

