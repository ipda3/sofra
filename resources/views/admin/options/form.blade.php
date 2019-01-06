@include('admin.layouts.partials.validation-errors')
@include('flash::message')


{!! Field::text('option_name' , 'اسم الإختيار') !!}
{!! Field::text('option_name_en' , 'Option Name') !!}
{!! Field::text('price' , 'سعر الإختيار') !!}



