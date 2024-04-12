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
    .error {color: #e74c3c !important;}
    .head-para-three p.second-para {padding-bottom: 25px;}
    .head-para-three video#video {width: 80%;object-fit: inherit;}
    .product-titles {font-size: 20px;}
</style>
<link rel="stylesheet" href="{{ asset('assets/vendors/toastr/build/toastr.min.css') }}">
@endsection
<!-- Not found data -->
<div class="home-main-banner">
    <div class="main-banner-wraper">
        <div class="container">
            <div class="main-banner-col">
                <div class="head-para-three pagenotfound">
                    <h1 class="page-title">Whoopsie Daisy</h1>
                    <p>We could not find what you are looking for.</p>
                    <div class="description"> <a class="btn-bg-small continueshopping" href="{{url('/')}}">Continue Shopping</a> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop from the Best start here -->
<div class="shopfrom-best">
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three">Explore our designs</h2>
        </div>
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslideronenotfound st-arrows">
            <div class="item">
                    <div class="product-info">
                        <div class="product-image">
                            <a href="{{ asset('/diamonds-rings') }}">
                                <?php
                                $ringImageDiamondRingUrl = getImageOptimizeDetails('/storage/Products/CX9-SC48_00003_1650365432.jpg', '340', '340');
                                ?>
                                <img src="https://marlows-diamonds.co.uk/tempfolderpath/multi-stone.png" alt="Multi Stone Rings">
                            </a>
                        </div>
                        <div class="product-item-details">
                            <div class="product-titles">
                                <a href="{{ asset('/diamonds-rings') }}" style="color:#8e2e65;    text-decoration: none;">Diamond Rings</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <a href="{{ asset('diamond-engagement-rings') }}" style="color:#8e2e65;    text-decoration: none;">Engagement Ring</a>
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
                                <a href="{{ asset('/wedding-rings') }}" style="color:#8e2e65;    text-decoration: none;">Wedding Rings</a>
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
                                <a href="{{ asset('/diamond-jewellery') }}" style="color:#8e2e65;    text-decoration: none;">Diamond Jewellery</a>
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