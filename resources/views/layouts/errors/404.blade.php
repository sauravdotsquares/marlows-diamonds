<?php

use App\Models\SitemapUrls;

SitemapUrls::deleteRecordByUrl(request()->path());
$pageRedirect = pageRedirects(request()->path());
if ($pageRedirect) {
    header("Location: $pageRedirect", true, 301);
    exit();
}
?>
@extends('layouts.front.error_page')
@section('content')
@section('css')
<style>
    .error {
        color: #e74c3c !important;
    }

    .head-para-three p.second-para {
        padding-bottom: 25px;
    }

    .head-para-three video#video {
        width: 80%;
        object-fit: inherit;
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/vendors/toastr/build/toastr.min.css') }}">
@endsection

<?php
// SitemapUrls::deleteRecordByUrl(request()->path());
// $pageRedirect = pageRedirects(request()->path());
// if($pageRedirect){
//     header("Location: $pageRedirect", true, 301);
//     exit();
// }
?>
<!-- Not found data -->
<div class="home-main-banner">
    <div class="main-banner-wraper">
        <div class="container">
            <div class="main-banner-col">
                {{-- <p  style="color: #8e2e65; font-size: 25px;padding: 20px 0px;" ><strong>Ooopsasfsd , we cannot find what you are looking for.</strong></p>
                --}}

                <div class="head-para-three pagenotfound">
                    <h1 class="page-title">Whoopsie Daisy</h1>
                    <p>We could not find what you are looking for.</p>
                    <div class="description"> <a class="btn-bg-small" href="{{url('/diamond-engagement-rings')}}">Continue Shopping</a> </div>
                </div>

                <!-- <center><a href="{{url('/')}}"><img src="{{ asset('assets\images/404image.png') }}"></a></center> -->
            </div>
        </div>
    </div>
</div>

<!-- Shop from the Best start here -->
<div class="shopfrom-best">
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three">Explore our other designs</h2>
        </div>
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlsliderone st-arrows">
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('diamond-engagement-rings') }}">
                                <?php
                                $ringImageEngagementRingUrl = getImageOptimizeDetails('/assets/images/engagement-ring.png', '340', '340');
                                ?>
                                <img src="{{$ringImageEngagementRingUrl}}" alt="Engagement Ring">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Engagement Ring
                            </div>
                            <div class="product-description">
                                Choose from an exotic range of diamond Rings or have your very own bespoke design made
                                for your special day.
                            </div>
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
                                $ringImageDiamondRingUrl = getImageOptimizeDetails('/storage/Products/CX9-SC48_00003_1650365432.jpg', '340', '340');
                                ?>
                                <img src="{{$ringImageDiamondRingUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Diamond Rings
                            </div>
                            <div class="product-description">
                                Choose from our diverse range of diamond bands available in solitaire, multi-stone, shoulder set and halo ring styles for all purposes.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/diamonds-rings') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/eternity-rings') }}">
                                <?php
                                $ringImageEternityRingUrl = getImageOptimizeDetails('/storage/Products/ET112-F-G-VS-SI_T_W.jpg', '340', '340');
                                ?>
                                <img src="{{ $ringImageEternityRingUrl }}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Eternity Rings
                            </div>
                            <div class="product-description">
                                Select eternity rings for your love and elevate your love's beauty with an eternal sparkle. Find your perfect ring in the UK from our collection.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/eternity-rings') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/wedding-rings') }}">
                                <?php
                                $ringImageWeddingRingUrl = getImageOptimizeDetails('/assets/images/wedding-ring.png', '340', '340');
                                ?>
                                <img src="{{$ringImageWeddingRingUrl}}" alt="Wedding Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Wedding Rings
                            </div>
                            <div class="product-description">
                                Something everlasting and as special as the marriage itself. Shop bespoke wedding rings from our collection.
                            </div>
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
                                $ringImageDiamondJewelleryUrl = getImageOptimizeDetails('/assets/images/diamond-jewellery.png', '340', '340');
                                ?>
                                <img src="{{$ringImageDiamondJewelleryUrl}}" alt="Diamond Jewellery">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Diamond Jewellery
                            </div>
                            <div class="product-description">
                                Select your favourite diamond jewellery from a range of GIA certified diamonds for your most special moments.
                            </div>
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
                                $ringImageHaloUrl = getImageOptimizeDetails('/storage/Products/RC2029_00003_1650430327.jpg', '340', '340');
                                ?>
                                <img src="{{$ringImageHaloUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Halo Ring
                            </div>
                            <div class="product-description">
                                A stunning GIA certified diamond - Halo Engagement rings - discovered from our collection. Our collection surely makes your day.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/engagement-rings/halo') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/engagement-rings/multi-stone') }}">
                                <?php
                                $ringImageMultistoneRingUrl = getImageOptimizeDetails('/assets/images/multi-stone.png', '340', '340');
                                ?>
                                <img src="{{$ringImageMultistoneRingUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Multi Stone Rings
                            </div>
                            <div class="product-description">
                                Why stick to classic solitaires when you can have a stunning multi-stone ring in a
                                unique arrangement?
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/engagement-rings/multi-stone') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/engagement-rings/shoulder-set') }}">
                                <?php
                                $ringImageShoulderSetUrl = getImageOptimizeDetails('/storage/Products/R1-2294_00003_1650373913.jpg', '340', '340');
                                ?>
                                <img src="{{$ringImageShoulderSetUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Shoulder Set Ring
                            </div>
                            <div class="product-description">
                                Looking for a classic ring for your lover, our shoulder set diamond engagement rings are right ones for you.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/engagement-rings/shoulder-set') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/engagement-rings/solitaire') }}">
                                <?php
                                $ringImageSolitaireUrl = getImageOptimizeDetails('/storage/Products/R1-327_00003_1650432540.jpg', '340', '340');
                                ?>
                                <img src="{{$ringImageSolitaireUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Solitaire Ring
                            </div>
                            <div class="product-description">
                                Find the perfect symbol of everlasting love and sophistication with our stunning assortment of solitaire engagement rings UK.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/engagement-rings/solitaire') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/wedding-rings/mens') }}">
                                <?php
                                $ringImageMensWeddingRingUrl = getImageOptimizeDetails('/storage/Products/WED028_T_W.jpg', '340', '340');
                                ?>
                                <img src="{{$ringImageMensWeddingRingUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Men's Wedding ring
                            </div>
                            <div class="product-description">
                                Check our collection of diamond & plain wedding bands for men and show your love & commitment. Shop our certified mens wedding rings online.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/wedding-rings/mens') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/wedding-rings/womens') }}">
                                <?php
                                $ringImageWomensWeddingRingUrl = getImageOptimizeDetails('/storage/Products/WED028_T_W.jpg', '340', '340');
                                ?>
                                <img src="{{$ringImageWomensWeddingRingUrl}}" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                Women's Wedding Ring
                            </div>
                            <div class="product-description">
                                Looking for a beautiful diamond wedding ring for your special one, shop a ring from our collection of diamond & plain wedding bands.
                            </div>
                            <div class="product-action-btn">
                                <a class="btn-bg-small" href="{{ asset('/wedding-rings/womens') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Shop from the Best end here -->

@endsection