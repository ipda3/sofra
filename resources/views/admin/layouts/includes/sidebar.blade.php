<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="{{asset('AdminLTE-2.3.0/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{Auth::user()->roles()->first()->display_name}}</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="بحث...">--}}
              {{--<span class="input-group-btn">--}}
                {{--<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>--}}
                {{--</button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">لوحة التحكم</li>
            <li><a href="{{url('admin')}}"><i class="fa fa-dashboard"></i> لوحة التحكم</a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-cutlery"></i> <span>المطاعم</span> <i
                            class="fa fa-angle-left pull-left"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/restaurant')}}">عرض المطاعم</a></li>
                    @if( auth()->user()->hasRole('admin','editor') )<li><a href="{{url('admin/category')}}">تصنيفات المطاعم</a></li>@endif
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-cutlery"></i> <span>الطلبات</span> <i
                            class="fa fa-angle-left pull-left"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/order')}}"> عرض الطلبات</a></li>
                </ul>
            </li>
            <li><a href="{{url('admin/transaction')}}"><i class="fa fa-money"></i> العمليات المالية</a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-list-ul"></i> <span>المناطق</span> <i
                            class="fa fa-angle-left pull-left"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('admin/city')}}">المدن</a></li>
                    <li><a href="{{url('admin/region')}}">المناطق</a></li>
                </ul>
            </li>
            <li><a href="{{url('admin/offer')}}"><i class="fa fa-tags"></i> العروض</a></li>
            <li><a href="{{url('admin/client')}}"><i class="fa fa-users"></i> العملاء ( طالبي الطعام )</a></li>

{{--            <li><a href="{{url('admin/docs')}}">توثيق الويب سيرفس</a></li>--}}
            <!-- Optionally, you can add icons to the links -->
            {{--<li class="treeview">--}}
                {{--<a href="#"><i class="fa fa-us"></i> <span>إدارة المستخدمين</span> <i--}}
                            {{--class="fa fa-angle-left pull-left"></i></a>--}}
                {{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{url('admin/user')}}">المستخدمين</a></li>--}}
                    {{--<li><a href="{{url('admin/role')}}">رتب المستخدمين</a></li>--}}
                    {{--<li><a href="#">الصلاحيات</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}

            <li><a href="{{url('admin/payment-method')}}"><i class="fa fa-cc-visa"></i> طرق الدفع</a></li>
            {{--<li><a href="{{url('admin/delivery-method')}}"><i class="fa fa-car"></i> طرق التوصيل</a></li>--}}
            <li><a href="{{url('admin/contact')}}"><i class="fa fa-envelope"></i>تواصل معنا</a></li>
            <li><a href="{{url('admin/settings')}}"><i class="fa fa-cogs"></i> الاعدادات</a></li>
            <li><a href="{{url('admin/user/change-password')}}"><i class="fa fa-key"></i>تغيير كلمة المرور</a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
