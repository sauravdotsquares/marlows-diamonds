@extends('layouts.front.app')
@section('content')
@section('css')
<link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection


<div class="category-banner" style="background-image:url({{ asset('') }}assets/images/engagement-rings-banner.png)">
    <div class="container">
        <div class="category-banner-text">
            <h1>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h1>
            <p>{!! !empty($categoryData->short_description) ? $categoryData->short_description : '' !!}</p>
        </div>
    </div>
</div>
<div class="container product-panel-new">
    <div class="row">
        <div class="col-sm-12">
            <p class="burgarmenu">
                <a href="{{ url('/') }}">Home </a> 
                <span>
                    <?php 
                        $url = $path;
                        if(isset($url) && !empty($url)){
                            echo " / ";
                        }

                        echo getBreadcrumbCategoryName($url); 
                    ?>
                </span>
            </p>

            @if(isset($url) && $url == 'diamond-engagement-rings')
            <!-- Choose a dreamy start here-->
            <div class="choosedreamy-wrap">
                <div class="container">
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Choose A Dream Setting for Your Engagement Ring</h2>
                    </div>
                    <div class="rings-grid-wrap">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-md-3">
                                <div class="ring-pr-items">
                                    <div class="ring-pr-image">
                                        <a href="/engagement-rings/solitaire"><img src="{{env('APP_IMAGE_URL').'/assets/images/CR10-SE45_0003.jpg'}}" alt="SOLITAIRE ENGAGEMENT RINGS"></a>
                                    </div>
                                    <div class="ring-pr-details">
                                        <h3 class="ring-pr-title">
                                            SOLITAIRE ENGAGEMENT RINGS
                                        </h3>
                                        <div class="ring-pr-desc">
                                            <p>Solitaire rings are classics for a reason. Their single stone setting exudes beauty like no other with a jaw-dropping centrepiece. This is the best of all diamond engagement rings if you want a flashy simple design.</p>
                                        </div>
                                        <div class="ring-pr-shop-btn">
                                            <a class="btn-bg-small" href="/engagement-rings/solitaire">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-3">
                                <div class="ring-pr-items">
                                    <div class="ring-pr-image">
                                        <a href="/engagement-rings/halo/"><img src="{{env('APP_IMAGE_URL').'/assets/images/DSR21-Images_0003.jpg'}}" alt="HALO ENGAGEMENT RINGS"></a>
                                    </div>
                                    <div class="ring-pr-details">
                                        <h3 class="ring-pr-title">
                                            HALO ENGAGEMENT RINGS
                                        </h3>
                                        <div class="ring-pr-desc">
                                            <p>Halo rings are solitaires made better! Complimented by a halo of smaller diamonds, the centre stone looks gorgeous in every way. If you love solitaires but want something extra, then this is the diamond ring for you.</p>
                                        </div>
                                        <div class="ring-pr-shop-btn">
                                            <a class="btn-bg-small" href="/engagement-rings/halo/">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-3">
                                <div class="ring-pr-items">
                                    <div class="ring-pr-image">
                                        <a href="/engagement-rings/shoulder-set/"><img src="{{env('APP_IMAGE_URL').'/assets/images/CX9-SL28_00003-1.jpg'}}" alt="SHOULDER SET ENGAGEMENT RINGS"></a>
                                    </div>
                                    <div class="ring-pr-details">
                                        <h3 class="ring-pr-title">
                                            SHOULDER SET ENGAGEMENT RINGS
                                        </h3>
                                        <div class="ring-pr-desc">
                                            <p>Want more sparkle? Go for shoulder set rings with a band of encrusted diamonds that make your ring all the more special. A dazzling solitaire with little diamonds along the way can make all the difference.</p>
                                        </div>
                                        <div class="ring-pr-shop-btn">
                                            <a class="btn-bg-small" href="/engagement-rings/shoulder-set/">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-md-3">
                                <div class="ring-pr-items">
                                    <div class="ring-pr-image">
                                        <a href="/engagement-rings/multi-stone/"><img src="{{env('APP_IMAGE_URL').'/assets/images/R3-143_0003.jpg'}}" alt="MULTI-STONE ENGAGEMENT RINGS"></a>
                                    </div>
                                    <div class="ring-pr-details">
                                        <h3 class="ring-pr-title">
                                            MULTI-STONE ENGAGEMENT RINGS
                                        </h3>
                                        <div class="ring-pr-desc">
                                            <p>Why stop at one when you can have many? Make a statement with diamond engagement rings in multi-stone settings. Unique styles and combinations are waiting for you.</p>
                                        </div>
                                        <div class="ring-pr-shop-btn">
                                            <a class="btn-bg-small" href="/engagement-rings/multi-stone/">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="text" name="title" class="search-item empty search-mobile" id="searchm" value="" placeholder="&#xF002; Search for product" aria-label="Search">

            <center>
                <!-- <h3>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h3> -->
            </center>

            @else
                <div class="owl-carousel owl-theme listing-slider" style="text-align: center; ">
                    @foreach ($filter_items as $filter_key => $filter_item)
                        @if($filter_item->slug == 'style-categories')
                            @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                                <div class="item">
                                    @if(isset($product_item_item->category_images) && !empty($product_item_item->category_images))
                                        <img src="{{ env('APP_IMAGE_URL').'/storage/'.$product_item_item->category_images }}" alt="{{$product_item_item->item_name}}">
                                    @else
                                        <img src="{{env('APP_IMAGE_URL').'/storage/Products/CX9-SC48_00003_1650365432.jpg'}}" alt="{{$product_item_item->item_name}}"> 
                                    @endif
                                    <p> <a href="{{ url($product_item_item->parent_category_slug->parent_cate->slug.'/'.$product_item_item->item_slug)}}">{{$product_item_item->item_name}}</a></p>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    



