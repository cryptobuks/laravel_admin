@extends('admin_template')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-toggle.min.css') }}">
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="height: 50px">
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <button type="button" class="btn btn-sm btn-success create-payType" data-href="{{ route('channel.create') }}">
                                        <i class="fa fa-gg"></i> 添加渠道
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tr>
                                    <th>渠道名称</th>
                                    <th>服务名</th>
                                    <th>支付类型</th>
                                    <th>商户信息</th>
                                    <th>排序</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{ $list['title'] }}</td>
                                        <td>{{ $list['name'] }}</td>
                                        <td></td>
                                        <td>{{ $list['info'] }}</td>
                                        <td>{{ $list['sort'] }}</td>
                                        <td></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info edit-payType" data-href="{{ route('payType.edit',['id'=>$list['id']]) }}"><i class="fa fa-edit"></i> 编辑</button>
                                            <button type="button" class="btn btn-sm btn-danger del-payType" data-href="{{ route('payType.delete',['id'=>$list['id']]) }}"><i class="fa fa-trash"></i> 删除</button>
                                        </td>
                                    </tr>
                                    @foreach($list->child_channel as $child_channel)
                                        <tr>
                                            <td>&emsp;&emsp;&emsp;{{ $child_channel['title'] }}</td>
                                            <td>{{ $child_channel['name'] }}</td>
                                            <td>{{ $child_channel['pay_type'] }}</td>
                                            <td>{{ $child_channel['info'] }}</td>
                                            <td>{{ $child_channel['sort'] }}</td>
                                            <td>
                                                <div style="width: 55px;height: 30px;" class="toggle-click">
                                                    <input type="checkbox" class="toggle-event" data-href="" @if($child_channel['status']==1) checked @endif data-toggle="toggle" data-on="开启" data-off="关闭" data-size="small" data-height="20" data-widget="60" data-onstyle="success" data-offstyle="danger" data-style="ios">
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info edit-payType" data-href="{{ route('payType.edit',['id'=>$child_channel['id']]) }}"><i class="fa fa-edit"></i> 编辑</button>
                                                <button type="button" class="btn btn-sm btn-danger del-payType" data-href="{{ route('payType.delete',['id'=>$child_channel['id']]) }}"><i class="fa fa-trash"></i> 删除</button>
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
    <script src="{{ asset('js/bootstrap-toggle.min.js') }}"></script>
    <script type="text/javascript">
        let $j = jQuery.noConflict();

        $j('.toggle-click').click(function () {
            let that = $j(this).find('.toggle-event');
            let lockApi = that.data('href');
            let val = that.prop('checked');
            if(val){
                that.bootstrapToggle('off');
                layer.confirm('是否确定关闭此通道？', {
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
                        url : lockApi,
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
                            layer.msg(e.statusText, {icon: 2});
                        }
                    });
                });
            } else {
                that.bootstrapToggle('on');
                layer.confirm('是否确定开启此通道？', {
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
                        url : lockApi,
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
                            layer.msg(e.statusText, {icon: 2});
                        }
                    });
                });
            }
        });

        $j('.create-payType').click(function(){
            let apiUrl = $j(this).data('href');
            $j.ajax({
                url : apiUrl,
                type : "get",
                dataType : "html",
                success: function(data){
                    layer.open({
                        title: '添加通道',
                        content: data,
                        type: 1,
                        offset: '0px',
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

        $j('.edit-payType').click(function(){
            let apiUrl = $j(this).data('href');
            $j.ajax({
                url : apiUrl,
                type : "get",
                dataType : "html",
                success: function(data){
                    layer.open({
                        title: '编辑',
                        content: data,
                        type: 1,
                        offset: '0px',
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
                    $j('#pay-type-status').bootstrapToggle();
                    $j('#pay-type-status').change(function() {
                        $j("input[name='status']").val($j(this).prop('checked') ? 1 : 0);
                    })
                },
                error: function(e){
                    layer.msg(e.statusText, {icon: 2})
                }
            });
        });

        $j('.del-payType').click(function(){
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