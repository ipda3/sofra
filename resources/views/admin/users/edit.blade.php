@extends('admin.layouts.main',[
                                'page_header'       => 'المستخدمين',
                                'page_description'  => 'تعديل مستخدم'
                                ])

@section('content')
<div class="box">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>['UserController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT'
                            ])!!}
    <div class="box-body">
        @include('admin.users.form')
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
    {!! Form::close()!!}
</div>
@stop