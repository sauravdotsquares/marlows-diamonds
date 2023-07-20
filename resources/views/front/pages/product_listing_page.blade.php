@extends('layouts.front.app')
@section('content')
@section('css')
<link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .dropdown-content {
        height: 30px;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .search-item {
        width: 320px;
        height: 29px;
        border: none;
        background: #efefef;
        padding: 6px;
    }

    input.empty {
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        text-decoration: inherit;
    }

    .sortbtn {
        width: 138px !important;
        background: #fff;
        border-radius: 6px;
        border: 2px solid #efefef;
        height: 30px;
        margin-left: 2px;
    }

    .ui-slider-handle {
        width: 35px !important;
        font-size: small !important;
        color: #FF0000 !important;
        text-align: center !important;
    }

    .ui-slider .ui-slider-handle {
        height: 1.5em;
        color: #8e2e65 !important;
    }

    .ui-widget-header {
        background: #8e2e65 !important;
    }

    .ui-state-hover,
    .ui-widget-content .ui-state-hover,
    .ui-widget-header .ui-state-hover,
    .ui-state-focus,
    .ui-widget-content .ui-state-focus,
    .ui-widget-header .ui-state-focus {
        border-color: #8e2e65 !important;
        outline: none;
        box-shadow: none;
        background: #fff !important;
    }

    .error {
        color: #e74c3c !important;
    }

    .accordion-body {
        padding: 0 15px;
    }

    .srchniput-fil span {
        font-size: 13px;
        background: #ffff;
        position: absolute;
        left: 8px;
        top: -22px;
        padding: 0px 4px;
        display: inline-block;
    }

    .nav-toggle {
        display: none; // display none for everyone
    }

    /* Landscape phone to portrait tablet  show the button */
    @media only screen and (max-width: 576px) and (min-width: 320px) {
        .nav-toggle {
            display: block; // or inline-block or inline : which ever is appropriate for you.
        }

        .filter-item {
            display: inline-block;
            vertical-align: top;
            margin-right: 60px;
            width: 300px;
        }

        .search-item {
            width: 134px !important;
        }

        .sortbtn {
            width: 71px !important;
        }
    }

    @media only screen and (max-width: 720px) and (min-width: 576px) {
        .nav-toggle {
            display: block; // or inline-block or inline : which ever is appropriate for you.
        }

        .filter-item {
            display: inline-block;
            vertical-align: top;
            margin-right: 60px;
            width: 300px;
        }

        .search-item {
            width: 135px !important;
        }

        .sortbtn {
            width: 122px !important;
        }
    }

    @media only screen and (max-width: 991px) and (min-width: 720px) {
        .nav-toggle {
            display: block; // or inline-block or inline : which ever is appropriate for you.
        }

        .filter-item {
            display: inline-block;
            vertical-align: top;
            margin-right: 60px;
            width: 300px;
        }

        .search-item {
            width: 178px !important;
        }
    }

    @media only screen and (max-width: 1300px) and (min-width: 991px) {
        .search-item {
            width: 280px !important;
        }
    }
    .policysection
    {
        margin-top: 20px;display: flex;flex-wrap: wrap;justify-content: space-between;
    }
    .policyheading
    {
        color: #8e2e65;
    font-weight: bold;
    text-transform: capitalize;
    font-size: 13px;
    }
    .policy0icon
		{
            border: 1px solid #8e2e65;
            padding: 7px 1px 0px;
            width: 24%;
            text-align: center;
            border-radius: 10px;
		}
		.policyimg
		{
            width: 50px;
            margin: 0 0 11px;
		}
		@media only screen and (max-width: 600px) {
			.policy0icon
		{
		    border: 1px solid #8e2e65;
            padding: 10px 15px 0px;
            width: 48%;
            text-align: center;
			border-radius: 10px;
			margin-top: 10px;
		}
		}
</style>
@endsection


<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <p style="padding-top: 10px;text-decoration:none!important"><a href="{{ url('/') }}">Home</a> <span><?php
                                                                                                                $url = $_SERVER['REQUEST_URI'];
                                                                                                                echo $url;
                                                                                                                ?></span></p>
            <center>
                <h3>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h3>
            </center>
            <div class="owl-carousel owl-theme" style="text-align: center; ">
                @foreach ($filter_items as $filter_key => $filter_item)
                    

                    @if($filter_item->slug == 'style-categories')
                        @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                            <div class="item">
                               
                                @if(isset($product_item_item->category_images) && !empty($product_item_item->category_images))
                                    <img src="{{ asset('storage/'.$product_item_item->category_images)}}" style="width:100px">
                                @endif
                                <p> <a href="{{ url($product_item_item->parent_category_slug->parent_cate->slug.'/'.$product_item_item->item_slug)}}">{{$product_item_item->item_name}}</a></p>
                            </div>
                        @endforeach
                    @endif

                @endforeach
                <!-- <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div>
                <div class="item">
                    <img src="https://192.168.3.141/marlows-diamond/public/storage/Products/ET105-F-VS_T_W.jpg" style="width:100px">
                    <p> Eternity Ring</p>
                </div> -->

            </div>
            <div>
            </div>
        </div>
    </div>

    <center><button href="#collapse1" class="nav-toggle btn" style="background-color: #8e2e65; color:#fff"><i class="fa fa-plus" style="font-size:15px;color:#fff"></i> All Filter Category</button></center><br>
</div>

<div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
    <div class="container">
        <div class="category-listing-row">
            <div id="collapse1" class="category-sidebar-wrap">
                <div>
                    <div style="display: flex">
                        <h3>Filter </h3>
                        <a href="javascript:void(0)" id="resetFilterButton" style="padding-left: 120px;color:black;"> Clear All Filter</a>
                    </div>
                    <div class="filter-container">
                        @foreach ($filter_items as $filter_key => $filter_item)
                        <div class="filter-item">
                            <input type="hidden" name="filter_item_slug" class="filter_item_slug" value="{{ $filter_item->slug }}" />
                            <div class="accordion-item">
                                <div class="category-filter-title">
                                    <div class="row">
                                        <div class="col-sm-6 col-9">
                                            <h6 style="padding:10px;"><b>{{ $filter_item->name }}</b></h6>
                                        </div>
                                        <div class="col-sm-6 col-3">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $filter_item->slug }}" aria-expanded="true" aria-controls="collapse{{ $filter_item->slug }}" style="background: #fff;border:none;"></button>
                                        </div>
                                    </div>
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
                            <a href="javascript:void(0)" id="resetFilterButton"><button class="reset-filer-btn"> See All (234)</button></a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="category-list-wrap">
                <div class="row">
                    <div class="col-sm-6 col-3">
                        <p>Item 282</p>
                    </div>
                    <div class="col-sm-6 col-9">
                        <div style="display: flex">
                            <input type="text" name="title" class="search-item empty" id="search" value="" placeholder="&#xF002; Search for product" aria-label="Search">
                            <div class="dropdown">
                            <select class="form-control dropdown-content" name="exampleSelect" id="exampleSelect">
                                <option value="" selected>Sort by <i class="fa fa-filter"></i></option>
                                <option value="asc">A to Z</option>
                                <option value="desc">Z to A</option>
                                <option value="price-min">Low to High</option>
                                <option value="price-max">High to Low</option>
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
                    <img alt="Product loader" src="{{ asset('assets/images/spinner-ring.gif') }}">
                    <p>Loading More Products</p>
                    <button style="display: none;" class="ajax-load-btn">Load more data</button>
                </div>
                <div class="ajax-loader">
                    <img src="{{ asset('images/spinner.gif') }}" id="loading-data-image" class="img-responsive" style="display:none;" />
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
        <div class="policy0icon"><img src="{{asset('/images/warranty.png')}}" class="policyimg"><h6 class="policyheading">Lifetime manufacturing<br> guarantee </h6></div>
        <div class="policy0icon"><img src="{{asset('/images/shipped.png')}}"class="policyimg"><h6 class="policyheading">Free Delivery <br> Collection </h6></div>
        <div class="policy0icon" ><img src="{{asset('/images/certificate.png')}}"class="policyimg"><h6 class="policyheading"> Certificate <br> Diamond </h6></div>
        <div class="policy0icon"><img src="{{asset('/images/return.jpg')}}"class="policyimg"><h6 class="policyheading">30 Days<br> Return </h6></div>
        </div>
