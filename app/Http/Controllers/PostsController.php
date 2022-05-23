<?php

namespace App\Http\Controllers;

use App\Events\BlogPostPosted;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => BlogPost::latestWithRelations()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePost $request
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();

        $post = BlogPost::create(array_merge($validated, ['user_id' => $request->user()->id]));

        if ($request->hasFile('thumbnail')) {

            $path = $request->file('thumbnail')->store('thumbnails');

            $post->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPosted($post));

        $request->session()->flash('status', 'Created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        $post = Cache::tags(['blog-post'])->remember("blog-post-{$id}", now()->addSeconds(30), function () use ($id) {
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                ->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;

        $now = now();

        foreach ($users as $session => $lastVisitTime) {
            if ($now->diffInMinutes($lastVisitTime) >= 3) {
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisitTime;
            }
        }

        if (!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >= 3) {
            $difference++;
        }
        $usersUpdate[$sessionId] = $now;

        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);

        if (!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $difference);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('posts.show', ["post" => $post, 'counter' => $counter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        return view('posts.edit', ["post" => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePost $request
     * @param int $id
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post);

        $validated = $request->validated();
        $post->fill($validated);

        if ($request->hasFile('thumbnail')) {

            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(Image::make(['path' => $path]));
            }
        }

        $post->save();

        $request->session()->flash('status', 'Updated!');

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

//        if (Gate::denies('delete-blog-post', $post)) {
//            abort(403, 'No mister! It is not yours!');
//        }
//        $this->authorize('delete-blog-post', $post);
        $this->authorize($post);

        $post->delete();

        session()->flash('status', "Deleted");
        return redirect()->route('posts.index');
    }
}
