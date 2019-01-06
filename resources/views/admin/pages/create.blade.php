@extends('admin.layouts.main',[
                                'page_header'       => 'الصفحات',
                                'page_description'  => 'إضافة صفحة'
                                ])
@section('content')
<div class="box box-danger">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'PageController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
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