</div>
<!-- FAQ Section start here -->

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

<div>
    <img src="{{url('/images/viewguide.PNG')}}">
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
                sendDataValues();
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

        $('.show-more-content').hide();
        $('.show-more').click(function() {
            $(this).parents('.reviewr-review-text').toggleClass("show-text-col");
        });


        $('#resetFilterButton').on('click', function() {
            $('.filter-item-data').prop("checked", false);
            var value = '{{$path}}';
            var arrVars = value.split("/");

            var value1 = arrVars[0];
            var value2 = arrVars[1];
            $("input[name=category][value=" + value1 + "]").prop('checked', true);
            $("input[name=style-categories][value=" + value2 + "]").prop('checked', true);
            $("input[name=filter-by-shape][value=" + value2.toUpperCase() + "]").prop('checked', true);
            $("#showProductList").html('');
            sendDataValues();
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
        sendDataValues();
    });

    $(document).on('change', "#exampleSelect", function() {
       $("#showProductList").html('');
        sendDataValues();
   });

    

    $(window).scroll(function() {
        var scroll = $('#scrollFlag').val();
        if (scroll == 0 && ($(window).scrollTop() >= parseInt($('#sectionHeight').val()))) {
            var page = $('#pagescroll').val();
            // sendDataValues(page);
            $('#scrollFlag').val(1);
        }
    });

    $('#search').on('keyup', function() {
        let searchTextData = $(this).val();
        if (searchTextData.length > 2) {
            $("#showProductList").html('');
            sendDataValues(1, 'html');
        } else if (searchTextData.length == 0) {
            var page = $('#pagescroll').val();
            sendDataValues(page, 'append');
        }
    });

    function sendDataValues(page, type = 'append') {
        // $("input[name=filter-by-shape]").attr('onclick', 'return false;');
        // filterShapechanged();
        $('.ajax-load').show();
        $.ajax({
            type: 'GET',
            url: "{{ route('getfilteredproducts') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'ids': $('.filter-item-data').serializeArray(),
                
                'sorting': $("#exampleSelect").val(),
                'keyword': $('#search').val(),
                'path': '{{ $path }}',
                'page': page
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
                    toggle_switch.html('<i class="fa fa-plus" style="font-size:15px;color:#fff"></i> All Filter Category');
                } else {
                    //change the button label to be 'Hide'
                    toggle_switch.html('<i class="fa fa-minus" style="font-size:15px;color:#fff;"></i> All Filter Category');
                }
            });
        });

        $(document).on('click', "[id^=productWishList]", function () {
            var index = parseInt($(this).attr("id").replace("productWishList", ''));
            var product_slug = $('#productWishList'+index).data('productslug');
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
                        $('#productWishList'+index).children('i').removeClass('fa-heart-o');
                        $('#productWishList'+index).children('i').addClass('fa-heart');
                        // $(".wishcount").removeClass('fa-heart-o');
                        // $(".wishcount").addClass('fa-heart');
                    }
                    toastr.success(res.success);
                }else{
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