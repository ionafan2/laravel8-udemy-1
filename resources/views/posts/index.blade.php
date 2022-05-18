@extends('layouts.app')

@section("title", 'All')

@section('content')
    <div class="row">
        <div class="col-8">
            @forelse($posts as $key => $post)
                @include('posts._post')
            @empty
                No Posts
            @endforelse
        </div>
        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>
@endsection
