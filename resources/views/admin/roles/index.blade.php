@extends('admin.layouts.main',[
                                'page_header'       => 'مجموعات المستخدمين',
                                'page_description'  => 'مجموعة جديدة'
                                ])
@section('content')
    <div class="box box-primary">
        <div class="box-body">
            {{--<div class="pull-right">--}}
                {{--<a href="{{url('admin/role/create')}}" class="btn btn-primary">--}}
                    {{--<i class="fa fa-plus"></i>مجموعه جديده--}}
                {{--</a>--}}
            {{--</div>--}}
            <div class="clearfix"></div>
            <br>
            @include('flash::message')
            @if(!empty($roles))
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>الاسم </th>
                        <th>اسم الظهور</th>
                        {{--<th>الوصف</th>--}}
                        {{--<th class="text-center">تعديل</th>--}}
                        {{--<th class="text-center">حذف</th>--}}
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($roles as $role)
                            <tr id="removable{{$role->id}}">
                                <td>{{$count}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->display_name}}</td>
                                {{--<td>{{$role->description}}</td>--}}
                                {{--<td class="text-center"><a href="admin/role/{{$role->id}}/edit"--}}
                                                           {{--class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>--}}
                                {{--</td>--}}
                                {{--<td class="text-center">--}}
                                    {{--<button id="{{$role->id}}" data-token="{{ csrf_token() }}"--}}
                                            {{--data-route="{{URL::route('role.destroy',$role->id)}}"--}}
                                            {{--type="button" class="destroy btn btn-danger btn-xs"><i--}}
                                                {{--class="fa fa-trash-o"></i></button>--}}
                                {{--</td>--}}
                            </tr>
                            @php $count ++; @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $roles->render() !!}
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@stop