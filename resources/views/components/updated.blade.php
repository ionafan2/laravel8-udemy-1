<span class="text-muted">{{$slot ?? 'Added'}} {{$date->diffForHumans()}}
    @if(isset($name))
        by  <a href="{{ route('user.show', ['user' => $userId]) }}">{{ $name }}</a>
    @endif
</span>
