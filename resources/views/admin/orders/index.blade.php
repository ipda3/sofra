@extends('admin.layouts.main',[
                                'page_header'       => ' عرض الطلبات',
                                'page_description'  => 'عرض'
                                ])
@inject('restaurant','App\Models\Restaurant')
<?php
$restaurants = $restaurant->pluck('name','id')->toArray();
?>
@section('content')


    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                {!! Form::open([
                    'method' => 'GET'
                ]) !!}
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('order_id',\Request::input('order_id'),[
                            'class' => 'form-control',
                            'placeholder' => 'رقم الطلب'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::select('restaurant_id',$restaurant->get()->pluck('restaurant_details','id')->toArray(),request()->input('restaurant_id'),[
                            'class' => 'form-control',
                            'placeholder' => 'كل المطاعم'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::select('state',
                            [
                                'pending' => 'قيد التنفيذ',
                                'accepted' => 'تم تأكيد الطلب',
                                'rejected' => 'مرفوض',
                            ],\Request::input('state'),[
                                'class' => 'form-control',
                                'placeholder' => 'كل حالات الطلبات'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('from',\Request::input('from'),[
                            'class' => 'form-control datepicker',
                            'placeholder' => 'من'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('to',\Request::input('to'),[
                            'class' => 'form-control datepicker',
                            'placeholder' => 'إلى'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-flat btn-block btn-primary">بحث</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <th>#</th>
                    <th>رقم الطلب</th>
                    <th>المطعم</th>
                    <th>الإجمالى</th>
                    <th>ملاحظات</th>
                    <th>الحالة</th>
                    <th>وقت الطلب</th>
                    <th class="text-center">عرض</th>
                    </thead>
                    <tbody>
                    @php $count = 1; @endphp
                    @foreach($order as $ord)
                        <tr id="removable{{$ord->id}}">
                            <td>{{$count}}</td>
                            <td><a href="{{url('admin/order/'.$ord->id)}}">#{{$ord->id}}</a></td>
                            <td>@if(count($ord->restaurant)){{$ord->restaurant->name}}@endif</td>
                            <td>{{$ord->total}}</td>
                            <td>{{$ord->note}}</td>
                            <td>{{$ord->state_text}}</td>
                            <td>{{$ord->created_at}}</td>
                            <td>
                                <a href="{{url('admin/order/'.$ord->id)}}" class="btn btn-success btn-block">عرض الطلب</a>
                            </td>
                        </tr>
                        @php $count ++; @endphp
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! $order->appends([
                    'order_id' => \Request::input('order_id'),
                    'restaurant_id' => \Request::input('restaurant_id'),
                    'state' => \Request::input('state'),
                    'from' => \Request::input('from'),
                    'to' => \Request::input('to'),
                ])->links() !!}
            </div>
        </div>
    </div>

@endsection