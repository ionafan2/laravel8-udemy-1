@extends('layouts.app')

@section("title", "Create new post")

@section('content')
    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        @include('posts._form_fields')

        <div class="form-group">
            <input class="btn btn-primary btn-block form-control" type="submit" name="submit" value="Create">
        </div>
    </form>
@endsection
