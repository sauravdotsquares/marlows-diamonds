<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{  !empty($page_title) ? "Marlows Admin ::" . $page_title : config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Datatables -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css')}}">
  <!-- Custom style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/custom_admin.css')}}">

  <link rel="stylesheet" href="{{ asset('admin/dist/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.css')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/dist/img/image_2023_03_17T10_13_17_718Z.png') }}">
  
  
  @yield('css')
  <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js')}}" defer></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    
    @include('layouts.admin.header')

    @include('layouts.admin.sidebar')
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include("layouts.admin.breadcrumb")
        @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.admin.footer')

</div>
<!-- ./wrapper -->
<script>
  var csrf_token = '<?php echo csrf_token(); ?>';
</script>
<!-- Bootstrap -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}" defer></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js?').env('VERSION')}}" defer></script>
<!-- overlayScrollbars -->
<script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}" defer></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.js')}}" defer></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('admin/plugins/jquery-mousewheel/jquery.mousewheel.js')}}" defer></script>
<script src="{{ asset('admin/plugins/raphael/raphael.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/jquery-mapael/jquery.mapael.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/jquery-mapael/maps/usa_states.min.js')}}" defer></script>

<script src="{{ asset('admin/plugins/chart.js/Chart.min.js')}}" defer></script>

<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}" defer></script>

<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}" defer></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/sweetalert2/sweetalert2.min.js')}}" defer></script>
<script src="{{ asset('admin/plugins/moment/moment.min.js')}}" defer></script>
<script src="{{ asset('admin/dist/js/pages/dashboard2.js')}}" defer></script>
<script src="{{ asset('admin/js/admin.js')}}" defer></script>


<script>
$(function () {
  bsCustomFileInput.init();
});
var csrf_token = '<?php echo csrf_token(); ?>';
</script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      "paging": false,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
  @include('layouts.toaster')
  @yield('js')
</body>
</html>
