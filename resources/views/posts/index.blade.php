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
            <div class="card" style="width: 18rem;">
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
    </div>
@endsection
