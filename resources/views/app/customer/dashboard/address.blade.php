@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>پنل مشتری</title>
@endsection

@section('content')

    <section class="row">

        <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

            <!-- start vontent header -->
            <section class="content-header mb-4">
                <section class="d-flex justify-content-between align-items-center">
                    <h2 class="content-header-title">
                        <span>آدرس های من</span>
                    </h2>
                    <section class="content-header-link">
                        <!--<a href="#">مشاهده همه</a>-->
                    </section>
                </section>
            </section>
            <!-- end vontent header -->


            <section class="my-addresses">

                @forelse(auth()->user()->addresses as $address)
                    <input type="hidden" name="address_id" value="{{ $address->id }}"
                           id="a-{{ $address->id }}"/>
                    <!--checked="checked"-->
                    <label for="a-{{ $address->id }}" class="address-wrapper mb-2 p-2">
                        <section class="mb-2">
                            <i class="fa fa-map-marker-alt mx-1"></i>
                            آدرس
                            : {{ convertEnglishToPersian(($address->province->name ?? '').'،'.($address->city->name ??'').'،'.($address->address)) ?? '-' }}
                        </section>
                        <section class="mb-2">
                            <i class="fa fa-user-tag mx-1"></i>
                            گیرنده : {{ ($address->recipient_first_name ?? auth()->user()->firstname) ?? '-' }}
                            {{ ($address->recipient_last_name ?? auth()->user()->lastname) ?? '-' }}
                        </section>
                        <section class="mb-2">
                            <i class="fa fa-mobile-alt mx-1"></i>
                            موبایل گیرنده : {{ convertEnglishToPersian($address->mobile ?? auth()->user()->mobile) ?? '-' }}
                        </section>
                        <a class="" data-bs-toggle="modal"
                           data-bs-target="#edit-address-{{ $address->id }}"><i class="fa fa-edit"></i>
                            ویرایش آدرس</a>
                    </label>


                    <!-- start edit address Modal -->
                    <section class="modal fade" id="edit-address-{{ $address->id }}" tabindex="-1"
                             aria-labelledby="add-address-label" aria-hidden="true">
                        <section class="modal-dialog">
                            <section class="modal-content">
                                <section class="modal-header">
                                    <h5 class="modal-title" id="add-address-label"><i
                                            class="fa fa-plus"></i> ویرایش آدرس </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </section>
                                <section class="modal-body">

                                    <form class="row"
                                          action="{{ route('customer.dashboard.profile.update-address',$address->id) }}"
                                          id="addressForm"
                                          method="post">
                                        @csrf
                                        @method('PUT')

                                        <section class="col-6 mb-2">
                                            <label for="update-province-{{ $address->id }}"
                                                   class="form-label mb-1 text-sm text-muted">استان</label>
                                            <select
                                                name="province_id"
                                                class="form-select form-select-sm"
                                                id="update-province-{{ $address->id }}">
                                                @foreach($provinces as $province)
                                                    <option
                                                        {{ $address->province_id == $province->id ? 'selected' : '' }}
                                                        data-update-url={{ route('customer.get-cities',$province->id) }}
                                                                            value="{{ $province->id }}">
                                                        {{ $province->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="city"
                                                   class="form-label mb-1 text-sm text-muted">شهر</label>
                                            <select name="city_id"
                                                    class="form-select form-select-sm"
                                                    id="update-city-{{ $address->id }}">
                                                <option selected>شهر را انتخاب کنید</option>

                                            </select>
                                        </section>
                                        <section class="col-12 mb-2">
                                            <label for="address"
                                                   class="form-label mb-1 text-sm text-muted">نشانی</label>
                                            <textarea name="address" class="form-control form-control-sm"
                                                      id="address">{{ $address->address }}</textarea>
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="postal_code"
                                                   class="form-label mb-1 text-sm text-muted">کد
                                                پستی</label>
                                            <input name="postal_code"
                                                   value="{{ convertEnglishToPersian($address->postal_code) ?? '' }}"
                                                   type="text"
                                                   class="form-control form-control-sm"
                                                   id="postal_code" placeholder="کد پستی">
                                        </section>


                                        <section class="col-3 mb-2">
                                            <label for="no"
                                                   class="form-label mb-1 text-sm text-muted">پلاک</label>
                                            <input name="no"
                                                   value="{{ convertEnglishToPersian($address->no) ?? '' }}"
                                                   type="text"
                                                   class="form-control form-control-sm"
                                                   id="no" placeholder="پلاک">
                                        </section>

                                        <section class="col-3 mb-2">
                                            <label for="unit"
                                                   class="form-label mb-1 text-sm text-muted">واحد</label>
                                            <input name="unit"
                                                   value="{{ convertEnglishToPersian($address->unit) ?? '' }}"
                                                   type="text"
                                                   class="form-control form-control-sm"
                                                   id="unit" placeholder="واحد">
                                        </section>

                                        <section class="border-bottom mt-2 mb-3"></section>

                                        <section class="col-12 mb-2">
                                            <section class="form-check">
                                                <input
                                                    {{ $address->recipient_first_name ? 'checked' : '' }}
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="receiver"
                                                    id="update-receiver">
                                                <label
                                                    class="form-check-label text-danger text-sm fw-bolder"
                                                    for="update-receiver">
                                                    سفارش برای شخص دیگری است (اطلاعات زیر تکمیل شود)
                                                </label>
                                            </section>
                                        </section>


                                        <section class="col-6 mb-2">
                                            <label for="first_name"
                                                   class="form-label mb-1 text-sm text-muted">نام
                                                گیرنده</label>
                                            <input name="recipient_first_name"
                                                   value="{{ ($address->recipient_first_name) ?? '' }}"
                                                   type="text"
                                                   class="form-control form-control-sm"
                                                   id="update-first_name" disabled
                                                   placeholder="نام گیرنده">
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="last_name"
                                                   class="form-label mb-1 text-sm text-muted">نام
                                                خانوادگی گیرنده</label>
                                            <input name="recipient_last_name"
                                                   type="text"
                                                   value="{{ $address->recipient_last_name ?? '' }}"
                                                   class="form-control form-control-sm"
                                                   id="update-last_name"
                                                   placeholder="نام خانوادگی گیرنده"
                                                   disabled>
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="mobile"
                                                   class="form-label mb-1 text-sm text-muted">شماره
                                                موبایل</label>
                                            <input name="mobile"
                                                   type="text"
                                                   value="{{ convertEnglishToPersian($address->mobile) ?? '' }}"
                                                   class="form-control form-control-sm"
                                                   id="update-mobile"
                                                   placeholder="09..." disabled>
                                        </section>
                                        <section class="modal-footer py-1">
                                            <button type="submit"
                                                    class="btn btn-sm btn-primary">ذخیره
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-dismiss="modal">بستن
                                            </button>


                                        </section>
                                    </form>

                                </section>


                            </section>
                        </section>
                    </section>
                    <!-- end add address Modal -->
                @empty
                    <section class="">
                        <span class="fw-bolder">فعلا آدرسی ثبت نکرده اید!</span>
                    </section>
                @endforelse


                <section class="address-add-wrapper">
                    <button class="address-add-button" type="button" data-bs-toggle="modal"
                            data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس جدید
                    </button>
                    <!-- start add address Modal -->
                    <section class="modal fade" id="add-address" tabindex="-1" aria-labelledby="add-address-label"
                             aria-hidden="true">
                        <section class="modal-dialog">
                            <section class="modal-content">
                                <section class="modal-header">
                                    <h5 class="modal-title" id="add-address-label"><i class="fa fa-plus"></i> ایجاد آدرس
                                        جدید</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </section>
                                <section class="modal-body">

                                    <form class="row"
                                          action="{{ route('customer.add-address') }}"
                                          id="addressForm"
                                          method="post">
                                        @csrf

                                        <section class="col-6 mb-2">
                                            <label for="province"
                                                   class="form-label mb-1 text-sm text-muted">استان</label>
                                            <select
                                                name="province_id"
                                                class="form-select form-select-sm"
                                                id="province">
                                                <option selected>استان را انتخاب کنید</option>
                                                @foreach($provinces as $province)
                                                    <option
                                                        data-url={{ route('customer.get-cities',$province->id) }}
                                                        value="{{ $province->id }}">{{ $province->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="city"
                                                   class="form-label mb-1 text-sm text-muted">شهر</label>
                                            <select name="city_id"
                                                    class="form-select form-select-sm" id="city">
                                                <option selected>شهر را انتخاب کنید</option>

                                            </select>
                                        </section>
                                        <section class="col-12 mb-2">
                                            <label for="address"
                                                   class="form-label mb-1 text-sm text-muted">نشانی</label>
                                            <textarea name="address"
                                                      class="form-control form-control-sm"
                                                      id="address"
                                                      placeholder="آدرس را بصورت دقیق وارد کنید...">{{ old('address') }}</textarea>
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="postal_code"
                                                   class="form-label mb-1 text-sm text-muted">کد
                                                پستی</label>
                                            <input name="postal_code" type="text"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('postal_code') }}"
                                                   id="postal_code" placeholder="کد پستی">
                                        </section>


                                        <section class="col-3 mb-2">
                                            <label for="no"
                                                   class="form-label mb-1 text-sm text-muted">پلاک</label>
                                            <input name="no" type="text"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('no') }}"
                                                   id="no" placeholder="پلاک">
                                        </section>

                                        <section class="col-3 mb-2">
                                            <label for="unit"
                                                   class="form-label mb-1 text-sm text-muted">واحد</label>
                                            <input name="unit" type="text"
                                                   class="form-control form-control-sm"
                                                   value="{{ old('unit') }}"
                                                   id="unit" placeholder="واحد">
                                        </section>

                                        <section class="border-bottom mt-2 mb-3"></section>

                                        <section class="col-12 mb-2">
                                            <section class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="receiver"
                                                       id="receiver">
                                                <label
                                                    class="form-check-label text-danger text-sm fw-bolder"
                                                    for="receiver">
                                                    سفارش برای شخص دیگری است (اطلاعات زیر تکمیل شود)
                                                </label>
                                            </section>
                                        </section>


                                        <section class="col-6 mb-2">
                                            <label for="recipient_first_name"
                                                   class="form-label mb-1 text-sm text-muted">نام
                                                گیرنده</label>
                                            <input name="recipient_first_name" type="text"
                                                   class="form-control form-control-sm"
                                                   id="first_name"
                                                   value="{{ old('recipient_first_name') }}"
                                                   disabled
                                                   placeholder="نام گیرنده">
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="recipient_last_name"
                                                   class="form-label mb-1 text-sm text-muted">نام
                                                خانوادگی گیرنده</label>
                                            <input name="recipient_last_name"
                                                   value="{{ old('recipient_last_name') }}"
                                                   type="text"
                                                   class="form-control form-control-sm"
                                                   id="last_name" placeholder="نام خانوادگی گیرنده"
                                                   disabled>
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="mobile"
                                                   class="form-label mb-1 text-sm text-muted">شماره
                                                موبایل</label>
                                            <input name="mobile"
                                                   type="text"
                                                   class="form-control form-control-sm"
                                                   id="mobile"
                                                   placeholder="09..." disabled>
                                        </section>
                                        <section class="modal-footer py-1">
                                            <button type="submit"
                                                    class="btn btn-sm btn-primary">ذخیره
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-dismiss="modal">بستن
                                            </button>

                                        </section>
                                    </form>


                                </section>
                            </section>
                        </section>
                        <!-- end add address Modal -->
                    </section>

                </section>


            </section>

        </section>
        @endsection

        @section('script')

            <script type="text/javascript">
                $(document).ready(function () {

                    function clearModalFields() {
                        $('#add-address').find('form')[0].reset(); // Update selector to target the form inside the modal
                    }

                    $('#add-address').on('shown.bs.modal', function () { // Change event from 'show.bs.modal' to 'shown.bs.modal'
                        clearModalFields();
                    });

                    $('#receiver').change(function () {
                        if ($(this).is(':checked')) {
                            $('#first_name').prop('disabled', false);
                            $('#last_name').prop('disabled', false);
                            $('#mobile').prop('disabled', false);
                        } else {
                            $('#first_name').prop('disabled', true);
                            $('#last_name').prop('disabled', true);
                            $('#mobile').prop('disabled', true);
                        }
                    });

                    $('#update-receiver').change(function () {
                        if ($(this).is(':checked')) {
                            $('#update-first_name').prop('disabled', false);
                            $('#update-last_name').prop('disabled', false);
                            $('#update-mobile').prop('disabled', false);
                        } else {
                            $('#update-first_name').prop('disabled', true);
                            $('#update-last_name').prop('disabled', true);
                            $('#update-mobile').prop('disabled', true);
                        }
                    });

                    // for adding address
                    $('#province').change(function () {
                        let province = $('#province option:selected');
                        let path = province.attr('data-url');
                        $.ajax({
                            url: path,
                            type: "GET",
                            success: function (response) {
                                console.log(response)
                                if (response.status) {
                                    let cities = response.cities;
                                    $('#city').empty();
                                    cities.map((city) => {
                                        $('#city').append($('<option/>').val(city.id).text(city.name));
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                                console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                            }
                        });
                    });

                    // for update address
                    $('#update-province').change(function () {
                        let province = $('#update-province option:selected');
                        let path = province.attr('data-url');

                        $.ajax({
                            url: path,
                            type: "GET",
                            success: function (response) {
                                if (response.status) {
                                    let cities = response.cities;
                                    $('#update-city').empty();
                                    cities.map((city) => {
                                        $('#update-city').append($('<option/>').val(city.id).text(city.name));
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                                console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                            }
                        });
                    });
                });


                let addresses = {!! auth()->user()->addresses !!};
                addresses.map(function (address) {
                    let id = address.id;
                    let target = `#update-province-${id}`;
                    let selected = `${target} option:selected`

                    $(target).change(function () {
                        var element = $(selected);
                        let path = element.attr('data-update-url');
                        $.ajax({
                            url: path,
                            type: "GET",
                            success: function (response) {
                                if (response.status) {
                                    let cities = response.cities;
                                    $(`#update-city-${id}`).empty();
                                    cities.map((city) => {
                                        $(`#update-city-${id}`).append($('<option/>').val(city.id).text(city.name));
                                    });
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                                console.error(`AJAX error: ${textStatus} - ${errorThrown}`);
                            }
                        });
                    });
                });

            </script>

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
