<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravael app - @yield("title")</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <script src="{{mix('js/app.js')}}" defer></script>
</head>
<body>
    <div class="d-flex mb-3 flex-column flex-md-row align-items-center p-3 p-md-4 bg-white border-bottom shadow-lg">
        <h5 class="my-0 mr-md-auto font-weight-normal">Laravel app</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{route('home.index')}}">Home</a>
            <a class="p-2 text-dark" href="{{route('home.contact')}}">Contact</a>
            <a class="p-2 text-dark" href="{{route('posts.index')}}">Blog Posts</a>
            <a class="p-2 text-dark" href="{{route('posts.create')}}">Create Post</a>
        </nav>
    </div>

    <div class="container">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <div>@yield("content")</div>
    </div>
</body>
</html>
