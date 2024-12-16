@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | نظرات | مشاهده نظر</title>

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-right mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.comment.index') }}">نظرات</a>
                        </li>
                        <li class="breadcrumb-item active">مشاهده</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت می توانید نظر مربوط به کالای <span class="text-success font-weight-bold">{{ $comment->commentable->name }}</span> را مشاهده و مدیریت کنید..
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
                        <section class="card mb-3">

                            <section class="card-body">
                                <div class="row mb-4 justify-content-between">
                                    <span class="d-flex">
                                       <p class="text-primary text-sm mr-3"> نام کالا : </p>
                                        <p class="font-weight-bold">{{ $comment->commentable->name ?? '-' }}</p>
                                    </span>
                                    <span class="text-muted text-sm">
                                        تاریخ :
                                        {{ persianDate($comment->created_at) }}
                                    </span>
                                </div>

                                <p class="font-weight-bold text-muted">
                                    <span class="text-info text-decoration-underline">
                                        {{ $comment->author->fullname }}
                                    </span> گفت :
                                </p>
                                <p style="border: 1px solid lightgrey;padding: 1rem 0.75rem;border-radius: 1rem;">
                                    {{ strip_tags(html_entity_decode($comment->body)) }}
                                </p>
                            </section>
                        </section>

                        <section
                            class="mt-4 mb-1 card-header text-center font-weight-bold">
                            تاریخچه نظر های کاربر به این کالا:
                        </section>
                        <div class="box direct-chat direct-chat-info" id="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">{{ $comment->commentable->name ?? '-' }}</h4>
                                <ul class="box-controls pull-right">
                                    {{--                <li><a class="box-btn-close" href="#"></a></li>--}}
                                    {{--                <li><a class="box-btn-slide" href="#"></a></li>--}}
                                    {{--                <li><a class="box-btn-fullscreen" href="#"></a></li>--}}
                                    {{--                <li><a class="" data-toggle="tooltip" title="" data-widget="chat-pane-toggle"--}}
                                    {{--                       data-original-title="Contacts"><i class="fa fa-comments"></i></a></li>--}}
                                    <li>
                                        <span class="text-muted text-sm">تعداد پاسخ به این نظر طی 24 ساعت گذشته :</span>
                                        <span data-toggle="tooltip" title="" class="badge badge-pill badge-info"
                                              data-original-title="1 New Messages">
                        @php
                            $currentDateTime = \Carbon\Carbon::now();
                            $twentyFourHoursAgo = $currentDateTime->subHour(24);
                            $latestRepliesCount = $comment->children()->where('created_at', '>=', $twentyFourHoursAgo)->count();
                        @endphp
                                            {{ $latestRepliesCount }}
                    </span>
                                    </li>

                                </ul>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <!-- Conversations are loaded here -->
                                <div class="slimScrollDiv"
                                     style="position: relative; overflow: hidden; width: auto; height: 310px;">
                                    <div class="direct-chat-messages"
                                         style="width: auto; height: 310px;">
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg mb-30">
                                            <div class="clearfix mb-15">
                                                <span
                                                    class="direct-chat-name">{{ $comment->author->fullname ?? '-' }}</span>
                                                {{-- <span class="direct-chat-timestamp pull-right">{{ jalaliDate($comment->created_at) }}</span>--}}
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img class="direct-chat-img avatar"
                                                 src="{{ asset('admin-asset/images/user1-128x128.jpg') }}"
                                                 alt="message user image">
                                            <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                <p>{{ strip_tags(html_entity_decode($comment->body)) }}</p>
                                                <p class="direct-chat-timestamp">
                                                    <time datetime="2018">{{ persianDate($comment->created_at) }}</time>
                                                </p>
                                            </div>
                                        </div>

                                        @if($comment->children)
                                            @foreach($comment->children as $reply)
                                                @include('admin.market.comment._reply_partial')
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="comment-reply-section" id="comment-reply-section">
                            @include('admin.market.comment.market_comment_partial',['comment' => $comment])
                            @yield('comment')
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script type="text/javascript">
    // Function to scroll to the last replies when opening a comment
    // TODO : fix scroll to bottom of the chat box after submitting the reply
    function scrollToLastReplies() {
        let repliesBox = $('#comment-replies-section'); // Adjust this selector to your replies container
        repliesBox.scrollPageDown(repliesBox[0].scrollHeight);
    }
</script>

<script type="text/javascript">
    function addComment(event) {
        event.preventDefault();
        let formData = $('#reply-form').serialize();
        let url = "{{ route('admin.market.comment.reply-to-comment',$comment->id ?? "") }}";
        $.ajax({
            url: url,
            data: formData,
            dataType: "json",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('hello')
                if (response.status) {
                    $('.direct-chat-messages').append(response.commentHtml);
                    $('#body').val('');
                    updateCommentBox();
                    showToastrMessage(response.message, response.alertType); // Display toast message
                } else {
                    showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message
                }
            },
            error: function () {
                showToastrMessage("مشکلی پیش آمده است.", "error"); // Display error message

            }
        });

        function updateCommentBox() {
            // Get the input value for the comment body
            const newCommentBody = $('#body').val().trim();

            // Create a dummy timestamp for the current time
            const currentTimeStamp = new Date().toLocaleString();

            // Check if the new comment body is not empty
            if (newCommentBody !== '') {
                // Manually create the HTML structure for the new comment reply
                let newCommentHTML = `
                    <div class="direct-chat-msg right mb-30">
                        <div class="clearfix mb-15">
                            <span class="direct-chat-name pull-right">Your Name</span>
                        </div>
                        <div class="direct-chat-text">
                            <p>${newCommentBody}</p>
                            <p class="direct-chat-timestamp">
                                <time datetime="${currentTimeStamp}">${currentTimeStamp}</time>
                            </p>
                        </div>
                    </div>
        `;
                // Append the new comment reply HTML to the chat box
                $('.direct-chat-messages').append(newCommentHTML);
                // Clear the input field after adding the comment
                $('#body').val('');

                // Function to scroll to the last replies when opening a comment
                function scrollToLastReplies() {
                    let repliesBox = $('#comment-replies-section'); // Adjust this selector to your replies container
                    repliesBox.scrollTop(repliesBox[0].scrollHeight);
                }

            }
        }


        function showToastrMessage(message, type) {
            toastr.options.timeOut = 10000;
            toastr.options.positionClass = "toast-top-left"
            switch (type) {
                case "success":
                    toastr.success(message);
                    break;
                case "error":
                    toastr.error(message);
                    break;
                case "warning":
                    toastr.warning(message);
                    break;
                default:
                    toastr.info(message);
            }
        }
    }
    // Assuming this function is called after successfully submitting a comment
    function scrollToBottom() {
        let chatBox = $('.direct-chat-messages');
        chatBox.scrollTop(chatBox[0].scrollHeight);
    }
</script>


@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

