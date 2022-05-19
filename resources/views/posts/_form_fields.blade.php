<div class="form-group">
    <label for="title">Title</label>
    <input class="form-control" id="title" name="title" type="text"
           value="{{old('title', optional($post ?? null)->title)}}">
    @error('title')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="content">Content</label>
    <textarea class="form-control" id="content" name="content" cols="30"
              rows="10">{{old('content', optional($post ?? null)->content)}}</textarea>
    @error('content')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="content">Thumbnail</label>

    <input class="form-control-file" type="file" name="thumbnail">

    @error('thumbnail')
    <div class="alert alert-danger">{{$message}}</div>
    @enderror
</div>

