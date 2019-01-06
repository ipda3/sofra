@extends('admin.layouts.main',[
								'page_header'		=> 'أصناف الطعام',
								'page_description'	=> 'عرض الأصناف'
								])

@section('content')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cutlery"></i> {{$restaurant->name}}</a></li>
        <li><i class="fa fa-long-arrow-left"></i> أصناف الطعام</li>
    </ol>
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(!empty($items))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم الصنف</th>
                        <th>وصف الصنف</th>
                        <th>السعر</th>
                        <th>مدة التحضير</th>
                        <th>الصورة</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($items as $item)
                            <tr id="removable{{$item->id}}">
                                <td>{{$count}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->description}}</td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->preparing_time}}</td>
                                <td>
                                    <a href="{{asset($item->photo)}}" data-lightbox="{{$item->id}}" data-title="{{$item->name}}"><img src="{{asset($item->photo)}}" alt="" style="height: 60px;"></a>
                                </td>
                                <td class="text-center">
                                    <button id="{{$item->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('item.destroy',[$restaurant->id,$item->id])}}"
                                            type="button" class="destroy btn btn-danger btn-xs">
                                        <i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $items->render() !!}
            @endif
        </div>
    </div>
@stop