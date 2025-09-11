@extends('layouts.front.app')
{{-- criteo start --}}
@section('criteo-tracking')
    <script type="text/javascript">
        window.criteo_q = window.criteo_q || [];
        var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/
            .test(navigator.userAgent) ? "m" : "d";

        window.criteo_q.push({
                event: "setAccount",
                account: 119681
            },
            @if (Auth::check())
                {
                    event: "setEmail",
                    email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}",
                    hash_method: "sha256"
                }, {
                    event: "setEmail",
                    email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}",
                    hash_method: "md5"
                },
            @endif

            {
                event: "setSiteType",
                type: "{{ request()->header('User-Agent') && preg_match('/iPad/', request()->header('User-Agent')) ? 't' : (preg_match('/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/', request()->header('User-Agent')) ? 'm' : 'd') }}"
            },
            @if (Auth::check())
                {
                    event: "setCustomerId",
                    id: {{ Auth::user()->id }}
                },
            @endif {
                event: "viewItem",
                item: "ig_{{ $data->id }}"
            }
        );
    </script>
@endsection

{{-- ends --}}
{{-- @inject('footer_settings', 'App\Models\Settings') --}}
@section('css')
    <style>
        .thumbnail {
            position: relative;
            padding: 0;
            margin-bottom: 20px
        }

        .thumbnail img {
            width: 80%
        }

        .thumbnail .caption {
            margin: 7px
        }

        .main-section {
            background-color: #f8f8f8
        }

        .dropdown {
            float: right;
            padding-right: 30px
        }

        .btn {
            border: 0;
            margin: 10px 0;
            box-shadow: none !important
        }

        .dropdown .dropdown-menu {
            padding: 20px;
            top: 30px !important;
            width: 350px !important;
            left: -110px !important;
            box-shadow: 0 5px 30px #000
        }

        .total-header-section {
            border-bottom: 1px solid #d2d2d2
        }

        .total-section p {
            margin-bottom: 20px
        }

        .cart-detail {
            padding: 15px 0
        }

        .cart-detail-img img {
            width: 100%;
            height: 100%;
            padding-left: 15px
        }

        .cart-detail-product p {
            margin: 0;
            color: #000;
            font-weight: 500
        }

        .cart-detail .price {
            font-size: 12px;
            margin-right: 10px;
            font-weight: 500
        }

        .cart-detail .count {
            color: #c2c2dc
        }

        .checkout {
            border-top: 1px solid #d2d2d2;
            padding-top: 15px
        }

        .checkout .btn-primary {
            border-radius: 50px;
            height: 50px
        }

        .dropdown-menu:before {
            content: " ";
            position: absolute;
            top: -20px;
            right: 50px;
            border: 10px solid transparent;
            border-bottom-color: #fff
        }

        .disabledAnchor a {
            pointer-events: none !important;
            cursor: default;
            color: #fff
        }

        span.price-not-found {
            font-size: 14px;
            color: #8e2e65;
            font-weight: 700
        }

        .error {
            color: #e74c3c !important
        }

        div#finaldiamondprice del {
            font-size: 20px
        }


        .hide-items {
            display: none;
        }

        .show-items {
            display: flex;
        }

        .metaltypeval {
            font-size: 15px;
            font-weight: bold;
            color: black
        }

        .tableheading {
            font-size: 17px;
            font-weight: bold;
            color: #fff !important;
            background: #8e2e65
        }

        .tablehover:hover {
            background-color: #8e2e65;
            color: #fff
        }

        .policy0icon {
            border: 1px solid #8e2e65;
            padding: 10px 15px 0px;
            width: 24%;
            text-align: center;
            border-radius: 10px;
        }

        .policysection {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .policyheading {
            color: #8e2e65;
            font-weight: bold;
            text-transform: capitalize;
            font-size: 13px;
        }

        .policy0icon {
            border: 1px solid #8e2e65;
            padding: 7px 1px 0px;
            width: 24%;
            text-align: center;
            border-radius: 10px;
        }

        .policyimg {
            width: 40px;
            margin: 0 0 11px;
        }

        .policysection a {
            color: #8e2e65;
        }

        @media only screen and (max-width: 600px) {
            .policy0icon {
                border: 1px solid #8e2e65;
                padding: 10px 15px 0px;
                width: 48%;
                text-align: center;
                border-radius: 10px;
                margin-top: 10px;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('assets/css/jquery.fancybox.css?') . env('VERSION') }}" rel="stylesheet" />
@endsection

@section('content')

@section('dynamic_og_image')
    <meta property="og:image" content="{{ env('APP_IMAGE_URL') . '/storage/' . $prodImages[0]->image_url }}" />
@endsection
<!-- product info and media -->


{{-- pop up content start from here --}}

<div class="modal fade sharesocial" id="sharesocial" tabindex="-1" aria-labelledby="sharesocialLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="modal-title" id="sharesociallLabel">Share</h3>
                <div id="copy-link">
                    <p id="copy-text">{{ URL::current() }}</p>
                    <button class="copy-btn" onclick="copyToClipboard()">Copy</button>
                </div>
            </div>


            @php

                $baseUrl = 'https://marlows-diamonds.co.uk';
                $productUrl = $baseUrl . '/product/' . $data->slug;
            @endphp




            <div class="sharesocialicon">
                <ul>
                    <li><a href="{{ Share::page(URL::current())->facebook()->getRawLinks() }}" target="_blank"
                            class="btn btn-facebook">
                            <i class="fa fa-facebook"></i>
                        </a></li>
                    <li>
                        <a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ urlencode($productUrl) }}"
                            target="_blank" class="btn btn-twitter">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode($productUrl) }}"
                            target="_blank" class="btn btn-pinterest">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    </li>

                    <li>
                        <a href="https://api.whatsapp.com/send/?text={{ urlencode($productUrl) }}&type=custom_url&app_absent=0"
                            target="_blank" class="btn btn-whatsapp">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                    </li>
                </ul>
            </div>





        </div>
    </div>
