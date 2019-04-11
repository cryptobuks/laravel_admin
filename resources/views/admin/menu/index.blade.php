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
                                    <button type="button" class="btn btn-sm btn-success create-menu" data-href="{{ route('menu.create') }}">
                                        <i class="fa fa-plus-square"></i> 添加菜单
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tr>
                                    <th>菜单名称</th>
                                    <th>分组</th>
                                    <th>URI</th>
                                    <th>排序</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($lists as $list)
                                    <tr class="font-weight-bold">
                                        <td><i class="fa {{ $list['icon'] }}"></i> {{ $list['name'] }}</td>
                                        <td>{{ $list['group'] }}</td>
                                        <td></td>
                                        <td>{{ $list['sort'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info edit-permission" data-href="{{ route('permission.edit',['id'=>$list['id']]) }}"><i class="fa fa-edit"></i> 编辑</button>
                                            <button type="button" class="btn btn-sm btn-danger del-permission" data-href="{{ route('permission.delete',['id'=>$list['id']]) }}"><i class="fa fa-trash"></i> 删除</button>
                                        </td>
                                    </tr>
                                    @foreach($list->sub_menus as $sub_menu)
                                        <tr class="text-muted">
                                            <td>&emsp;&emsp;&emsp;<i class="fa {{ $sub_menu['icon'] }}"></i> {{ $sub_menu['name'] }}</td>
                                            <td>{{ $sub_menu['group'] }}</td>
                                            <td>{{ $sub_menu['permission']['uri'] }}</td>
                                            <td>{{ $sub_menu['sort'] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info edit-permission" data-href="{{ route('permission.edit',['id'=>$sub_menu['id']]) }}"><i class="fa fa-edit"></i> 编辑</button>
                                                <button type="button" class="btn btn-sm btn-danger del-permission" data-href="{{ route('permission.delete',['id'=>$sub_menu['id']]) }}"><i class="fa fa-trash"></i> 删除</button>
                                            </td>
                                        </tr>
                                    @endforeach
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

        $j('.create-menu').click(function(){
            let apiUrl = $j(this).data('href');
            $j.ajax({
                url : apiUrl,
                type : "get",
                dataType : "html",
                success: function(data){
                    layer.open({
                        title: '添加菜单',
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
                    $j("#pid").change(function(){
                        let pid = $j(this).val();
                        if( pid === '0' ){
                            $j('#group').parent().removeClass('hide'); //顶级菜单显示分组
                            $j('#permission_id').parent().addClass('hide'); //顶级菜单隐藏路由(权限)
                        } else {
                            $j('#group').parent().addClass('hide'); //子菜单隐藏分组
                            $j('#permission_id').parent().removeClass('hide');//子菜单显示路由(权限)
                        }
                    });
                },
                error: function(e){
                    layer.msg(e.statusText, {icon: 2})
                }
            });
        });



        $j('.clear-cache').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('确定清除权限缓存？', {
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

        $j('.restore-permission').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('确定重置权限表？', {
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

        $j('.del-permission').click(function(){
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