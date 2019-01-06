@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('city','App\Models\City')
@inject('user','App\User')
@inject('category','App\Models\Category')
@php
$restaurant_admins = [ 0 => 'بدون مدير' ]+$user->whereHas('roles',function($q){
$q->where('name','restaurant_admin');
})->pluck('name','id')->toArray();
$restaurant_contractors = [ 0 => 'بدون مندوب' ]+$user->whereHas('roles',function($q){
$q->where('name','restaurant_contractor');
})->pluck('name','id')->toArray();
$cities = [0 => 'اختر المدينة'] + $city->pluck('name','id')->toArray();
$regions = [0 => 'اختر المنطقة'];
$selected = null;
$selectedRegion = null;
if($model->region_id > 0)
{
$selected =  $model->region->city->id;
$selectedRegion = $model->region->id;
$regions = $regions+$city->find($selected)->regions()->pluck('name','id')->toArray();
}
$plugin = 'select2';
$placeholder = 'اختر المدينة';

$days = [
0 => 'الأحد',
1 => 'الأثنين',
2 => 'الثلاثاء',
3 => 'الأربعاء',
4 => 'الخميس',
5 => 'الجمعة',
6 => 'السبت'
];

$option=' <option value="0">إختر المنطقة</option>';
@endphp
<div class="row">
    <div class="col-md-6">
        {!! Field::text('name' , 'اسم المطعم') !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('name_en' , ' Restaurant name ') !!}
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        {!! Field::textarea('general_info',' نبذه') !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('general_info_en','brief') !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('about','عن المطعم') !!}
    </div>
    <div class="col-md-6">
        {!! Field::textarea('about_en','about') !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('contact','للتواصل') !!}
    </div>
    <div class="col-md-6">
        {!! Field::text('contact_en','Contact') !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('delivery','خدمة توصيل الطلبات',['1' => 'نعم', '0' => 'لا']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('takeaway','خدمة التقاط الطلبات',['1' => 'نعم', '0' => 'لا']) !!}
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="city_id">إختر المدينة</label>
            <div class="">
                {!! Form::select('city_id',$cities,$selected,[
                "class" => "form-control ".$plugin,
                "id" => 'city_id',
                "data-placeholder"=> $placeholder,
                'data-url' => url('api/v1/regions_ajax')
                ])  !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div  class="form-group">
            <label for="region_id" class="control-label">اختر المنطقة</label>
            {!! Form::select('region_id',$regions,$selectedRegion,[
                "class" => "form-control ".$plugin,
                "id" => 'region_id',
                "data-placeholder"=> $placeholder
                ])  !!}
        </div>
    </div>

    <div class="col-md-6">
        {!! Field::number('minimum_takeaway','الحد الأدني للطلبات') !!}
    </div>

    <div class="col-md-6">
        {!! Field::select('availability','حالة المطعم',['open' => 'مفتوح', 'soon' => 'قريبا', 'closed' => 'مغلق']) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('user_id','مدير المطعم',$restaurant_admins) !!}
    </div>
    <div class="col-md-6">
        {!! Field::select('contractor_id','مندوب المطعم',$restaurant_contractors) !!}
    </div>
</div>
<div class="clearfix"></div>

{{--{!! Field::multiSelect('regions_list' , 'اختر مناطق التوصيل',$delivery_regions) !!}--}}

<hr>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">فترات العمل</label>
            <div id="work_times">
                @if(count($model->working_times) > 0 )
                    @foreach($model->working_times as $time)
                        <div id="main_time" class="row">
                            <div class="col-sm-3">
                                {!! Form::select('weekdays[]',$days,$time->weekday,[
                                "class" => "form-control"
                                ]) !!}
                            </div>
                            <div class="col-sm-3">
                                <input type="time" value="{{$time->opening}}" name="from[]" placeholder="من" class="form-control from " style="direction: ltr">
                            </div>
                            <div class="col-sm-3">
                                <input type="time" value="{{$time->closing}}" name="to[]" placeholder="إلى" class="form-control to " style="direction: ltr">
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-danger" onclick="deleteDynamicPhone(this)" ><i class="fa fa-trash-o"></i></button>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                        </div>
                    @endforeach
                @else
                    <div id="main_time" class="row">
                        <div class="col-sm-2">
                            {!! Form::select('weekdays[]',$days,null,[
                                "class" => "form-control"
                                ]) !!}
                        </div>
                        <div class="col-sm-2">
                            <input type="time" name="from[]" placeholder="من" class="form-control from" style="direction: ltr">
                        </div>
                        <div class="col-sm-2">
                            <input type="time" name="to[]" placeholder="إلى" class="form-control to" style="direction: ltr">
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-danger" onclick="deleteDynamicPhone(this)" ><i class="fa fa-trash-o"></i></button>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                    </div>
                @endif
            </div>
            <br>
            <button class="btn btn-primary" id="new_time"><i class="fa fa-plus-circle"></i> أضف </button>
        </div>
    </div>
    <div class="col-md-6">
        {!! \App\Ibnfarouk\MyClasses\Field::multiSelect('categories_list','اختر التصنيفات',$category->pluck('name','id')->toArray()) !!}
    </div>
</div>
<br>
<hr>
{!! Field::text('address' , 'العنوان') !!}
{!! Field::gMap(null,true,true,300) !!}
<hr>
{!! Field::fileWithPreview('logo','شعار المطعم') !!}
@if($model->logo != '')
    <div class="col-md-3">
        <img src="{{asset($model->logo)}}" class="img-responsive" alt="">
    </div>
    <div class="clearfix"></div>
    <br>
@endif
<hr>
{!! Field::multiFileUpload('photos[]','اختر صور المطعم') !!}
@if($model->has('photos'))
    @foreach($model->photos as $photo)
        <div class="col-md-3" id="removable{{$photo->id}}">
            <img src="{{asset($photo->url)}}" class="img-responsive" alt="">
            <div class="clearfix"></div>
            <button id="{{$photo->id}}" data-token="{{ csrf_token() }}"
                    data-route="{{URL::route('photo.destroy',$photo->id)}}"
                    type="button" class="destroy btn btn-danger btn-xs btn-block">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    @endforeach
    <div class="clearfix"></div>
    <br>
@endif


