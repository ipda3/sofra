@extends('admin.layouts.main',[
                                'page_header'       => 'العمليات المالية',
                                'page_description'  => 'إضافة العمليات المالية'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'TransactionController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST',
                            'files'=>true
                            ])!!}

    <div class="box-body">
        @include('admin.transactions.form',$model)
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection