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
                            <span>اطلاعات حساب</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>
                <!-- end vontent header -->

                <section class="d-flex justify-content-end my-4">
                    <a class="btn btn-link btn-sm text-info text-decoration-none mx-1"
                       data-bs-toggle="modal"
                       data-bs-target="#update-profile"
                       href="{{ route('customer.dashboard.profile.edit-profile') }}">
                        <i class="fa fa-edit px-1"></i>
                        ویرایش حساب
                    </a>
                </section>

                <!-- start update address Modal -->
                <section class="modal fade" id="update-profile" tabindex="-1"
                         aria-labelledby="update-profile-label" aria-hidden="true">
                    <section class="modal-dialog">
                        <section class="modal-content">
                            <section class="modal-header">
                                <h5 class="modal-title" id="update-profile-label"><i
                                        class="fa fa-edit"></i> ویرایش پروفایل</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </section>
                            <section class="modal-body">

                                <form class="row"
                                      action="{{ route('customer.dashboard.profile.update-profile') }}"
                                      id="profileForm"
                                      method="post">
                                    @csrf
                                    @method('PUT')

                                    <section class="col-6 mb-2">
                                        <label for="firstname" class="form-label mb-1">نام</label>
                                        <input value="{{ auth()->user()->firstname ?? '' }}"
                                               type="text" name="firstname" class="form-control form-control-sm" autofocus
                                               id="firstname" >
                                    </section>

                                    <section class="col-6 mb-2">
                                        <label for="lastname" class="form-label mb-1">نام خانوادگی</label>
                                        <input value="{{ auth()->user()->lastname ?? '' }}"
                                               type="text" name="lastname" class="form-control form-control-sm"
                                               id="lastname">
                                    </section>

                                    <section class="col-12 mb-2">
                                        <label for="national_code" class="form-label mb-1">کد ملی
                                        </label>
                                        <input value="{{ auth()->user()->national_code ?? '' }}"
                                               type="text" name="national_code" class="form-control form-control-sm"
                                               id="national_code" placeholder="کد ملی">
                                    </section>


                                    <section class="modal-footer py-1">
                                        <button type="submit" class="btn btn-sm btn-primary">ویرایش
                                            حساب</button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-dismiss="modal">بستن</button>
                                    </section>
                                </form>


                            </section>

                        </section>
                    </section>
                </section>
                <!-- end update address Modal -->



                <section class="row">
                    <section class="col-6 border-bottom mb-2 py-2">
                        <section class="field-title">نام</section>
                        <section class="field-value overflow-auto">{{ auth()->user()->firstname ?? '-' }}</section>
                    </section>

                    <section class="col-6 border-bottom my-2 py-2">
                        <section class="field-title">نام خانوادگی</section>
                        <section class="field-value overflow-auto">{{ auth()->user()->lastname ?? '-' }}</section>
                    </section>

                    <section class="col-6 border-bottom my-2 py-2">
                        <section class="field-title">شماره تلفن همراه</section>
                        <section
                            class="field-value overflow-auto">{{ convertEnglishToPersian(auth()->user()->mobile) ?? '-' }}</section>
                    </section>

                    <section class="col-6 border-bottom my-2 py-2">
                        <section class="field-title">ایمیل</section>
                        <section class="field-value overflow-auto">{{ auth()->user()->email ?? '-' }}</section>
                    </section>

                    <section class="col-6 my-2 py-2">
                        <section class="field-title">کد ملی</section>
                        <section
                            class="field-value overflow-auto">{{ convertEnglishToPersian(auth()->user()->national_code) ?? '-' }}</section>
                    </section>

                    <section class="col-6 my-2 py-2">
                        <section class="field-title">تاریخ عضویت</section>
                        <section
                            class="field-value overflow-auto"> {{ convertEnglishToPersian(persianDate(auth()->user()->created_at)) }} </section>
                    </section>

                </section>


            </section>
    </section>
@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
