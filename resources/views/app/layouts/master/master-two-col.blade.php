<!doctype html>
<html lang="en">
<head>
    @include('app.layouts.head-tag')
    @yield('head-tag')
</head>
<body>
@include('app.layouts.header')
<section class="container-xxl body-container">
    @yield('app.layouts.sidebar')
</section>
<main id="main-body-two-col" class="main-body">
    @yield('content')
</main>

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
