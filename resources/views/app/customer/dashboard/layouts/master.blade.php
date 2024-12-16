<!doctype html>
<html lang="en">
<head>
    @include('app.layouts.head-tag')
    @yield('head-tag')
    <title>پنل مشتری</title>
</head>
<body>
@include('app.layouts.header')

<section class="">

    <section id="main-body-two-col" class="container-xxl body-container">
        {{-- show errors --}}
        @if(session('error'))
            <div id="alert-danger" class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div id="alert-success" class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li class="alert alert-danger">{{ $error }}</li>
                @endforeach
            </ul>

        @endif
        {{-- show errors --}}
        <section class="row">
            @include('app.customer.dashboard.layouts.sidebar')

            <main id="main-body" class="main-body col-md-9">
                @yield('content')
            </main>

        </section>
    </section>
</section>


@include('app.layouts.footer')
@include('app.layouts.script')
@yield('script')

@include('admin.alerts.sweetalert.success')
@include('admin.alerts.sweetalert.error')
@include('admin.alerts.sweetalert.delete-confirm')
@include('admin.alerts.toast.index')


<script type="text/javascript">
    function showToastrMessage(message, type) {
        toastr.options.timeOut = 5000;
        toastr.options.positionClass = "toast-top-right";
        toastr.options.progressBar = true;
        switch (type) {
            case "success":
                toastr.success(message);
                break;
            case "error":
                toastr.error(message);
                break;
            case "warning":
                toastr.warning(message);
                break;
            default:
                toastr.info(message);
        }
    }
</script>
</body>
</html>
