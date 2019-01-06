@extends('admin.layouts.main',[
                                'page_header'       => 'أصناف الطعام',
                                'page_description'  => 'صنف جديد'
                                ])
@section('content')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cutlery"></i> {{$restaurant->name}}</a></li>
    </ol>
    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>['ItemController@store',$restaurant->id],
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST',
                                'files' => true
                                ])!!}
        <div class="box-body">
            @include('admin.items.form')
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div><!-- /.box -->
@endsection