@extends('admin.layouts.main',[
                                'page_header'       => 'طرق التوصيل',
                                'page_description'  => 'أضف جديد'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'DeliveryMethodController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}

    <div class="box-body">

        @include('admin.delivery_methods.form')

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection