@extends('layouts.app')

@section("title", 'All')

@section('content')
    @forelse($posts as $key => $post)
        @include('posts.partials.post')
    @empty
        No Posts
    @endforelse
@endsection
