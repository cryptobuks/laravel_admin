<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="password">新密码</label>
            <input type="password" class="form-control" name="password" placeholder="请输入新密码">
        </div>
        <div class="form-group">
            <label for="password_confirmation">确认密码</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="请输入确认密码">
        </div>
    </div>
    <!-- /.card-body -->
</form>