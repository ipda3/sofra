@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('permission','App\Permission')
<?php
$permissions = $permission->pluck('display_name', 'id')->toArray();
?>
{!! Field::text('name' , 'الاسم') !!}
{!! Field::text('display_name' , 'اسم الظهور') !!}
{!! Field::text('description' , 'الوصف') !!}
{!! Field::multiSelect('permissions_list' , 'الصلاحيات', $permissions) !!}




