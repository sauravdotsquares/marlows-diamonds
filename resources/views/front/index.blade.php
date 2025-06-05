@inject('header_settings', 'App\Models\Settings')
@extends('layouts.front.app')
@section('content')
@section('css')
    <style>
        .error {color: #e74c3c !important;}
    </style>
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/build/toastr.min.css') }}">
     {{-- start --}}
     <script type="text/javascript">
        window.criteo_q = window.criteo_q || [];
        var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
        window.criteo_q.push(
          { event: "setAccount", account: 119681 },
          @if(Auth::check())
            { event: "setEmail", email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}", hash_method: "sha256" },
            { event: "setEmail", email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}", hash_method: "md5" },
          @endif
          { event: "setSiteType", type: "{{ request()->header('User-Agent') && preg_match('/iPad/', request()->header('User-Agent')) ? 't' : (preg_match('/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/', request()->header('User-Agent')) ? 'm' : 'd') }}" },
          @if(Auth::check())
          { event: "setCustomerId", id: {{ Auth::user()->id }} },
          @endif
          { event: "viewHome" }
        );
      </script>
     {{-- end --}}
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "VideoObject",
          "name": "Why Choose Marlow’s Diamonds?",
          "description": "Our diamonds and gemstones offer exceptional value, consistently surpassing any like-for-like comparison with other UK jewellers. Our collection features multiple shape diamonds, including ovals, marquises, emerald cuts, and cushions, all expertly polished to the highest standards. We guarantee that most of our diamonds visually appear larger than their carat weight. Our skilled polishers focus on maximising proportions rather than just carat weight, meaning our 1ct diamonds often look equivalent to a 1.25ct from other jewellers. We invite you to visit any of our stores to be amazed. Furthermore, if you find a better price elsewhere, simply send us a link, and we will gladly beat it—guaranteeing you the best deal.",
          "thumbnailUrl": "https://admin.marlowsdiamonds.com/storage/HomePageVideos/homeopagevideo.mp4",
          "uploadDate": "2021-06-01",
          "duration": "PT0M43S"
        }
        </script>
