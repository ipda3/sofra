@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('section','App\Models\Section')
@php
$sections=[0 => '']+$section->where('restaurant_id',$restaurant->id)->pluck('name','id')->toArray();
@endphp

<div class="row">
    <div class="col-md-6">
        {!! Field::text('name' , 'اسم الصنف') !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('name_en' , 'Item name') !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('desc', 'وصف الصنف') !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('desc_en', 'Item Description') !!}
    </div>
    <div class="clearfix"></div>
</div>

{!! Field::number('price' , 'السعر') !!}
{!! Field::select('section_id','أقسام القائمة',$sections) !!}
{!! Field::select('is_available','متاح',['1' => 'نعم', '0' => 'لا']) !!}
{!! Field::fileWithPreview('photo','صورة الصنف') !!}
@if($model->photo != '')
    <div class="col-md-3">
        <img src="{{asset($model->photo)}}" class="img-responsive" alt="">
    </div>
    <div class="clearfix"></div>
    <br>
@endif


