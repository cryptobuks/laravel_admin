@extends('admin_template')
@section('style')
    <style>
        .table .data-time { padding-top: 0; padding-bottom: 0; }
        table tr td small { cursor: pointer; }
    </style>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="height: 50px">
                            <div class="card-tools">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover">
                                <tr>
                                    <th>商户号</th>
                                    <th>商户名</th>
                                    <th>系统订单号</th>
                                    <th>商户订单号</th>
                                    <th>支付方式</th>
                                    <th>支付渠道</th>
                                    <th>订单金额</th>
                                    <th>支付金额</th>
                                    <th>手续费</th>
                                    <th>支付状态</th>
                                    <th>通知状态</th>
                                    <th>充值IP</th>
                                    <th>下单时间</th>
                                    <th>到账时间</th>
                                </tr>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{ $list['merchant_no'] }}</td>
                                        <td>{{ $list['name'] }}</td>
                                        <td>{{ $list['pay_no'] }}</td>
                                        <td>{{ $list['order_id'] }}</td>
                                        <td>{{ $list['pay_type'] }}</td>
                                        <td>{{ $list['pay_channel'] }}</td>
                                        <td>{{ $list['amount'] }}</td>
                                        <td>{{ $list['actual_amount'] }}</td>
                                        <td>{{ $list['fee'] }}</td>
                                        <td>@if($list['pay_status'] == 1) <small class="badge badge-success">已支付</small> @else <small class="badge badge-danger pay-status">未支付</small> @endif <small class="badge badge-remedy hide" data-href="{{ route('order.remedy',[$list['id']]) }}">补单</small></td>
                                        <td>@if($list['notice_status'] == 1) <small class="badge badge-info notice-status" data-status="{{$list['pay_status']}}">已通知</small> @else <small class="badge badge-danger notice-status" data-status="{{$list['pay_status']}}">未通知</small> @endif <small class="badge badge-notice hide" data-href="{{ route('order.notice',[$list['id']]) }}">重发通知</small></td>
                                        <td>{{ $list['pay_ip'] }}</td>
                                        <td class="data-time">{!! datetimeLineFeed($list['order_time']) !!}</td>
                                        <td class="data-time">{!! datetimeLineFeed($list['pay_time']) !!}</td>
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

        $j('.pay-status').mouseover(function () {
            $j(this).addClass('hide');
            $j(this).next().removeClass('hide')
        });

        $j('.badge-remedy').mouseout(function () {
            $j(this).addClass('hide');
            $j(this).prev().removeClass('hide')
        });

        $j('.badge-remedy').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('是否确定补单？', {
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

        $j('.notice-status').mouseover(function () {
            let payStatus = $j(this).data('status');
            if( payStatus === 1 ){
                $j(this).addClass('hide');
                $j(this).next().removeClass('hide')
            }
        });

        $j('.badge-notice').mouseout(function () {
            $j(this).addClass('hide');
            $j(this).prev().removeClass('hide')
        });

        $j('.badge-notice').click(function(){
            let apiUrl = $j(this).data('href');
            layer.confirm('确定重发回调通知？', {
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

    </script>
@stop