@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | ویرایش اولویت بندی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ticket.category.index') }}">اولویت بندی تیکت</a></li>
                        <li class="breadcrumb-item active">ویرایش اولویت بندی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <small class="text-muted mr-1 ml-1">
                    شما در حال ویرایش اولویت <span class="text-success font-weight-bold">{{ $priority->name }}</span> هستید.
                </small>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.ticket.priority.update',$priority->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">عنوان اولویت بندی</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       id="name"
                                       value="{{ old('name',$priority->name) }}">
                            </div>
                            @error('name')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status" class="text-sm text-muted">وضعیت اولویت بندی</label>
                                <select name="status" id="status" class="form-control form-control-sm">
                                    <option value="1" @if(old('status',$priority->status) == 1) selected @endif>فعال</option>
                                    <option value="0" @if(!old('status',$priority->status)) selected @endif>غیر فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="alert_required text-danger" role="alert">
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

