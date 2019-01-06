@extends('admin.layouts.main',[
                                'page_header'       => ' الصفحات',
                                'page_description'  => 'تعديل صفحة'
                                ])

@section('content')
        <!-- FILE: app/views/start.blade.php -->
<div class="box box-danger">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>['PageController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT'
                            ])!!}
    <div class="box-body">
        @include('admin.pages.form')
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
    {!! Form::close()!!}
</div>
@stop