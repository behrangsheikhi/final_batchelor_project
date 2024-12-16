@extends('admin.layout.master')

@section('head-tag')
    <title>اطلاعیه ها | ویرایش پیامک</title>
    <link rel="stylesheet" href="{{ asset('admin-asset/datepicker/persian-datepicker.min.css') }}">

@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notify.sms.index') }}">اطلاعیه پیامکی</a></li>
                        <li class="breadcrumb-item active">ویرایش اطلاعیه پیامکی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش اطلاعیه پیامکی با عنوان <span class="text-success font-weight-bold">{{ $message->title }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.notify.sms.update',$message->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="title" class="text-sm text-muted">عنوان</label>
                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       id="title"
                                       value="{{ old('title',$message->title) }}">
                            </div>
                            @error('title')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="published_at_view" class="text-sm text-muted">تاریخ انتشار</label>
                                <input type="hidden"
                                       class="form-control form-control-sm d-none"
                                       name="published_at"
                                       id="published_at"
                                       value="{{ old('published_at',$message->published_at) }}">
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    id="published_at_view"
                                >
                            </div>
                            @error('published_at')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                            @enderror
                        </section>

                    </div>
                    <div class="row">

                        <section class="col-12 mb-4">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت </label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status',$message->status) == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status',$message->status)) selected @endif>غیر فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                </div>
                <section class="col-12 mb-4">
                    <div class="form-group">
                        <label for="body" class="text-sm
                                    text-muted">متن اطلاعیه پیامکی</label>

                        <textarea cols="60"
                                  rows="4"
                                  class="form-control form-control-sm"
                                  name="body" id="body">{{ old('body',$message->body) }}</textarea>
                    </div>
                    @error('body')
                    <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                    @enderror
                </section>

                <section class="">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-save"></i> ذخیره
                    </button>
                </section>
            </form>
        </div>
    </section>
@endsection


@section('script')
    <script src="{{ asset('admin-asset/datepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-asset/datepicker/persian-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin-asset/vendor_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at',
                cellHeight : 30,
                cellWidth : 30,
                fontSize : 10,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                }
            })
        });
    </script>


    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

