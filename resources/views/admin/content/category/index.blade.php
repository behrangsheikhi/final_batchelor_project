@extends('admin.layout.master')

@section('head-tag')
<title>محتوا | دسته بندی ها</title>
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
<div class="content-header text-right">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-sm-6">
                <a role="button" href="{{ route('admin.content.category.create') }}" type="button" class="btn btn-primary btn-sm">ایجاد دسته بندی جدید</a>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                    <li class="breadcrumb-item active">ایجاد دسته بندی</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center" style="border: 1px solid lightgrey; border-radius: 1rem;">
            <i class="fa fa-check-circle text-success"></i>
            <strong class="text-muted mr-1 ml-1">
                <small>
                    در این قسمت می توانید دسته بندی مقالات سایت خود را ایجاد و یا مدیریت کنید.
                    <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل دسته بندی ها
                        : {{ $postCategories->count() != 0 ? $postCategories->count() : 'صفر' }}</strong>
                </small>
            </strong>
        </div>
    </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="example" class="display table table-striped table-bordered table-responsive-md table-hover">
                            <style>
                                th {
                                    text-align: right !important;
                                }
                            </style>
                            <thead>
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                    <th scope="col">شناسه</th>
                                    <th scope="col">نام دسته</th>
                                    <th scope="col">اسلاگ</th>
                                    <th scope="col">تصویر</th>
                                    <th scope="col">تگ ها</th>
                                    <th scope="col">وضعیت</th>
                                    <th class="max-width-16-rem text-left" scope="col">
                                        <i class="fa fa-cogs"></i>
                                        تنظیمات
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($postCategories as $category)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    @if( !isset($category->image) && $category->image == null )
                                    <td class="text-danger font-weight-bold">ندارد</td>
                                    @else
                                    <td>
                                        <img style="width: 50px;height: 50px;" src="{{ asset($category->image['indexArray'][$category->image['currentImage']]) }}" alt="تصویر دسته بندی">
                                    </td>
                                    @endif
                                    <td>{{ $category->tags }}</td>
                                    <td class="">
                                        <label for="status">
                                            <input data-url="{{ route('admin.content.category.status',$category->id) }}" type="checkbox" name="status" id="{{ $category->id }}" onchange="changeStatus('{{ $category->id }}')" {{ $category->status ? 'checked' : '' }}>
                                        </label>
                                    </td>

                                    <td class="text-left">
                                        <form class="d-inline" action="{{ route('admin.content.category.destroy',$category->id) }}" method="post">

                                            @csrf
                                            @method('delete')
                                            <button type="submit" id="delete" class="btn btn-xs btn-danger delete">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                        <a href="{{ route('admin.content.category.edit',$category->id)
                                     }}" class="btn btn-xs btn-primary"><i class="fa
                                    fa-edit"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function changeStatus(id) {
        const url = $("#" + id).data("url"); // Get the URL from the data attribute
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response)
                if (response.status) {
                    $("#" + id).prop("checked", response.checked); // Update checkbox state
                    showToastrMessage(response.message, response.alertType); // Display toast message
                } else {
                    showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                }
            },
            error: function() {
                showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
            }
        });
    }
</script>
@endsection

@section('script')
@php $data = ['className' => "delete"] @endphp
@include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@include('admin.alerts.sweetalert.success')
@include('admin.alerts.sweetalert.error')
@endsection