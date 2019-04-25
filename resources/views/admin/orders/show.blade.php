@extends('admin.layouts.main',[
                                'page_header'       => ' عرض الطلب',
                                'page_description'  => 'عرض'
                                ])
@section('content')


    <div class="box box-primary">
        <div class="box-body">

        @include('flash::message')
        @if(!empty($records))
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> تفاصيل طلب # {{$order->id}}
                                <small class="pull-left"><i class="fa fa-calendar-o"></i>  {{$order->created_at}}
                                </small>
                            </h2>
                        </div><!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            طلب من
                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  @if(count($order->client)){{$order->client->name}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>   الهاتف : @if(count($order->client)){{$order->client->phone}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  البريد الإلكترونى : @if(count($order->client)){{$order->client->email}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  العنوان : {{$order->address}}
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            المطعم :
                            <address>
                                <i class="fa fa-angle-left" aria-hidden="true"></i><strong>  @if(count($order->restaurant)>0){{$order->restaurant->name}}@endif</strong><br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i> @if(count($order->restaurant)>0) {{$order->restaurant->address}}@endif
                                <br>
                                <i class="fa fa-angle-left" aria-hidden="true"></i>  الهاتف :  @if(count($order->restaurant)>0) {{$order->restaurant->contact}}@endif
                            </address>
                        </div><!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b> رقم الفاتورة  #{{$order->id}}</b><br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>   تفاصيل طلب {{$order->order_type}}</b><br>
                            <i class="fa fa-angle-left" aria-hidden="true"></i><b>  حالةالطلب:
                                {{$order->state_text}}
                            </b><br>
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
                                    <th>ملاحظة</th>
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
                                    <td>{{$item->pivot->note}}</td>

                                </tr>
                                @php $count ++; @endphp
                                    @endforeach
                                <tr>
                                    <td>--</td>
                                    <td>تكلفة التوصيل</td>
                                    <td>-</td>
                                    <td>{{$order->delivery_cost}}</td>
                                    <td></td>
                                </tr>
                                <tr class="bg-success">
                                    <td>--</td>
                                    <td>الإجمالي</td>
                                    <td>-</td>
                                    <td>
                                            {{$order->total}}  ريال سعودى
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="{{url('admin/layouts/print/'.$order->id)}}" target="_blank" class="btn btn-default">
                                <i class="fa fa-print"></i> طباعة </a>
                            <script>
//                                $('#myModal').on('shown.bs.modal', function () {
//                                    $('#myInput').focus()
//                                })
                            </script>
                        </div>
                    </div>
                </section><!-- /.content -->
                <div class="clearfix"></div>
            @endif
        </div>
    </div>
@endsection