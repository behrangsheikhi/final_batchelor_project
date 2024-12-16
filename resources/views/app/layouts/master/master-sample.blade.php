<!doctype html>
<html lang="en">
<head>
    @include('app.layouts.head-tag')
    @yield('head-tag')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
</head>
<body>
<main id="main-body-one-col" class="main-body">
    @yield('content')
</main>

@include('app.layouts.script')
@yield('script')


@include('admin.alerts.sweetalert.success')
@include('admin.alerts.sweetalert.error')
@include('admin.alerts.sweetalert.delete-confirm')
@include('admin.alerts.toast.index')

<script type="text/javascript">
    function showToastrMessage(message, type) {
        toastr.options.timeOut = 5000;
        toastr.options.positionClass = "toast-top-left";
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

    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

    // Use the JavaScript variable to show welcome toast
    if (welcomeToast) {
        showToastrMessage(welcomeToast.message, welcomeToast.type);
    }
</script>
</body>
</html>
