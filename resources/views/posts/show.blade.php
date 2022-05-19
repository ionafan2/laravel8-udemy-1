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
                <x-updated :date="$post->created_at" :user="$post->user">Added</x-updated>
            </p>
            <p>
                <x-updated :date="$post->updated_at" :user="$post->user">Updated</x-updated>
            </p>
            <p>
                <x-tags :tags="$post->tags"></x-tags>
            </p>
            <p><span class="text-muted">Currently read by {{$counter}} people</span></p>

            <h4>Comments</h4>

            <x-comment-form route="{{route('posts.comments.store', ['post' => $post->id])}}"></x-comment-form>

            <x-comments-list :comments="$post->comments"></x-comments-list>

        </div>
        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection

