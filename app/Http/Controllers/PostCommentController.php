<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;
use App\Models\BlogPost;
use App\Models\Comment;

class PostCommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreCommentRequest $request)
    {
        /** @var Comment $comment */
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        $request->session()->flash('status', 'Comment added!');

        ThrottledMail::dispatch(
            new CommentPostedMarkdown($comment),
            $post->user
        );

        NotifyUsersPostWasCommented::dispatch($comment);

        return redirect()->back();
    }
}
