<h3>
    @if($post->trashed())
        <del>
            @endif
            <a class="{{$post->trashed() ? "text-muted": "" }}"
               href="{{route('posts.show', ['post' => $post->id])}}">{{$post->title}}</a>
            @if($post->trashed())
        </del>
    @endif
</h3>

<x-updated :date="$post->created_at" name="{{$post->user->name}}"></x-updated>
<x-tags :tags="$post->tags"></x-tags>

@if($post->comments_count)
    <p>{{$post->comments_count}} comments</p>
@else
    <p>No comments!</p>
@endif
<div class="mb-3">
    @auth()
        @can('update', $post)
            <a class="btn btn-primary" href="{{route('posts.edit', ['post' => $post->id])}}">Edit</a>
        @endcan

        @if(!$post->trashed())
            @can('delete', $post)
                <form class="d-inline" method="post" action="{{route('posts.destroy', ['post' => $post->id])}}">
                    @method('DELETE')
                    @csrf
                    <input type="submit" value="Delete" class="btn btn-primary">
                </form>
            @endcan
        @endif
    @endauth
</div>
