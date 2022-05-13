@if(!isset($hide) || !$hide)
<span class="badge badge-{{$type ?? 'success'}}">{{$slot}}</span>
@endif
