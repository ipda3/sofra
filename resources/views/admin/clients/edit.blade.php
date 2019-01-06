@extends('admin.layouts.main',[
                                'page_header'       => 'أصناف الطعام',
                                'page_description'  => 'تعديل صنف'
                                ])
@section('content')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cutlery"></i> {{$restaurant->name}}</a></li>
    </ol>
    <!-- general form elements -->
    <div class="box box-primary">
        <!-- form start -->
        {!! Form::model($model,[
                                'url'=> 'admin/'.$restaurant->id.'/item/'.$model->id,
                                'id'=>'myForm',
                                'role'=>'form',
                                'method'=>'PUT',
                                'files' => true
                                ])!!}

        <div class="box-body">

            @include('admin.items.form')

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>

        </div>
        {!! Form::close()!!}

    </div><!-- /.box -->

@endsection