<div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
    <div class="container">
        <div class="category-listing-row">
            <div class="category-sidebar-wrap category-sidebar-left">
                <div>
                    <a href="javascript:void(0)" class="clearallfilter-desktop resetFilterButton" id="resetFilterButton">All Filter Category</a>
                    <div class="filter-clear">
                        <button href="#collapse1" class="nav-toggle btn" style=""><i class="fa fa-angle-down" style="color:#993168"></i>  Filter </button>
                       
                        <div class="dropdown sortmobile">
                            <i class="fa fa-angle-down" style="font-size:15px;color:#993168" aria-hidden="true"></i>
                            <select class="form-control dropdown-content" name="sortingMSelect" id="sortingMSelect">
                                <option value="" selected>Sort by <i class="fa fa-filter"></i></option>
                                <option value="asc">A to Z</option>
                                <option value="desc">Z to A</option>
                                <!-- <option value="price-min">Low to High</option>
                                <option value="price-max">High to Low</option> -->
                              </select>

                            </div>
                    </div>
                    <div class="filter-container" id="collapse1">
                        @foreach ($filter_items as $filter_key => $filter_item)
                        <div class="filter-item">
                            <input type="hidden" name="filter_item_slug" class="filter_item_slug" value="{{ $filter_item->slug }}" />
                            <div class="accordion-item">
                                <div class="category-filter-title">

                                            <h6><b>{{ $filter_item->name }}</b></h6>

                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $filter_item->slug }}" aria-expanded="true" aria-controls="collapse{{ $filter_item->slug }}" style="background: #fff;border:none;"></button>
                                </div>
                                <ul>
                                    <div id="collapse{{ $filter_item->slug }}" class="accordion-collapse collapse show" aria-labelledby="{{ $filter_item->slug }}" data-bs-parent="#accordionExample">
                                        @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                                        <div class="accordion-body">
                                            <li>
                                                @php
                                                $checkVariable = 'true';
                                                $checkVariableNew = '';
                                                @endphp

                                                @if (in_array(Str::lower($product_item_item->item_value), $slugs))
                                                <?php
                                                $checkVariable = 'false';
                                                $checkVariableNew = 'checked';
                                                ?>
                                                @elseif(in_array(Str::lower(Str::replace(' ', '-', $product_item_item->item_name)), $slugs))
                                                <?php
                                                $checkVariable = 'false';
                                                $checkVariableNew = 'checked';
                                                ?>
                                                @endif

                                                @if (isset($product_item_item->item_name) && $product_item_item->item_name == 'price')
                                                <div class="diamond-field-contens col-lg-9">
                                                    <div class="diamond-field-inner-bar">
                                                        <div class="range_carat_wap">
                                                            <div class="srchniput-fil">
                                                                <div class="minrange">
                                                                    <span>Min</span>
                                                                    <input id="sliderRangeSetMin" disabled="" data-index="0" class="sliderValue" value="100">
                                                                </div>
                                                                <div class="maxrange">
                                                                    <span>Max</span>
                                                                    <input id="sliderRangeSetMax" disabled="" data-index="1" class="sliderValue" value="150000">
                                                                </div>
                                                            </div>

                                                            <div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 19.1489%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 59.5745%;"></span>
                                                            </div>
                                                            <div class="srchniput-fil">
                                                                <input type="hidden" class="sliderValue filter-item-data" data-index="0" value="100" id="input-carat-min" name="price-min" autocomplete="off">
                                                                <input type="hidden" class="sliderValue filter-item-data" data-index="1" value="150000" id="input-carat-max" name="price-max" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <input type="{{ $filter_item->input_type }}" name="{{ $filter_item->slug }}" {{ $checkVariableNew }} onclick="return {{ $checkVariable }};" value="{{ $product_item_item->item_value }}" class="filter-item-data">
                                                {{ $product_item_item->item_name }}
                                                @endif
                                            </li>
                                        </div>
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                        <div class="reset-filer-container">
                            <a href="javascript:void(0)" id="resetFilterButton" class="resetFilterButton">
                                See All </a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="category-list-wrap">
                <div class="row">
                    <div class="category-list-top">
                    <div class="category-list-item">
                        <!-- <p>Item <span id="productCountData">{{$product_count}}</span></p> -->
                        <a href="javascript:void(0)" class="clearallfilter-desktop clearallfilter-mobile resetFilterButton" id="resetFilterButton">   <i class="fa fa-angle-down" style="font-size:15px;color:#993168" aria-hidden="true"></i>  All Filter Category</a>
                    </div>
                    <div class="category-list-item-searchsort dropdown-content-desktop">
                          <input type="text" name="title" class="search-item empty" id="searchd" value="" placeholder="&#xF002; Search for product" aria-label="Search">
                            <div class="dropdown">
                            <select class="form-control dropdown-content" name="sortingDSelect" id="sortingDSelect">
                                <option value="" selected>Sort by <i class="fa fa-filter"></i></option>
                                <option value="asc">A to Z</option>
                                <option value="desc">Z to A</option>
                                <!-- <option value="price-min">Low to High</option>
                                <option value="price-max">High to Low</option> -->
                              </select>

                            </div>
                    </div>
