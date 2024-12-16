@extends('admin.layout.master')

@section('head-tag')
    <title>محتوا | مقالات</title>
@endsection

@section('content')

    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-6">


                    <a role="button" href="{{ route('admin.content.post.create') }}" type="button"
                       class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>
                        ایجاد مقاله جدید
                    </a>


                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">مقالات</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید مقالات سایت خود را ایجاد و یا مدیریت کنید.
                        <br><strong class="text-success mt-2" style="margin-right: auto">تعداد کل مقالات
                            : {{ $posts->count() != 0 ? $posts->count() : 'صفر' }}</strong>
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
                            <table id="example"
                                   class="display table table-striped table-bordered table-responsive-md table-hover"
                                   style="width:100%">
                                <thead>
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem">
                                    <th scope="col">شناسه</th>
                                    <th scope="col">عنوان مقاله</th>
                                    <th scope="col">دسته بندی</th>
                                    <th scope="col">خلاصه</th>
                                    <th scope="col">تصویر</th>
                                    <th scope="col">تگ ها</th>
                                    <th scope="col">وضعیت</th>
                                    <th scope="col">قابلیت نظردهی</th>
                                    {{--                                <th scope="col">زمان انتشار</th>--}}
                                    @can('update-post', $posts)
                                        <th class="max-width-16-rem text-left" scope="col">
                                            <i class="fa fa-cogs"></i>
                                            تنظیمات
                                        </th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $loop->iteration }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td title="{{ $post->description }}">{{ \Illuminate\Support\Str::limit($post->description,50) }}</td>
                                        @if( !isset($post->image) && $post->image == null )
                                            <td class="text-danger font-weight-bold">ندارد</td>
                                        @else
                                            <td>
                                                <img style="width: 50px;height: 50px;"
                                                     src="{{ asset($post->image['indexArray'][$post->image['currentImage']]) }}"
                                                     alt="تصویر دسته بندی">
                                            </td>
                                        @endif
                                        <td>{{ $post->tags }}</td>
                                        <td class="">
                                            <label for="status">
                                                <input
                                                    data-url="{{ route('admin.content.post.status', $post->id) }}"
                                                    type="checkbox"
                                                    name="status"
                                                    id="status-{{ $post->id }}"
                                                    onchange="changeStatus('{{ $post->id }}')"
                                                    {{ $post->status ? 'checked' : '' }}
                                                >
                                            </label>
                                        </td>
                                        <td class="">
                                            <label for="commentable">
                                                <input
                                                    data-url="{{ route('admin.content.post.commentable', $post->id) }}"
                                                    type="checkbox"
                                                    name="commentable"
                                                    id="commentable-{{ $post->id }}"
                                                    onchange="changeCommentable('{{ $post->id }}')"
                                                    {{ $post->commentable ? 'checked' : '' }}
                                                >
                                            </label>
                                        </td>

                                        {{--                                    <td>--}}
                                        {{--                                        {{ jalaliDate($post->published_at,'Y/m/d') }}--}}
                                        {{--                                    </td>--}}

                                        @can('update-post',$post)
                                            <td class="text-center">
                                                <form class="d-inline"
                                                      action="{{ route('admin.content.post.destroy',$post->id) }}"
                                                      method="post">

                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                            id="delete"
                                                            class="btn btn-danger btn-xs delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                </form>
                                                <a href="{{ route('admin.content.post.edit',$post->id)}}"
                                                   class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>

                                        @endcan
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
            const url = $("#status-" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        $("#status-" + id).prop("checked", response.checked); // Update checkbox state
                        showToastrMessage(response.message, response.alertType); // Display toast message
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                    }
                },
                error: function () {
                    showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                }
            });
        }

        function changeCommentable(id) {
            const url = $("#commentable-" + id).data("url"); // Get the URL from the data attribute
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        $("#commentable-" + id).prop("checked", response.checked); // Update checkbox state
                        showToastrMessage(response.message, response.alertType); // Display toast message
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                    }
                },
                error: function () {
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

