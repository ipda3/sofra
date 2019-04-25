<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} | لوحة التحكم</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
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
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/lightbox2/css/lightbox.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/plugins/wickedpicker/wickedpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/summernote.css')}}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/skins/skin-red-light.min.css')}}">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/bootstrap/css/bootstrap-rtl.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/AdminLTE-rtl.css')}}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red-light sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{!! url('admin') !!}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{config('app.name')}}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{{config('app.name')}}</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    {{--<li class="dropdown notifications-menu">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">--}}
                    {{--<i class="fa fa-bell-o"></i>--}}
                    {{--<span class="label label-warning new_orders_count">0</span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu">--}}
                    {{--<li class="header">لديك <span class="new_orders_count">0</span> طلبات جديدة</li>--}}
                    {{--<li class="footer"><a href="{{url('admin')}}">الذهاب لصفحة الطلبات</a></li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                            <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('AdminLTE-2.3.0/dist/img/user2-160x160.jpg')}}" class="user-image"
                                 alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{asset('AdminLTE-2.3.0/dist/img/user2-160x160.jpg')}}" class="img-circle"
                                     alt="User Image">
                                <p>
                                    {{Auth::user()->name}}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        تسجيل الخروج
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>