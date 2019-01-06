@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('restaurant','App\Models\Restaurant')

{!! \App\Ibnfarouk\MyClasses\Field::select('restaurant_id','المطعم  ',$restaurant->get()->pluck('restaurant_details','id')->toArray()) !!}
{!! \App\Ibnfarouk\MyClasses\Field::number('amount' , 'المبلغ') !!}
{!! Field::text('note','بيان العملية') !!}
