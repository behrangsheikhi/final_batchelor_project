@if(session('alert-section-success'))


    <div role="alert" class="alert alert-success alert-dismissible fade show">
        <div class="row">
            <button class="close" type="button" data-dismiss="alert" aria-label="close" style="left: auto !important;right: 0 !important;">
                <span aria-hidden="true">&times;</span>
            </button>
            <p class="mb-0 font-bold">
                {{ session('alert-section-success') }}
            </p>
        </div>
    </div>


@endif
