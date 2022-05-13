@extends('layouts.app')

@section("title", $post->title)

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <p>Added {{$post->created_at->diffForHumans()}}</p>
    @if(now()->diffInMinutes($post->created_at) < 34)
        <x-badge type="primary">Test</x-badge>
    @endif

    <h4>Comments</h4>
    @forelse($post->comments as $comment)

        <p class="mt-3">
            {{$comment->content}} , <span class="text-muted">added {{$comment->created_at->diffForHumans()}}</span>
        </p>

    @empty
        <p>No Comments yet!</p>
    @endforelse

@endsection
