<?php

namespace App\Http\Controllers\Admin;

use App\Constants\CommentApproveValue;
use App\Constants\CommentStatusValue;
use App\Constants\CommentTypeValue;
use App\Constants\StatusTypeValue;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
{


    public function Index()
    {
        $unseenComments = Comment::where('seen', CommentStatusValue::UNSEEN)->get();
        foreach ($unseenComments as $unseenComment) {
            $unseenComment['seen'] = 1;
            $result = $unseenComment->save();
        }
        $comments = Comment::where('parent_id',null)->orderByDesc('created_at')->get();
        return View::make('admin.comment.index', ['comments' => $comments]);
    }

    public function show(Comment $comment)
    {
        $comment = Comment::with(['parent', 'children'])->find($comment->id);
        return view('admin.comment.show', compact('comment'));
    }

    public function replyToComment(Request $request, Comment $comment)
    {
        $model = '';
        if ($comment->commentable_type == CommentTypeValue::CONTENT_COMMENT)
            $model = 'App\Models\Admin\Content\Post';
        elseif ($comment->commentable_type == CommentTypeValue::PRODUCT_COMMENT)
            $model = 'App\Models\Admin\Market\Product';

        if ($request->ajax()) {
            $this->validate($request, [
                'body' => 'required|string',
                'parent_id' => 'required|exists:' . Comment::class . ',id',
                'author_id' => 'required|exists:' . User::class . ',id',
                'commentable_type' => 'required|string',
                'commentable_id' => 'required|string|exists:' . $model . ',id',
                'seen' => 'required|in:0,1',
                'approved' => 'required|in:0,1',
                'status' => 'required|in:0,1'
            ], [
                'body.required' => 'لطفا متن پاسخ را وارد کنید.',
            ]);
        }
        $user = User::first()->get()->toArray();
        $user_id = Auth::id();
        if ($model == CommentTypeValue::PRODUCT_COMMENT)
        {
            $reply = Comment::create([
                'body' => $request->input('body'),
                'parent_id' => $comment->id,
                'author_id' => $user_id,
                'commentable_type' => CommentTypeValue::PRODUCT_COMMENT,
                'commentable_id' => $comment->commentable_id,
                'seen' => CommentStatusValue::SEEN,
                'approved' => CommentApproveValue::APPROVED,
                'status' => StatusTypeValue::ACTIVE,
                'created_at' => now()
            ]);
        }elseif($model == CommentTypeValue::CONTENT_COMMENT)
        {
            $reply = Comment::create([
                'body' => $request->input('body'),
                'parent_id' => $comment->id,
                'author_id' => $user_id,
                'commentable_type' => CommentTypeValue::CONTENT_COMMENT,
                'commentable_id' => $comment->commentable_id,
                'seen' => CommentStatusValue::SEEN,
                'approved' => CommentApproveValue::APPROVED,
                'status' => StatusTypeValue::ACTIVE,
                'created_at' => now()
            ]);
        }

        $comment->approved = 1; // update the approved field for replied comment
        $comment->save();
        $reply->save();
        if ($reply) {
//            return \view('admin.partials._reply',compact('reply');)
            $message = $reply == true ? 'پاسخ مورد نظر با موفقیت ثبت شد' : 'پاسخ شما ثبت نشد';
            $alertType = $reply == true ? 'success' : 'error';
            $newComment = Comment::find($comment->id);
            $newCommentHtml = view('admin.comment._reply_partial', ['reply' => $reply])->render();
            return response()->json([
                'status' => true,
                'message' => $message,
                'alertType' => $alertType,
                'commentHtml' => $newCommentHtml,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'مشکلی پیش آمده است.',
                'alertType' => 'error'
            ]);
        }
    }

    public function approve(Comment $comment)
    {
        $comment->approved = $comment->approved === 0 ? 1 : 0;
        $result = $comment->save();

        if ($result) {
            $message = $comment->approved === 0 ? 'کامنت مورد نظر لغو تایید شد' : 'کامنت مورد نظر تایید شد';
            $alertType = $comment->approved === 0 ? 'warning' : 'success';
            $buttonClass = $comment->approved === 0 ? 'warning' : 'success';
            $buttonText = $comment->approved === 0 ? 'عدم تایید' : 'تایید';

            return response()->json([
                'status' => true,
                'checked' => $comment->approved,
                'message' => $message,
                'alertType' => $alertType,
                'buttonClass' => $buttonClass,
                'buttonText' => $buttonText
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'مشکلی پیش آمده است.',
                'alertType' => 'error'
            ]);
        }
    }

    public function status(Comment $comment)
    {
        $comment->status = $comment->status === 0 ? 1 : 0;
        $result = $comment->save();

        if ($result) {
            $message = $comment->status === 0 ? 'کامنت مورد نظر غیرفعال شد' : 'کامنت مورد نظر فعال شد';
            $alertType = $comment->status === 0 ? 'warning' : 'success';
            return response()->json([
                'status' => true,
                'checked' => $comment->status,
                'message' => $message,
                'alertType' => $alertType
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'مشکلی پیش آمده است.',
                'alertType' => 'error'
            ]);
        }
    }
}
