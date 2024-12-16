@extends('admin.layout.master')

@section('head-tag')
    <title>مدیریت سطوح دسترسی | ویرایش نقش ها</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user.role.index') }}">نقش ها</a></li>
                        <li class="breadcrumb-item active">ویرایش</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        شما در حال ویرایش دسترسی های نقش <span
                            class="text-success font-weight-bold">{{ $role->name }}</span> هستید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.user.role.permissionUpdate',$role->id) }}"
                  method="post"
                  id="form">
                @csrf
                @method('put')

                <div class="row">
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="name"
                                   class="text-sm text-muted">عنوان نقش</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   disabled
                                   class="form-control form-control-sm"
                                   value="{{ $role->name }}">
                        </div>
                    </section>
                    <section class="col-12 col-md-6 mb-4">
                        <div class="form-group">
                            <label for="status"
                                   class="text-sm text-muted">وضعیت نقش</label>
                            <select name="status"
                                    id="status"
                                    disabled
                                    class="form-control form-group-sm">
                                <option value="1" @if($role->status === 1) selected @endif>فعال</option>
                                <option value="0" @if($role->status === 0) selected @endif>غیر فعال</option>
                            </select>
                        </div>

                    </section>
                    <section class="col-12 mb-4">
                        <div class="form-group">
                            <label for="description" class="text-sm text-muted">توضیح نقش</label>
                            <input type="text"
                                   id="description"
                                   name="description"
                                   disabled
                                   class="form-control form-control-sm"
                                   value="{{ $role->description }}">
                        </div>
                    </section>
                </div>

                <section class="col-12 mb-4">
                    <section class="row border-top mt-3 py-3">
                        @php
                            $rolePermissionsArray = $role->permissions->pluck('id')->toArray(); // Retrieve permission IDs associated with the role
                        @endphp

                        @if($permissions->count() > 0)
                            @foreach($permissions as $key => $permission)
                                <section class="col-md-3 mb-4">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               name="permissions[]"
                                               id="{{ $permission->id }}"
                                               value="{{ $permission->id }}"
                                               @if(in_array($permission->id, $rolePermissionsArray)) checked @endif //
                                        Check if the permission is associated with the role
                                        >
                                        <label for="{{ $permission->id }}"
                                               class="form-check-label mr-3 mt-1">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @error('permission'.'.'.$key)
                                    <span class="text-sm custom-alert p-2 mb-4 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                            @endforeach
                        @else
                            <span class="text-danger font-weight-bold my-4">
                                <i class="fa fa-window-close"></i>
                                هیچ نوع سطح دسترسی (مجوز) ثبت یا فعال نشده است. لطفا ابتدا از بخش سطوح دسترسی، آیتم های مورد نظر را اضافه یا فعال نموده و سپس امتحان کنید.
                                <small>
                                    <a class="btn btn-info btn-sm my-4"
                                       href="{{ route('admin.user.permission.index') }}">رفتن به صفحه مورد نظر</a>
                                </small>
                            </span>
                        @endif

                    </section>
                </section>

                <section class="col-12">
                    <button class="btn btn-primary btn-block text-sm font-weight-bold">اعمال تغییرات نقش ها</button>
                </section>
            </form>
        </div>
    </section>
@endsection


@section('script')

    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