</div>

                </div>
                <input type="hidden" id="pagescroll" value="1">
                <input type="hidden" name="sectionHeight" id="sectionHeight" value="">
                <input type="hidden" name="scrollFlag" id="scrollFlag" value="">

                <div class="text-center">{!!isset($filterItemTextData->top_text)?$filterItemTextData->top_text:''!!}</div>
                <br>
                <div class="search-result" style="margin-top: -15px;"> @include('front.includes.productCard')</div>
                <div class="loading-data-element"></div>
                <input type="hidden" name="nextPageNumber" id="nextPageNumber" value="{{ $nextPage }}" />
                <div class="ajax-load text-center" style="display:none;">
                    {{--<img loading="lazy" alt="Product loader" src="{{env('APP_IMAGE_URL').'/assets/images/spinner-ring.gif' }}">--}}
                    <p>Loading More Products</p>
                    <button style="display: none;" class="ajax-load-btn">Load more data</button>
                </div>
                <div class="ajax-loader">
                    {{--<img src="{{env('APP_IMAGE_URL').'/images/spinner.gif' }}" id="loading-data-image" class="img-responsive" style="display:none;" /> --}}
                </div>
                <br>
                <br>
                <div class="text-center">{!!isset($filterItemTextData->bottom_text)?$filterItemTextData->bottom_text:''!!}</div>
                {{-- {!! isset($categoryData->description) ? $categoryData->description : '' !!} --}}
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="head-para-three">
        <div class="heading-h-three">
            Delivery & Return Policy
        </div>
    </div>
    <div class="policysection">
        <div class="policy0icon">
            <i class="diamond-icon search-lifetimewarranty"></i>
            <h6 class="policyheading"><a href="/terms">Lifetime <br> Warranty (T&C)</a> </h6></div>
        <div class="policy0icon">
            <i class="diamond-icon search-freedelivery"></i>
            <h6 class="policyheading"><a href="/terms"> Free Delivery & <br> Collection  </a> </h6></div>
        <div class="policy0icon" >
            <i class="diamond-icon search-diamondquality"></i>
            <h6 class="policyheading"> <a href="/terms"> Diamond Quality <br> Certificate </a> </h6></div>
        <div class="policy0icon">
            <i class="diamond-icon search-returnpolicy"></i>
            <h6 class="policyheading"><a href="/terms"> 30 Days<br> Return </a> </h6></div>
    </div>
