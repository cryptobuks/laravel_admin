@extends('admin_template')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="height: 50px">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-orange store-merchant" data-href="{{ route('merchant.store') }}">
                                        <i class="fa fa-refresh"></i> 重置缓存
                                    </button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success create-merchant" data-href="{{ route('merchant.create') }}" data-title="添加商户">
                                        <i class="fa fa-user-plus"></i> 添加商户
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>商户号</th>
                                    <th>登录名</th>
                                    <th>秘钥</th>
                                    <th>状态</th>
                                    <th>创建时间</th>
                                    <th>修改时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{ $list['id'] }}</td>
                                        <td>{{ $list['merchant_no'] }}</td>
                                        <td>{{ $list['name'] }}</td>
                                        <td>{{ $list['key'] }}</td>
                                        <td>{{ $list['status'] }}</td>
                                        <td>{{ $list['created_at'] }}</td>
                                        <td>{{ $list['updated_at'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-blue set-rate" data-href="{{ route('merchant.rate',['id'=>$list['id']]) }}"><i class="fa fa-sliders"></i> 设置费率</button>
                                            <button type="button" class="btn btn-sm btn-warning reset-key" data-href="{{ route('merchant.key',['id'=>$list['id']]) }}"><i class="fa fa-key"></i> 重置秘钥</button>
                                            <button type="button" class="btn btn-sm btn-info reset-password" data-href="{{ route('merchant.password',['id'=>$list['id']]) }}"><i class="fa fa-user"></i> 重置登录密码</button>
                                            <button type="button" class="btn btn-sm btn-cyan reset-security" data-href="{{ route('merchant.security',['id'=>$list['id']]) }}"><i class="fa fa-rmb"></i> 重置资金密码</button>
                                            <button type="button" class="btn btn-sm btn-danger del-merchant" data-href="{{ route('merchant.delete',['id'=>$list['id']]) }}"><i class="fa fa-trash"></i> 删除</button>
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
        let $j = jQuery.noConflict();

        $j('.create-merchant').click(function(){
            let apiUrl = $j(this).data('href');
            let title = $j(this).data('title');
            $j.ajax({
                url : apiUrl,
                type : "get",
                dataType : "html",
                success: function(data){
                    layer.open({
                        title: title,
                        content: data,
                        type: 1,
                        offset: '100px',
                        area: '500px',
                        closeBtn: 0,
                        shadeClose: true,
                        fixed: false,
                        btn: ['确定','取消'],
                        yes: function () {
                            $j.ajax({
                                url : apiUrl,
                                type : "post",
                                data : $j('form').serialize(),
                                success: function(data){
                                    if(data.status === 0){
                                        layer.msg(data.message, {icon: 6});
                                        window.location.reload();
                                    }else{
                                        layer.msg(data.message, {icon: 5});
                                    }
                                },
                                error: function(e){
                                    layer.msg(e.statusText, {icon: 2})
                                }
                            });
                        },
                        btn2: function () {
                            layer.close();
                        }
                    });
                },
                error: function(e){
                    layer.msg(e.statusText, {icon: 2})
                }
            });
        });

        $j('.store-merchant').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('确定重置商户缓存？', {
                skin: 'warning-class',
                icon: 7,
                title: false,
                closeBtn: 0,
                btn: ['确定','取消'],
                btnAlign: 'c',
                anim: 6,
                shadeClose: true
            }, function(){
                $j.ajax({
                    url : apiUrl,
                    type : "post",
                    success: function(data){
                        if(data.status === 0){
                            layer.msg(data.message, {icon: 6});
                        }else{
                            layer.msg(data.message, {icon: 5});
                        }
                    },
                    error: function(e){
                        layer.msg(e.statusText, {icon: 2})
                    }
                });
            });
        });

        $j('.reset-key').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('是否确定重置密钥？', {
                skin: 'warning-class',
                icon: 7,
                title: false,
                closeBtn: 0,
                btn: ['确定','取消'],
                btnAlign: 'c',
                anim: 6,
                shadeClose: true
            }, function(){
                $j.ajax({
                    url : apiUrl,
                    type : "post",
                    success: function(data){
                        if(data.status === 0){
                            layer.msg(data.message, {icon: 6});
                            window.location.reload();
                        }else{
                            layer.msg(data.message, {icon: 5});
                        }
                    },
                    error: function(e){
                        layer.msg(e.statusText, {icon: 2})
                    }
                });
            });
        });

        $j('.reset-password').click(function(){
            let apiUrl = $j(this).data('href');
            $j.ajax({
                url : apiUrl,
                type : "get",
                dataType : "html",
                success: function(data){
                    layer.open({
                        title: '重置登录密码',
                        content: data,
                        type: 1,
                        offset: '100px',
                        area: '500px',
                        closeBtn: 0,
                        shadeClose: true,
                        fixed: false,
                        btn: ['确定','取消'],
                        yes: function () {
                            $j.ajax({
                                url : apiUrl,
                                type : "post",
                                data : $j('form').serialize(),
                                success: function(data){
                                    if(data.status === 0){
                                        layer.msg(data.message, {icon: 6});
                                        window.location.reload();
                                    }else{
                                        layer.msg(data.message, {icon: 5});
                                    }
                                },
                                error: function(e){
                                    layer.msg(e.statusText, {icon: 2})
                                }
                            });
                        },
                        btn2: function () {
                            layer.close();
                        }
                    });
                },
                error: function(e){
                    layer.msg(e.statusText, {icon: 2})
                }
            });
        });

        $j('.reset-security').click(function(){
            let apiUrl = $j(this).data('href');
            $j.ajax({
                url : apiUrl,
                type : "get",
                dataType : "html",
                success: function(data){
                    layer.open({
                        title: '重置资金密码',
                        content: data,
                        type: 1,
                        offset: '100px',
                        area: '500px',
                        closeBtn: 0,
                        shadeClose: true,
                        fixed: false,
                        btn: ['确定','取消'],
                        yes: function () {
                            $j.ajax({
                                url : apiUrl,
                                type : "post",
                                data : $j('form').serialize(),
                                success: function(data){
                                    if(data.status === 0){
                                        layer.msg(data.message, {icon: 6});
                                        window.location.reload();
                                    }else{
                                        layer.msg(data.message, {icon: 5});
                                    }
                                },
                                error: function(e){
                                    layer.msg(e.statusText, {icon: 2})
                                }
                            });
                        },
                        btn2: function () {
                            layer.close();
                        }
                    });
                },
                error: function(e){
                    layer.msg(e.statusText, {icon: 2})
                }
            });
        });

        $j('.del-merchant').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('是否确定删除？', {
                skin: 'warning-class',
                icon: 7,
                title: false,
                closeBtn: 0,
                btn: ['确定','取消'],
                btnAlign: 'c',
                anim: 6,
                shadeClose: true
            }, function(){
                $j.ajax({
                    url : apiUrl,
                    type : "delete",
                    success: function(data){
                        if(data.status === 0){
                            layer.msg(data.message, {icon: 6});
                            window.location.reload();
                        }else{
                            layer.msg(data.message, {icon: 5});
                        }
                    },
                    error: function(e){
                        layer.msg(e.statusText, {icon: 2})
                    }
                });
            });
        });

    </script>
@stop