@extends('app.layouts.master.master-sample')

@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">

        <form action="{{ route('auth.register-send-otp') }}" method="post">
            @csrf

            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <h4 style="font-family: 'mj_yalda'">راسته فرش</h4>

                </section>
                @if(session('error'))
                    <div id="alert-danger" class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                            <li class="alert alert-danger text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <section class="login-title">
                    <small class="login-info text-muted">لطفا اطلاعات درخواست شده را تکمیل کنید</small>
                </section>

                <section class="login-input-text">
                    <input type="text" name="firstname" value="{{ old('firstname') }}"
                           class="outline text-right px-2 border-1"
                           autofocus
                           placeholder="نام">
                </section>
                <section class="login-input-text">
                    <input type="text" name="lastname" value="{{ old('lastname') }}"
                           class="outline text-right px-2 border-1"
                           placeholder="نام خانوادگی">
                </section>
                <section class="login-input-text">
                    <input type="text" name="national_code" value="{{ old('national_code') }}"
                           class="outline text-right px-2 border-1"
                           placeholder="کد ملی معتبر">
                </section>
                <section class="login-input-text">
                    <input type="text" name="identity" value="{{ old('identity') }}"
                           class="outline text-right px-2 border-1"
                           autofocus
                           placeholder="شماره موبایل">
                </section>



                <section class="login-btn d-grid g-2">
                    <button type="submit" class="btn font-weight-bold text-white custom-btn"
                            onclick="otpCodeSent()"
                            data-url="{{ route('auth.register-send-otp') }}">ارسال کد
                    </button>
                </section>

                <section class="login-terms-and-conditions"><a href="{{ route('auth.register.create') }}">ثبت نام کنید</a> اگر حساب کاربری ندارید
                </section>
            </section>
        </form>

    </section>
@endsection

@section('script')

    <script type="text/javascript">
        function otpCodeSent() {
            const url = $().data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    showToastrMessage(response.message, response.alertType); // Display toast message
                },
                error: function () {
                    console.log(response)
                    showToastrMessage("مشکل از فرانت", "error"); // Display error message
                }
            });
        }
    </script>
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection
