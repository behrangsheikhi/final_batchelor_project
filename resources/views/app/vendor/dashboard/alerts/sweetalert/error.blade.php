@if(session('swal-error'))

    <script>
       $(document).ready(function (){
           Swal.fire({
               icon: 'error',
               title: 'خطا',
               text: '{{ session('swal-error') }}',
               confirmButtonText : 'بسیار خب'
           });
       });
    </script>

@endif
