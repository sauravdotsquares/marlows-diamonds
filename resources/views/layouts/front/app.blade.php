<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{!! isset($data->meta_title)?$data->meta_title:'' !!}</title>
    <meta name="description" content="{!! isset($data->meta_description)?$data->meta_description:'' !!}" />

    <link rel="canonical" href="{{url()->current()}}" />

    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{!! isset($data->meta_title)?$data->meta_title:'' !!}" />
    <meta property="og:description" content="{!! isset($data->meta_description)?$data->meta_description:'' !!}" />
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:site_name" content="{!! config('app.name') !!}" />
    <meta property="og:image" content="" />
    <meta property="og:image:width" content="120" />
    <meta property="og:image:height" content="120" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@marlowsdiamonds" />

    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/custom.css?').env('VERSION') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/responsive.css?').env('VERSION') }}" rel="stylesheet" type="text/css">
    @yield('css')

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.11/angular.js"></script>

</head>
<body ng-app="MarlowsAPP">
    @include('layouts.front.header')

    @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div> 
    @endif

    @yield('content')

    @include('layouts.front.footer')

<script src="{{ asset('assets/js/angular-route.min.js?').env('VERSION')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.11/angular-sanitize.js"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js?').env('VERSION')}}"></script>
<script src="{{ asset('assets/js/controllers/app.js?').env('VERSION')}}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js?').env('VERSION') }}"></script>
<script src="{{ asset('assets/js/ui-bootstrap-tpls-0.5.0.js?').env('VERSION') }}"></script>
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

<script type="text/javascript">
    $(function() {
        $('input.typeahead').focusout(function() {
          $(this).val(" ");
          $('.search-suggestion').html(" ");
          $('.search-suggestion').hide();
        });
    });

    $("input.typeahead").on('keyup',function(e){
        $('.search-suggestion').html(" ");
        if (e.target.value.length >= 3) {
          $.ajax({
              url: '{{ route("autocomplete") }}',
              method: "get",
              data: {
                  _token: '{{ csrf_token() }}', 
                  query: $(this).val(),
              },
              success: function (response) {
                  if(response.html){
                    $('.search-suggestion').append(response.html);
                    $('.search-suggestion').css('display','block');
                  }
              }
          });
        }        
    });
</script>
</body>
</html>