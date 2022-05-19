<span class="text-muted">{{$slot ?? 'Added'}} {{$date->diffForHumans()}}
    @if(isset($user->name))
        by  <a href="{{ route('user.show', ['user' => $user->id]) }}">{{ $user->name }}</a>
    @endif
</span>