</div>
{{-- ends here --}}

<div class="product-detail-wraper">
    <div class="container">
        <div class="product-detail-row flexed flex-flex-wrap">
            <div class="product-info-media">
                <div class="product-info-media-site-icon">
                    <a href="#" class="product-gallery__trigger"><i class="fa fa-search"
                            aria-hidden="true"></i></a>

                    @php
                        $wishlist = session()->get('wishlist', []);
                        $wishListClass = 'fa-heart-o';
                        if (array_key_exists($data->id, $wishlist)) {
                            $wishListClass = 'fa-heart';
                        }
                    @endphp
                    <a href="javascript:void(0);" id="productWishListImage"><i
                            class="fa {{ $wishListClass }} wishcount" aria-hidden="true"></i></a>

                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sharesocial" class=""><i
                            class="fa fa-share-alt" aria-hidden="true"></i></a>
                </div>
                <div id="carousel" class="owl-carousel">
                    @if (!empty($data->getProductVariation[0]->vari_video))
                        <div class="item product-items-carousel">
                            @if (isset($data->getProductVariation) && !empty($data->getProductVariation[0]->vari_video))
                                <a id="variationAnchorVideo" data-fancybox="gallery1"
                                    href="{{ env('APP_IMAGE_URL') . '/storage/' . $data->getProductVariation[0]->vari_video }}"
                                    data-caption="">
                                    <video id="variationVideo" style="width: 100%;" loop autoplay muted="1"
                                        playsinline>
                                        <source
                                            src="{{ env('APP_IMAGE_URL') . '/storage/' . $data->getProductVariation[0]->vari_video }}"
                                            type="video/mp4" type="video/mp4" />
                                    </video>
                                </a>
                            @else
                                <a id="variationAnchorVideo" data-fancybox="gallery1" href="" data-caption="">
                                    <video id="variationVideo" style="width: 100%;" loop autoplay muted="1"
                                        playsinline>
                                        <source src="" type="video/mp4" type="video/mp4" />
                                    </video>
                                </a>
                            @endif
                        </div>
                    @endif
                    @if ($prodImages)
                        @foreach ($prodImages as $key => $images)
                            @php
                                $explode = explode('/', $images->image_url);
                                $explode1 = explode('.', $explode[1]);
                            @endphp
                            <div class="item product-items-carousel  @if ($key == 0) active @endif">
                                <a data-fancybox="gallery1"
                                    href="{{ env('APP_IMAGE_URL') . '/storage/' . $images->image_url }}"
                                    data-caption="{{ $explode1[0] }}">
                                    <img class="thumbnail-src"
                                        src="{{ env('APP_IMAGE_URL') . '/storage/' . $images->image_url }}"
                                        alt="{{ $explode1[0] }}">
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div id="thumbnail-carousel" class="owl-carousel">
                    @if (isset($data->getProductVariation[0]->vari_video))
                        <a class="btn-360" data-index="{{ $key }}"
                            data-video="{{ env('APP_IMAGE_URL') . '/storage/' . $data->getProductVariation[0]->vari_video }}">
                            <img src="/assets/images/360icon.jpg" alt="360">
                        </a>
                        @if ($prodImages)
                            @foreach ($prodImages as $key => $images)
                                @php
                                    $explode = explode('/', $images->image_url);
                                    $explode1 = explode('.', $explode[1]);
                                @endphp
                                <div class="item thumbnail-item">
                                    <a href="javascript:void(0)" class="thumbnail-link"
                                        data-index="{{ $key }}">
                                        <img class="thumbnail-img"
                                            src="{{ env('APP_IMAGE_URL') . '/storage/' . $images->image_url }}"
                                            alt="{{ $explode1[0] }}">
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>

                <div class="productdetailbtns">
                    <a type="button" class="btn-bg-small"
                        onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal"
                        data-bs-target="#requestAppointment"> Book an Appointment </a>
                    <a href="tel:447535425059" class="btn-bg-small">Contact Us</a>
                    <a target="_blank" href="https://maps.app.goo.gl/Xqo2hCwJrVK4FbfB6" class="btn-bg-small">Get
                        Directions</a>
                </div>
                <div id="myDivChanges"></div>
            </div>
            @php
                $getParentCategoryArray = explode(',', $data->cat_details);
                $getParentCategory = '';
                if (in_array('Engagement Rings', $getParentCategoryArray)) {
                    $getParentCategory = $getParentCategoryArray[0];
                    $regular_price = $data->AdditionalPriceMetalType['regular_price'];
                    $lab_price = $data->AdditionalPriceMetalType['lab_price'];
                }
            @endphp
            <input type="hidden" name="lab_price" id="lab_price"
                value="{{ isset($lab_price) ? $lab_price : 742 }}">

            <div class="product-info-main">
                <div class="product-title-name">
                    <h1>{{ isset($data->title) ? $data->title : '' }}</h1>
                </div>

                <div class="diamond-type">
                    <label>Diamond Type</label>
                    <div class="d-type-input">
                        <input type="radio" name="attribute_choose-your-diamond" value="mined_diamond"
                            id="mined_item" class="diamond_type">
                        <span>Mined Diamond</span>
                    </div>
                    <div class="d-type-input">
                        <input type="radio" name="attribute_choose-your-diamond" value="lab_grown" id="lab_item"
                            class="diamond_type" checked>
                        <span>Lab Grown Diamond</span>
                    </div>
                </div>
                <?php $default = 'lab_grown'; ?>
                <a class="customise-ring" href="https://marlows-diamonds.co.uk/ring-size-guide"
                    target="_blank"><b>Customise your Ring</b></a>

                <div class="product-type-variations" id="filterDataDesign">
                    <div class="type-variations-row">
                    </div>
                </div>
                @if ($plainbandMulti == false)
                    {{-- Show items for lab grown only --}}
                    <div id="apiCustomDesign">
                        <div
                            class="type-variations-row1 lab_item mined_lab_items {{ $default == 'lab_grown' ? 'show-items' : 'hide-items' }}">
                            <div class="type-variations-col">
                                <label for="lab_grown_carat" class="label"> Central Diamond Weight </label>
                                <select class="form-control lab_price_update_items " name="carat"
                                    id="lab_grown_carat">
                                    <!--<option value="0.30-0.39" selected="selected">0.30-0.39</option>-->
                                    <option value="0.50-0.59">0.50-0.59</option>
                                    <option value="0.70-0.79">0.70-0.79</option>
                                    <option value="1.00-1.19" selected>1.00-1.19</option>
                                    <option value="1.50-1.69">1.50-1.69</option>
                                    <option value="2.00-2.49">2.00-2.49</option>
                                    <option value="2.50-2.99">2.50-2.99</option>
                                    <option value="3.00-3.99">3.00-3.99</option>
                                    <option value="4.00-4.99">4.00-4.99</option>
                                    <option value="5.00-5.99">5.00-5.99</option>


                                </select>
                            </div>
                            <div class="type-variations-col">
                                <label for="lab_grown_colour" class="label"> Colour </label>
                                <select class="form-control lab_price_update_items " name="diamond-colour"
                                    id="lab_grown_colour">
                                    <option value="D" selected="selected">D - Exceptional White +</option>
                                    <option value="E">E - Exceptional White</option>
                                    <option value="F">F - Rare White +</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Show items for lab grown only --}}
                    <div
                        class="type-variations-row1 lab_item mined_lab_items {{ $default == 'lab_grown' ? 'show-items' : 'hide-items' }}">
                        <div class="type-variations-col">
                            <label for="lab_grown_clarity" class="label"> Clarity </label>
                            <select class="form-control lab_price_update_items " name="diamond-clarity"
                                id="lab_grown_clarity">
                                <option value="VS1">VS1 - Very Small Inclusions</option>
                                <option value="VS2" selected>VS2 - Very Small Inclusions</option>
                                <option value="VVS1">VVS1 - Minute Inclusions</option>
                                <option value="VVS2">VVS2 - Minute Inclusions</option>
                            </select>
                        </div>
                    </div>

                    {{-- Show items for mined only --}}
                    <div id="apiCustomDesign">
                        <div
                            class="type-variations-row1 mined_item mined_lab_items {{ $default == 'mined' ? 'show-items' : 'hide-items' }}">
                            <div class="type-variations-col">
                                <label for="carat" class="label"> Central Diamond Weight </label>
                                <select class="form-control" name="carat" id="carat">
                                    <option value="0.30-0.39" selected="selected">0.30-0.39</option>
                                    <option value="0.40-0.49">0.40-0.49</option>
                                    <option value="0.50-0.59">0.50-0.59</option>
                                    <option value="0.60-0.69">0.60-0.69</option>
                                    <option value="0.70-0.79">0.70-0.79</option>
                                    <option value="0.80-0.89">0.80-0.89</option>
                                    <option value="0.90-0.99">0.90-0.99</option>
                                    <option value="1.00-1.19">1.00-1.19</option>
                                    <option value="1.20-1.49">1.20-1.49</option>
                                    <option value="1.50-1.69">1.50-1.69</option>
                                    <option value="1.70-1.99">1.70-1.99</option>
                                    <option value="2.00-2.49">2.00-2.49</option>
                                    <option value="2.50-2.99">2.50-2.99</option>
                                    <option value="3.00-3.99">3.00-3.99</option>
                                </select>
                            </div>
                            <div class="type-variations-col">
                                <label for="diamond-colour" class="label"> Colour </label>
                                <select class="form-control" name="diamond-colour" id="diamond-colour">
                                    <option value="D" selected="selected">D - Exceptional White +</option>
                                    <option value="E">E - Exceptional White</option>
                                    <option value="F">F - Rare White +</option>
                                    <option value="G">G - Rare White</option>
                                    <option value="H">H - White</option>
                                    <option value="I">I - Slightly Tinted White</option>
                                    <option value="J">J - Slightly Tinted White</option>
                                    <option value="K">K - Tinted White</option>
                                </select>
                            </div>
                        </div>

                        <div
                            class="type-variations-row1 mined_item mined_lab_items {{ $default == 'mined' ? 'show-items' : 'hide-items' }}">
                            <div class="type-variations-col">
                                <label for="diamond-clarity" class="label"> Clarity </label>
                                <select class="form-control" name="diamond-clarity" id="diamond-clarity">
                                    <option value="IF">IF - Internally Flawless</option>
                                    <option value="VVS1">VVS1 - Minute Inclusions</option>
                                    <option value="VVS2">VVS2 - Minute Inclusions</option>
                                    <option value="VS1">VS1 - Very Small Inclusions</option>
                                    <option value="VS2">VS2 - Very Small Inclusions</option>
                                    <option value="SI1">SI1 - Small Inclusions</option>
                                    <option value="SI2" selected="selected">SI2 - Small Inclusions</option>
                                </select>
                            </div>
                            @if (isset($data->diamond_shape) && $data->diamond_shape == 'ROUND')
                                <div class="type-variations-col">
                                    <label for="diamond-grade" class="label"> Cut Grade </label>
                                    <select class="form-control" name="diamond-grade" id="diamond-grade">
                                        <option value="">Choose an option</option>
                                        <option value="EX" selected="selected">Excellent</option>
                                        <option value="VG">Very Good</option>
                                        <option value="GD">Good</option>
                                    </select>
                                </div>
                            @endif
                            <div class="type-variations-col{{ $data->diamond_shape == 'ROUND' ? '-one' : '' }}">
                                <label for="diamond-certificate" class="label"> Certificate </label>
                                <select class="form-control" name="diamond-certificate" id="diamond-certificate">
                                    <option value="GIA" selected="selected">GIA</option>
                                    <option value="IGI">IGI</option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="type-variations-row1 mined_item mined_lab_items {{ $default == 'mined' ? 'show-items' : 'hide-items' }}">
                        </div>
                        <div
                            class="view-diamond-sec mined_item_block mined_lab_items {{ $default == 'mined' ? 'show-items' : 'hide-items' }}">
                            <div class="viewall-diamond-btn"><a class="btn-bg-large viewdiamond-btn"
                                    href="javascript:void(0)">View Available Diamonds</a></div>
                            <div class="diamond-table">
                                <div class="refine-heading">Refine Your Search</div>
                                <div class="diamond-table-outer">
                                    <table width="100%" class="diamond-table-items">
                                        <thead>
                                            <tr>
                                                <th>Shape</th>
                                                <th>Carat</th>
                                                <th>Colour</th>
                                                <th>Clarity</th>
                                                @if (isset($data->diamond_shape) && $data->diamond_shape == 'ROUND')
                                                    <th class="cut_grade_th" style="display: block;">Cut</th>
                                                @endif
                                                <th>Cert</th>
                                                <th>Price</th>
                                                <th>Certificate</th>
                                                <th>Image</th>
                                                <th>Select</th>
                                            </tr>
                                        </thead>
                                        <tbody id="refineSearchData">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="product-decriptions product-description-common product-description-common_mined_item"
                    style="display: none;">
                    {!! $data->description ? $data->description : $data->description !!}
                </div>
                <div class="product-decriptions product-description-common product-description-common_lab_item">
                    {!! $data->lab_description ? $data->description . '<br>' . $data->lab_description : $data->description !!}
                </div>
                <p class="delieveryDescription">
                    {!! str_replace(
                        'Contact us',
                        '<a href="/contact" style="text-decoration: underline; color: #8e2e65;">Contact us</a>',
                        $getVariationDescription->description,
                    ) !!}
                </p>
                <p class="customringlink">If you want to customize your ring please <a href="javascript:void(0)"
                        onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal"
                        data-bs-target="#requestAppointment"><b>Book an appointment</b></a></p>

                <div class="price-section">
                    <div style="display: flex;">
                        <h4><del style="color:#000" id="shopPrice"> </del> </h4>
                        <div class="product-finder-price" id="finaldiamondprice" style="">
                        </div>
                    </div>
                    <p><span style="color:green">You Save : <span id="savePrice"></span></span> | <del
                            id="rrpPrice"> </del> </p>
                </div>


                <input type="hidden" id="getLabDiamondPrices" name="getLabDiamondPrices" value="">


                <input type="hidden" id="certificate_url" name="certificate_url" value="">
                <input type="hidden" name="selected_variation_price" id="selected_variation_price"
                    value="{{ isset($variationDetails->regular_price) ? $variationDetails->regular_price : $variationDetails->sale_price }}">
                <input type="hidden" name="selected_setting_price" id="selected_setting_price" value="0.00">
                <input type="hidden" name="selected_discounted_price" id="selected_discounted_price"
                    value="0.00">
                <input type="hidden" name="selected_diamond_price" id="selected_diamond_price" value="0.00">
                <input type="hidden" name="selected_final_price" id="selected_final_price" value="0.00">
                <input type="hidden" name="selected_diamond_shape" id="selected_diamond_shape"
                    value="{{ $data->diamond_shape }}">
                <input type="hidden" name="selected_diamond_certno" id="selected_diamond_certno" value="">

                <div class="product-add-cart">
                    <div class="product-to-wishlist">
                        @php
                            $wishlist = session()->get('wishlist', []);

                            $wishListClass = 'fa-heart-o';
                            if (array_key_exists($data->id, $wishlist)) {
                                $wishListClass = 'fa-heart';
                            }
                        @endphp
                        <a href="javascript:void(0);" id="productWishList"><i
                                class="fa {{ $wishListClass }} wishcount" aria-hidden="true"></i></a>
                    </div>
                    <div class="product-to-basket">
                        <!-- <a class="btn-bg-small" href="#">Add to basket</a> -->
                        <!-- <a id="addtobasket" href="{{ route('add.to.cart', $data->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to basket</a> </p> -->
                        <a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to
                            basket</a>
                    </div>
                    <div class="product-req-appointment">
                        <a type="button" class="btn-bg-small"
                            onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal"
                            data-bs-target="#requestAppointment">
                            Request an Appointment
                        </a>
                    </div>
                </div>
                <div class="product-postactions">
                    <a href="https://g.page/r/CXBl1avOXsIkEB0/review " class="review-action" target="_blank">
                        Reviews
                    </a>
                    <!-- <a target="_blank" class="review-action" href="#">Reviews</a> -->
                    <a class="store-locator store-locator-border-right" href="{{ asset('visit-us') }}">Store
                        Locator</a>
                    <!-- <a target="_blank" id="productCertificateLink" class="view-certificate mined-certificate" href="#">View Certificate</a> -->
                </div>

                @php
                    $getMonthTextArray = getMonthwiseDiscountText();
                    $getCurrentMonth = (int) date('m');
                    $now = new DateTime('now');
                    $lastDate = new DateTime('now');
                    $lastDate->modify('last day of this month');
                    $dist_future = $lastDate->format('m/d/Y');
                @endphp

                <div class="discount-offerproduct">
                    <h3>{!! strtoupper($getMonthTextArray[$getCurrentMonth]) !!}</h3>
                    <h4>Selected Lines only. <a href="/terms" style="text-decoration: underline; color: #fff;">T&C's
                        </a> apply*</h4>
                </div>
                <div id="social-links" class="social-share-buttons">
                    <!-- Facebook -->
                    <a href="{{ Share::page(URL::current())->facebook()->getRawLinks() }}" target="_blank"
                        class="btn btn-facebook">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <!-- Twitter -->
                    <a href="{{ Share::page(URL::current())->twitter()->getRawLinks()['twitter'] }}" target="_blank"
                        class="btn btn-twitter">
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>

                    <!-- LinkedIn -->
                    <a href="{{ Share::page(URL::current())->pinterest()->getRawLinks()['pinterest'] }}"
                        target="_blank" class="btn btn-linkedin">
                        <i class="fa fa-pinterest"></i>
                    </a>

                    <!-- WhatsApp -->
                    <a href="{{ Share::page(URL::current())->whatsapp()->getRawLinks()['whatsapp'] }}"
                        target="_blank" class="btn btn-whatsapp">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </div>

                <div class="policysection">
                    <div class="policy0icon">
                        <i class="diamond-icon search-lifetimewarranty"></i>
                        <h6 class="policyheading"><a href="/terms">Lifetime <br> Warranty (T&C)</a> </h6>
                    </div>
                    <div class="policy0icon">
                        <i class="diamond-icon search-freedelivery"></i>
                        <h6 class="policyheading"><a href="/terms">Free Delivery & <br> Collection </a> </h6>
                    </div>
                    <div class="policy0icon">
                        <i class="diamond-icon search-diamondquality"></i>
                        <h6 class="policyheading"> <a href="/terms">Diamond Quality <br> Certificate </a> </h6>
                    </div>
                    <div class="policy0icon">
                        <i class="diamond-icon search-returnpolicy"></i>
                        <h6 class="policyheading"><a href="/terms">30 Days<br> Return </a> </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="discount-sale-sec">
    <div class="container">
        <div class="discount-saleinner">
            <div class="diamond-sale">
                <h5>Diamond Spec: <span></span></h5>
            </div>
            <div class="pricetotalbag-sec">
                <div class="pricetotalbag">
                    <div class="salesvates">
                        {{-- <h5>Christmas Sale Price <span>£832.50 inc. VAT</span></h5> --}}
                        <h5><del style="color:#000" id="shopPricefooter"> </del> </h5>
                        <div class="product-finder-price" id="finaldiamondpricefooter">
                        </div>
                    </div>
                    <div class="subpricetotal">
                        {{-- <h5>Subtotal: <span>£925</span></h5> --}}
                        <h5><span>You Save : <span id="savePricefooter"></span></span> | <del id="rrpPricefooter">
                            </del> </h5>
                    </div>
                </div>
                <div class="pricetotalbag-btn">
                    <a id="addtobasketfooter" href="javascript:void(0);" class="btn-bg-small" role="button">Add to
                        Basket</a>
                    <a type="button" class="btn-bg-small"
                        onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal"
                        data-bs-target="#requestAppointment">
                        Request An Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Related Product start heRe -->
