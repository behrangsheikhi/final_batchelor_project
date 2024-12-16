@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | نظرات پست ها</title>

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-right mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item active">لیست نظرات</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید نظرات ایجاد شده در بخش فروشگاه سایت خود را مشاهده و یا مدیریت کنید.
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
                                <style>
                                    th {
                                        text-align: right !important;
                                    }
                                </style>
                                <thead>
                                <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                                    <th scope="col">شناسه</th>
                                    <th scope="col">نظر</th>
                                    <th scope="col">وضعیت پاسخ</th>
                                    <th scope="col">نویسنده</th>
                                    <th scope="col">محصول/مقاله</th>
                                    <th scope="col">تاریخ</th>
                                    <th scope="col">وضعیت</th>
                                    <th class="max-width-16-rem text-left" scope="col">
                                        <i class="fa fa-check-circle"></i>
                                        وضعیت
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($comments as $comment)
                                    <tr role="row" class="odd">
                                        <td class="sorting_1">{{ $loop->iteration }}</td>
                                        <td title="{{ strip_tags($comment->body) }}">{{ strip_tags(html_entity_decode(\Illuminate\Support\Str::limit($comment->body,50))) }}</td>
                                        <td class="text-{{ $comment->children->count() > 0 ? 'success' : 'danger' }}">
                                            <i class="fa fa-lg fa-{{ $comment->children->count() > 0 ? 'check-circle' : 'times-circle' }}"></i>
                                        </td>
                                        <td>{{ $comment->author->fullname ?? 'کاربر مهمان' }}</td>
                                        @if($comment->commentable_type == \App\Constants\CommentTypeValue::PRODUCT_COMMENT)
                                            <td title="مشاهده صفحه محصول">
                                                <a href="{{ route('admin.market.product.show',$comment->commentable_id) }}">{{ $comment->commentable->name ?? '-' }}</a>
                                            </td>
                                        @elseif($comment->commentable_type == \App\Constants\CommentTypeValue::CONTENT_COMMENT)
                                            <td title="مشاهده صفحه پست">
                                                <a href="{{ route('admin.content.post.show',$comment->commentable_id) }}">{{ $comment->commentable->title ?? '-' }}</a>
                                            </td>
                                        @endif
                                        <td>{{ persianDateTime($comment->created_at) }}</td>
                                        <td class="">
                                            <label for="status">
                                                <input
                                                    data-url="{{ route('admin.comment.status',$comment->id) }}"
                                                    type="checkbox"
                                                    name="status"
                                                    id="{{ $comment->id }}"
                                                    onchange="changeStatus('{{ $comment->id }}')"
                                                    {{ $comment->status ? 'checked' : '' }}
                                                >
                                            </label>
                                        </td>
                                        <td class="d-flex flex-row justify-content-end">

                                            <a href="{{ route('admin.comment.show',$comment->id) }}"
                                               class="btn btn-xs btn-{{ $comment->children->count() == 0 ? 'info' : 'success' }}"><i class="fa fa-eye"></i>
                                            @if($comment->children->count() == 0)
                                                پاسخ
                                            @else
                                                مشاهده
                                            @endif
                                            </a>
                                            @if($comment->approved == \App\Constants\CommentApproveValue::APPROVED)
                                                <a href="#"
                                                   data-url="{{ route('admin.comment.approve', $comment->id) }}"
                                                   id="approve_{{ $comment->id }}"
                                                   class="btn btn-warning btn-xs text-sm mx-1 text-white"
                                                   onclick="changeApprove('{{ $comment->id }}')">
                                                    <i class="fa fa-clock"></i> عدم تایید
                                                </a>
                                            @else
                                                <a href="#"
                                                   data-url="{{ route('admin.comment.approve', $comment->id) }}"
                                                   id="approve_{{ $comment->id }}"
                                                   class="btn btn-success btn-xs text-sm mx-1 text-white"
                                                   onclick="changeApprove('{{ $comment->id }}')">
                                                    <i class="fa fa-check-circle"></i> تایید
                                                </a>
                                            @endif
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
                success: function (response) {
                    if (response.status) {
                        $("#" + id).prop("checked", response.checked);
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

        function changeApprove(id) {
            event.preventDefault();
            const url = $("#approve_" + id).data("url");
            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.status) {
                        const button = $("#approve_" + id); // Get the button element
                        if (response.checked === 0) {
                            button.toggleClass("btn-success");
                        }
                        button.toggleClass("btn-warning"); // Toggle button classes
                        button.text((response.buttonText === "عدم تایید") ? " تایید" : "عدم تایید");

                        showToastrMessage(response.message, response.alertType);
                    } else {
                        showToastrMessage("مشکلی پیش آمده است.", "error");
                    }
                },
                error: function () {
                    showToastrMessage("مشکلی پیش آمده است.", "error");
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