</div>


<!-- CHoose a dreamy end here-->
@if(isset($url) && $url == 'diamond-engagement-rings')
<!-- Banner Text Section-->
<div class="findmatch-wrap perfect-ring-guidepartner">
	<div class="container">
		<div class="leftright-img-text-wraper">
			<div class="leftright-imt-rows flexed flex-flex-wrap flex-items-center">
				
				<div class="leftright-imt-col leftright-text">
					<h2 class="leftright-heading heading-h-three">
						Find Your Perfect Ring for Your Partner
					</h2>
					<p>Once you've found your perfect match, you should choose the perfect engagement ring that suits her personality and look. We bring to you a curated assortment of diamond engagement rings in the most beautiful designs, stone settings, diamond shapes, and ring sizes.</p>
					<p>Our diamond engagement rings are fully natural and unique, designed in our lab. We only use ethically sourced diamonds in our engagement rings. Additionally, we offer diamonds that are graded by the GIA, so you can be confident that they are of high quality. Adorning our sparkling stones will bring you joy and warmth for the rest of your lives.</p>
					<div class="viewguide-btn">
						<a class="btn-bg-small" href="/diamond-engagement-rings">Shop Now</a>
					</div>
				</div>
                <div class="leftright-imt-col leftright-img">
					<img src="{{env('APP_IMAGE_URL').'/assets/images/banner-hand.jpg'}}" alt="banner-hand">
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Best Selling Marlow's Diamond Jewellery start here -->
<!-- Best Selling Marlow's Diamond Jewellery end here -->

<!-- Your Journery of a lifetime start here start-->
<div class="journery-life-wraper">
	<div class="container">
		{!! isset($pageData->description)?$pageData->description:"" !!}
	</div>
</div>
<!-- Your Journery of a lifetime start here end-->

<!-- Best Post Carousel Block start here -->
@include('front.includes.postcarouselblock')
<!-- Best Post Carousel Block start here -->

<!-- FAQ Section start here -->



@endif
<!-- Section Reviews -->
<div class="container">
    <div class="rating-review-block">
        <div class="owl-carousel owl-theme slider-review">
            @include('front.pages.reviews')
        </div>
    </div>
</div>

<!-- FAQ Section end here -->
<div class="faq-section engagement-ring-faq">
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three">
                Engagement Ring FAQ’s
            </h2>
            <h3 style="font-size: 15px;">Some of the most common Engagement Ring Q&A's</h3>
        </div>
        <div class="faq-list">
            <div class="accordion" id="accordionExample">

                @php
                $getEngagementFaqs = getEngagementFaqs();
                @endphp

                @foreach($getEngagementFaqs as $key => $faq)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="{{$faq->id}}">
                        @if($key == 0)
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                            @else
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                                @endif
                                {{isset($faq->title)?$faq->title:""}}
                            </button>
                    </h2>
                    @if($key == 0)
                    <div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                        @else
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                            @endif
                            <div class="accordion-body">
                                {!! isset($faq->description)?$faq->description:"" !!}
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

@include('front.includes.instagram-section')
<div class="engagement-ring-img">
    <img src="{{env('APP_IMAGE_URL').'/images/viewguide.PNG'}}" alt="Find the perfect engagement ring">
    <div class="engagement-ring-img-content">
        <div class="container">
    <h2>Find the perfect engagement ring</h2>
    <button class="reset-filer-btn"> <a href="{{env('APP_IMAGE_URL').'/storage/MarlowsDiamonds-PremiumContent-Guide-3.pdf'}}" target="_blank"> View Guide </a> </button>
</div>
</div>
</div>

