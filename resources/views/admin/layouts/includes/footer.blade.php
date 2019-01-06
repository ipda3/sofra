<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        تصميم وبرمجة شركة ابداع تك
    </div>
    <!-- Default to the left -->
    <strong>&copy; 2018 <a href="#">{{config('app.name')}}</a>.</strong> جميع الحقوق محفوظة
</footer>
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<!-- Pusher -->
<script src="{{asset('AdminLTE-2.3.0/plugins/pusher/pusher.min.js')}}"></script>
<!-- jQuery 2.1.4 -->
<script src="{{asset('AdminLTE-2.3.0/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('AdminLTE-2.3.0/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('AdminLTE-2.3.0/dist/js/app.min.js')}}"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
<script src="{{asset('AdminLTE-2.3.0/plugins/jquery-confirm/jquery.confirm.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/select2/select2.full.min.js')}}"></script>
{{--<script src="{{asset('AdminLTE-2.3.0/plugins/datepicker/bootstrap-datepicker.js')}}"></script>--}}
<script src="{{asset('AdminLTE-2.3.0/plugins/jQueryUI/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src='http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyAJDNGhvRiWXMvI7VjALT363E3QMOqp6j8'></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/locationpicker/dist/locationpicker.jquery.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('AdminLTE-2.3.0/plugins/bootstrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/bootstrap-fileinput/js/fileinput_locale_ar.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/lightbox2/js/lightbox.min.js')}}"></script>
<script src="{{asset('AdminLTE-2.3.0/plugins/wickedpicker/wickedpicker.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js  "></script>
<script src="{{asset('AdminLTE-2.3.0/summernote.min.js')}}"></script>
<script>
    /**
     * summer note
     **/
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300
        });
    });
</script>
<script>
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('restaurant_admin'))
            window.restaurants_id = [];
            window.is_restaurant_admin = false;
        @if(auth()->user()->hasRole('restaurant_admin'))
            window.is_restaurant_admin = true;
            @if(count(auth()->user()->restaurants) > 0)
            @foreach(auth()->user()->restaurants()->pluck('id')->toArray() as $rest)
            window.restaurants_id.push("{{$rest}}");
            @endforeach
            @endif
        @endif
        window.can_see_order = true;
    @endif
</script>
<script src="{{asset('js/ibnfarouk.js')}}"></script>
<script>
    $('#Modal').click(function(){

    });
</script>
</body>
</html>
