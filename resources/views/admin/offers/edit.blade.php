@extends('admin.layouts.main',[
                                'page_header'       => 'العروض',
                                'page_description'  => 'تعديل عرض'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>['OfferController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'PUT',
                            'files'=>true
                            ])!!}

    <div class="box-body">

        @include('admin.offers.form',compact('model'))

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection