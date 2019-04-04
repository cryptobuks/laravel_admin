@extends('admin_template')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class='row'>

                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="oldPassword">旧密码</label>
                                    <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="请输入旧密码" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">新密码</label>
                                    <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="请输入新密码" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">确认密码</label>
                                    <input type="password" class="form-control" name="newPassword_confirmation" id="newPassword_confirmation" placeholder="请输入确认密码" required>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">提交修改</button>
                            </div>
                        </form>
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
            event.preventDefault();
            $j.ajax({
                url : "/admin/account/password",
                type : "post",
                data : $j('form').serialize(),
                success: function(data){
                    console.log(data);
                    if(data.status === 0){
                        alert(data.message);
                        window.location.reload();
                    }else{
                        alert(data.message);
                    }
                },
                error: function(e){
                    alert(e.statusText)
                }
            });
        });
    </script>
@stop