
<div class="direct-chat-msg right mb-30">
    <!-- Display information about the child comment -->
    <div class="clearfix mb-15">
        <span class="direct-chat-name pull-right">{{ $reply->author->fullname }}</span>
    </div>
    <div class="direct-chat-text">
        <!-- Display the content of the child comment -->
        <p>{{ $reply->body }}</p>
        <p class="direct-chat-timestamp">
            <time datetime="2018">{{ persianDateTime($reply->created_at) }}</time>
        </p>
    </div>
    <!-- /.direct-chat-text -->
</div>


