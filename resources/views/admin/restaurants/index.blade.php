@inject('city','App\Models\City')
@inject('user','App\User')
@php
$contractors = $user->whereHas('roles',function($q){
$q->where('name','restaurant_contractor');
})->pluck('name','id')->toArray();
$restaurant_admins = [ "" => 'بدون مدير' ]+$user->whereHas('roles',function($q){
$q->where('name','restaurant_admin');
})->pluck('name','id')->toArray();
$cities = $city->pluck('name','id')->toArray();
@endphp
<style>
    span.select2-container {
        z-index: 10050;
        width: 100% !important;
        padding: 0;
    }

    .select2-container .select2-search--inline {
        float: left;
        width: 100%;
    }

    .restaurant-filter span.select2-container {
        z-index: 999;
        width: 100% !important;
        padding: 0;
    }

    /*.modal-open .modal {*/
        /*overflow-x: hidden;*/
        /*overflow-y: auto;*/
        /*z-index: 99999;*/
    /*}*/
</style>
@extends('admin.layouts.main',[
								'page_header'		=> 'المطاعم',
								'page_description'	=> 'عرض المطاعم'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
                <div class="clearfix"></div>
                <br>
                <div class="restaurant-filter">
                    {!! Form::open([
                    'method' => 'get'
                    ]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                'placeholder' => 'اسم المطعم',
                                'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('city_id',$cities,request()->input('city_id'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'المدينة'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{-- 'soon' => 'قريبا', --}}
                            <div class="form-group">
                                {!! Form::select('availability',['open' => 'مفتوح', 'closed' => 'مغلق'],request()->input('availability'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'حالة المطعم'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(count($restaurants) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم المطعم</th>
                        <th>المدينة</th>
                        <th class="text-center">العمولات المستحقة</th>
                        <th class="text-center">حالة المطعم</th>
                        <th class="text-center">تفعيل / إيقاف</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($restaurants as $restaurant)
                            <tr id="removable{{$restaurant->id}}">
                                <td>{{$count}}</td>
                                <td><a style="cursor: pointer" data-toggle="modal" data-target="#myModal{{$restaurant->id}}">{{$restaurant->name}}</a></td>
                                <td>
                                    @if(count($restaurant->region))
                                        {{$restaurant->region->name}}
                                        @if(count($restaurant->region->city))
                                            {{$restaurant->region->city->name}}
                                        @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $restaurant->total_commissions - $restaurant->total_payments }}
                                </td>
                                <td class="text-center">
                                    @if($restaurant->availability == 'open')
                                        <i class="fa fa-circle-o text-green"></i> مفتوح
                                    @else
                                        <i class="fa fa-circle-o text-red"></i> مغلق
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if($restaurant->activated)
                                        <a href="restaurant/{{$restaurant->id}}/de-activate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> إيقاف</a>
                                    @else
                                        <a href="restaurant/{{$restaurant->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> تفعيل</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button id="{{$restaurant->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('restaurant.destroy',$restaurant->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal{{$restaurant->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">{{$restaurant->name}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <ul>
                                                        <li> العنوان :  {{$restaurant->address}}</li>
                                                        <li> المدينة :
                                                            @if(count($restaurant->region))
                                                                {{$restaurant->region->name}}
                                                                @if(count($restaurant->region->city))
                                                                    {{$restaurant->region->city->name}}
                                                                @endif
                                                            @endif
                                                        </li>
                                                        <li> الحد الأدنى للطلبات : {{$restaurant->minimum_charger}}</li>
                                                        <li> للتواصل : {{$restaurant->phone}}</li>
                                                        <hr>
                                                        <li>إجمالي الطلبات : {{$restaurant->total_orders_amount}}</li>
                                                        <li>إجمالي العمولات المستحقة : {{$restaurant->total_commissions}}</li>
                                                        <li>إجمالي المبالغ المسددة : {{$restaurant->total_payments}}</li>
                                                        <li>صافي العمولات المستحقة : {{$restaurant->total_commissions - $restaurant->total_payments}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                    <img height="150px" width="150px" src="{{url('/'.$restaurant->photo.'/')}}"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $restaurants->appends([
                        'name' => request()->input('name'),
                        'city_id' => request()->input('city_id'),
                        'availability' => request()->input('availability'),
                    ])->render() !!}
                </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد سجلات</div>
                </div>
            @endif

        </div>
    </div>


@stop