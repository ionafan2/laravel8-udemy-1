@forelse($comments as $comment)
    <p class="mt-3">
        {{$comment->content}}
        <x-updated :date="$comment->created_at" :user="$comment->user"></x-updated>
    </p>
    <x-tags :tags="$comment->tags"></x-tags>
@empty
    <p>No Comments yet!</p>
@endforelse
