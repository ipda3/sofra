@extends('admin.layouts.main',[
                                'page_header'       => 'مجموعات المستخدمين',
                                'page_description'  => 'تعديل مجموعة'
                                ])

@section('content')
        <!-- FILE: app/views/start.blade.php -->
<div class="box box-danger">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>['RoleController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT'
                            ])!!}
    <div class="box-body">
        @include('admin.roles.form')
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
    {!! Form::close()!!}
</div>
@stop