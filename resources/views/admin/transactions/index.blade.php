@extends('admin.layouts.main',[
								'page_header'		=> 'العمليات المالية',
								'page_description'	=> 'عرض العمليات'
								])
@inject('restaurant','App\Models\Restaurant')

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <div class="pull-right">
                <a href="{{url('admin/transaction/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>  إضافة عملية مالية
                </a>
            </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            <div class="filter">
                {!! Form::open([
                            'action'=>'TransactionController@index',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'GET',
                            ])!!}
                <div class="row">
                    <div class="col-md-3">
                        {!! Field::select('restaurant_id','',$restaurant->get()->pluck('restaurant_details','id')->toArray()) !!}
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-flat bg-navy btn-block"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            @if(!empty($transactions))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم المطعم</th>
                        <th>المبلغ</th>
                        <th>بيان العملية</th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($transactions as $transaction)
                            <tr id="removable{{$transaction->id}}">
                                <td>{{$count}}</td>
                                <td>{{(count($transaction->restaurant)) ? $transaction->restaurant->name : ''}}</td>
                                <td>{{$transaction->amount}}</td>
                                <td>{{$transaction->note}}</td>
                                <td class="text-center">
                                    <a href="transaction/{{$transaction->id}}/edit" class="btn btn-xs btn-success">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <button id="{{$transaction->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('transaction.destroy',$transaction->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i
                                                class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center">
                    {!! $transactions->appends([
                    'restaurant_id' => \Request::input('restaurant_id'),
                ])->render() !!}
                </div>
            @endif
        </div>
    </div>
@stop