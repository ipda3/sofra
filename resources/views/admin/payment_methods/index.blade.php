@extends('admin.layouts.main',[
								'page_header'		=> 'طرق الدفع',
								'page_description'	=> 'عرض الكل'
								])
@section('content')
    <div class="box box-default">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/payment-method/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> أضف جديد
                </a>
            </div>
        </div>
        @if(!empty($payment_methods))
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
                    @foreach($payment_methods as $record)
                        <tr id="removable{{$record->id}}">
                            <td>{{$count}}</td>
                            <td>{{$record->name}}</td>
                            <td class="text-center"><a href="payment-method/{{$record->id}}/edit" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a></td>
                            <td class="text-center">
                                <button id="{{$record->id}}" data-token="{{ csrf_token() }}" data-route="{{URL::route('payment-method.destroy',$record->id)}}"  type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        @php $count ++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
            {!! $payment_methods->render() !!}
        @endif


    </div>
@stop