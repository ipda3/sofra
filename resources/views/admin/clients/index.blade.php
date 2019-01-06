@extends('admin.layouts.main',[
								'page_header'		=> 'العملاء',
								'page_description'	=> 'طالبي الطعام'
								])

@section('content')
    <div class="box box-primary">
        <div class="box-header">
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(!empty($clients))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم العميل</th>
                        <th>الايميل</th>
                        <th>الهاتف</th>
                        <th>المدينة</th>
                        <th>العنوان</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($clients as $client)
                            <tr id="removable{{$client->id}}">
                                <td>{{$count}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->email}}</td>
                                <td>{{$client->phone}}</td>
                                <td>
                                    @if(count($client->region))
                                        {{$client->region->name}}
                                        @if(count($client->region->city))
                                            {{$client->region->city->name}}
                                        @endif
                                    @endif
                                </td>
                                <td>{{$client->address}}</td>
                                <td class="text-center">
                                    <button id="{{$client->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('client.destroy',$client->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs">
                                        <i class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {!! $clients->render() !!}
            @endif
        </div>
    </div>
@stop