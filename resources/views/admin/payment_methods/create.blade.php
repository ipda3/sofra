@extends('admin.layouts.main',[
                                'page_header'       => 'طرق الدفع',
                                'page_description'  => 'أضف جديد'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'PaymentMethodController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}

    <div class="box-body">

        @include('admin.payment_methods.form')

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection