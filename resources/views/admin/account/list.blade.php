@extends('admin_template')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="height: 50px">
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <button type="button" class="btn btn-sm btn-success"><i class="fa fa-user-plus"></i>添加管理员</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>用户名</th>
                                    <th>邮箱</th>
                                    <th>角色</th>
                                    <th>创建日期</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{ $list['id'] }}</td>
                                        <td>{{ $list['name'] }}</td>
                                        <td>{{ $list['email'] }}</td>
                                        <td>{{ $list['role_id'] }}</td>
                                        <td>{{ $list['created_at'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info"><i class="fa fa-edit"></i>编辑</button>
                                            <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-key"></i>重置密码</button>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>删除</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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