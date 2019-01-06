@extends('admin.layouts.main',[
                                'page_header'       => 'الإختيارات ',
                                'page_description'  => 'إضافة إختيار'
                                ])
@section('content')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cutlery"></i> {{$restaurant->name}}</a></li>
        <li><i class="fa fa-angle-double-left" aria-hidden="true"></i> @if(count($item->section)){{$item->section->name}}@endif</li>
        <li><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{$item->name}}</li>
        <li><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{$addon->name}}</li>
    </ol>
    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($model,[
                                'action'=>['OptionController@store',$restaurant->id,$item->id,$addon->id],
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'POST',
                                'files' => true
                                ])!!}
        <div class="box-body">
            @include('admin.options.form')
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        {!! Form::close()!!}
    </div><!-- /.box -->
@endsection