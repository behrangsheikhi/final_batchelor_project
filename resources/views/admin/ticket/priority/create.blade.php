@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | ایجاد اولویت بندی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ticket.category.index') }}">اولویت بندی تیکت</a></li>
                        <li class="breadcrumb-item active">ایجاد اولویت بندی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <small class="text-muted mr-1 ml-1">
                    در این قسمت می توانید اولویت برای تیک های خود ایجاد کنید.
                </small>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.ticket.priority.store') }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">عنوان اولویت بندی</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       id="name"
                                       placeholder="نام اولویت بندی تیکت را اینجا بنویسید..."
                                       value="{{ old('name') }}">
                            </div>
                            @error('name')
                            <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 mb-4">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت اولویت بندی</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status')) selected @endif>غیر فعال</option>
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

