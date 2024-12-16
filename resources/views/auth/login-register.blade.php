@extends('app.layouts.master.master-sample')

@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">

        <form action="{{ route('auth.auth') }}" method="post">
            @csrf

            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    {{--                    <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="logo">--}}
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
                    <small class="login-info text-muted">جهت ادامه شماره موبایل خود را وارد کنید.</small>
                </section>
                <section class="login-input-text">
                    {{-- identity can be email or mobile --}}
                    <input type="text" name="identity" value="{{ old('identity') }}"
                           class="outline text-center border-1"
                           autofocus
                           placeholder="شماره موبایل یا ایمیل...">
                </section>

                <section class="login-btn d-grid g-2">
                    <button type="submit" class="btn font-weight-bold text-white custom-btn"
                            onclick="otpCodeSent()"
                            data-url="{{ route('auth.auth') }}">ورود
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
