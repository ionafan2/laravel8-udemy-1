<div class="form-group">
    @error('title')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <label for="title">Title</label>
    <input id="title" class="form-control" type="text" name="title" value="{{old('title', optional($post ?? null)->title)}}" placeholder="">
    @error('content')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
    <label for="content">Content</label>
    <div><textarea class="form-control" id="content" name="content" placeholder="" id="" cols="30" rows="10">{{old('content', optional($post ?? null)->content)}}</textarea></div>
    @if($errors->any())
        <div class="mb-3">
            <ul class="list-group">
                @foreach($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
