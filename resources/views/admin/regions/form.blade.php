@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('city','App\Models\City')
@php
$cities = $city->pluck('name','id')->toArray();
@endphp

{!! Field::text('name' , 'اسم المنطقة') !!}
{!! Field::select('city_id','اختر المدينة',$cities) !!}

