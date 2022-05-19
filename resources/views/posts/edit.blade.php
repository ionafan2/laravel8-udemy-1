@extends('layouts.app')

@section("title", "Update post")

@section('content')
    <form action="{{route('posts.update', ['post'=> $post->id])}}" method="post" enctype="multipart/form-data">
        @csrf @method('PUT')

        @include('posts._form_fields')

        <div class="form-group">
            <input class="btn btn-primary btn-block form-control" type="submit" name="submit" value="Update">
        </div>
    </form>
@endsection
