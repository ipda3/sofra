@extends('admin.layouts.main',[
								'page_header'		=> 'الإختيارات ',
								'page_description'	=> 'عرض الإختيارات'
								])

@section('content')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cutlery"></i> {{$restaurant->name}}</a></li>
        <li><i class="fa fa-angle-double-left" aria-hidden="true"></i> @if(count($item->section)){{$item->section->name}}@endif</li>
        <li><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{$item->name}}</li>
        <li><i class="fa fa-angle-double-left" aria-hidden="true"></i> {{$addon->name}}</li>
    </ol>
    <div class="box box-primary">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/'.$restaurant->id.'/'.$item->id.'/'.$addon->id.'/option/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> إضافة إختيار جديد
                </a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(!empty($option))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم الإختيار</th>
                        <th> Option Name</th>
                        <th>السعر</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($option as $opt)
                            <tr id="removable{{$opt->id}}">
                                <td>{{$count}}</td>
                                <td>{{$opt->option_name}}</td>
                                <td>{{$opt->option_name_en}}</td>
                                <td>{{$opt->price}}</td>
                                <td class="text-center">
                                    <a href="option/{{$opt->id}}/edit"  class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <button id="{{$opt->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('option.destroy',[$restaurant->id,$item->id,$addon->id,$opt->id])}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $option->render() !!}
            @endif
        </div>
    </div>
@stop