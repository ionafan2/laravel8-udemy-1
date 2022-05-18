@foreach($tags as $tag)
    <a href="{{route('posts.tags.index', ['id' => $tag->id])}}"
       class="badge badge-pill badge-success badge-text-lg">
        {{$tag->name}}
    </a>
@endforeach

