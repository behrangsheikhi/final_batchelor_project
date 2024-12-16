<script>
    // import * as toastr from "autoprefixer";
    @if (Session::has('message'))
    let type = "{{ Session::get('alert-type', 'info') }}";

    toastr.options = {
        closeButton: true,
        debug: true,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-top-full-width",
        preventDuplicates: false,
        onclick: null,
        showDuration: "6000",
        hideDuration: "1000",
        timeOut: "50000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    export default toastr;

    switch (type) {
        case 'info':

            toastr.options.timeOut = 10000;
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':

            toastr.options.timeOut = 10000;
            toastr.options.positionClass = "toast-top-left";
            toastr.success("{{ Session::get('message') }}");

            break;
        case 'warning':

            toastr.options.timeOut = 10000;
            toastr.warning("{{ Session::get('message') }}");

            break;
        case 'error':

            toastr.options.timeOut = 10000;
            toastr.error("{{ Session::get('message') }}");

            break;
    }
    @endif
</script>
