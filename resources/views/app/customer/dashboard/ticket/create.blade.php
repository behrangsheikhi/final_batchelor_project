@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>محتوا | ایجاد تیکت جدید</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            {{-- breadcrumb --}}

            {{-- breadcrumb --}}

            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        <i class="fa fa-info-circle text-danger"></i>
                        کاربر گرامی، لطفا قبل از ایجاد تیکت بخش سوالات متعدد را مشاهده کرده و در صورت نیافتن پاسخ خود از
                        طریق تیکت با ما در ارتباط باشید.
                        <br>
                        با تشکر
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('customer.dashboard.customer-ticket.store') }}"
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="subject" class="text-sm text-muted">موضوع </label>
                                <input type="text"
                                       name="subject"
                                       autofocus
                                       class="form-control"
                                       id="subject"
                                       placeholder="در اینجا بنویسید..."
                                       value="{{ old('subject') }}">
                            </div>

                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label class="text-sm text-muted" for="file">پیوست فایل</label>
                                <input type="file" name="file"
                                       class="custom-file-input form-control form-control-sm" id="file">
                            </div>
                        </section>

                    </div>
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="ticket_category_id" class="text-sm text-muted">دسته بندی تیکت</label>
                                <select name="ticket_category_id" id="ticket_category_id"
                                        class="form-control form-group-sm">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if(old('ticket_category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="ticket_priority_id" class="text-sm text-muted">درجه اهمیت تیکت</label>
                                <select name="ticket_priority_id" id="ticket_priority_id"
                                        class="form-control form-group-sm">
                                    @foreach($priorities as $priority)
                                        <option value="{{ $priority->id }}"
                                                @if(old('ticket_priority_id') == $priority->id) selected @endif>{{ $priority->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('ticket_priority_id')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                    </div>

                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="description" class="text-sm
                                    text-muted">توضیحات</label>

                            <textarea cols="60"
                                      rows="8"
                                      class="form-control form-control-sm"
                                      name="description"
                                      id="description"
                                      placeholder="در اینجا بنویسید...">{{ old('description') }}</textarea>
                        </div>

                    </section>


                    <section class="">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-save"></i> ذخیره
                        </button>
                    </section>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

