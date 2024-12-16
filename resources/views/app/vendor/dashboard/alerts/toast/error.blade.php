@if(session('toast-error'))
    <section class="toast" data-delay="5000">
        <section class="toast-body d-flex py-3 bg-danger text-white">
            <strong class="ml-auto">
                {{ session('toast-error') }}
            </strong>
            <button class="mr-2 mb-1 close" role="button" data-dismiss="toast" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </section>
    </section>
    <script>
        $(document).ready(function () {
            $('.toast').toast('show');
        });
    </script>

@endif