<div class="related-products-section">
    <div class="container">
        <div class="head-para-three">
            <div class="heading-h-three">
                Related products
            </div>
        </div>
        <div class="related-products-list">
            <div id="relatedProductData" class="related-product">

            </div>

        </div>
    </div>
</div>
<!-- Related Product end heRe -->

<!-- FAQ Section start here -->
@php
    $faqCategoryKey = md5(20);
    $categoryData = (object) ['faq_category' => 20];
@endphp
{!! Cache::remember('productListingPageFaqCategoryWise_{$faqCategoryKey}', 3600, function () use (
    $categoryData,
) {
    return view('front.includes.faq-category-wise', compact('categoryData'))->render();
}) !!}

<!-- image and text start here -->
<div class="product-image-text-sec">
    <div class="container">
        <div class="leftright-img-text-wraper">
            <div class="leftright-imt-rows flexed flex-flex-wrap flex-items-center">
                <div class="leftright-imt-col leftright-text">
                    <div class="leftright-heading heading-h-three">
                        Choose Your Diamond with Marlow’s Terminology Guide
                    </div>
                    <p>Start your journey towards your finding your perfect engagement ring with our insightful diamond
                        guide. Gain a better understanding of the different types of diamond engagement rings and the
                        meaning behind diamond cut, colour, clarity, and carat. Download your free guide today!</p>
                    <div class="viewguide-btn">
                        <a class="btn-bg-small" href="{{ asset('/certified-diamond-terminology-guide') }}">View
                            Guide</a>
                    </div>
                </div>
                <div class="leftright-imt-col leftright-img">
                    <img src="/assets/images/perfect-ring.jpg" alt="perfect-ring">
                </div>

            </div>
        </div>
    </div>
