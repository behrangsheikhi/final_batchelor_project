@if(session('swal-success'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: 'عملیات با موفقیت انجام شد',
                text: '{{ session('swal-success') }}',
                icon: 'success',
                confirmButtonText : 'بسیار خب'
            });
        });
    </script>

@endif
