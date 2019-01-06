@extends('admin.layouts.main',[
								'page_header'		=> 'المناطق',
								'page_description'	=> 'عرض المناطق'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/region/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> منطقة جديدة
                </a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(!empty($regions))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم المنطقة</th>
                        <th>المدينة</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($regions as $country)
                            <tr id="removable{{$country->id}}">
                                <td>{{$count}}</td>
                                <td>{{$country->name}}</td>
                                <td>@if(count($country->city) > 0){{$country->city->name}}@endif</td>
                                <td class="text-center">
                                    <a href="region/{{$country->id}}/edit"  class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <button id="{{$country->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('region.destroy',$country->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $regions->render() !!}
            @endif
        </div>
    </div>
@stop