@extends('admin.layout.master')

@section('head-tag')
    <title>کاربران | سطوح دسترسی</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">سطوح دسترسی</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید سطوح دسترسی ادمین <span
                            class="text-success fw-bolder">{{ $admin->fullname }}</span> را مدیریت یا ویرایش کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.user.admin-user.permissions-store',$admin->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="permissions">سطوح دسترسی
                                    <span class="text-danger">*</span>
                                </label>
                                <select multiple class="form-control form-control-sm" id="select_permissions"
                                        name="permissions[]">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}"
                                                @foreach ($admin->permissions as $user_permission) @if($user_permission->id === $permission->id) selected @endif
                                            @endforeach>{{ $permission->description }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('permissions')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
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

    <script type="text/javascript">
        var select_permissions = $('#select_permissions');
        select_permissions.select2({
            placeholder: 'لطفا سطوح دسترسی را وارد نمایید',
            multiple: true,
            tags: true,
            direction: 'rtl'
        })
    </script>
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

