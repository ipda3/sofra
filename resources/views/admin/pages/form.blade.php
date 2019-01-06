@include('admin.layouts.partials.validation-errors')
@include('flash::message')

{!! Field::text('title' , 'العنوان') !!}
{!! Field::editor('body' , 'المحتوى') !!}




