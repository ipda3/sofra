@extends('admin.layouts.main',[
								'page_header'		=> 'طرق التوصيل',
								'page_description'	=> 'عرض الكل'
								])
@section('content')
    <div class="box box-default">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/delivery-method/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> أضف جديد
                </a>
            </div>
        </div>
        @if(!empty($delivery_methods))
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <th>#</th>
                <th>الاسم</th>
                <th class="text-center">تعديل</th>
                <th class="text-center">حذف</th>
                </thead>
                <tbody>
                    @php $count = 1; @endphp
                    @foreach($delivery_methods as $record)
                        <tr id="removable{{$record->id}}">
                            <td>{{$count}}</td>
                            <td>{{$record->name}}</td>
                            <td class="text-center"><a href="delivery-method/{{$record->id}}/edit" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a></td>
                            <td class="text-center">
                                <button id="{{$record->id}}" data-token="{{ csrf_token() }}" data-route="{{URL::route('delivery-method.destroy',$record->id)}}"  type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        @php $count ++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
            {!! $delivery_methods->render() !!}
        @endif


    </div>
@stop