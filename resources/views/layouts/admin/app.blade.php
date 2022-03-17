<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css')}}">
  @yield('css')
  <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js')}}"></script>
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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

<!-- Bootstrap -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('admin/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{ asset('admin/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('admin/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{ asset('admin/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js')}}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admin/dist/js/pages/dashboard2.js')}}"></script>
@yield('js')
</body>
</html>
