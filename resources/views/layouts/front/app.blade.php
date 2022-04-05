<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom.css?').env('VERSION') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/responsive.css?').env('VERSION') }}" rel="stylesheet" type="text/css">
    @yield('css')

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.11/angular.js"></script>

</head>
<body ng-app="MarlowsAPP">
    @include('layouts.front.header')

    @yield('content')

    @include('layouts.front.footer')

<script src="{{ asset('assets/js/controllers/app.js?').env('VERSION')}}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js?').env('VERSION') }}"></script>
<script src="{{ asset('assets/js/custom.js?').env('VERSION') }}"></script>
@yield('js')

<script>
    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
           $('.header-main').addClass('sticky-header');
        } else {
           $('.header-main').removeClass('sticky-header');
        }
    });
</script>
<!-- Menu toggle -->
<script>
$(document).ready(function(){
  $(".togglebar-nav").click(function(){
    $("body").toggleClass("navbars-show");
  });
  $(".mobile-serch-box").click(function(){
    $("body").addClass("show-search-box");
  });
  $(".remve-mobile-serch-box").click(function(){
    $("body").removeClass("show-search-box");
  });
});
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.accordian-toggle').click(function() {        
     $(".footer-title").siblings('.footerlinks-col').toggle('show');
        });
    });
</script>
</body>
</html>