</div>
<!-- image and text end here -->

<!-- Section Reviews -->
<div class="container">
    <div class="rating-review-block">
        <div class="owl-carousel owl-theme slider-review">
            @include('front.pages.reviews')
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="requestAppointment" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request an appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <!-- Success message -->
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="visit-form">

                        <form id="contactForm">
                            @csrf
                            <input type="hidden" name="custom_url" id="custom_url" value="{{ url()->full() }}">
                            <div class="form-controls">
                                <input type="text" name="title" id="title"
                                    class="{{ $errors->has('title') ? 'error' : '' }}" placeholder="Your Name">
                                <!-- Error -->
                                @if ($errors->has('name'))
                                    <div class="error">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-controls">
                                <input type="email" name="email" id="email"
                                    class="{{ $errors->has('email') ? 'error' : '' }}"
                                    placeholder="Your Email Address">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-controls">
                                <input type="text" name="phone" id="phone"
                                    class="{{ $errors->has('phone') ? 'error' : '' }}"
                                    placeholder="Your Contact No.">
                                @if ($errors->has('phone'))
                                    <div class="error">
                                        {{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-controls">
                                <textarea name="description" id="description" class="{{ $errors->has('description') ? 'error' : '' }}"
                                    placeholder="Your Message"></textarea>
                                @if ($errors->has('description'))
                                    <div class="error">
                                        {{ $errors->first('description') }}
                                    </div>
                                @endif
                            </div>
                            <div class="action-submit">
                                <button type="submit" name="send" value="Submit">Send Message</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
{{-- @include('front.includes.dekopay-finance-options') --}}



@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script> --}}
{{-- <script src='https://www.google.com/recaptcha/api.js'></script> --}}

