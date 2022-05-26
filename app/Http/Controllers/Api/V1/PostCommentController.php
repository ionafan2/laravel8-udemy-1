<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\Comment as CommentResource;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogPost $post, Request $request)
    {
        $perPage = $request->input('per_page') ?? 15;
        return CommentResource::collection(
            $post->comments()->with('user')->paginate($perPage)->appends(
                [
                    'per_page' => $perPage
                ]
            )
        );
    }

    public function store(BlogPost $post, StoreCommentRequest $request)
    {
        /** @var Comment $comment */
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        event(new CommentPosted($comment));

        return new CommentResource($comment);

    }

    /**
     * Display the specified resource.\
     *
     * @param int $id
     */
    public function show(BlogPost $post, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(BlogPost $post, Comment $comment, StoreCommentRequest $request)
    {
        $this->authorize($comment);

        $comment->content = $request->input('content');
        $comment->save();

        return new CommentResource($comment);

    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(BlogPost $post, Comment $comment)
    {
        $this->authorize($comment);

        $comment->delete();

        return response()->noContent();
    }
}
