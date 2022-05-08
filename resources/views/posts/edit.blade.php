@extends('layouts.app')

@section("title", "Update post")

@section('content')

    <form action="{{route('posts.update', ['post'=> $post->id])}}" method="post">

        @include('posts.partials.form')
        <div><input class="btn btn-primary btn-block"  type="submit" name="submit" value="Update"></div>
        @method('PUT')
        @csrf
    </form>

@endsection
