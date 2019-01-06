<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} | لوحة التحكم</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Io-nicons -->
    {{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/select2/select2.min.css')}}">
    {{--<link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/datepicker/datepicker3.css')}}">--}}
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/bootstrap-fileinput/css/fileinput.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/skins/skin-blue-light.min.css')}}">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/bootstrap/css/bootstrap-rtl.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/AdminLTE-rtl.css')}}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/iCheck/square/blue.css')}}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{url('/')}}">{{config('app.name')}}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">قم بتسجيل الدخول</p>

        <form action="{{ url('/login') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="البريد الاليكتروني" id="email" name="email" value="{{ old('email') }}" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="كلمة المرور" id="password" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> تذكرني
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"> الدخول </button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        {{--<div class="social-auth-links text-center">--}}
            {{--<p>- OR -</p>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using--}}
                {{--Facebook</a>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using--}}
                {{--Google+</a>--}}
        {{--</div>--}}
        <!-- /.social-auth-links -->

        <a href="#">هل نسيت كلمة المرور</a><br>
        {{--<a href="register.html" class="text-center">تسجيل عضوية جديدة</a>--}}

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{asset('AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('AdminLTE-2.3.0/plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
