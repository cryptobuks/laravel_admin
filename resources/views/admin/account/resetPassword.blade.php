@extends('admin_template')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class='row'>

                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="oldPassword">旧密码</label>
                                <input type="password" class="form-control" name="oldPassword" placeholder="请输入旧密码" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">新密码</label>
                                <input type="password" class="form-control" name="newPassword" placeholder="请输入新密码" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">确认密码</label>
                                <input type="password" class="form-control" name="newPassword_confirmation" placeholder="请输入确认密码" required>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">提交修改</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>

            </div><!-- /.row -->
        </div>
    </section>
@stop
@section('script')
    <script type="text/javascript">
        var $j = jQuery.noConflict();
        $j(':submit').click(function(){
            $j.ajax({
                url : "/admin/account/password",
                type : "post",
                data : $j(':password').serialize(),
                success: function(data){
                    console.log(data);
                    if(data.status === 0){
                        layer.msg(data.message, {
                            icon: 6,
                            time: 0, //不自动关闭
                            btn: ['确定'],
                            btnAlign: 'c',
                            yes: function(){
                                // window.location.reload();
                                location.href = "/";
                            }
                        });
                    }else{
                        layer.msg(data.message, {icon: 5});
                    }
                },
                error: function(e){
                    layer.msg(e.statusText, {icon: 2})
                }
            });
        });
    </script>
@stop