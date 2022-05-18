@extends('layouts.app')

@section("title", $post->title)

@section('content')
<div class="row">
    <div class="col-8">
        <h1>
            {{ $post->title }}
            <x-badge hide="{{ now()->diffInMinutes($post->created_at) > 10}}" >New post !</x-badge>
        </h1>
        <p>{{ $post->content }}</p>

        <x-updated :date="$post->created_at" name="{{$post->user->name}}"></x-updated>
        <br>
        <x-updated :date="$post->updated_at">Updated</x-updated>
        <br>
        <x-tags :tags="$post->tags"></x-tags>
        <p>Currently read by {{$counter}} people</p>

        <h4>Comments</h4>
        @forelse($post->comments as $comment)

            <p class="mt-3">
                {{$comment->content}} <x-updated :date="$post->created_at"></x-updated>
            </p>

        @empty
            <p>No Comments yet!</p>
        @endforelse
    </div>
    <div class="col-4">
        @include('posts.partials.activity')
    </div>
</div>
@endsection
