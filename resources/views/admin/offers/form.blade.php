@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('restaurant','App\Models\Restaurant')

@php
$restaurants = [ '' => 'اختر المطعم'] + $restaurant->pluck('name','id')->toArray();
@endphp
{!! \App\Ibnfarouk\MyClasses\Field::text('title' , 'العنوان') !!}
{!! \App\Ibnfarouk\MyClasses\Field::textarea('content','محتوى العرض') !!}
{!! Field::select('restaurant_id','اختر المطعم',$restaurants , 'اختر المطعم') !!}
<div class="row">
    <div class="col-md-6">
        {!! \App\Ibnfarouk\MyClasses\Field::date('date_from','بداية العرض') !!}
    </div>
    <div class="col-md-6">
        {!! \App\Ibnfarouk\MyClasses\Field::date('date_to','نهاية العرض') !!}
    </div>
</div>