<script>
    const CSRFTOKEN = "{{ csrf_token() }}";
    const dataPhpVariable = @json($data);
    const contactRoute = "{{ route('contact') }}";
    const addToCartRoute = "{{ route('add.to.cart') }}";
    const setProductWishlistRoute = "{{ route('set-product-wishlist') }}";
    const customFilterRoute = "{{ route('custom-filter') }}";
    const requestDataPhpVariable = @json($requestData);
    const getProductVideoRoute = "{{ route('get-product-video') }}";
    const assetStorageUrl = "{{ asset('storage/') }}/";
    const MYCURRENCYSYMBOLPhpVariable = "{{ config('constants.MY_CURRENCY_SYMBOL') }}";
    const getProductVariationPricesRoute = "{{ route('get-product-variation-prices') }}";
    const customApiFilterDataRoute = "{{ route('custom-api-filter-data') }}";
    const getRelatedProductListRoute = "{{ route('get.related.product.list') }}";
    // const customApiFilterDataRoute = "{{ route('custom-api-filter-data') }}";
    // const customApiFilterDataRoute = "{{ route('custom-api-filter-data') }}"
</script>
<script src="{{ mix('js/product-details-dyes.js') }}"></script>

<!-- Product Schema code start -->
@php
    $schemaProImages = []; // Initialize an empty array
    foreach ($prodImages as $key => $images) {
        if ($key == 0) {
            $proimgURL = env('APP_IMAGE_URL') . '/storage/' . $images->image_url;
            $schemaProImages[] = ['proimgURL' => $proimgURL];
        }
    }
    // Extract proimgURL values into a simple array
    $ImgurlArray = array_column($schemaProImages, 'proimgURL');
    $ImagesURLS = implode(', ', $ImgurlArray);
    $getFinalPrice = getMinimumPriceFunction($data);
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": dataPhpVariable.title || "",
  "image": "{{ $ImagesURLS }}",
  "url": "{{url()->full()}}",
  "description":  "{{ isset($data->description) ? strip_tags($data->description) : '' }}",
  "brand": {
    "@type": "Brand",
    "name": "Marlow's Diamonds"
  },
  "sku": "{{ base64_encode($data->id) }}",
  "offers": {
    "@type": "Offer",
    "url": "{{url()->full()}}",
    "priceCurrency": "GBP",
	"price": "{{ $getFinalPrice['final_discounted_price'] }}",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "bestRating": "5",
    "worstRating": "1",
    "ratingCount": "2626"
  }
}
</script>
<!-- Product Schema code end -->

{{-- video schema starts from here --}}
@php
    $videoUrl = env('APP_IMAGE_URL') . '/storage/' . $data->getProductVariation[0]->vari_video;
    $thumbnailUrl = str_replace('.mp4', '.jpg', $videoUrl);
    $VideoThumbnailUrl = str_replace('.jpg', '.mp4', $videoUrl);
    $uploadDate = isset($data->created_at)
        ? \Carbon\Carbon::parse($data->created_at)->format('Y-m-d')
        : now()->format('Y-m-d');
@endphp

<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "VideoObject",
      "name": dataPhpVariable.title || "",
      "description": "{{ isset($data->description) ? strip_tags($data->description) : '' }}",
      "thumbnailUrl": "{{ env('APP_IMAGE_URL').'/storage/'.$data->getProductImages->image_url }}",
      "duration": "PT20S",
	  "contentUrl": "{{ $VideoThumbnailUrl }}",
	  "embedUrl":"{{url()->current()}}"
    }
</script>
{{-- video schema ends here --}}
@endsection
