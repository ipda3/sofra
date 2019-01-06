@extends('admin.layouts.main',[
                                'page_header'       => 'المناطق',
                                'page_description'  => 'منطقة جديدة'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'RegionController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}
    <div class="box-body">
        @include('admin.regions.form')
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
    </div>
    {!! Form::close()!!}
</div><!-- /.box -->
@endsection