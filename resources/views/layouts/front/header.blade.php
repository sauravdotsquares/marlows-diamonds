@inject('header_settings', 'App\Models\Settings')

<!-- Header Start here -->
<header class="header-main">
    <!-- Mobile Top Start here -->
    <div class="top-bar-mob">
        <div class="container">
            <div class="owl-carousel owl-theme mobil-bar">
                <div class="item">
                    <a class="whatspp-num" target="_blank" href="https://api.whatsapp.com/send?phone=447535425059"><i class="fa fa-whatsapp" aria-hidden="true"></i>{{WHATSAPP_TITLE}}: {!!$header_settings->get_options('field1')!!}</a>
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
                        <a class="whatspp-num" target="_blank" href="https://api.whatsapp.com/send?phone=447535425059">
                            <i class="fa fa-whatsapp" aria-hidden="true"></i> {{WHATSAPP_TITLE}} {{$header_settings->get_options('whatsapp')}}
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
                        <li class="my-account-blk">
                            <a href="{{route('my-account')}}"><i class="fa fa-user-o" aria-hidden="true"></i>{{MY_ACCOUNT_TITLE}}</a>
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

                                <img src="{{asset('')}}assets/images/cart-color.png" alt="cart">
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
                            <img src="{{asset('images/'.$header_settings->get_options('logo'))}}" alt="{{$header_settings->get_options('site_title')}}">

                        @elseif($header_settings->get_options('site_title')!='')
                            <div>{{$header_settings->get_options('site_title')}}</div>
                            <span>{{$header_settings->get_options('site_tagline')}}</span>
                        @else
                            <span>{{env('APP_NAME')}}</span>
                        @endif
                    </a>
                </div>
                <div class="mobile-cart-wishlist">
                <div class="mobile-wishlist mobile-acc">
                            <a href="/my-account"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                    </div>
                    <div class="mobile-wishlist">
                            <a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                    </div>
                    <div class="mobile-cart">
                        <a href="{{ route('product.cart') }}">
                            <img src="{{asset('')}}/assets/images/cart-color-black.png" alt="cart">
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
                        <div class="mobile-serch-box">
                            <img src="{{asset('')}}assets/images/search.png" alt="search">
                            Search for products...
                        </div>
                    <nav class="nav-navbars">

                        <ul class="static-megamenu">

                            @if(!empty($navbars))

                                @foreach($navbars as $navbarItem)
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
                                            @include('layouts.front.menus-sub', ['subs' => $navbarItem['children']])
                                        @endif
                                    </li>
                                @endforeach

                            @endif
                        </ul>
                    </nav>
                    </div>
                </div>

                <div class="head-mini-search">
                    <div class="remve-mobile-serch-box">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </div>
                    <form ng-controller="CommonController" >
                        <div class="formgroup">
                            <input type="text" name="search" class="typeahead" placeholder="Search for product.." ng-model="search" ng-keyup="searchProducts()" autocomplete="off">
                            <button class="seach-btn" type="button"><img src="{{asset('')}}assets/images/search.png" alt="search"></button>
                        </div>
                        <div class="search-suggestion" ng-if="searchResults.length>0" ng-cloak>
                            <div class="search-suggestion-list" ng-repeat="result in searchResults">
                                <a href="/product/<%result.slug%>">
                                    <div class="search-suggestion-img">
                                        <img src="{{asset('/storage')}}/<%result.get_product_images.image_url%>" alt="Marlow's Diamond">
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
            </div>
        </div>
    </div>
    <!-- Navbars and logo end here -->

    <!-- Post bar start -->

    <div class="post-bar">
        <div class="container">
            <div class="post-bar-wraper flexed flex-justify-between flex-items-center header-post-bar-wraper">
                <div class="post-bar-left header-post-bar-left">
                    <p>{!!$header_settings->get_options('header-left')!!}</p>
                </div>
                <div class="post-bar-center" style="height: 40px;">
                    {{-- <a href="{{ route('products.exclusive') }}" >
                        <span> Exclusive to Marlows </span>
                    </a> --}}
                    <p> The Marlow's Black Friday Sale is here. Up to  </p>
                    <p> <span class="header-heighlight-text">30%</span> Off throughout </p>
                </div>
                <div class="post-bar-right header-post-bar-left">
                    <p>{!!$header_settings->get_options('header-right')!!}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Post bar end -->

</header>
<!-- Header end here -->
