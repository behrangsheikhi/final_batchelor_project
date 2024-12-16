<!doctype html>
<html lang="en">
<head>
    @include('app.vendor.dashboard.layout.head-tag')
    @yield('head-tag')

    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            /*overflow-x: hidden;*/
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0,
            'wght' 400,
            'GRAD' 0,
            'opsz' 24
        }

    </style>
</head>
{{-- TODO : Add fixed to body class to fix the sidebar if needed --}}
<body class="sidebar-mini rtl skin-black wysihtml5-supported" style="height: auto; min-height: 100%;">
<div class="wrapper" style="height: auto; min-height: 100%;">

    @include('app.vendor.dashboard.layout.header')
    @include('app.vendor.dashboard.layout.sidebar')
    <div class="content-wrapper" style="height: 2072.58px;">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->


</div>

{{--@include('admin.layout.control-sidebar')--}}
<!-- ./wrapper -->


@include('admin.layout.scripts')
@yield('script')

@include('admin.alerts.sweetalert.success')
@include('admin.alerts.sweetalert.error')
@include('admin.alerts.sweetalert.delete-confirm')
@include('admin.alerts.toast.index')

<script>
    $(document).ready(function (){
        new DataTable('#example', {
            info: false,
            ordering: false,
            paging: true,
            pagingType: 'full_numbers'
        });
    });

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
</script>
</body>
</html>
