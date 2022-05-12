<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;

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
        $posts = BlogPost::latest()->withCount('comments')->get();

        return view('posts.index', ['posts' => $posts]);
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
        return view('posts.show', ["post" => BlogPost::with('comments')->findOrFail($id)]);

//        return view('posts.show', [
//            "post" => BlogPost::with(['comments' => function ($query) {
//                return $query->latest();
//            }])->findOrFail($id)
//        ]);
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
