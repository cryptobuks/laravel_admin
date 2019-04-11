<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="name">角色名称</label>
            <input type="text" class="form-control" name="name" placeholder="请输入角色名称" value="{{$name or null}}" autofocus>
        </div>
    </div>
    <!-- /.card-body -->
</form>