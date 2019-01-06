@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('role','App\Role')
<?php
$roles = $role->pluck('display_name', 'id')->toArray();
?>

{!! Field::text('name' , 'الاسم') !!}
{!! Field::email('email','الايميل') !!}
{!! Field::text('phone' , 'رقم الهاتف') !!}
{!! Field::password('password','كلمة المرور') !!}
{!! Field::password('password_confirmation','تأكيد كلمة المرور') !!}
{!! Field::multiSelect('roles_list','مجموعه المستخدمين' , $roles  ) !!}



