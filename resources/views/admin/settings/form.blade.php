@include('admin.layouts.partials.validation-errors')
@include('flash::message')

<h3>اعدادات التطبيق</h3>

<h4>بيانات التواصل الاجتماعي</h4>
{!! \App\Ibnfarouk\MyClasses\Field::text('facebook' , 'فيس بوك') !!}
{!! \App\Ibnfarouk\MyClasses\Field::text('twitter','تويتر') !!}
{!! \App\Ibnfarouk\MyClasses\Field::text('instagram' , 'انستقرام') !!}
<hr>
{!! \App\Ibnfarouk\MyClasses\Field::number('commission','عمولة التطبيق') !!}
{!! \App\Ibnfarouk\MyClasses\Field::editor('about_app','عن التطبيق') !!}
{!! \App\Ibnfarouk\MyClasses\Field::editor('terms','الشروط والأحكام') !!}
<hr>
<h4>بيانات صفحة العمولة</h4>
{!! \App\Ibnfarouk\MyClasses\Field::textarea('commissions_text' , 'نص العمولة') !!}
{!! \App\Ibnfarouk\MyClasses\Field::editor('bank_accounts' , 'الحسابات بنكية') !!}
<hr>