</div>
@endsection
@section('js')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(document).ready(function() {

        
        $("#slider").slider({
            range: true,
            min: 100,
            max: 150000,
            step: 2,
            values: [100, 150000],
            slide: function(event, ui) {
                var value1 = $("#slider").slider("values", 0);
                var value2 = $("#slider").slider("values", 1);
                $("#sliderRangeSetMin").val(value1);
                $("#sliderRangeSetMax").val(value2);


                for (var i = 0; i < ui.values.length; ++i) {
                    $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
                }

            },
            change: function() {

                var value1 = $("#slider").slider("values", 0);
                var value2 = $("#slider").slider("values", 1);

                $("#showProductList").html('');
                sendDataValues(1,'append'); 
            },
        });

        $("#sliderRangeSetMin").change(function(event) {
            var value1 = parseFloat($("#sliderRangeSetMin").val());
            var highVal = value1 * 2;
            $("#slider").slider("option", {
                "max": highVal,
                "value": value1
            });
        });

        $("#sliderRangeSetMax").change(function(event) {
            var value1 = parseFloat($("#sliderRangeSetMax").val());
            var highVal = value1 * 2;
            $("#slider").slider("option", {
                "max": highVal,
                "value": value1
            });
        });

        var stepsSlider = document.getElementById('range-slider');
        var input0 = document.getElementById('input-carat-min');
        var input1 = document.getElementById('input-carat-max');
        var inputs = [input0, input1];

        $('.resetFilterButton').on('click', function() {
            $('.filter-item-data').prop("checked", false);
            var value = '{{$path}}';
            var arrVars = value.split("/");

            var value1 = arrVars[0];
            var value2 = arrVars[1];
            if(value1 == 'diamond-engagement-rings'){
                value1 = 'engagement-rings';
            }
            $("input[name=category][value=" + value1 + "]").prop('checked', true);
            $("input[name=style-categories][value=" + value2 + "]").prop('checked', true);
            if(value2 !== undefined){
                $("input[name=filter-by-shape][value=" + value2 + "]").prop('checked', true);
                $("input[name=jewellery-categories][value=" + value2 + "]").prop('checked', true);
            }
            $("#showProductList").html('');
            sendDataValues(1,'append');
        });

        var value = '{{$path}}';
        var arrVars = value.split("/");

        if (arrVars[0] == 'diamonds-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css('display', 'none');
        }

        if (arrVars[0] == 'diamond-engagement-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='mens']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='womens']").parent('li').css('display', 'none');

            $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css('display', 'none');
        }

        if (arrVars[0] == 'eternity-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='halo']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='multi-stone']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='shoulder-set']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='solitaire']").parent('li').css('display', 'none');

            $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display', 'none');

            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css('display', 'none');
        }


        if (arrVars[0] == 'wedding-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='halo']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='multi-stone']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='shoulder-set']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='solitaire']").parent('li').css('display', 'none');

            $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display', 'none');

            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css('display', 'none');
        }

        if (arrVars[0] == 'engagement-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='mens']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='womens']").parent('li').css('display', 'none');

            $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css('display', 'none');
        }

        if (arrVars[0] == 'diamond-jewellery') {
            $("input[name=category][value='diamonds-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');

            $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='style-categories']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
        }

        if (arrVars[1] == 'halo' || arrVars[1] == 'shoulder-set' || arrVars[1] == 'solitaire' || arrVars[1] == 'multi-stone') {
            $("input[name=style-categories]").attr('onclick', 'return false;');
        }
        filterShapechanged();
        filterStylechanged();
        filterRingTypechanged();
        filterJewelleryTypechanged();
    });

    function filterShapechanged() {
        $('input[name="filter-by-shape"]:checked').each(function() {
            if (this.value != '') {
                $("input[name=filter-by-shape]").attr('onclick', 'return false;');
            }
        });
    }

    function filterStylechanged() {
        $('input[name="style-categories"]:checked').each(function() {
            if (this.value != '') {
                $("input[name=style-categories]").attr('onclick', 'return false;');
            }
        });
    }

    function filterRingTypechanged() {
        $('input[name="ring-categories"]:checked').each(function() {
            if (this.value != '') {
                $("input[name=ring-categories]").attr('onclick', 'return false;');
            }
        });
    }

    function filterJewelleryTypechanged() {
        $('input[name="jewellery-categories"]:checked').each(function() {
            if (this.value != '') {
                $("input[name=jewellery-categories]").attr('onclick', 'return false;');
            }
        });
    }

    $(document).on('mouseenter', '.product-hover-affect', function(event) {
        if ($(this).find('video').length) {
            $(this).find('video')[0].play()
        }
    }).on('mouseleave', '.top-level', function() {
        console.log('mouse leave')
        if ($(this).find('video').length) {
            $(this).find('video')[0].pause()
        }
    })

    $(document).on('touchstart', '.product-hover-affect', function() {
        $(this).find('a.product-hov').css({
            '-webkit-transition': 'all 200ms ease-in',
            '-webkit-transform': 'scale(1.2)',
            '-ms-transition': 'all 200ms ease-in',
            '-ms-transform': 'scale(1.2)',
            '-moz-transition': 'all 200ms ease-in',
            '-moz-transform': 'scale(1.2)',
            'transition': 'all 200ms ease-in',
            'transform': 'scale(1.2)'
        });
        $(this).find('.product-hover-video').css({
            'display': "block",
            'position': "absolute",
            'top': "0",
            "width": "100%",
            "height": "100%",
            "background": "#fff"
        });
        if ($(this).find('video').length) {
            $(this).find('video')[0].play()
        }
    });
    $(document).on('change', ".filter-item-data", function() {
        $("#showProductList").html('');
        sendDataValues(1,'append');
    });

    $(document).on('change', "#sortingDSelect", function() {
        $("#showProductList").html('');
        sendDataValues(1,'append',$(this).val());
    });

    $(document).on('change', "#sortingMSelect", function() {
       $("#showProductList").html('');
        sendDataValues(1,'append',$(this).val());
   });

    $(window).scroll(function() {
        var scroll = $('#scrollFlag').val();
        if (scroll == 0 && ($(window).scrollTop() >= parseInt($('#sectionHeight').val()))) {
            var page = $('#pagescroll').val();
            // sendDataValues(page);
            $('#scrollFlag').val(1);
        }
    });

    $('#searchd').on('keyup', function() {
        let searchTextData = $(this).val();
        if (searchTextData.length > 2) {
            $("#showProductList").html('');
            sendDataValues(1, 'html');
        } else if (searchTextData.length == 0) {
            location.reload();
            // var page = $('#pagescroll').val();
            // sendDataValues(page, 'append');
        }
    });

    function sendDataValues(page, type = 'append',sorting='asc') {
        // $("input[name=filter-by-shape]").attr('onclick', 'return false;');
        // filterShapechanged();
        $('.ajax-load').show();
        $.ajax({
            type: 'GET',
            url: "{{ route('getfilteredproducts') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'ids': $('.filter-item-data').serializeArray(),
                'sorting': sorting,
                'keyword': $('#searchd').val(),
                'path': '{{ $path }}',
                'page': page,
                'per_page_product': 70
            },
            success: function(res) {
                // filterShapechanged();
                $('#pagescroll').val(res.nextPage);

                if (res.productItems == "") {
                    $('.ajax-load').html("No more products found");
                    return false;
                }
                $('.ajax-load').hide();
                if (type == 'append') {
                    $("#showProductList").append(res.productItems);
                } else {
                    $("#showProductList").html(res.productItems);
                }
                $('#productCountData').text(res.product_count);
                $('#sectionHeight').val($('#showProductList').height());
                $('#scrollFlag').val(0);
            }
        });
    }

  
