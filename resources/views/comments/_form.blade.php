<div class="mt-2 mb-2">
    @auth()
        <form action="{{route('posts.comments.store', ['post' => $post->id])}}" method="post">
            @csrf

            <div class="form-group">
                <textarea class="form-control" id="content" name="content" placeholder="" rows="4"></textarea>
                @error('content')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <input class="btn btn-primary btn-block form-control" type="submit" name="submit" value="Add comment">
            </div>
        </form>
    @else
        You must <a href="{{route('login')}}">Log inn</a> to add comment!
    @endauth
</div>
<hr>
