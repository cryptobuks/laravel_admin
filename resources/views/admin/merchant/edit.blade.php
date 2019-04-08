<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="name">用户名</label>
            <input type="text" class="form-control" name="name" value="{{$name or null}}">
        </div>
        <div class="form-group">
            <label for="email">邮箱</label>
            <input type="email" class="form-control" name="email" value="{{$email or null}}">
        </div>
    </div>
    <!-- /.card-body -->
</form>