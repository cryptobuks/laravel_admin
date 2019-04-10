<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="description">名称</label>
            <input type="text" class="form-control" name="description" value="{{$description or null}}">
        </div>
        <div class="form-group">
            <label for="name">命名</label>
            <input type="text" class="form-control" name="name" value="{{$name or null}}">
        </div>
        <div class="form-group">
            <label for="uri">URI</label>
            <input type="text" class="form-control" name="uri" value="{{$uri or null}}">
        </div>
    </div>
    <!-- /.card-body -->
</form>