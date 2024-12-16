@if(session('alert-section-error'))


    <div role="alert" class="alert alert-error alert-dismissible fade show">
        <h4 class="alert-heading">&times; خطا </h4>
        <hr>
        <p class="mb-0 font-bold">
            {{ session('alert-section-error') }}
        </p>

        <button class="close" type="button" data-dismiss="alert" aria-label="close" style="right: auto !important;left: 0 !important;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>


@endif
