@extends('layouts.app')
@section('style')
    <style>
        .netHot{
            float: left;
            font-size: 16px;
            margin-left: 295px;
            margin-top: 13px;
            letter-spacing: 1px;
        }
        body{
            width:100%;
            height:100%;
            background-image:url("{{ asset('img/background.jpg') }}");
            background-size:cover;
        }

        body:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            height: 100%;
            z-index: -1;
        }
        .navbar-default{
            background-color: transparent;
        }
        .panel-default{
            width: 590px;
            height: 340px;
            background-image: linear-gradient( to bottom right , #f2abf7,#6F427B,#6C71FE,#4134C9);
            box-shadow: 0 2px 18px #8A6D69;
            border:none;
            margin: 0 auto;
            margin-top: 153px;
            opacity:.9;
        }
        .panel-body{
            padding: 15px;
            height: 200px;
            width: 500px;
            margin: 0 auto;
            margin-top: 32px;
        }
        .panel-default>.panel-heading{
            background: bottom;

        }
        .panel-default>.panel-heading>.login{
            width: 47px;
            margin: 0 auto;
            margin-top: 2px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 5px;
            text-indent: 5px;
            color:#ffffff
        }
        .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12{
            letter-spacing: 1px;
            color:#ffffff;
            padding-right:0
        }
        .form-horizontal .form-group{
            margin-left: -61px;
            margin-top:50px;
        }
        .form-group{
            margin-bottom: 30px;
        }
        .btn{
            width: 193px;
            height: 36px;
            margin-left: 24px;
            background: rgba(97, 128, 166,.7);
            border-color:darkgoldenrod;
            font-size: 15px;
            letter-spacing: 5px;
            text-indent: 4px;
            color:#ffffff;
        }
        .btn:hover{
            color:goldenrod;
        }
    </style>
@stop
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                {{--<div class="panel-heading"><div class="login"></div></div>--}}

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">用户名</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-6 col-md-offset-4">--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住密码--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn">
                                    登录
                                </button>

{{--                                <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                    Forgot Your Password?--}}
{{--                                </a>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
