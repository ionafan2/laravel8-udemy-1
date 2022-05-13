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
                    <x-card title="Most Commented" subtitle="Waht people are currently talking about!">
                        <x-slot name="items">
                            @foreach($mostCommentedPosts as $mcPost)
                                <li class="list-group-item"><a href="{{route('posts.show', ['post' => $mcPost->id] )}}">
                                        {{$mcPost->title}}
                                    </a><br>
                                    <span class="text-muted"> {{$mcPost->comments_count}} total comments</span>
                                </li>
                            @endforeach
                        </x-slot>
                    </x-card>
                </div>
                <div class="row mb-3">
                    <x-card title="Most Active" subtitle="Users with most posts published last month."
                            :items="collect($mostActive)->pluck('name')">
                    </x-card>
                </div>
                <div class="row mb-3">
                    <x-card title="Most Active Last Month" subtitle="Users with most posts published."
                            :items="collect($mostActiveLastMonth)->pluck('name')">
                    </x-card>
                </div>
            </div>
        </div>
    </div>
@endsection
