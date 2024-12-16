@extends('app.layouts.master.master-sample')
@section('head-tag')
    <style>
        #resend-otp {
            font-size: 1rem;

        }
    </style>
@endsection
@section('content')
    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">

        <form action="{{ route('auth.login-confirm.token',$token) }}" method="post">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
{{--                    <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="logo">--}}
                    <h4 style="font-family: 'mj_yalda'">راسته فرش</h4>

                </section>
                @if($errors->any())
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
                            <li class="alert alert-danger text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <section class="login-title">
                    <a href="{{ route('auth.form') }}" title="بازگشت به صفحه ورود"><i class="fa fa-arrow-right"></i></a>
                    <h2 class="login-title font-weight-bold">کد تایید را وارد کنید</h2>
                </section>
                @php
                    $otp->identity = convertEnglishToPersian($otp->identity);
                @endphp
                <section class="login-title text-muted">
                    <small style="font-size: .7rem">
                        {{ convertEnglishToPersian($otp->type == 'mobile' ? "کد تایید به شماره موبایل $otp->identity ارسال گردید" : "کد تایید به ایمیل $otp->identity ارسال گردید.") }}
                    </small>
                </section>
                <section class="login-input-text">
                    {{-- identity can be email or mobile --}}
                    <input type="text"
                           name="otp"
                           id="otp"
                           class="outline text-center border-1"
                           autocomplete="off"
                           autofocus
                           placeholder="__ __ __ __ __ __">
                </section>

                <section class="login-btn d-grid g-2">
                    <button type="submit" onclick="checkLogin()" data-url="{{ route('auth.login-confirm.token',$token) }}"
                            class="btn font-weight-bold text-white custom-btn">اعتبارسنجی
                    </button>
                </section>
                <section class="d-none login-btn d-grid g-2" id="resend-otp">
                    <a href="{{ route('auth.login-resend-otp', $token) }}" class="text-center font-weight-bold"
                       style="font-weight: 600">
                        <i class="fa fa-paper-plane"></i> ارسال مجدد کد تایید
                    </a>
                </section>

                <section id="timer" class="text-success" style="font-size: 0.75rem;font-weight: 600">

                </section>
            </section>

        </form>

    </section>
@endsection



@section('script')
    @php
        $timer = ((new \Carbon\Carbon($otp->created_at))->addSeconds(120)->timestamp - \Carbon\Carbon::now()->timestamp)*1000; // mili-seconds
    @endphp
    <script type="text/javascript">
        let countDownDate = new Date().getTime() + {{ $timer }};
        let timer = $('#timer');
        let resendOtp = $('#resend-otp');

        let x = setInterval(function () {
            let now = new Date().getTime();
            let distance = countDownDate - now;
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            if (minutes == 0) {
                timerText = '<i class="fas fa-clock-clock"></i> ارسال مجدد کد تائید تا ' + toFarsiNumber(seconds) + ' ثانیه دیگر.';
            } else {
                timerText = '<i class="fas fa-clock"></i> ارسال کد تایید تا ' + toFarsiNumber(minutes) + ' دقیقه و ' + toFarsiNumber(seconds) + ' ثانیه دیگر';
            }
            timer.html(timerText);
            if (distance <= 0) {
                clearInterval(x);
                timer.addClass('d-none')
                resendOtp.removeClass('d-none');
            }

        }, 1000);

        function checkLogin() {
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

        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }

    </script>
@endsection
@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))

@endsection
