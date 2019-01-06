@extends('admin.layouts.main',[
                                'page_header'       => 'المستخدمين',
                                'page_description'  => 'إضافة مستخدم'
                                ])

@section('content')

<div class="box">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'UserController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
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