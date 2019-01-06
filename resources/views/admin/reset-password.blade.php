@extends('admin.layouts.main',[
                                'page_header'       => 'المستخدمين',
                                'page_description'  => 'تغيير كلمة المرور'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::open([
                            'action'=>'UserController@changePasswordSave',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}

    <div class="box-body">
        @include('flash::message')
        @include('admin.layouts.partials.validation-errors')
        {!! Field::password('old-password','كلمة المرور الحالية') !!}
        {!! Field::password('password','كلمة المرور الجديدة') !!}
        {!! Field::password('password_confirmation','تأكيد كلمة المرور الجديدة') !!}

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection