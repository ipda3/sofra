@extends('admin.layouts.main',[
								'page_header'		=> 'العروض',
								'page_description'	=> 'عرض العروض'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            {{--<div class="pull-right">--}}
                {{--<a href="{{url('admin/offer/create')}}" class="btn btn-primary">--}}
                    {{--<i class="fa fa-plus"></i> عرض جديد--}}
                {{--</a>--}}
            {{--</div>--}}
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(!empty($offers))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>المطعم</th>
                        <th>الصورة</th>
                        <th>بداية العرض</th>
                        <th>نهاية العرض</th>
                        <th class="text-center"> متاح / غير متاح</th>
                        {{--<th class="text-center">تعديل</th>--}}
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($offers as $offer)
                            <tr id="removable{{$offer->id}}">
                                <td>{{$count}}</td>
                                <td>{{$offer->name}}</td>
                                <td>@if(count($offer->restaurant)){{$offer->restaurant->name}}@endif</td>
                                <td>
                                    <a href="{{asset($offer->photo)}}" data-lightbox="{{$offer->id}}" data-title="{{$offer->title}}"><img src="{{asset($offer->photo)}}" alt="" style="height: 60px;"></a>
                                </td>
                                <td>{{$offer->starting_at->format('Y-m-d')}}</td>
                                <td>{{$offer->ending_at->format('Y-m-d')}}</td>
                                <td class="text-center">{!!  ($offer->available) ? '<i class="fa fa-2x fa-check text-green"></i>' : '<i class="fa fa-2x fa-close text-red"></i>' !!}</td>
                                {{--<td class="text-center"><a href="offer/{{$offer->id}}/edit"--}}
                                                           {{--class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>--}}
                                {{--</td>--}}
                                <td class="text-center">
                                    <button id="{{$offer->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('offer.destroy',$offer->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $offers->render() !!}
            @endif
        </div>
    </div>
@stop