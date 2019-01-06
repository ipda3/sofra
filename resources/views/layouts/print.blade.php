<html>
<head>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/bootstrap/css/bootstrap-rtl.min.css')}}">
    <!-- Theme style -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('AdminLTE-2.3.0/dist/css/AdminLTE-rtl.css')}}">
    <link href="{{asset('front/css/style.css')}}" rel="stylesheet" >
    <link href="{{asset('front/css/font-awesome.min.css')}}" rel="stylesheet" >
</head>
<body>

@if(!empty($order))
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>طلب
            <small># {{$order->id}}</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> تفاصيل طلب {{$order->order_type}}
                    <small class="pull-left"><i class="fa fa-calendar-o"></i>   التاريخ:{{$order->created_at}}
                    </small>
                </h2>
            </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                طلب من
                <address>
                    <i class="fa fa-angle-left" aria-hidden="true"></i>  {{$order->user->name}}
                    <br>
                    <i class="fa fa-angle-left" aria-hidden="true"></i>   الهاتف : {{$order->user->phone}}
                    <br>
                    <i class="fa fa-angle-left" aria-hidden="true"></i>  البريد الإلكترونى : {{$order->user->email}}
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                المطعم :
                <address>
                    <i class="fa fa-angle-left" aria-hidden="true"></i><strong> {{$order->restaurant->name}}</strong><br>
                    <i class="fa fa-angle-left" aria-hidden="true"></i> {{$order->restaurant->address}}
                    <br>
                    <i class="fa fa-angle-left" aria-hidden="true"></i>  الهاتف : {{$order->restaurant->contact}}
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <i class="fa fa-angle-left" aria-hidden="true"></i><b> رقم الفاتورة  #{{$order->id}}</b><br>
                <i class="fa fa-angle-left" aria-hidden="true"></i><b>   تفاصيل طلب {{$order->order_type}}</b><br>
                <i class="fa fa-angle-left" aria-hidden="true"></i><b>  التاريخ:{{$order->created_at}}</b><br>
                <i class="fa fa-angle-left" aria-hidden="true"></i><b>  الإجمالى:</b> {{$order->total}}
            </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>إسم المنتج</th>
                        <th>الكمية</th>
                        <th>السعر</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $count = 1; @endphp
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{$count}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->pivot->quantity}}</td>
                            <td>{{$item->pivot->price}}</td>

                        </tr>
                        @php $count ++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>الإجمالى</th>
                            <td>{{$order->total}}  ريال سعودى</td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="{{url('admin/layouts/print/'.$order->id)}}" target="_blank" class="btn btn-default">
                    <i class="fa fa-print"></i> طباعة </a>
            </div>
        </div>
    </section><!-- /.content -->
    <div class="clearfix"></div>
@endif
<!-- jQuery 2.1.4 -->
<script src="{{asset('AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-2.3.0/dist/js/app.min.js')}}"></script>
</body>
</html>