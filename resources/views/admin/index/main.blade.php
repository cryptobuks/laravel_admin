@extends('admin_template')
@section('style')
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>150</h3>

                            <p>订单总数</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>订单成功率</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>44</h3>

                            <p>新增商户</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>65</h3>

                            <p>有效订单数量</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary" style="background-color: #16ccb9!important;">
                        <div class="inner">
                            <h3>26370</h3>

                            <p>订单总金额</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-ios-cart"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary" style="background-color: #c313e6!important;">
                        <div class="inner">
                            <h3>15820</h3>

                            <p>总收入</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-yen"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary" style="background-color: #b2dc45!important;">
                        <div class="inner">
                            <h3>3600</h3>

                            <p>总提现</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-social-yen-outline"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary" style="background-color: #fb8c31!important;">
                        <div class="inner">
                            <h3>11</h3>

                            <p>好评数量</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-heart"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary" style="background-color: #f0f118!important;">
                        <div class="inner">
                            <h3>111</h3>

                            <p>收藏数量</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-attach"></i>
                        </div>
                        <a href="#" class="small-box-footer">详细信息 <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection