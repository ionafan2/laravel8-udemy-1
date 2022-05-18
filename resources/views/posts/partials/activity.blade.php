<div class="container">
    <div class="row mb-3">
        <x-card title="Most Commented" subtitle="Waht people are currently talking about!">
            <x-slot name="items">
                @foreach($mostCommentedPosts as $mcPost)
                    <li class="list-group-item"><a href="{{route('posts.show', ['post' => $mcPost->id] )}}">
                            {{$mcPost->title}}
                        </a><br>
                        <span class="text-muted"> {{$mcPost->comments_count}} total comments</span>
                    </li>
                @endforeach
            </x-slot>
        </x-card>
    </div>
    <div class="row mb-3">
        <x-card title="Most Active" subtitle="Users with most posts published last month."
                :items="collect($mostActiveUsers)->pluck('name')">
        </x-card>
    </div>
    <div class="row mb-3">
        <x-card title="Most Active Last Month" subtitle="Users with most posts published."
                :items="collect($mostActiveUsersLastMonth)->pluck('name')">
        </x-card>
    </div>
</div>
