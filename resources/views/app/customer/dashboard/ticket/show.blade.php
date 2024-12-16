@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>پنل کاربری | تیکت | نمایش</title>
@endsection


@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">

                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تاریخچه تیکت </span>
                            </h2>

                            <section class="content-header-link m-2">
                                <a href="{{ route('customer.dashboard.ticket-customer') }}"
                                   class="btn btn-sm btn-danger text-white fw-bolder"> بازگشت
                                </a>
                            </section>
                        </section>
                        @if($ticket->status === 0)
                            <section class="fw-bolder bg-warning my-4 p-4 rounded text-xs">
                                <i class="fa fa-info-circle"></i>
                                این تیکت قبلا توسط ادمین بسته شده است. در صورت داشتن هر گونه سوال و یا مشکل ابتدا بخش سوالات متداول را مطالعه نموده و در صورت نیاز از
                                <a href="{{ route('customer.dashboard.customer-ticket.create') }}">این</a> قسمت تیکت جدید ایجاد کنید.
                            </section>
                        @endif

                    </section>
                    <!-- end vontent header -->
                    <section class="order-wrapper">

                        <section class="card mb-3">

                            <section class="card-header bg-gray-50 d-flex justify-content-between fw-bolder">
                                <div>{{ $ticket->user->fullname }}</div>
                                <small>{{ convertEnglishToPersian(persianDateTime($ticket->created_at)) }}</small>
                            </section>
                            <section class="card-body">
                                <h6 class="card-title">
                                    <span class="fw-bolder">موضوع :</span>
                                    {{ $ticket->subject }}
                                </h6>
                                <p class="card-text">
                                    {{ $ticket->description }}
                                </p>
                            </section>
                            @if($ticket->file()->count() > 0)
                                <section class="card-footer">
                                    <a class="btn btn-success" href="{{ asset($ticket->file->file_path) }}"
                                       download>دانلود
                                        ضمیمه</a>
                                </section>
                            @endif

                        </section>


                        <hr>

                        <div class="border my-2">
                            @foreach ($ticket->children as $child)

                                <section class="card m-4">
                                    <section class="card-header bg-gray d-flex justify-content-between fw-bolder">
                                        <div> {{ $child->user->fulllname }} <i class="fa fa-info-circle"></i> پاسخ دهنده
                                            :
                                            {{ $child->admin ? $child->admin->user->fullname : 'مدیر' }}</div>
                                        <small>{{ convertEnglishToPersian(persianDateTime($child->created_at)) }}</small>
                                    </section>
                                    <section class="card-body">
                                        <p class="card-text fw-bolder">
                                            {{ strip_tags(convertEnglishToPersian($child->description)) }}
                                        </p>
                                    </section>
                                </section>
                            @endforeach

                        </div>


                        @if($ticket->children->isNotEmpty())
                            <section class="my-3">
                                <form action="{{ route('customer.dashboard.customer-ticket.answer', $ticket->id) }}"
                                      method="post">
                                    @csrf
                                    @if($ticket->status !== 0)
                                        <section class="row">
                                            <section class="col-12">
                                                <div class="form-group">
                                                    <label for="description" class="my-2 text-sm text-muted">پاسخ
                                                        تیکت </label>
                                                    <textarea class="form-control form-control-sm"
                                                              id="description"
                                                              rows="4"
                                                              placeholder="در اینجا بنویسید..."
                                                              autofocus
                                                              name="description">{{ old('description') }}</textarea>
                                                </div>
                                            </section>
                                            <section class="col-12 my-3">
                                                <button class="btn btn-primary btn-sm">ثبت</button>
                                            </section>
                                        </section>
                                    @endif

                                </form>
                            </section>

                        @else

                            <section class="fw-bolder bg-warning my-4 p-4 rounded">
                                <i class="fa fa-info-circle"></i>
                                در انتظار پاسخ توسط ادمین
                            </section>
                        @endif


                    </section>


                </section>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection


@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
