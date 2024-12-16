@extends('admin.layout.master')

@section('head-tag')
    <title>کاربران | ایجاد نقش جدید</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">ایجاد نقش جدید</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید نقش های ادمین <span
                            class="text-success fw-bolder">{{ $admin->fullname }}</span> را مدیریت یا ویرایش کنید.
                    </small>
                </strong>
            </div>
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.user.admin-user.roles-store',$admin->id) }} "
                  id="form"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="roles">نقش ها</label>
                                <select multiple class="form-control form-control-sm"
                                        id="select_roles"
                                        name="roles[]">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                                @foreach ($admin->roles as $user_role) @if($user_role->id === $role->id) selected @endif
                                            @endforeach>{{ $role->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('roles')
                            <span class="alert_required bg-danger text-white p-1 rounded"
                                  role="alert">
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
        var select_roles = $('#select_roles');
        select_roles.select2({
            placeholder: 'لطفا نقش ها را وارد نمایید',
            multiple: true,
            tags: true,
            direction: 'rtl'
        })
    </script>
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

