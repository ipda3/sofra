@extends('admin.layouts.main',[
                                'page_header'       => 'مجموعات المستخدمين',
                                'page_description'  => 'إضافة مجموعة'
                                ])
@section('content')
<div class="box box-danger">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'RoleController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
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