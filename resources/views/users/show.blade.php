@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-4">
            <img class="rounded mx-auto d-block" src="{{$user->image ? $user->image->url() : ''}}"/>
        </div>
        <div class="col-8">
            <h3>{{ $user->name }}</h3>
            <x-comment-form route="{{route('users.comments.store', ['user' => $user->id])}}"></x-comment-form>
            <x-comments-list :comments="$user->commentsOn"></x-comments-list>
        </div>

    </div>
@endsection