@endsection
@section('dynamic_og_image')<meta property="og:image" content="{{env('APP_IMAGE_URL').'/images/logo/'.$header_settings->get_options('logo')}}" />@endsection
    <!-- home main-banner start -->
    <div class="home-main-banner">
        <div class="main-banner-wraper flex-flex-wrap flexed">
            <div class="main-banner-col banner-left-col">
                <div class="main-banner-left-text">
                    <h1 class="123">GIA Certified Diamond Rings by Marlows</h1>
                    <p><strong>Buy a natural diamond and get a similar lab grown for free. Offer valid till 30th June for in store only</strong></p>
                    <div class="shop-engage-btn">
                    <a class="btn-bg-large" href="{{ asset('diamond-engagement-rings') }}">SHOP ENGAGEMENT RINGS</a>
                    </div>
                </div>
            </div>
            <div class="main-banner-col banner-ryt-col">
                <div class="main-banner-ryt-img">
                    <?php 
                        $ringImageUrl = getImageOptimizeDetails('/assets/images/ring-img.webp','340','500');
                    ?>
                    <img src="{{ $ringImageUrl }}" alt="Ring">
                </div>
            </div>
        </div>
    </div>
    <!-- home main-banner endt -->

    <!-- Shop from the Best start here -->
    <div class="shopfrom-best">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">Our Best Selling Collections</h2>
            </div>
            <div class="product-item-slider">
                <div class="owl-carousel owl-theme owlsliderone st-arrows">
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('diamond-engagement-rings') }}">
                                    <?php 
                                        $ringImageEngagementRingUrl = getImageOptimizeDetails('/assets/images/engagement-ring.png','340','340');
                                    ?>
                                    <img src="{{$ringImageEngagementRingUrl}}" alt="Engagement Ring">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('diamond-engagement-rings') }}">
                                    <div class="product-titles">
                                        Engagement Ring
                                    </div>
                                    {{-- <div class="product-description">
                                        Choose from an exotic range of diamond Rings or have your very own bespoke design made
                                        for your special day.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small" href="{{ asset('diamond-engagement-rings') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/diamonds-rings') }}">
                                    <?php
                                        $ringImageDiamondRingUrl = getImageOptimizeDetails('/storage/Products/CX9-SC48_00003_1650365432.jpg','340','340');
                                    ?>
                                    <img src="{{$ringImageDiamondRingUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/diamonds-rings') }}">
                                    <div class="product-titles">
                                        Diamond Rings
                                    </div>
                                    {{-- <div class="product-description">
                                        Choose from our diverse range of diamond bands available in solitaire, multi-stone, shoulder set and halo ring styles for all purposes.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/diamonds-rings') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/eternity-rings') }}">
                                    <?php 
                                        $ringImageEternityRingUrl = getImageOptimizeDetails('/storage/Products/ET112-F-G-VS-SI_T_W.jpg','340','340');
                                    ?>
                                    <img src="{{ $ringImageEternityRingUrl }}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/eternity-rings') }}">
                                    <div class="product-titles">
                                        Eternity Rings
                                    </div>
                                    {{-- <div class="product-description">
                                        Select eternity rings for your love and elevate your love's beauty with an eternal sparkle. Find your perfect ring in the UK from our collection.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/eternity-rings') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/wedding-rings') }}">
                                    <?php 
                                        $ringImageWeddingRingUrl = getImageOptimizeDetails('/assets/images/wedding-ring.png','340','340');
                                    ?>
                                    <img src="{{$ringImageWeddingRingUrl}}" alt="Wedding Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/wedding-rings') }}">
                                    <div class="product-titles">
                                        Wedding Rings
                                    </div>
                                    {{-- <div class="product-description">
                                        Something everlasting and as special as the marriage itself. Shop bespoke wedding rings from our collection.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small" href="{{ asset('/wedding-rings') }}">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/diamond-jewellery') }}">
                                    <?php
                                        $ringImageDiamondJewelleryUrl = getImageOptimizeDetails('/assets/images/diamond-jewellery.png','340','340');
                                    ?>
                                    <img src="{{$ringImageDiamondJewelleryUrl}}" alt="Diamond Jewellery">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/diamond-jewellery') }}">
                                    <div class="product-titles">
                                        Diamond Jewellery
                                    </div>
                                    {{-- <div class="product-description">
                                        Select your favourite diamond jewellery from a range of GIA certified diamonds for your most special moments.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small" href="{{ asset('/diamond-jewellery') }}">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/engagement-rings/halo') }}">
                                    <?php
                                        $ringImageHaloUrl = getImageOptimizeDetails('/storage/Products/RC2029_00003_1650430327.jpg','340','340');
                                    ?>
                                    <img src="{{$ringImageHaloUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/engagement-rings/halo') }}">
                                    <div class="product-titles">
                                        Halo Ring
                                    </div>
                                    {{-- <div class="product-description">
                                        A stunning GIA certified diamond - Halo Engagement rings - discovered from our collection. Our collection surely makes your day.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/engagement-rings/halo') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/engagement-rings/multi-stone') }}">
                                    <?php
                                        $ringImageMultistoneRingUrl = getImageOptimizeDetails('/assets/images/multi-stone.png','340','340');
                                    ?>
                                    <img src="{{$ringImageMultistoneRingUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/engagement-rings/multi-stone') }}">
                                    <div class="product-titles">
                                        Multi Stone Rings
                                    </div>
                                    {{-- <div class="product-description">
                                        Why stick to classic solitaires when you can have a stunning multi-stone ring in a
                                        unique arrangement?
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/engagement-rings/multi-stone') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/engagement-rings/shoulder-set') }}">
                                    <?php 
                                        $ringImageShoulderSetUrl = getImageOptimizeDetails('/storage/Products/R1-2294_00003_1650373913.jpg','340','340');
                                    ?>
                                    <img src="{{$ringImageShoulderSetUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/engagement-rings/shoulder-set') }}">
                                    <div class="product-titles">
                                        Shoulder Set Ring
                                    </div>
                                    {{-- <div class="product-description">
                                        Looking for a classic ring for your lover, our shoulder set diamond engagement rings are right ones for you.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/engagement-rings/shoulder-set') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/engagement-rings/solitaire') }}">
                                    <?php 
                                        $ringImageSolitaireUrl = getImageOptimizeDetails('/storage/Products/R1-327_00003_1650432540.jpg','340','340');
                                    ?>
                                    <img src="{{$ringImageSolitaireUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/engagement-rings/solitaire') }}">
                                    <div class="product-titles">
                                        Solitaire Ring
                                    </div>
                                    {{-- <div class="product-description">
                                        Find the perfect symbol of everlasting love and sophistication with our stunning assortment of solitaire engagement rings UK.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/engagement-rings/solitaire') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/wedding-rings/mens') }}">
                                    <?php 
                                        $ringImageMensWeddingRingUrl = getImageOptimizeDetails('/storage/Products/WED028_T_W.jpg','340','340');
                                    ?>
                                    <img src="{{$ringImageMensWeddingRingUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/wedding-rings/mens') }}">
                                    <div class="product-titles">
                                        Men's Wedding ring
                                    </div>
                                    {{-- <div class="product-description">
                                        Check our collection of diamond & plain wedding bands for men and show your love & commitment. Shop our certified mens wedding rings online.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/wedding-rings/mens') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="{{ asset('/wedding-rings/womens') }}">
                                    <?php
                                        $ringImageWomensWeddingRingUrl = getImageOptimizeDetails('/storage/Products/217231453wed052-silver-front.png','340','340');
                                    ?>
                                    <img src="{{$ringImageWomensWeddingRingUrl}}" alt="Multi Stone Rings">
                                </a>
                            </div>
                            <div class="product-item-details">
                                <a href="{{ asset('/wedding-rings/womens') }}">
                                    <div class="product-titles">
                                        Women's Wedding Ring
                                    </div>
                                    {{-- <div class="product-description">
                                        Looking for a beautiful diamond wedding ring for your special one, shop a ring from our collection of diamond & plain wedding bands.
                                    </div> --}}
                                </a>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('/wedding-rings/womens') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Shop from the Best end here -->

    <!-- Choose Your Diamond Engagement ring from Marlow's  start here -->
    @include('front.includes.choosediamond')
    <!-- Choose Your Diamond Engagement ring from Marlow's end here -->
    
    <!-- whay choose marlows start here -->
    <div class="whychoose-marlows">
        <div class="container">
            <div class="whychoose-wraper">
                <div class="head-para-three">
                    <div class="heading-h-three">
                        Why Choose Marlow’s Diamonds?
                        <p style="line-height: 2;">Because we are specialists in affordable luxury-the one stop jewellery superstore</p>
                    </div>
                    <p>For over three generations, we have proudly assisted countless happy couples in expressing
                        their love and commitment. We share your values of quality and dedication, and that is why
                        Marlow’s is a must.</p>
                    <p class="second-para">Our diamonds and gemstones offer exceptional value, consistently surpassing any like-for-like comparison with other UK jewellers. Our      collection features multiple shape diamonds,
                        including ovals, marquises, emerald cuts, and cushions, all expertly polished to the highest
                        standards. We guarantee that most of our diamonds visually appear larger than their carat weight. Our
                        skilled polishers focus on maximising proportions rather than just carat weight, meaning our 1ct diamonds often look equivalent to a 1.25ct from other jewellers. We invite you to visit any
                        of our stores to be amazed. Furthermore, if you find a better price elsewhere, simply send us a link, and we will gladly
                        beat it—guaranteeing you the best deal.</p>
                    <video src="{{env('APP_IMAGE_URL').'/storage/HomePageVideos/homeopagevideo.mp4'}}" controls autoplay muted loop id="video" poster="/storage/HomePageVideos/homeopagevideo.png"></video >
                </div>
                <div class="text-center" id="getDirectionDetails1">
                    <a class="btn-bg-small getdirection" href="#location_data_section">Find Marlow’s</a>
                </div>
                

                <div class="whychoose-rows flex-flex-wrap flexed">
                    <a href="/terms" class="whychoose-col whychoose-link">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <i class="diamond-icon search-lifetime"></i>
                            </div>
                            <div class="whychoose-col-text">
                                Lifetime Warranty T&c Apply
                            </div>
                        </div>
                    </a>
                    <a href="/gia-certified-diamonds" class="whychoose-col whychoose-link">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <i class="diamond-icon search-giacertified"></i>
                            </div>
                            <div class="whychoose-col-text">
                                GIA Certified Diamonds
                            </div>
                        </div>
                    </a>
                    <a href="/diamond-certificates/" class="whychoose-col whychoose-link">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <i class="diamond-icon search-experienced"></i>
                            </div>
                            <div class="whychoose-col-text">
                                70 Years Experience
                            </div>
                        </div>
                    </a>
                    <a href="/delivery-and-returns-policy" class="whychoose-col whychoose-link">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <i class="diamond-icon search-terms-conditions"></i>
                            </div>
                            <div class="whychoose-col-text">
                                30 Day Returns. T&c Apply
                            </div>
                        </div>
                    </a>
                </div>

                <div class="rating-img">
                    <i class="diamond-icon search-starviews"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- whay choose marlows end here -->

    <!-- Best Selling Marlow's Diamond Jewellery start here -->
    @include('front.includes.featuredproduct')
    <!-- Best Selling Marlow's Diamond Jewellery end here -->
    <!-- Best Selling Marlow's Diamond Jewellery start here -->
    @include('front.includes.visit-our-showrooms')
    <!-- Best Selling Marlow's Diamond Jewellery end here -->

    <!-- Marlow's start here -->
    <!-- <div class="marlows-diamond">
        <div class="container">
            <div class="marlows-diamond-title heading-h-two">
                Marlow's Diamonds: Inspiring a Generation of Love.
            </div>
        </div>

    </div> -->


    <!-- Marlow's End here -->
    {{-- <div class="whychoose-rows flex-flex-wrap flexed">
        <a href="/terms" class="whychoose-col whychoose-link">
            <div class="whychoose-col-inner">
                <div class="whychoose-col-img">
                    <i class="diamond-icon search-lifetime"></i>
                </div>
                <div class="whychoose-col-text">
                    Lifetime Warranty T&c Apply
                </div>
            </div>
        </a>
        <a href="/gia-certified-diamonds" class="whychoose-col whychoose-link">
            <div class="whychoose-col-inner">
                <div class="whychoose-col-img">
                    <i class="diamond-icon search-giacertified"></i>
                </div>
                <div class="whychoose-col-text">
                    GIA Certified Diamonds
                </div>
            </div>
        </a>
        <a href="/diamond-certificates/" class="whychoose-col whychoose-link">
            <div class="whychoose-col-inner">
                <div class="whychoose-col-img">
                    <i class="diamond-icon search-experienced"></i>
                </div>
                <div class="whychoose-col-text">
                    70 Years Experience
                </div>
            </div>
        </a>
        <a href="/delivery-and-returns-policy" class="whychoose-col whychoose-link">
            <div class="whychoose-col-inner">
                <div class="whychoose-col-img">
                    <i class="diamond-icon search-terms-conditions"></i>
                </div>
                <div class="whychoose-col-text">
                    30 Day Returns. T&c Apply
                </div>
            </div>
        </a>
    </div> --}}

    <!--Shop from Marlow’s GIA Certified Diamond Rings start -->
    <div class="shopfrom-block">
        <div class="container">
            <div class="head-para-three">
                <h3 class="heading-h-three">
                    Our Happy Customers
                </h3>
                <!--<p>Diamond rings are more than just jewellery. We understand the symbolism that they represent. So that they
                    can withstand the test of time our<br> diamond jewellery is certified by the GIA, so they provide quality
                    and longevity.</p>-->
                <!--<div class="explore-btn">
                    <a class="btn-bg-small" href="/diamonds-rings">Explore Diamond Rings</a>
                </div>-->
            </div>
           <!-- <div class="rating-img">
               <i class="diamond-icon search-starviews"></i>
            </div>-->

            <div class="product-rating">
<div class="rating-review"><h5>3000+</h5><span><img src="/assets/images/one-star1.png" alt=""> </span></div>
    <div class="start-standing">
        <div class="start-position"><span><img src="/assets/images/five-star11.png" alt=""> </span></div>
        <h4>Outstanding  <span>(5 out of 5)</span></h4>
    </div>
</div>

            <div class="rating-review-block">
                <div class="owl-carousel owl-theme slider-review">
                    @include('front.pages.reviews')
                </div>
            </div>
        </div>
    </div>
    <!--Shop from Marlow’s GIA Certified Diamond Rings end -->
    {!! isset($data->description) ? $data->description : '' !!}
    <!-- Join our mailing list section start -->
    <div class="joinour-mailing">
        <div class="container">
            <div class="joinour-wraper">
                <div class="joinour-heading">
                    <div class="heading-h-two white-text">
                        Join our mailing list
                    </div>
                    <p>Join our world full of diamonds and we’ll sparkle your inbox by keeping you up-to-date.</p>
                </div>
                <div class="joinour-mailing-form">
                    <form id="contactForm">
                        @csrf
                        <div class="form-rows flexed flex-flex-wrap">
                            <input type="hidden" name="custom_url" id="custom_url" value="{{ url()->full() }}">
                            <div class="form-col width-50">
                                <label>Your Name<sup>*</sup></label>
                                <input required="required"
                                    class="input-control {{ $errors->has('title') ? 'error' : '' }}" type="text"
                                    name="title" placeholder="Your Name">
                                <!-- Error -->
                                @if ($errors->has('title'))
                                    <div class="error">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-col width-50">
                                <label>Email<sup>*</sup></label>
                                <input required="required"
                                    class="input-control {{ $errors->has('email') ? 'error' : '' }}" type="text"
                                    name="email" placeholder="Email Address">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                         {{-- <div class="form-rows flexed flex-flex-wrap">
                            <div class="form-col">
                                <label>Message</label>
                                <textarea required="required" name="description"
                                    class="input-control {{ $errors->has('description') ? 'error' : '' }}" placeholder="Message"></textarea>
                            </div>
                        </div>  --}}
                        @if(env('APP_ENV') == 'production')
                            <div class="google-capatcha form-controls">
                                <div class="g-recaptcha"
                                    data-sitekey="6LfQrxUgAAAAAFD1c2BmyaKHy1F20WUJEloRiyie">
                                </div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <div class="error">
                                        {{ $errors->first('g-recaptcha-response') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="action-btn">
                            <button class="white-bg-btn" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Join our mailing list section End -->
    @include('front.includes.instagram-section')
    @include('front.includes.location_section')

    <!-- insta photos section end -->
    @php
        $getPopups = getPromotionalPOPup();
    @endphp
    @if(isset($getPopups) && !empty($getPopups))
        <!-- Modal -->
        <div class="modal fade" id="showPromotionPopup" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ isset($getPopups->title)?$getPopups->title:'' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            {!! isset($getPopups->description)?$getPopups->description:'' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('js')
<script src='https://www.google.com/recaptcha/api.js' async></script>
<script src="https://www.google.com/recaptcha/api.js?render=6Lc9hhUgAAAAAJzmHHLuY__2pxT9bHMlIPzgGbwN"></script>
<script src="{{ asset('assets/vendors/jquery-validator/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/vendors/toastr/build/toastr.min.js') }}"></script>
<?php
    $environment = env('APP_ENV');
?>
<script>
    var stagingVar = '{{$environment}}';
    if(stagingVar == 'production'){
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lc9hhUgAAAAAJzmHHLuY__2pxT9bHMlIPzgGbwN', {
            action: 'contact'
        }).then(function(token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });

    $(document).ready(function(){
        $('#showPromotionPopup').modal('show');
    });
    }

    function blankForm() {
        $('input[name="title"]').val('');
        $('input[name="email"]').val('');
        $('textarea[name="description"]').val('');
        $("button[type='submit']").prop('disabled', false);
        if(stagingVar == 'production'){
        grecaptcha.reset();
        }
    }

    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Letters and spaces only please");


    jQuery.validator.addMethod(
        "noSpacesOnly",
            function(value, element) {
                return $.trim(value).length > 3;
            },
            "This field cannot be empty or contain only spaces."
        );

    $('form#contactForm').validate({
        rules: {
            title: {
                required: true,
                lettersonly: true,
                noSpacesOnly: true
            },
            email: {
                required: true,
                email: true
            },
            description: {
                required: true,
                noSpacesOnly: true
            }
        },
        messages: {
            title: {
                required: 'Name is required',
                 noSpacesOnly: "Name cannot be empty and must not contain spaces."
            },
            email: {
                required: 'Email is required',
                email: 'Valid email is required',
            },
            description: {
                required: 'Message is required',
                noSpacesOnly: "Description cannot be empty and must not contain spaces."
            }
        },
        submitHandler: function(form) {
            if(stagingVar == 'production'){
                if (grecaptcha.getResponse()) {
                    var form_data = new FormData(form);
                    $(form).find("button[type='submit']").prop('disabled', true);
                    $("button[type='submit']").text("Please Wait...");
                    $.ajax({
                        url: "{{ route('maillist') }}",
                        method: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(response) {
                            blankForm();
                            $("button[type='submit']").text("Subscribe");
                            // $(this).find("button[type='submit']").prop('disabled',true);
                            // console.log(response);
                            // return false;
                            if (response.status == 200) {
                                toastr.success(response.success);
                                // window.location.reload();
                            } else {
                                toastr.info(response.error);
                            }
                        }
                    });
                } else {
                    alert('Please confirm captcha to proceed')
                }
            } else {
                var form_data = new FormData(form);
                $(form).find("button[type='submit']").prop('disabled', true);
                $("button[type='submit']").text("Please Wait...");
                $.ajax({
                    url: "{{ route('maillist') }}",
                    method: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(response) {
                        blankForm();
                        $("button[type='submit']").text("Subscribe");
                        // $(this).find("button[type='submit']").prop('disabled',true);
                        // console.log(response);
                        // return false;
                        if (response.status == 200) {
                            toastr.success(response.success);
                            // window.location.reload();
                        } else {
                            toastr.info(response.error);
                        }
                    }
                });
            }
        }
    });
</script>
@endsection
