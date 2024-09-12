@inject('header_settings', 'App\Models\Settings')
@inject('header_settingss', 'App\Models\SettingsLang')
<style>
    .discount_timer{
        font-weight: 800;
        letter-spacing: 2px;
        /* display: none; */
    }
    .post-bar-center{
        width: 38.33%;
        font-weight: 800;
    }
    .search-suggestion.hide_254 {display: none;}
</style>
<!-- Header Start here -->
<header class="header-main">
    <!-- Mobile Top Start here -->

    <?php
        $now = new DateTime("now");
        $lastDate = new DateTime('now');
        $lastDate->modify('last day of this month');        
        $dist_future = $lastDate->format('m/d/Y');
    ?>

    <div class="top-bar-mob">
        <div class="container">
            <div class="owl-carousel owl-theme mobil-bar">
                <div class="item">
                    <a class="whatspp-num" href="javascript:void(0);">
                        {!!$header_settings->get_options('header-right')!!}
                        {{--WHATSAPP_TITLE--}} {{--$header_settings->get_options('field1')--}}
                    </a>
                </div>
                <div class="item">
                    <div class="addr-number">
                        <p>{!!$header_settings->get_options('field2')!!}</p>
                    </div>
                </div>
                <div class="item">
                    <p>{!!$header_settings->get_options('field3')!!}</p>
                </div>
                <div class="item">
                    {!!$header_settings->get_options('field4')!!}
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Top end here -->

    <!--Top bar start -->
    <div class="top-bar">
        <div class="container">
            <p>{{$header_settings->get_options('top-bar-desktop')}}</p>
        </div>
    </div>
    <!--Top bar end -->

    <!--middle Top bar start -->
    <div class="middle-topbar">
        <div class="container">
            <div class="middle-topbar-wrap flexed flex-justify-between">
                <div class="middle-topbar-left">
                    <div class="whatsapp-top-h">
                        <a class="whatspp-num" target="_blank" href="https://api.whatsapp.com/send?phone=447449262928">
                            <img src="{{asset('assets/images/whatsapp.png')}}" alt="whatsApp">
                        </a>
                    </div>
                    <div class="location-top-h">
                        <a href="{{asset('visit-us')}}">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>{{LOCATION_TITLE}}
                            <div class="location-drop">
                                <div class="location-drop-inner">
                                    <p class="location-details-title">{{BRIMINGHAM_LOCATION_TITLE}}</p>
                                    <p class="location-text">{!!$header_settings->get_options('location1')!!}</p>
                                </div>
                                <div class="location-drop-inner">
                                    <p class="location-details-title">{{LONDON_LOCATION_TITLE}}</p>
                                    <p class="location-text">{!!$header_settings->get_options('location2')!!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="middle-topbar-right">
                    <ul>
                        <li>
                            <div class="head-mini-search">
                        <div class="remve-mobile-serch-box">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </div>
                        <form id="homeSearchForm" ng-controller="CommonController">
                            <div class="formgroup">
                                <input type="text" name="search" class="typeahead search-selection-text" placeholder="Search for product.." ng-model="search" ng-keyup="searchProducts()" autocomplete="off">
                                <button class="seach-btn" type="button"><i class="diamond-icon search-top"></i></button>
                            </div>
                            <div class="search-suggestion hide_<%searchResults.length%>" ng-if="searchResults.length>0" ng-cloak>
                                <div class="search-suggestion-list" ng-repeat="result in searchResults">
                                    <a href="/product/<%result.slug%>">
                                        <div class="search-suggestion-img">
                                            <img ng-src="{{env('APP_IMAGE_URL').'/storage'}}/<% result.get_product_images.image_url || 'defult.png' %>" alt="Marlow's Diamond">
                                        </div>
                                        <div class="search-suggestion-text">
                                            <div class="search-suggestion-title">
                                                <%result.title%>
                                            </div>
    
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="search-suggestion" ng-if="searchResults.length==0" ng-cloak>
                                <p>No Product Found.</p>
                            </div>
                        </form>
                    </div>
                        </li>
                        <li class="my-account-blk">
                        @if(auth()->guard('customer')->check())   
                            <a href="{{route('my-account')}}"><i class="fa fa-user-o" aria-hidden="true"></i>{{MY_ACCOUNT_TITLE}}</a>
                        @else
                            <a href="{{route('my-account')}}"><i class="fa fa-user-o" aria-hidden="true"></i>{{MY_ACCOUNT_LOGIN}}</a>
                        @endif
                        </li>
                        <li class="my-whishlist-blk">
                            <?php
                                $getArray = session('wishlist');
                                if(isset($getArray) && count($getArray)){
                                    $wishlistIcon = 'fa-heart';
                                }else{
                                    $wishlistIcon = 'fa-heart-o';
                                }
                            ?>
                                <a href="{{route('products.wishlist')}}"><i class="fa {{$wishlistIcon}} wishcount" aria-hidden="true"></i>{{MY_WISHLIST_TITLE}}</a>
                        </li>
                        <!-- <li class="my-cart-blk">
                            <a href="#"><img src="assets/images/cart-color.png" alt="cart"> {{MY_CART_TITLE}}<span class="cart-number">(0)</span></a>
                        </li> -->
                        <li class="dropdown">
                            <a href="{{ route('product.cart') }}">

                                <!--<img src="{{env('APP_IMAGE_URL').'/assets/images/cart-color.png'}}" alt="cart">-->
                                <i class="diamond-icon search-cart"></i>
                                <!-- <i class="fa fa-shopping-bag" aria-hidden="true"></i> -->
                                {{MY_CART_TITLE}} <span class="badge badge-pill badge-danger cartcount">{{ count((array) session('cart')) }}</span>

                            </a>
                            <div class="dropdown-menu">
                                <div class="row total-header-section">
                                    <div class="col-lg-6 col-sm-6 col-6">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                                    </div>
                                    @php $total = 0 @endphp
                                    <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                        <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                                    </div>
                                </div>
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                        <!-- <div class="row cart-detail">
                                            <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                                <img src="{{ $details['image'] }}" />
                                            </div>
                                            <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                                <p>{{ isset($details['name'])?$details['name']:'' }}</p>
                                                <span class="price text-info"> ${{ isset($details['price'])?$details['price']:'' }}</span> <span class="count"> Quantity:{{ isset($details['quantity'])?$details['quantity']:'' }}</span>
                                            </div>
                                        </div> -->
                                    @endforeach
                                @endif
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                        <a href="{{ route('product.cart') }}" class="btn btn-primary btn-block">View all</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--middle Top bar end -->

    <!-- Navbars and logo start here -->
    <div class="logo-menu-bar">
        <div class="container">
            <div class="logo-menu-bar-wrap flexed flex-justify-between">

                <div class="site-logo-main">
                    <a href="{{url('/')}}" title="{{$header_settings->get_options('site_title')}}">
                        @if($header_settings->get_options('logo')!='')
                            <img src="{{env('APP_IMAGE_URL').'/images/logo/'.$header_settings->get_options('logo')}}" alt="{{$header_settings->get_options('site_title')}}">
                        @elseif($header_settings->get_options('site_title')!='')
                            <div>{{$header_settings->get_options('site_title')}}</div>
                            <span>{{$header_settings->get_options('site_tagline')}}</span>
                        @else
                            <span>{{env('APP_NAME')}}</span>
                        @endif
                    </a>
                </div>
                <div class="mobile-cart-wishlist">
                      <div class="mobile_search">
                          <a>
                              <i class="fa fa-search" aria-hidden="true"></i>
                          </a>
                      </div>
                      <div class="whats_app">
                            <a class="whatspp-num" target="_blank" href="https://api.whatsapp.com/send?phone=447449262928">
                                <img src="{{asset('assets/images/whatsapp.png')}}" alt="whatsApp">
                            </a>
                      </div>
                    <div class="mobile-wishlist mobile-acc">
                            <a href="/my-account"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                    </div>
                    <div class="mobile-wishlist">
                        <?php
                                $getArray = session('wishlist');
                                if (isset($getArray) && count($getArray)) {
                                    $wishlistIcon = 'fa-heart';
                                } else {
                                    $wishlistIcon = 'fa-heart-o';
                                }
                            ?>
                            <a href="{{ route('products.wishlist') }}" title="Wishlist"><i
                                    class="fa {{ $wishlistIcon }} wishcount" aria-hidden="true"></i>
                            </a>
                    </div>
                    <div class="mobile-cart">
                        <a href="{{ route('product.cart') }}">
                            <img src="{{env('APP_IMAGE_URL').'/assets/images/cart-color-black.png'}}" alt="cart">
                            <!-- <i class="fa fa-shopping-bag" aria-hidden="true"></i> -->
                        <span class="mob-cart-number cartcount">{{ count((array) session('cart')) }}</span>
                        </a>
                    </div>

                </div>
                <div class="main-navigaiton">
                    <div class="navbar-toggler">
                        <div class="togglebar-nav">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="menus-wraper">
                        <div class="navbar-toggler">
                        <div class="togglebar-nav">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                        <!--<div class="mobile-serch-box">-->
                        <!--    <form ng-controller="CommonController" >-->
                        <!--        <div class="formgroup">-->
                        <!--            <input type="text" name="search" class="typeahead search-selection-text" placeholder="Search for product.." ng-model="search" ng-keyup="searchProducts()" autocomplete="off">-->
                        <!--            <button class="seach-btn" type="button"><i class="diamond-icon search-top"></i></button>-->
                        <!--        </div>-->
                        <!--        <div class="search-suggestion hide_<%searchResults.length%>" ng-if="searchResults.length>0" ng-cloak>-->
                        <!--            <div class="search-suggestion-list" ng-repeat="result in searchResults">-->
                        <!--                <a href="/product/<%result.slug%>">-->
                        <!--                    <div class="search-suggestion-img">-->
                        <!--                        <img ng-src="{{env('APP_IMAGE_URL').'/storage'}}/<% result.get_product_images.image_url || 'defult.png' %>" alt="Marlow's Diamond">-->
                        <!--                    </div>-->
                        <!--                    <div class="search-suggestion-text">-->
                        <!--                        <div class="search-suggestion-title">-->
                        <!--                            <%result.title%>-->
                        <!--                        </div>-->
        
                        <!--                    </div>-->
                        <!--                </a>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--        <div class="search-suggestion" ng-if="searchResults.length==0" ng-cloak>-->
                        <!--            <p>No Product Found.</p>-->
                        <!--        </div>-->
                        <!--    </form>-->
                        <!--</div>-->
                    <nav class="nav-navbars">

                        <ul class="static-megamenu">

                            @if(!empty($navbars))
                                
                                @foreach($navbars as $keyCount => $navbarItem)
                                    <li class="level-zero submenu {{$navbarItem['class_level']}}">
                                        <span>
                                            <a href="{{url($navbarItem['href'])}}">
                                                {!! $navbarItem['text'] !!}
                                            </a>
                                        @if(isset($navbarItem['children']) && count($navbarItem['children']) > 0)
                                            <i class="fa fa-angle-down {{$navbarItem['class_level']}}" aria-hidden="true"></i>
                                        @endif

                                        </span>
                                        @if(isset($navbarItem['children']) && count($navbarItem['children']) > 0)
                                            @include('layouts.front.menus-sub', ['subs' => $navbarItem['children'],'count'=>$keyCount, 'titlename' => $navbarItem['title']])
                                        @endif
                                    </li>
                                @endforeach

                            @endif
                        </ul>
                    </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Navbars and logo end here -->

    <!-- Post bar start -->
                            
    <?php 
        $getMonthTextArray = getMonthwiseDiscountText();
        $getCurrentMonth = (int)date('m');
    ?>
  <div class="post-bar">
        <div class="container">
            <div class="post-bar-wraper flexed flex-justify-between flex-items-center header-post-bar-wraper">
                <div class="post-bar-left header-post-bar-left">
                    <p>{!!$header_settings->get_options('header-left')!!}</p>
                </div>
                @if($lastDate > $now)
                <div class="post-bar-center" style="height: 40px;">
                    {{-- <a href="{{ route('products.exclusive') }}" >
                        <span> Exclusive to Marlows </span>
                    </a> --}}
                    {{-- <p>Mid Season Sale - Up to 30% off </p>  --}}
                    <p id="offer-text"> {{$getMonthTextArray[$getCurrentMonth]}} </p>
                    <p>
                    {{-- <span class="header-heighlight-text">Up to 35% off</span> --}}
                         <span class="header-heighlight-text discount_timer"></span>
                        <br>

                    </p>
                </div>
                @endif
                <div class="post-bar-right header-post-bar-left">
                    <p>{!!$header_settings->get_options('header-right')!!}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Post bar end -->

</header>
<!-- Header end here -->


<script>

        $(document).ready(function(){
            // Attach click event to body
            $('body').click(function(){
                // Clear search input value
                var removedDiv = $('.search-suggestion-list.ng-scope').remove();
                if(removedDiv){
                    $('.search-suggestion.hide_1').css('border','none');
                }else{
                    $('.search-suggestion.hide_1').css('border','1px solid #D0D0D0');
                }
            });

            // Prevent search input click event propagation
            $('.head-mini-search').click(function(event){
                event.stopPropagation();
            });
        });
        // $(".search-selection-text").focusin(function(){
        //     $('.search-suggestion').css('display','block');
        // });
        // $(".search-selection-text").focusout(function(){
        //     $('.search-suggestion').css('display','none');
        // });
        
        // let discountDate = "05/31/2024 23:59:32"; //{{$dist_future}}";
        let discountText = "{{$getMonthTextArray[$getCurrentMonth]}}";
        let discountDate = "{{$dist_future}}"+" "+"23:59:32";
        var countDownDate = new Date(discountDate).getTime();
        var myfunc = setInterval(function() {

        var now = new Date().getTime();      
        var timeleft = countDownDate - now;

        // Calculating the days, hours, minutes and seconds left
        var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

        // Result is output to the specific element
        const daysToShow = days + "d "
        const hoursToShow = hours + "h "
        const minutesToShow = minutes + "m "
        const secondsToShow = seconds + "s "

        const timerToShow = daysToShow+' '+ hoursToShow+' '+ minutesToShow+' '+ secondsToShow;
        $(".discount_timer").css('display','inline-block');
        $(".discount_timer").text(timerToShow);
        // $("#offer-text").text('Wedding Rings Sale - Up to 35% off');
        $("#offer-text").text(discountText);
        // console.log('first', hoursToShow);
        // console.log('first', minutesToShow);
        // console.log('first', secondsToShow);
        // Display the message when countdown is over
        if (timeleft < 0) {
            clearInterval(myfunc);
            $(".discount_timer").text('');
            $(".discount_timer").css('display','none');
            $(".offer-text").text('');
        }
        }, 1000);
</script>
