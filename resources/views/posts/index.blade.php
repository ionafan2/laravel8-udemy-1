@extends('layouts.app')

@section("title", 'All')

@section('content')
    <div class="row">
        <div class="col-8">
    @forelse($posts as $key => $post)
        @include('posts.partials.post')
    @empty
        No Posts
    @endforelse
        </div>
        <div class="col-4">
            <div class="container">
                <div class="row mb-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <p class="card-text text-muted">Waht people are currently talking about!</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($mostCommentedPosts as $mcPost)
                                <li class="list-group-item"><a href="{{route('posts.show', ['post' => $mcPost->id] )}}">
                                        {{$mcPost->title}}
                                    </a><br>
                                    <span class="text-muted"> {{$mcPost->comments_count}} total comments</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <p class="card-text text-muted">Users with most posts published. </p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($mostActive as $user)
                                <li class="list-group-item">
                                        {{$user->name}}
                                    <span class="text-muted"> {{$user->blog_posts_count}} total posts</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active Last Month</h5>
                            <p class="card-text text-muted">Users with most posts published last month. </p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($mostActiveLastMonth as $user)
                                <li class="list-group-item">
                                        {{$user->name}}
                                    <span class="text-muted"> {{$user->blog_posts_count}} total posts</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
