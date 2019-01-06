@extends('admin.layouts.main',[
                                'page_header'       => 'العمليات المالية',
                                'page_description'  => 'تعديل العمليات المالية'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>['TransactionController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT',
                            'files'=>true
                            ])!!}

    <div class="box-body">

        @include('admin.transactions.form',compact('model'))

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ التعديل</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection