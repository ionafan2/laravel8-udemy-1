<h3>
    <a href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a>
</h3>

@if($post->comments_count)
    <p>{{$post->comments_count}} comments</p>
@else
    <p>No comments!</p>
@endif
<div class="mb-3">
    <a class="btn btn-primary" href="{{route('posts.edit', ['post' => $post->id])}}">Edit</a>
    <form class="d-inline" method="post" action="{{route('posts.destroy', ['post' => $post->id])}}">
        @method('DELETE')
        @csrf
        <input type="submit" value="Delete" class="btn btn-primary">
    </form>
</div>
