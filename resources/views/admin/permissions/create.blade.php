@extends('layouts.app')
    @section('content')
    <div class="container">
    {!! Form::model($permission ,[
                    'action'=>'PermissionController@store',
                    'data-toggle'=>'validator',
                    'id'=>'myForm',
                    'role'=>'form',
                    'method'=>'POST'
                    ])!!}
    @include('permissions.form');
    {!! Form::close()!!}
    </div>
@endsection