@extends('admin.layouts.main',[
                                'page_header'       => 'الصفحات ',
                                'page_description'  => 'صفحة جديدة'
                                ])
@section('content')
    <div class="box box-primary">
        <div class="box-body">
            <div class="pull-right">
                <a href="{{url('admin/page/create')}}" class="btn btn-primary">
                    <i class="fa fa-plus"></i>صفحة جديده
                </a>
            </div>
            <div class="clearfix"></div>
            <br>
            @include('flash::message')
            @if(!empty($pages))
                <div class="table-responsive">
                    <table class="data-table table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>العنوان  </th>
                        <th class="text-center">تعديل</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($pages as $page)
                            <tr id="removable{{$page->id}}">
                                <td>{{$count}}</td>
                                <td>{{$page->title}}</td>

                                <td class="text-center">
                                    <a href="page/{{$page->id}}/edit" class="btn btn-xs btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <button id="{{$page->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('page.destroy',$page->id)}}"
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
                    {!! $pages->render() !!}
                </div>
            @endif
            <div class="clearfix"></div>
        </div>
    </div>
@stop