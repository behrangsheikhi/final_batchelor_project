<div class="box-footer">
    <form action="{{ route('admin.market.comment.reply-to-comment', $comment->id) }}"
          method="POST"
          class="reply-form"
          onsubmit="addComment(event)"
          id="reply-form">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        {{-- TODO: fix this author_id input after authentication action --}}
        @php
            $user = \App\Models\User::first()->get()->toArray();
            $user_id = $user[0]['id'];
        @endphp
        <input type="hidden" name="author_id" value="{{ $user_id }}">
        <input type="hidden" name="commentable_type" value="{{ $comment->commentable_type }}">
        <input type="hidden" name="commentable_id" value="{{ $comment->commentable_id }}">
        <input type="hidden" name="seen" value="1">
        <input type="hidden" name="approved" value="1">
        <input type="hidden" name="status" value="1">

        <div class="input-group">
            <input type="text"
                   name="body"
                   id="body"
                   placeholder="پاسخ خود را اینجا بنویسید..." class="form-control">
            <div class="input-group-addon">
                <div class="align-self-end gap-items">
                    <button type="submit"
                            id="publisher-btn"
                            class="publisher-btn">
                        <i class="fa fa-paper-plane text-info"></i>
                    </button>
                </div>
            </div>
        </div>
        @error('body')
        <span class="alert_required text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </form>
</div>
@section('script')
    <script>
        function showToastrMessage(message, type) {
            toastr.options.timeOut = 5000;
            toastr.options.positionClass = "toast-top-left";
            toastr.options.progressBar = true;
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
    </script>
@endsection

