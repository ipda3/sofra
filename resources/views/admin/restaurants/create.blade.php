@extends('admin.layouts.main',[
                                'page_header'       => 'المطاعم',
                                'page_description'  => 'مطعم جديد '
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'RestaurantController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST',
                            'files'=>'true'
                            ])!!}
    <div class="box-body">
        @include('admin.restaurants.form')
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>
    </div>
    {!! Form::close()!!}
</div><!-- /.box -->
@endsection