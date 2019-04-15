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
                                    <button type="button" class="btn btn-sm btn-success create-channel" data-href="{{ route('channel.create') }}">
                                        <i class="fa fa-skyatlas"></i> 添加渠道
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tr>
                                    <th>渠道名称</th>
                                    <th>服务名<i class="fa fa-arrow-right"></i>支付类型</th>
                                    <th>排序(DESC)</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($lists as $list)
                                    <tr class="font-weight-bold">
                                        <td><i class="fa fa-pinterest-p"></i> {{ $list['title'] }}</td>
                                        <td>{{ $list['name'] }}</td>
                                        <td>{{ $list['sort'] }}</td>
                                        <td>&nbsp;&nbsp;&nbsp;<i class="fa fa-info-circle"></i></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info edit-channel" data-href="{{ route('channel.edit',['id'=>$list['id']]) }}"><i class="fa fa-edit"></i> 编辑</button>
                                            <button type="button" class="btn btn-sm btn-danger del-channel" data-href="{{ route('channel.delete',['id'=>$list['id']]) }}"><i class="fa fa-trash"></i> 删除</button>
                                        </td>
                                    </tr>
                                    @foreach($list->child_channel as $child_channel)
                                        <tr class="text-muted">
                                            <td>&emsp;&emsp;&nbsp;{{ $child_channel['title'] }}</td>
                                            <td>{{ $child_channel['pay_type'] }}</td>
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

        $j('.create-channel').click(function(){
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

        $j('.edit-channel').click(function(){
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

        $j('.del-channel').click(function(){
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