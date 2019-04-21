<form role="form">
    <div class="card-body">
        <div class="form-group">
            <label for="name">用户名</label>
            <input type="text" class="form-control" name="name" placeholder="请输入用户名">
        </div>
        <div class="form-group">
            <label for="email">邮箱</label>
            <input type="email" class="form-control" name="email" placeholder="请输入邮箱">
        </div>
        <div class="form-group">
            <label for="password">密码</label>
            <input type="password" class="form-control" name="password" placeholder="请输入密码">
        </div>
        <div class="form-group">
            <label for="password_confirmation">确认密码</label>
            <input type="password" class="form-control" name="password_confirmation" placeholder="请输入确认密码">
        </div>
        <div class="form-group">
            <label>角色</label>
            <select class="form-control" name="role_id">
                <option value="0">暂无角色</option>
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <!-- /.card-body -->
</form>