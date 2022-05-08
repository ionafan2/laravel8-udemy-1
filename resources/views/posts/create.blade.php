@extends('layouts.app')

@section("title", "Create new post")

@section('content')

    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">

        @include('posts.partials.form')
        <div><input class="btn btn-primary btn-block" type="submit" name="submit" value="Create"></div>
        @csrf
    </form>

@endsection
