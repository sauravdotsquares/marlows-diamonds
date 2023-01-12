@inject('header_settings', 'App\Models\Settings')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not found</title>
    <meta name="description" content="{!! isset($data->meta_description)?$data->meta_description:'' !!}" />
    <meta name="robots" content="noindex, nofollow">

    @include('layouts.front.seo_header')

	  <link rel="shortcut icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/x-icon" />
	  <link rel="apple-touch-icon" href="{{ asset('assets/images/apple-icon-180x180.png') }}" />
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css?').env('VERSION') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/developer.css?').env('VERSION') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css?').env('VERSION') }}" rel="stylesheet">

    @yield('css')

    <script>
      var systemBaseUrl = '<?php echo url("/"); ?>/';
    </script>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.11/angular.js"></script>
    <style>
      [ng-cloak] {  display: none !important; }
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-1365164-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-1365164-1');
    </script>
    
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WBT3LKH');</script>
    <!-- End Google Tag Manager -->

</head>
<body ng-app="MarlowsAPP">
    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WBT3LKH"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    @yield('google-ecommerce')
    @include('layouts.front.header')

    @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
    @endif

    @yield('content')

    @include('layouts.front.footer')


    <script>
      const mapMarker = '{{ asset("images/map_marker.png") }}';
    </script>

<script src="{{ asset('assets/js/angular-route.min.js?').env('VERSION')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.11/angular-sanitize.js"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js?').env('VERSION')}}"></script>
<script src="{{ asset('assets/js/controllers/app.js?').env('VERSION')}}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js?').env('VERSION') }}"></script>
<script src="{{ asset('assets/js/ui-bootstrap-tpls-0.5.0.js?').env('VERSION') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
{{-- .env('VERSION') --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRuSAPepWzsXoo0rJiXvDyWDDuuaR_2YU" defer ></script>


@yield('js')
<script>



  $(document).ready(function(){
    
      $('.show-more-content').hide();
      $('.show-more').click(function(){

        const element = $(this).parents('.reviewr-review-text');
        if(element.hasClass('show-text-col')){
          $(this).text('Read more');
          element.removeClass('show-text-col');
        }else{
          $(this).text('Read less');
          element.addClass('show-text-col');
        }

        // $(this).parents('.reviewr-review-text').toggleClass("show-text-col");
      });

    // Zopim zendesk Chat JS function Call start
    window.zopimloaded = false;
    setTimeout(function(){
        if(window.zopimloaded == false){
            loadZopim();
            window.zopimloaded = true;
        }
    }, 3000);
    // Zopim zendesk Chat JS function Call End
  });

    // Zopim zendesk Chat JS function apply Start
    function loadZopim(){
        window.$zopim || (function (d, s) {
            var z = $zopim = function (c) {
                z._.push(c)
            }, $ = z.s =
            d.createElement(s), e = d.getElementsByTagName(s)[0]; z.set = function (o) {
                z.set.
                _.push(o)
            }; z._ = []; z.set._ = []; $.async = !0; $.setAttribute('charset', 'utf-8');  $.setAttribute('defer', 'defer');
            $.src = 'https://v2.zopim.com/?lAfFPTz4EQR4ncicqFdIqIA6clXDoO0f'; z.t = +new Date; $.
            type = 'text/javascript'; e.parentNode.insertBefore($, e)
        })(document, 'script');

        $zopim(function () {
            $zopim.livechat.button.setColor('#FFCC00');
        });
    }

    // Zopim zendesk Chat JS function apply End


</script>
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

<!-- footer collapse -->
<script>
  if($(window).innerWidth() <= 767) {
    $(document).ready(function() {
        $('.accordian-toggle').click(function() {
          $(this).parents('.column-one-fifth').toggleClass('show-collapse');
        });
      });
  }
</script>

<!-- header dropdown menu level collapse -->
<script>
  if($(window).innerWidth() <= 1024) {
    $(document).ready(function() {
        $('.main-navigaiton .nav-navbars .level-zero .fa-angle-down').on('click',function() {
            $(this).parents('.level-0').toggleClass('show-menus');
        });
        $('.main-navigaiton .nav-navbars .level-zero .fa-angle-right').on('click',function() {
            $(this).parents('.level-1').toggleClass('show-menus');
        });
    });
  }
</script>



<script>
    /*$(function() {
        $('input.typeahead').focusout(function() {
          $(this).val(" ");
          $('.search-suggestion').html(" ");
          $('.search-suggestion').hide();
        });
    });*/

    /*$("input.typeahead").on('keyup',function(e){
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
    });*/
</script>
</body>
</html>