</script>
<script>
    $(document).ready(function() {

       var collapse1value = document.getElementById('collapse1');
        if (screen.width <= 320 || screen.width <= 991) {
            collapse1value.style.display = "none";
        } else {
            // collapse1value.style.display="block11";
        }
        $('.nav-toggle').click(function() {
            //get collapse content selector
            var collapse_content_selector = $(this).attr('href');

            //make the collapse content to be shown or hide
            var toggle_switch = $(this);
            $(collapse_content_selector).toggle(function() {
                if ($(this).css('display') == 'none') {
                    //change the button label to be 'Show'
                    toggle_switch.html('<i class="fa fa-angle-down" style="color:#993168"></i>  Filter');
                } else {
                    //change the button label to be 'Hide'
                    toggle_switch.html('<i class="fa fa-angle-up" style="color:#993168"></i>  Filter');
                }
            });
        });

        $(document).on('click', "[id^=productWishListRelated]", function () {
            var index = parseInt($(this).attr("id").replace("productWishListRelated", ''));
            var product_slug = $('#productWishListRelated'+index).data('productslug');
            console.log(product_slug);
            addtobasketFunction('{{route("set-product-wishlist")}}',product_slug,index);
        });

    });

    function addtobasketFunction(getUrl,product_slug,index){
        var trdata = $('#finaldiamondprice .price').text().replace(/[^\0-9.-]+/g, '');
        var rrpPrice = $('#rrpPrice.rrpPriceval').text().replace(/[^\0-9.-]+/g, '');
        var savePriceval = $('#savePrice.save').text().replace(/[^\0-9.-]+/g, '');
        var shopPricedata= $('#shopPrice.shopPriceval').text().replace(/[^\0-9.-]+/g, '');

        let lab_grown_price = $("#finaldiamondprice .price").text().replace("£", "");
        
        let diamondCaratWeight;
        let diamondColour;
        var diamondShape;
        let diamondGrade;
        let diamondClarity;
        let diamondCertificate;
        if($('.diamond_type:checked').val() == 'mined_diamond'){
            diamondCaratWeight = $('#carat').val();
            diamondColour = $('#diamond-colour').val();
            diamondShape = $('#selected_diamond_shape').val();
            diamondGrade = $('#diamond-grade').val();
            diamondClarity = $('#diamond-clarity').val();
            diamondCertificate = $('#diamond-certificate').val();
        }else if($('.diamond_type:checked').val() == 'lab_grown'){
            diamondCaratWeight = $('#lab_grown_carat').val();
            diamondColour = $('#lab_grown_colour').val();
            diamondShape = $('#selected_diamond_shape').val();
            diamondGrade = '';
            diamondClarity = $('#lab_grown_clarity').val();
            diamondCertificate = '';
        }

        var variations = [];
        $('.type-variations-row select').each(function(i, sel){

            if($(sel).attr('name')!='finger-size')
                variations.push($(sel).val());
        });


        $.ajax({
            type: 'POST',
            url: getUrl,
            data: {
                '_token': "{{csrf_token()}}",
                'carat' : $('#carat').val(),
                'variations' : variations,
                'total-diamond-weight' : $('#total-diamond-weight').val(),
                'color' : $('#diamond-colour').val(),
                'clarity' : $('#diamond-clarity').val(),
                'width-mm' : $('#width-mm').val(),
                'grade' : $('#diamond-grade').val(),
                'fingersize' : $('#finger-size').val(),
                'metal_type' : $('#metal-type').val(),
                'certificate' : $('#diamond-certificate').val(),
                'choose_diamond': $('input[name="attribute_choose-your-diamond"]:checked').val(),
                'slug' : product_slug,
                'price':parseInt(trdata) || 0,
                'rrpPrice':parseInt(rrpPrice) || 0,
                'savePrice':parseInt(savePriceval) || 0,
                'shopPrice':parseInt(shopPricedata) || 0,
                'diamond_type' : $(".diamond_type:checked").val(),
                'discounted_price':parseInt($('#selected_discounted_price').val()) || 0, 
                'final_price':parseInt($('#selected_final_price').val()) || 0, 
                'setting_price': parseInt(trdata) || 0, 
            },
            success: function (res) {
                if(res.success != '' && typeof res.success !== "undefined"){
                    if(res.cartcount){
                        $(".cartcount").text(res.cartcount);
                    }
                    if(res.wishcount){
                        if(index>0){
                            $('#productWishListRelated'+index).children('i').addClass('fa-heart');
                            $('#productWishListRelated'+index).children('i').removeClass('fa-heart-o');
                        }else{
                            $('#productWishList'+index).children('i').removeClass('fa-heart-o');
                            $('#productWishList'+index).children('i').addClass('fa-heart');
                        }
                    }
                    toastr.success(res.success);
                }else{
                    if(res.error){
                        if(index>0){
                            $('#productWishListRelated'+index).children('i').removeClass('fa-heart');
                            $('#productWishListRelated'+index).children('i').addClass('fa-heart-o');
                        }else{
                            $('#productWishList'+index).children('i').removeClass('fa-heart');
                            $('#productWishList'+index).children('i').addClass('fa-heart-o');
                        }
                    }
                    toastr.info(res.error);
                }
            }
        });
    }

    $(function() {
        var owl = $(".owl-carousel");
        owl.owlCarousel({
            items: 7,
            margin: 2,
            loop: true,
            nav: false,
            responsive: {
                320: {
                    items: 2
                },
                480: {
                    items: 3
                },
                769: {
                    items: 4
                },
                991: {
                    items: 6
                }
            }
        });
    });
</script>
</script>
@endsection