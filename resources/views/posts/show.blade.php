@extends('layouts.app')

@section("title", $post->title)

@section('content')
    <div class="row">
        <div class="col-8">

            @if($post->image)
                <div
                    style="background-image: url('{{$post->image->url()}}'); min-height: 400px; color: white; text-align: center; background-attachment: fixed">
                    <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
                        {{ $post->title }}
                        <x-badge hide="{{ now()->diffInMinutes($post->created_at) > 10}}">New post!</x-badge>
                    </h1>
                </div>
            @else
                <h1>
                    {{ $post->title }}
                    <x-badge hide="{{ now()->diffInMinutes($post->created_at) > 10}}">New post!</x-badge>
                </h1>
            @endif

            <p>{{ $post->content }}</p>

            <p>
                <x-updated :date="$post->created_at" name="{{$post->user->name}}">Added</x-updated>
            </p>
            <p>
                <x-updated :date="$post->updated_at">Updated</x-updated>
            </p>
            <p>
                <x-tags :tags="$post->tags"></x-tags>
            </p>
            <p><span class="text-muted">Currently read by {{$counter}} people</span></p>

            <h4>Comments</h4>

            @include('comments._form')

            @forelse($post->comments as $comment)
                <p class="mt-3">
                    {{$comment->content}}
                    <x-updated :date="$post->created_at" name="{{$comment->user->name}}"></x-updated>
                </p>
            @empty
                <p>No Comments yet!</p>
            @endforelse
        </div>
        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
