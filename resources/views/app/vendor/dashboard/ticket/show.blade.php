@extends('admin.layout.master')

@section('head-tag')
    <title>تیکت | مشاهده تیکت</title>
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css"/>--}}

@endsection

@section('content')
    <div class="content-header text-right">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <ol class="breadcrumb float-right mb-4">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ticket.index') }}">تیکت</a></li>
                        <li class="breadcrumb-item active">مشاهده</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
            <div class="row border-1 pb-2 pt-2 pr-1 pl-1 mr-2 d-flex align-items-center"
                 style="border: 1px solid lightgrey; border-radius: 1rem;">
                <i class="fa fa-check-circle text-success"></i>
                <strong class="text-muted mr-1 ml-1">
                    <small>
                        در این قسمت میتوانید تیکت مورد نظر را مشاهده کرده و از قسمت پاین صفحه پاسخ دهید.
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
                                       <p class="text-primary text-sm mr-3"> موضوع تیکت : </p>
                                        <p class="font-weight-bold">{{ $ticket->subject }}</p>
                                    </span>
                                    <span class="text-muted text-sm">
                                        تاریخ :
                                        {{ persianDate($ticket->created_at) }}
                                    </span>
                                </div>

                                <p class="font-weight-bold text-muted">
                                    <span class="text-info text-decoration-underline">
                                        {{ $ticket->user->fullname ?? '-' }}
                                    </span> گفت :
                                </p>
                                <p style="border: 1px solid lightgrey;padding: 1rem 0.75rem;border-radius: 1rem;">
                                    {{ strip_tags(html_entity_decode($ticket->description)) }}
                                </p>
                            </section>
                        </section>

                        <section
                            class="mt-4 mb-1 card-header text-center font-weight-bold">
                            تاریخچه تیکت های این کاربر:
                        </section>
                        <div class="box direct-chat direct-chat-info" id="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">{{ $ticket->subject }}</h4>
                                <ul class="box-controls pull-right">
                                    <li>
                                        <span
                                            class="text-muted text-sm">تعداد پاسخ ها به این تیکت در 24 ساعت گذشته :</span>
                                        <span data-toggle="tooltip" title="" class="badge badge-pill badge-info"
                                              data-original-title="1 New Messages">
                                            @php
                                                $currentDateTime = \Carbon\Carbon::now();
                                                $twentyFourHoursAgo = $currentDateTime->subHour(24);
                                                $latestRepliesCount = $ticket->answer()->where('created_at', '>=', $twentyFourHoursAgo)->count();
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
                                                    class="direct-chat-name">{{ $ticket->user->fullname ?? '-' }}</span>
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img class="direct-chat-img avatar"
                                                 src="{{ asset('admin-asset/images/user1-128x128.jpg') }}"
                                                 alt="message user image">
                                            <!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                <p>{{ strip_tags(html_entity_decode($ticket->description)) }}</p>
                                                <p class="direct-chat-timestamp">
                                                    <time datetime="2018">{{ persianDate($ticket->created_at) }}</time>
                                                </p>
                                            </div>
                                        </div>

                                        @if($ticket->answer)
                                            @foreach($ticket->answer as $reply)

                                                <div class="direct-chat-msg right mb-30">
                                                    <!-- Display information about the child comment -->
                                                    <div class="clearfix mb-15">
                                                        <span class="direct-chat-name pull-right">{{ $reply->user->fullname }}</span>
                                                    </div>
                                                    <div class="direct-chat-text">
                                                        <!-- Display the content of the child comment -->
                                                        <p>{{ strip_tags(html_entity_decode($reply->description)) }}</p>
                                                        <p class="direct-chat-timestamp">
                                                            <time datetime="2018">{{ persianDateTime($reply->created_at) }}</time>
                                                        </p>
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="box-footer">
                            <form action="{{ route('admin.ticket.answer', $ticket->id) }}"
                                  method="POST"
                                  class="reply-form"
                                  id="reply-form">
                                @csrf
                                <section class="col-12">
                                    <div class="font-weight-bold text-muted my-3">ثبت پاسخ به تیکت</div>
                                    <div class="input-group">
                                    <textarea type="text"
                                              name="description"
                                              id="description"
                                              placeholder="پاسخ خود را اینجا بنویسید..."
                                              class="form-control"></textarea>
                                    </div>
                                    @error('description')
                                    <span class="alert_required text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </section>

                                <section class="mr-4">
                                    <button type="submit" class="btn btn-primary btn-sm mt-3">ثبت پاسخ</button>
                                </section>
                            </form>
                        </div>
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


@section('script')
    <script src="{{ asset('admin-asset/vendor_components/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description')
    </script>
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection

