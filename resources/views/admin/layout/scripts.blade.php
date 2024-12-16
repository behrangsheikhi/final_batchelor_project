<script src="{{ asset('admin-asset/vendor_components/jquery-3.3.1/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/jquery-ui/jquery-ui.js') }}"></script>
{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>--}}
<script src="{{ asset('admin-asset/vendor_components/toastr/js/toastr.min.js') }}"></script>
{{--<script src="{{ asset('admin-asset/vendor_components/jquery-toast-plugin-master/dist/jquery.toast.min.js') }}"></script>--}}

<script>
$.widget.bridge("uibutton", $.ui.button);
</script>
<script src="{{ asset('admin-asset/vendor_components/popper/dist/popper.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.all.min.js"></script>
{{--<link rel="stylesheet" href="{{ asset('admin-asset/vendor_components/sweetalert/sweetalert.css') }}">--}}
<script src="{{ asset('admin-asset/vendor_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/echarts/dist/echarts-en.min.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/echarts/echarts-liquidfill.min.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_components/raphael/raphael.min.js') }}"></script>
{{--<script src="{{ asset('admin-asset/vendor_components/morris.js/morris.min.js') }}"></script>--}}
<script src="{{ asset('admin-asset/js/template.js') }}"></script>
{{--<script src="{{ asset('admin-asset/js/pages/dashboard2.js') }}"></script>--}}
{{--<script src="{{ asset('admin-asset/js/demo.js') }}"></script>--}}
{{--<script src="{{ asset('admin-asset/vendor_components/datatables/datatables.min.js') }}"></script>--}}
<script src="{{ asset('admin-asset/vendor_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-asset/vendor_plugins/JqueryPrintArea/demo/jquery.PrintArea.js') }}"></script>
<script src="{{ asset('admin-asset/js/pages/invoice.js') }}"></script>
<script type="text/javascript">
    let notificationDropDown = document.getElementById('dropdown-toggle');
    notificationDropDown.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default behavior of the link

        let path = "{{ route('admin.notification.read-all') }}";
        $.ajax({
            type: "POST",
            url: path,
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                // Update the badge content after clearing notifications
                let notificationBadge = document.getElementById('notification-badge');
                if (notificationBadge) {
                    notificationBadge.innerText = ''; // Update the badge content to '0'
                    notificationBadge.classList.remove('badge','badge-sm','badge-pill','badge-danger'); // Remove the 'badge-danger' class
                }
            }
        });
    });


</script>
{{--<script src="{{ asset('admin-asset/js/pages/dashboard4.js') }}"></script>--}}
{{--<script src="{{ asset('admin-asset/js/demo.js') }}"></script>--}}
{{--<script src="{{ asset('admin-asset/js/template.js') }}"></script>--}}
{{--<script src="{{ asset('admin-asset/vendor_components/persianDatePicker/js/persian-date.min.js') }}"></script>--}}

