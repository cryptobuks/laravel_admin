<form role="form">
    <div class="card-body">
        <input type="hidden" class="form-control" name="id" value="{{$id or 0}}">
        <div class="form-group">
            <label for="security_password">新密码</label>
            <input type="password" class="form-control" name="security_password" placeholder="请输入新密码">
        </div>
        <div class="form-group">
            <label for="security_password_confirmation">确认密码</label>
            <input type="password" class="form-control" name="security_password_confirmation" placeholder="请输入确认密码">
        </div>
    </div>
    <!-- /.card-body -->
</form>