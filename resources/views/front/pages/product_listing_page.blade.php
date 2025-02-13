@extends('layouts.front.app')
@inject('footer_settings', 'App\Models\Settings')
@section('content')
@section('css')
    <link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    <style>
        .leftright-imt-col.leftright-text.postcontent100 {
            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
        .color-btn {
    cursor: pointer;
}
    </style>
@endsection
<?php
$pathData = explode('/',strtolower($path));
if(in_array('diamond-engagement-rings',$pathData) || in_array('engagement-rings',$pathData)) { ?>
<style>
    .diamondribgbanner {
        display: none;
    }
    @media (min-width: 320px) and (max-width: 376px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/320_3.jpg') }}');
        }
    }

    @media (min-width: 377px) and (max-width: 575px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/575_3.jpg') }}');
        }
    }

    @media (min-width: 576px) and (max-width: 768px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/767_3.jpg') }}');
        }
    }
    @media (min-width: 769px) and (max-width: 991px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/991_3.jpg') }}');
        }
    }

    @media (min-width: 992px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/1199_3.jpg') }}');
            background-position: bottom center;
            background-position: center;
            padding: 130px 0;
        }
    }

    @media (min-width: 1399px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/1900_3.jpg') }}');
            background-position: center;
            padding: 130px 0;
        }
    }
</style>
<?php } elseif(in_array('wedding-rings',$pathData) || in_array('eternity-rings',$pathData)) { ?>
<style>
    .diamondribgbanner {
        display: none;
    }

    @media (min-width: 320px) and (max-width: 376px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/320_1.jpg') }}');
        }
    }

    @media (min-width: 377px) and (max-width: 575px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/575_1.jpg') }}');
        }
    }

    @media (min-width: 576px) and (max-width: 768px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/768_1.jpg') }}');
        }
    }

    @media (min-width: 769px) and (max-width: 991px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/991_1.jpg') }}');
        }
    }

    @media (min-width: 992px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/1199_1.jpg') }}');
        }
    }

    @media (min-width: 1399px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/1900_1.jpg') }}');
        }
    }
</style>
<?php } elseif(in_array('diamond-jewellery',$pathData)) { ?>
<style>
    .diamondribgbanner {
        display: none;
    }

    @media (min-width: 320px) and (max-width: 376px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/320_2.jpg') }}');
            background-position: bottom center;
        }
    }

    @media (min-width: 377px) and (max-width: 575px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/575_2.jpg') }}');
            background-position: bottom center;
        }
    }

    @media (min-width: 576px) and (max-width: 768px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/767_2.jpg') }}');
            background-position: bottom center;
        }
    }

    @media (min-width: 769px) and (max-width: 991px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/991_2.jpg') }}');
            background-position: bottom center;
        }
    }

    @media (min-width: 992px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/1199_2.jpg') }}');
            background-position: bottom center;
        }
    }

    @media (min-width: 1399px) {
        .banner {
            background-image: url('{{ asset('storage/BannerCategory/1900_2.jpg') }}');
            background-position: bottom center;
        }
    }
</style>
<?php
 } elseif(in_array('diamonds-rings',$pathData)){ 
    ?>
<style>
    .diamondribgbanner {
        display: block;
    }

    .banner {
        background-size: cover;
        background-position: center;
        padding: 0;
        display: flex;
        position: relative;
        flex-wrap: wrap;
    }

    .banner:before {
        display: none;
    }

    .banner img.diamondribgbanner-dektop {
        width: 100%;
        height: 100%;
    }

    .banner img.diamondribgbanner-mobile {
        display: none;
    }

    .banner .category-banner-text {
        max-width: 550px;
        margin: auto;
        height: 100%;
        background-size: cover;
        display: flex;
        align-items: center;
        padding: 0 40px;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        background: url(https://marlows-diamonds.co.uk/storage/BannerCategory/1199_41.png) no-repeat;
        background-size: cover;
    }

    .banner .category-banner-text h1 {
        margin: 0 0 25px;
    }

    .banner .category-banner-text p {
        font-size: 18px;
        margin: 0 0 18px;
    }

    .banner .category-banner-text p a {
        font-weight: bold;
        text-decoration: none;
        color: #ffcc00;
        transition: all 0.9s ease;
    }

    .banner .category-banner-text p a:hover {
        color: #d764b7;
        transition: all 0.9s ease;
    }

    .banner img.diamondribgbanner-dektop {
        object-fit: cover;
    }

    @media (max-width: 1399px) {
        .banner .category-banner-text p {
            font-size: 16px;
        }
    }

    @media (max-width: 1199px) {
        .banner .category-banner-text {
            width: 400px;
        }

        .banner .category-banner-text h1 {
            margin: 0 0 10px;
            font-size: 24px;
            line-height: 24px;
        }

        .banner .category-banner-text p {
            font-size: 14px;
            line-height: 18px;
        }
    }

    @media (max-width: 991px) {
        .banner {
            height: 260px;
        }

        .banner img.diamondribgbanner-dektop {
            height: 100%;
        }

        .banner .category-banner-text {
            height: 100%;
        }
    }

    @media (max-width: 575px) {
        .banner .category-banner-text {
            width: 100%;
            background: none;
            padding: 0 15px;
            align-items: end;
        }

        .banner .category-banner-text:before {
            background: rgb(142 46 101 / 76%);
            content: '';
            top: 0;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .banner .category-banner-text .category-banner-textcontent {
            z-index: 1;
        }

        .banner .category-banner-text {
            padding: 0 15px;
        }

        .banner img.diamondribgbanner-mobile {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner img.diamondribgbanner-dektop {
            display: none;
        }

        .banner .category-banner-text:before {
            display: none;
        }

        .banner .category-banner-text p {
            font-size: 14px;
            line-height: 18px;
            margin-bottom: 7px;
        }
    }
</style>
<?php } ?>

@if (isset($categoryData->banner_image_url) && !empty($categoryData->banner_image_url))
    @section('dynamic_og_image')
        <meta property="og:image" content="{{env('APP_IMAGE_URL') . '/storage/' . $categoryData->banner_image_url }}" />
    @endsection
    <div class="category-banner banner">
        <img src="https://marlows-diamonds.co.uk/storage/BannerCategory/1199_4.png" alt=""
            class="diamondribgbanner diamondribgbanner-dektop">
        <img src="https://marlows-diamonds.co.uk/storage/BannerCategory/526_4.png" alt=""
            class="diamondribgbanner diamondribgbanner-mobile">
    @else
        @section('dynamic_og_image')
            <meta property="og:image" content="{{ asset('assets/images/engagement-rings-banner.png') }}" />
        @endsection
        <div class="category-banner"
            style="background-image:url({{ asset('') }}assets/images/engagement-rings-banner.png)">
@endif
<div class="container">
    <div class="category-banner-text">
        <div class="category-banner-textcontent">
            <h1>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h1>
            <p>{!! !empty($categoryData->short_description) ? $categoryData->short_description : '' !!}</p>
        </div>
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
                    if (isset($url) && !empty($url)) {
                        echo ' / ';
                    }
                    
                    echo getBreadcrumbCategoryName($url);
                    ?>
                </span>
            </p>


            {{-- @if (isset($categoryData->pre_content) && $categoryData->pre_content->count())
                <?php
                if ($categoryData->pre_content->count() == 1) {
                    $customCss = 'col-lg-12 col-sm-12 col-md-12';
                } elseif ($categoryData->pre_content->count() == 2) {
                    $customCss = 'col-lg-6 col-sm-6 col-md-6';
                } elseif ($categoryData->pre_content->count() == 3) {
                    $customCss = 'col-lg-4 col-sm-6 col-md-4';
                } elseif ($categoryData->pre_content->count() == 4) {
                    $customCss = 'col-lg-3 col-sm-6 col-md-3';
                } else {
                    $customCss = 'col-lg-3 col-sm-6 col-md-3';
                }
                ?>


                <center>
                    <!-- <h3>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h3> -->
                </center>
            @else
                <div class="owl-carousel owl-theme listing-slider" style="text-align: center; ">
                    @foreach ($filter_items as $filter_key => $filter_item)
                        @if ($filter_item->slug == 'style-categories')
                            @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                                <div class="item">
                                    @if (isset($product_item_item->category_images) && !empty($product_item_item->category_images))
                                        <img src="{{ getImageOptimizeDetails('/storage/' . $product_item_item->category_images, '217', '217') }}"
                                            alt="{{ $product_item_item->item_name }}">
                                    @else
                                        <img src="{{ getImageOptimizeDetails('/storage/Products/CX9-SC48_00003_1650365432.jpg', '217', '217') }}"
                                            alt="{{ $product_item_item->item_name }}">
                                    @endif
                                    <p>
                                        @if (isset($product_item_item->parent_category_slug) &&
                                                !empty($product_item_item->parent_category_slug->parent_cate->slug))
                                            <a
                                                href="{{ url($product_item_item->parent_category_slug->parent_cate->slug . '/' . $product_item_item->item_slug) }}">{{ $product_item_item->item_name }}</a>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @endif --}}
        </div>
    </div>


    <div class="filter-header">
        <!-- <span>Filter by:</span> -->
        <div class="selected-filters" id="selected-filters">
        </div>
    </div>

    <div class="category-list-item-searchsort dropdown-content-desktop">
        <input type="text" name="title" class="search-item empty search-mobile" id="searchm" value="" placeholder="Search for product" aria-label="Search">
    </div>

    <div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
        <div class="container">
            <div class="category-listing-row">
                <div class="category-sidebar-wrap category-sidebar-left">
                    <a href="javascript:void(0)" class="clearallfilter-desktop resetFilterButton"
                        id="resetFilterButton">All Filter Category</a>
                    <div class="filter-clear">
                        <button href="#collapse1" class="nav-toggle btn" style=""><i class="fa fa-angle-down"
                                style="color:#993168"></i> Filter </button>

                        <div class="dropdown sortmobile">
                            <i class="fa fa-angle-down" style="font-size:15px;color:#993168" aria-hidden="true"></i>
                            <select class="form-control dropdown-content" name="sortingMSelect" id="sortingMSelect">
                                <option value="" selected>Sort by <i class="fa fa-filter"></i></option>
                                <option value="asc">A to Z</option>
                                <option value="desc">Z to A</option>
                                <option value="price-min">Price: Low to High</option>
                                <option value="price-max">Price: High to Low</option>
                            </select>

                        </div>
                    </div>



                    {{-- start from here --}}



                    <div class="filter-container" id="collapse1">
                        @foreach ($filter_items as $filter_key => $filter_item)
                            <div class="filter-item">
                                <input type="hidden" name="filter_item_slug" class="filter_item_slug"
                                    value="{{ $filter_item->slug }}" />
                                <div class="accordion-item">

                                    <div class="category-filter-title">
                                        
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $filter_item->slug }}" aria-expanded="false"
                                            aria-controls="collapse{{ $filter_item->slug }}"
                                            style="background: #fff; border:none;"><h6><b>{{ $filter_item->name }}</b> <span id="filter-count-{{ $filter_item->slug }}"></span></h6></button>
                                    </div>

                                    
                                    <ul>
                                        <div id="collapse{{ $filter_item->slug }}" class="accordion-collapse collapse"
                                            aria-labelledby="{{ $filter_item->slug }}"
                                            data-bs-parent="#accordionExample">
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
                                                                                <input id="sliderRangeSetMin"
                                                                                    disabled="" data-index="0"
                                                                                    class="sliderValue" value="100">
                                                                            </div>
                                                                            <div class="maxrange">
                                                                                <span>Max</span>
                                                                                <input id="sliderRangeSetMax"
                                                                                    disabled="" data-index="1"
                                                                                    class="sliderValue"
                                                                                    value="150000">
                                                                            </div>
                                                                        </div>

                                                                        <div id="slider"
                                                                            class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                                                            <span
                                                                                class="ui-slider-handle ui-state-default ui-corner-all"
                                                                                tabindex="0"
                                                                                style="left: 19.1489%;"></span>
                                                                            <span
                                                                                class="ui-slider-handle ui-state-default ui-corner-all"
                                                                                tabindex="0"
                                                                                style="left: 59.5745%;"></span>
                                                                        </div>
                                                                        <div class="srchniput-fil">
                                                                            <input type="hidden"
                                                                                class="sliderValue filter-item-data"
                                                                                data-index="0" value="100"
                                                                                id="input-carat-min" name="price-min"
                                                                                autocomplete="off">
                                                                            <input type="hidden"
                                                                                class="sliderValue filter-item-data"
                                                                                data-index="1" value="150000"
                                                                                id="input-carat-max" name="price-max"
                                                                                autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                        <?php
                                                        $getCategoryWiseCount = '';

                                                        if($filter_item->slug == 'ring-categories'){

                                                            $getCategoryWiseCount = getCategoryWiseCount($product_item_item->item_slug,'ring-categories');

                                                            if($product_item_item->filter_category_slug == 'diamond-band'){
                                                                $getParameterArray = explode('/',Request::path());
                                                                if(count($getParameterArray) == 1){
                                                                    $getParameterArray[2] =  'mens/'.$product_item_item->filter_category_slug;
                                                                }else{
                                                                    $getParameterArray[2] =  $product_item_item->filter_category_slug;
                                                                }
    
                                                                $url = URL::to('/').'/'.implode('/',$getParameterArray);
                                                            }elseif($product_item_item->filter_category_slug == 'plain-band'){
                                                                $getParameterArray = explode('/',Request::path());
                                                                if(count($getParameterArray) == 1){
                                                                    $getParameterArray[2] =  'mens/'.$product_item_item->filter_category_slug;
                                                                }else{
                                                                    $getParameterArray[2] =  $product_item_item->filter_category_slug;
                                                                }
                                                                $url = URL::to('/').'/'.implode('/',$getParameterArray);
                                                            }else{
                                                                if(!empty($product_item_item->filter_category_slug)){
                                                                    $url = URL::to('/').'/'.$product_item_item->filter_category_slug;
                                                                }else{
                                                                    $url = 'javascript:void(0);';
                                                                }
                                                            }
                                                        }elseif($filter_item->slug == 'jewellery-categories'){
                                                            $getCategoryWiseCount = getCategoryWiseCount($product_item_item->item_slug);
                                                            $url = URL::to('/').$product_item_item->filter_category_slug;
                                                        }elseif($filter_item->slug == 'filter-by-shape'){
                                                            $getCategoryWiseCount = getCategoryWiseCount($product_item_item->item_slug,'filter-by-shape');

                                                            $url = URL::to('/').$product_item_item->filter_category_slug;
                                                        }elseif($filter_item->slug == 'style-categories'){
                                                            $getCategoryWiseCount = getCategoryWiseCount($product_item_item->item_slug);
                                                            
                                                            $url = URL::to('/').$product_item_item->filter_category_slug;
                                                        }elseif($filter_item->slug == 'metal_type'){
                                                            $url = 'javascript:void(0);';
                                                        }elseif($filter_item->slug == 'category'){

                                                            $getCategoryWiseCount = getCategoryWiseCount($product_item_item->item_slug);

                                                            $url = URL::to('/').'/'.$product_item_item->filter_category_slug;
                                                        }
                                                    ?>
                                                            @php
                                                            $currentUrl = url()->current();
                                                            @endphp

                                                        @if (!str_contains($currentUrl, 'diamond-jewellery') || $product_item_item->item_value != 'diamonds-rings')
                                                            <input type="{{ $filter_item->input_type }}"
                                                                data-slug="{{ $url }}"
                                                                name="{{ $filter_item->slug }}"
                                                                {{ $checkVariableNew }}
                                                                onclick="return {{ $checkVariable }};"
                                                                value="{{ $product_item_item->item_value }}"
                                                                class="filter-item-data"  
                                                                {{ $product_item_item->item_value == 'diamonds-rings' ? 'checked' : '' }}>
                                                            {{ $product_item_item->item_name }}
                                                            {{ $getCategoryWiseCount != '' ? "($getCategoryWiseCount)" : '' }}
                                                        @endif
                                                        @endif
                                                    </li>
                                                </div>
                                            @endforeach
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                        <div class="reset-filer-container">
                            <a href="javascript:void(0)" id="resetFilterButton" class="resetFilterButton">
                                See All
                            </a>
                        </div>
                    </div>


                    <div id="selected-filters-container">
                        <h6>Selected Filters:</h6>
                        <ul id="selected-filters-list">
                            <!-- Selected filters will be dynamically added here -->
                        </ul>
                    </div>

                    {{-- ends here --}}
                </div>
                <div class="category-list-wrap">
                    <div class="row">
                        <div class="category-list-top">
                            <div class="category-list-item">
                                <p><span id="productCountData">Showing {{ $product_count }} of
                                        {{ isset($productListingData['totalProductCount']) ? $productListingData['totalProductCount'] : 12 }}</span>
                                </p>
                                <a href="javascript:void(0)"
                                    class="clearallfilter-desktop clearallfilter-mobile resetFilterButton"
                                    id="resetFilterButton"> <i class="fa fa-angle-down"
                                        style="font-size:15px;color:#993168" aria-hidden="true"></i> All Filter
                                    Category</a>
                            </div>
                            <div class="category-list-item-searchsort dropdown-content-desktop">
                                <input type="text" name="title" class="search-item empty" id="searchd"
                                    value="" placeholder="Search for product" aria-label="Search">
                                <div class="dropdown">
                                    <select class="form-control dropdown-content" name="sortingDSelect"
                                        id="sortingDSelect">
                                        <option value="" selected>Sort by <i class="fa fa-filter"></i></option>
                                        <option value="asc">A to Z</option>
                                        <option value="desc">Z to A</option>
                                        <option value="price-min">Price: Low to High</option>
                                        <option value="price-max">Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" id="pagescroll" value="1">
                    <input type="hidden" name="sectionHeight" id="sectionHeight" value="">
                    <input type="hidden" name="scrollFlag" id="scrollFlag" value="">

                    <!--<div class="text-center">{!! isset($filterItemTextData->top_text) ? $filterItemTextData->top_text : '' !!}</div>-->
                    <br>
                    <div class="search-result" style="margin-top: -15px;">
                        <div class="product-grid-wrap">
                            <div class="product-grid-row flexed flex-flex-wrap" id="showProductList">
                                {{-- <img src="/assets/images/banner_image.png" alt="banner"> --}}
                                @foreach ($sortedArray as $index => $product)
                                <?php
                                $thumbnailGif = getThumbnailGif($product->id);
                                $getCategory = explode(',', $product->categories);
                                ?>
                            
                            @if ($index === 3 || $index === 11)
                            <!-- Add the image or modal content as a separate grid item -->
                            <div class="product-grid-items-item">
                                @if ($index === 3)
                                 <a href = "https://marlows-diamonds.co.uk/live-diamond-search">
                                    <img class="diamond-engage-banner" src="/assets/images/banner_image.png" alt="Banner">
                                 </a>
                                @else
                                  


                                    <div class="modal-body productvisitform">
                                      <div class="col-lg-12">
                                          <!-- Success message -->
                                          @if(Session::has('success'))
                                              <div class="alert alert-success">
                                                  {{Session::get('success')}}
                                              </div>
                                          @endif
                                              <div class="visit-form">
                                                <h5 class="modal-title" id="exampleModalLabel">Request an appointment</h5>
                              
                                                  <form id="contactForm">
                                                  @csrf
                                                      <input type="hidden" name="custom_url" id="custom_url" value="{{url()->full()}}">
                                                      <div class="form-controls">
                                                          <input type="text" name="title" id="title" class="{{ $errors->has('title') ? 'error' : '' }}" placeholder="Your Name">
                                                          <!-- Error -->
                                                          @if ($errors->has('name'))
                                                          <div class="error">
                                                              {{ $errors->first('name') }}
                                                          </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-controls">
                                                          <input type="email" name="email" id="email" class="{{ $errors->has('email') ? 'error' : '' }}" placeholder="Your Email Address">
                                                          @if ($errors->has('email'))
                                                          <div class="error">
                                                              {{ $errors->first('email') }}
                                                          </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-controls">
                                                          <input type="text" name="phone" id="phone" class="{{ $errors->has('phone') ? 'error' : '' }}" placeholder="Your Contact No.">
                                                          @if ($errors->has('phone'))
                                                          <div class="error">
                                                              {{ $errors->first('phone') }}
                                                          </div>
                                                          @endif
                                                      </div>
                                                      <div class="form-controls">
                                                          <textarea name="description" id="description" class="{{ $errors->has('description') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
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
                                @endif
                            </div>
                        @endif
                            
                                <!-- Continue rendering the product card for every product -->
                                <div class="product-grid-items-item {{ $thumbnailGif ? 'product-hover-affect' : '' }}">
                                    <div class="product-items-item-info">
                                        <div class="product-item-top">
                                            <div class="product-onsale">
                                                <!-- On Sale -->
                                            </div>
                                            @php
                                                $wishlist = session()->get('wishlist', []);
                                                $wishListClass = 'fa-heart-o';
                                                if (array_key_exists($product->id, $wishlist)) {
                                                    $wishListClass = 'fa-heart';
                                                }
                                            @endphp
                                            <a href="javascript:void(0);" class="share-file" type="button" data-bs-toggle="modal" data-bs-target="#sharesocial" data-url="{{ asset('product/' . $product->slug) }}">
                                                <img src="/assets/images/share.png" alt="share">
                                            </a>
                                            <a href="javascript:void(0);" class="wishlist-heart" id="productWishListRelated{{ $product->id }}" data-productslug="{{ $product->slug }}">
                                                <i class="fa {{ $wishListClass }} wishcount" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <?php
                                        $getMonthTextArray = getMonthwiseDiscountText();
                                        $getCurrentMonth = (int)date('m');
                                        $now = new DateTime("now");
                                        $lastDate = new DateTime('now');
                                        $lastDate->modify('last day of this month');
                                        $dist_future = $lastDate->format('m/d/Y');
                                         ?>
                                        
                                        <div class="product-items-item-image">
                                            <div class="list-discount-btn">
                                                <div class="disbtn-box">{!! strtoupper($getMonthTextArray[$getCurrentMonth]) !!}</div>
                                                {{-- <div class="disbtn-box extradis">Extra 10% Off</div>
                                                <div class="disbtn-box freebtn">Free Gift</div> --}}
                                            </div>
                                            <a href="{{ asset('product/' . $product->slug) }}" id="variationImageShown{{$product->id}}" class="{{ $thumbnailGif ? 'product-hov' : '' }}">
                                                @if (isset($product->getProductImages) && !empty($product->getProductImages['image_url']))
                                                    <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $product->getProductImages['image_url'] }}" alt="{{ $product->title }}" loading="lazy">
                                                @endif
                            
                                                <!-- @if ($thumbnailGif)
                                                    @if ($thumbnailGif->extension == 'gif')
                                                        <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $thumbnailGif->image_url }}" class="product-hover-video" loading="lazy">
                                                    @elseif ($thumbnailGif->extension == 'mp4')
                                                        {{-- Add mp4 handling logic here if needed --}}
                                                    @else
                                                        <img class="product-hover-video" src="{{ env('APP_IMAGE_URL') . '/storage/' . $thumbnailGif->image_url }}" alt="{{ $product->title }}">
                                                    @endif
                                                @endif -->
                                            </a>
                                        </div>


                                        <div class="color-buttons">
                                            {{-- @if (stripos($product->title, 'engagement ring') === false) --}}

                                            <a class="color-default" id="fetchdefaultimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="Default">Default</a>



                                            {{-- <a class="color-btn silver" id="fetchvariationSilverimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="Silver">Silver</a> --}}


                                            <a class="color-btn rose-gold" id="fetchvariationRoseimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="18ct Rose Gold">Rose Gold</a>
                                            <a class="color-btn yellow-gold" id="fetchvariationYellowimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="18ct Yellow Gold">Yellow Gold</a>
                                            {{-- @endif --}}
                                        </div>

                                        
                                        <div class="product-items-item-details">
                                            <div class="product-items-item-name">
                                                <div class="list_product_title">
                                                    <?php
                                                    $titleSplits = [];
                                                    if (isset($product->title) && !empty($product->title)) {
                                                        $titleSplits = explode('|', $product->title);
                                                    }
                                                    ?>
                                                    @if (isset($product->slug) && !empty($product->slug))
                                                        <a href="{{ asset('product/' . $product->slug) }}" class="title-list-heading">{{ isset($titleSplits[0]) ? $titleSplits[0] : '' }}</a>
                                                        @if (isset($titleSplits[1]) && !empty($titleSplits[1]))
                                                            <a href="{{ asset('product/' . $product->slug) }}">{{ $titleSplits[1] }}</a>
                                                        @endif
                                                    @else
                                                        <a href="#">{{ isset($titleSplits[0]) ? $titleSplits[0] : '' }}</a>
                                                        <a href="#">{{ isset($titleSplits[1]) ? $titleSplits[1] : '' }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                            
                                        <!-- Price section logic remains the same -->
                                        @if (!in_array(50, $getCategory) && !in_array(53, $getCategory) && !in_array(54, $getCategory))
                                            @if (isset($product->lab_grown) && $product->lab_grown != 0.0)
                                                <div class="price-section">
                                                    <div style="display: flex;">
                                                        @if (isset($product->discounted_lab_grown) && !empty($product->discounted_lab_grown))
                                                            @if ($product->discounted_lab_grown !== $product->lab_grown)
                                                                <h4>
                                                                    <del style="color:#000" class="shopPriceval" id="shopPrice">
                                                                        {{ MY_CURRENCY_SYMBOL }} {{ round($product->lab_grown, 2) }}</del>
                                                                </h4>
                                                            @endif
                            
                                                            <div class="product-finder-price" id="finaldiamondprice">
                                                                <span class="price">{{ MY_CURRENCY_SYMBOL }} {{ sprintf('%0.2f', $product->discounted_lab_grown) }}</span>
                                                            </div>
                                                        @else
                                                            <div class="product-finder-price" id="finaldiamondprice">
                                                                <span class="price">{{ MY_CURRENCY_SYMBOL }} {{ sprintf('%0.2f', $product->lab_grown) }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <p class="save_price">
                                                        <span style="color:green">You Save : <span id="savePrice">
                                                            {{ MY_CURRENCY_SYMBOL }} {{ sprintf('%0.2f', $product->lab_grown_rrp - $product->discounted_lab_grown) }}</span>
                                                        </span> | <del id="rrpPrice">RRP: {{ MY_CURRENCY_SYMBOL }} {{ sprintf('%0.2f', $product->lab_grown_rrp) }}</del>
                                                    </p>
                                                </div>
                                            @endif
                                        @elseif (in_array(54, $getCategory))
                                            <div class="price-section">
                                                <div style="display: flex;">
                                                    <div class="product-finder-price" id="finaldiamondprice">
                                                        <span class="price">{{ MY_CURRENCY_SYMBOL }} {{ sprintf('%0.2f', $product->mined_diamond) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif (in_array(53, $getCategory) || in_array(50, $getCategory))
                                            <div class="price-section">
                                                <div style="display: flex;">
                                                    <div class="product-finder-price" id="finaldiamondprice">
                                                        <span class="price">{{ MY_CURRENCY_SYMBOL }} {{ sprintf('%0.2f', $product->mined_diamond) }}</span>
                                                    </div>
                                                </div>
                                                <p class="save_price">
                                                    <span style="color:green">You Save : <span id="savePrice">
                                                        {{ MY_CURRENCY_SYMBOL }} {{ $product->mined_diamond_rrp - $product->mined_diamond }}</span>
                                                    </span> | <del id="rrpPrice">RRP: {{ MY_CURRENCY_SYMBOL }} {{ $product->mined_diamond_rrp }}</del>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            

                                {!! $getProductListFinal->render() !!}
                            </div>
                        </div>

                    </div>
                    <div class="loading-data-element"></div>
                    <input type="hidden" name="nextPageNumber" id="nextPageNumber" value="{{ $nextPage }}" />
                    <div class="ajax-load text-center" style="display:none;">
                        <!-- <img loading="lazy" alt="Product loader" src="{{ env('APP_IMAGE_URL') . '/assets/images/spinner-ring.gif' }}"> -->
                        <!-- <p>Loading More Products</p>
                    <button style="display: none;" class="ajax-load-btn">Load more data</button> -->
                    </div>
                    <div class="ajax-loader">
                        {{-- <img src="{{env('APP_IMAGE_URL').'/images/spinner.gif' }}" id="loading-data-image"
                                class="img-responsive" style="display:none;" /> --}}
                    </div>
                    <br>
                    <br>
                    <!--<div class="text-center">{!! isset($filterItemTextData->bottom_text) ? $filterItemTextData->bottom_text : '' !!}</div>-->
                    {{-- {!! isset($categoryData->description) ? $categoryData->description : '' !!} --}}
                </div>
            </div>
        </div>
    </div>

    {{--first section  starts from here --}}

   @if (isset($categoryData->pre_content) && $categoryData->pre_content->count())
   <?php
   if ($categoryData->pre_content->count() == 1) {
       $customCss = 'col-lg-12 col-sm-12 col-md-12';
   } elseif ($categoryData->pre_content->count() == 2) {
       $customCss = 'col-lg-6 col-sm-6 col-md-6';
   } elseif ($categoryData->pre_content->count() == 3) {
       $customCss = 'col-lg-4 col-sm-6 col-md-4';
   } elseif ($categoryData->pre_content->count() == 4) {
       $customCss = 'col-lg-3 col-sm-6 col-md-3';
   } else {
       $customCss = 'col-lg-3 col-sm-6 col-md-3';
   }
   ?>


   <center>
       <!-- <h3>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h3> -->
   </center>
@else
   <div class="owl-carousel owl-theme listing-slider" style="text-align: center; ">
       @foreach ($filter_items as $filter_key => $filter_item)
           @if ($filter_item->slug == 'style-categories')
               @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                   <div class="item">
                       @if (isset($product_item_item->category_images) && !empty($product_item_item->category_images))
                           <img src="{{ getImageOptimizeDetails('/storage/' . $product_item_item->category_images, '217', '217') }}"
                               alt="{{ $product_item_item->item_name }}">
                       @else
                           <img src="{{ getImageOptimizeDetails('/storage/Products/CX9-SC48_00003_1650365432.jpg', '217', '217') }}"
                               alt="{{ $product_item_item->item_name }}">
                       @endif
                       <p>
                           @if (isset($product_item_item->parent_category_slug) &&
                                   !empty($product_item_item->parent_category_slug->parent_cate->slug))
                               <a
                                   href="{{ url($product_item_item->parent_category_slug->parent_cate->slug . '/' . $product_item_item->item_slug) }}">{{ $product_item_item->item_name }}</a>
                           @endif
                       </p>
                   </div>
               @endforeach
           @endif
       @endforeach
   </div>
@endif

   {{-- ends here --}}


    <!-- Choose a dreamy start here-->
    <div class="choosedreamy-wrap">
        <div class="container">
            <div class="head-para-three">
                {{-- <h2 class="heading-h-three">{{ $categoryData->pre_content[0]->title }}</h2> --}}
                @if(!empty($categoryData->pre_content) && isset($categoryData->pre_content[0]->title))
                 <h2 class="heading-h-three">{{ $categoryData->pre_content[0]->title }}</h2>
                @endif
            </div>
            <div class="rings-grid-wrap">
                @if (
                    $path == 'engagement-rings/solitaire' ||
                        $path == 'engagement-rings/shoulder-set' ||
                        $path == 'engagement-rings/halo' ||
                        $path == 'engagement-rings/multi-stone')
                    <div class="product-item-slider">
                        <div class="owl-carousel owl-theme owlslidercategoryprecontent st-arrows">
                            @foreach ($categoryData->pre_content as $keyData => $preContentData)
                                <div class="item">
                                    <div class="product-info">
                                        <div class="product-image">
                                            <a href="{{ asset('diamond-engagement-rings') }}">
                                                <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $preContentData->image_url }}"
                                                    alt="{{ isset($preContentData->image_alt_title) ? $preContentData->image_alt_title : '' }}">
                                            </a>
                                        </div>
                                        <div class="product-item-details">
                                            <div class="product-titles">
                                                {{ $preContentData->heading }}
                                            </div>
                                            @if (isset($preContentData->description) && !empty($preContentData->description))
                                                <div class="product-description">
                                                    {!! Str::limit(strip_tags($preContentData->description), 250, ' ...') !!}
                                                </div>
                                            @endif
                                            <div class="product-action-btn">
                                                @if (isset($preContentData->button_check) && $preContentData->button_check == 1)
                                                    <a class="btn-bg-small"
                                                        href="{{ isset($preContentData->button_url) ? $preContentData->button_url : '' }}">
                                                        {{ isset($preContentData->button_title)
                                                            ? $preContentData->button_title
                                                            : 'Shop Now' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach ($categoryData->pre_content as $keyData => $preContentData)
                            <div class="{{ $customCss }}">
                                <div class="ring-pr-items">
                                    <div class="ring-pr-image">
                                        @if (isset($preContentData->image_url) && !empty($preContentData->image_url))
                                            <!-- <a href="/engagement-rings/solitaire"> -->
                                            <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $preContentData->image_url }}"
                                                alt="{{ isset($preContentData->image_alt_title) ? $preContentData->image_alt_title : '' }}">
                                            <!-- </a> -->
                                        @endif
                                    </div>
                                    <div class="ring-pr-details">
                                        <h3 class="ring-pr-title">
                                            {{ $preContentData->heading }}
                                        </h3>
                                        @if (isset($preContentData->description) && !empty($preContentData->description))
                                            <div class="ring-pr-desc">
                                                {!! Str::limit(strip_tags($preContentData->description), 250, ' ...') !!}
                                            </div>
                                        @endif
                                        <div class="ring-pr-shop-btn">
                                            @if (isset($preContentData->button_check) && $preContentData->button_check == 1)
                                                <a class="btn-bg-small"
                                                    href="{{ isset($preContentData->button_url) ? $preContentData->button_url : '' }}">
                                                    {{ isset($preContentData->button_title)
                                                        ? $preContentData->button_title
                                                        : 'Shop Now' }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- <div class="category-list-item-searchsort dropdown-content-desktop">
        <input type="text" name="title" class="search-item empty search-mobile" id="searchm" value=""
            placeholder="Search for product" aria-label="Search">
    </div> --}}

    <div class="container">
        <div class="head-para-three">
            <div class="heading-h-three">
                Delivery & Return Policy
            </div>
        </div>
        <div class="policysection">
            <div class="policy0icon">
                <i class="diamond-icon search-lifetimewarranty"></i>
                <h6 class="policyheading"><a href="/terms">Lifetime <br> Warranty (T&C)</a> </h6>
            </div>
            <div class="policy0icon">
                <i class="diamond-icon search-freedelivery"></i>
                <h6 class="policyheading"><a href="/terms"> Free Delivery & <br> Collection </a> </h6>
            </div>
            <div class="policy0icon">
                <i class="diamond-icon search-diamondquality"></i>
                <h6 class="policyheading"> <a href="/terms"> Diamond Quality <br> Certificate </a> </h6>
            </div>
            <div class="policy0icon">
                <i class="diamond-icon search-returnpolicy"></i>
                <h6 class="policyheading"><a href="/terms"> 30 Days<br> Return </a> </h6>
            </div>
        </div>
    </div>

    <!-- CHoose a dreamy end here-->
    @if (isset($categoryData->post_content) && $categoryData->post_content->count())
        <!-- Banner Text Section-->
        @foreach ($categoryData->post_content as $key => $postContent)
            <div class="findmatch-wrap perfect-ring-guidepartner">
                <div class="container">
                    <div class="leftright-img-text-wraper">
                        <div class="leftright-imt-rows flexed flex-flex-wrap flex-items-center">
                            @if (empty($postContent->image_url))
                                <?php
                                $conditionalCss = 'postcontent100';
                                ?>
                            @else
                                <?php
                                $conditionalCss = '';
                                ?>
                            @endif
                            <div class="leftright-imt-col leftright-text {{ $conditionalCss }}">
                                <h2 class="leftright-heading heading-h-three">
                                    {{ $postContent->heading }}
                                </h2>
                                {!! $postContent->description !!}
                                @if ($postContent->button_check == 1)
                                    <div class="viewguide-btn">
                                        <a class="btn-bg-small"
                                            href="{{ $postContent->button_url }}">{{ $postContent->button_title }}</a>
                                    </div>
                                @endif
                            </div>
                            @if (isset($postContent->image_url) && !empty($postContent->image_url))
                                <div class="leftright-imt-col leftright-img">
                                    <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $postContent->image_url }}"
                                        alt="{{ isset($postContent->image_alt_title) ? $postContent->image_alt_title : '' }}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <br>
        @endforeach
    @endif

    <!-- Best Selling Marlow's Diamond Jewellery start here -->
    <!-- Best Selling Marlow's Diamond Jewellery end here -->

    <!-- Your Journery of a lifetime start here start-->
    <div class="journery-life-wraper">
        <div class="container">
            {{-- isset($pageData->description)?$pageData->description:"" --}}
        </div>
    </div>
    <!-- Your Journery of a lifetime start here end-->

    <!-- Best Post Carousel Block start here -->
    @include('front.includes.postcarouselblock')

    <!-- Best Post Carousel Block start here -->

    <!-- FAQ Section start here -->

    <!-- Section Reviews -->
    <div class="container review-section">
        <div class="rating-review-block">
            <div class="owl-carousel owl-theme slider-review">
                @include('front.pages.reviews')
            </div>
        </div>
    </div>


    @php
        $getEngagementFaqs = getFaqByCategory(explode(',', $categoryData->faq_category));
    @endphp

    @if (isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
        <!-- FAQ Section start here -->
        <div class="faq-section engagement-ring-faq">
            <div class="container">
                <div class="head-para-three">
                    <h2 class="heading-h-three">
                        {{ isset($data->faq_title) ? $data->faq_title : "FAQ's" }}
                    </h2>
                    <p>Some of the most common Q&A's</p>
                </div>
                <div class="faq-list">
                    <div class="accordion" id="accordionExample">
                        @foreach ($getEngagementFaqs as $key => $faq)
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="{{ $faq->id }}">
                                    @if ($key == 0)
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true"
                                            aria-controls="collapse{{ $faq->id }}">
                                        @else
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $faq->id }}">
                                    @endif
                                    {{ isset($faq->title) ? $faq->title : '' }}
                                    </button>
                                </h3>
                                @if ($key == 0)
                                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse show"
                                        aria-labelledby="{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    @else
                                        <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="{{ $faq->id }}"
                                            data-bs-parent="#accordionExample">
                                @endif
                                <div class="accordion-body">
                                    {!! isset($faq->description) ? $faq->description : '' !!}
                                </div>
                            </div>
                    </div>
    @endforeach
</div>
</div>
</div>
</div>
</div>
<!-- FAQ Section End -->
@endif

@include('front.includes.instagram-section')
</div>
<div class="engagement-ring-img">
    <img src="{{ getImageOptimizeDetails('/images/viewguide.webp', '1349', '537') }}"
        alt="Find the perfect engagement ring">
    <div class="engagement-ring-img-content">
        <div class="container">
            <h2>Find the perfect engagement ring</h2>
            <button class="reset-filer-btn"> <a
                    href="{{ env('APP_IMAGE_URL') . '/storage/MarlowsDiamonds-PremiumContent-Guide-3.pdf' }}"
                    target="_blank"> View Guide </a> </button>
        </div>
    </div>
</div>

<div class="modal fade sharesocial" id="sharesocial" tabindex="-1" aria-labelledby="sharesocialLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="modal-title">Share</h3>
                <div id="copy-link">
                    <p id="copy-text"></p> <!-- Now this will be dynamically updated -->
                    <button class="copy-btn" onclick="copyToClipboard()">Copy</button>
                </div>
            </div>
            <div class="sharesocialicon">
                <ul>
                    <li><a href="#" id="facebookShare" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="#" id="twitterShare" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="#" id="pinterestShare" target="_blank" class="btn btn-linkedin"><i class="fa fa-pinterest"></i></a></li>
                    <li><a href="#" id="whatsappShare" target="_blank" class="btn btn-whatsapp"><i class="fa fa-whatsapp"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {

         //start
        $.validator.addMethod("phoneno", function(phone_number, element) {
			phone_number = phone_number.replace(/\s+/g, "");
			return phone_number.length > 9 ;
		}, "Please specify a valid phone number");

		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[a-z," "]+$/i.test(value);
		}, "Letters and spaces only please"); 

		$(document).ready(function(){
			$('[data-fancybox="gallery1"]').fancybox({ 
				afterLoad : function(instance, current) {
					current.$image.attr('alt', '{{$data->title}}' );
				}
			});
            
			toastr.options = {
				"preventDuplicates": true,
				"preventOpenDuplicates": true
			};
        });

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
                phone: {
                    digits: true,
                    phoneno:true
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
                phone: {
                    required: 'Phone is required',
                    digits: 'Please enter a valid phone number with only digits',
                },
                description: {
                    required: 'Description is required',
                    noSpacesOnly: "Description cannot be empty and must not contain spaces."

                }
            },
            submitHandler: function (form) {
                // if (grecaptcha.getResponse()) {
                    var form_data = new FormData(form);
                    $(form).find("button[type='submit']").prop('disabled',true);
                    $("button[type='submit']").text("Please Wait...");
                    $.ajax({
                        url: "{{ route('contact') }}",
                        method: "POST",
                        cache:false,
                        contentType:false,
                        processData: false,
                        data: form_data,
                        success: function (response) {
                            $("button[type='submit']").text("Send Message");
                            if(response.status == 200){
                                toastr.success(response.success);
                            }else{
                                toastr.info(response.error);
                            }
                            blankForm();
                        }
                    });
                // } else {
                //     alert('Please confirm captcha to proceed')
                // }
            }
        });

            function blankForm(){
                $('input[name="title"]').val('');
                $('input[name="email"]').val('');
                $('input[name="phone"]').val('');
                $('textarea[name="description"]').val('');
                $("button[type='submit']").prop('disabled',false);
                $('#requestAppointment').modal('hide');
                // grecaptcha.reset();
            }
    //ends

        $(document).on('click', '.pagination a', function(event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];
            if ($('#sortingDSelect').val() == '') {
                var sortingData = $('#sortingMSelect').val();
            } else if ($('#sortingMSelect').val() == '') {
                var sortingData = $('#sortingDSelect').val();
            } else {
                var sortingData = '';
            }
            sendDataValues(page, 'append', sortingData);
        });

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
                sendDataValues(1, 'append');
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
            var value = '{{ $path }}';
            var arrVars = value.split("/");

            var value1 = arrVars[0];
            var value2 = arrVars[1];
            if (value1 == 'diamond-engagement-rings') {
                value1 = 'engagement-rings';
            }
            $("input[name=category][value=" + value1 + "]").prop('checked', true);
            $("input[name=style-categories][value=" + value2 + "]").prop('checked', true);
            if (value2 !== undefined) {
                $("input[name=filter-by-shape][value=" + value2 + "]").prop('checked', true);
                $("input[name=jewellery-categories][value=" + value2 + "]").prop('checked', true);
            }
            $("#showProductList").html('');
            sendDataValues(1, 'append');
        });

        var value = '{{ $path }}';
        var arrVars = value.split("/");

        if (arrVars[0] == 'diamonds-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
                'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
                'display', 'none');
        }

        if (arrVars[0] == 'diamond-engagement-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='mens']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='womens']").parent('li').css('display', 'none');

            // $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
                'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
                'display', 'none');

            $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
                'return false;');

            $("input[name=category][value='eternity-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='eternity-rings']")
                .data('slug') + "'; return false;");
            $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                    'slug') + "'; return false;");
            $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");

            // $("input[name=category][value='eternity-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='eternity-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");

        }

        if (arrVars[0] == 'eternity-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='halo']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='multi-stone']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='shoulder-set']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='solitaire']").parent('li').css('display', 'none');

            // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display',
                'none');

            // $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
                'display', 'none');
            $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
                'return false;');

            $("input[name=category][value='engagement-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='engagement-rings']")
                .data('slug') + "'; return false;");
            $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                    'slug') + "'; return false;");
            $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");


            // $("input[name=category][value='engagement-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='engagement-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");
        }


        if (arrVars[0] == 'wedding-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='halo']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='multi-stone']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='shoulder-set']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='solitaire']").parent('li').css('display', 'none');

            // $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display',
                'none');

            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
                'display', 'none');

            $("input[name=category][value='engagement-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='engagement-rings']")
                .data('slug') + "'; return false;");
            $("input[name=category][value='eternity-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='eternity-rings']")
                .data('slug') + "'; return false;");
            $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");

            $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
                'return false;');
            // $("input[name=category][value='eternity-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='eternity-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='engagement-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='engagement-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");
        }

        if (arrVars[0] == 'engagement-rings') {
            $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
            $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='mens']").parent('li').css('display', 'none');
            $("input[name=style-categories][value='womens']").parent('li').css('display', 'none');

            // $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
                'none');
            $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
                'display', 'none');

            $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                    'slug') + "'; return false;");
            $("input[name=category][value='eternity-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='eternity-rings']")
                .data('slug') + "'; return false;");
            $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");

            $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
                'return false;');
            // $("input[name=category][value='eternity-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='eternity-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");
        }

        if (arrVars[0] == 'diamond-jewellery') {
            $("input[name=category][value='diamonds-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
            $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');

            // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
            // $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
            $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display',
                'none');
            $("input[name=filter_item_slug][value='style-categories']").parent('.filter-item').css('display',
                'none');
            $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
                'none');

            $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                    'slug') + "'; return false;");
            $("input[name=category][value='engagement-rings']").parent('li').attr('onclick',
                "javascript:window.location.href='" + $("input[name=category][value='engagement-rings']")
                .data('slug') + "'; return false;");

            $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
                'return false;');
            // $("input[name=category][value='engagement-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='engagement-rings']").data('slug')+"'></a>");
            // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
        }

        if (arrVars[1] == 'halo' || arrVars[1] == 'shoulder-set' || arrVars[1] == 'solitaire' || arrVars[1] ==
            'multi-stone') {
            $("input[name=style-categories]").attr('onclick', 'return false;');
        }
        filterShapechanged();
        filterStylechanged();
        filterRingTypechanged();
        filterJewelleryTypechanged();
    });

    function filterShapechanged() {
        getFilterStyleChangedWithClass('filter-by-shape');
        // var valuesFilterShapechanged = $("input[name='filter-by-shape']:checked")
        //       .map(function(){return $(this).val();}).get();

        // if(valuesFilterShapechanged.length != 0){
        //     var dynamicFilterShapechanged = {};
        //     $("input[name='filter-by-shape']:not(:checked)").each(function() {
        //         var key = $(this).val();
        //         var value = $(this).data('slug');
        //         dynamicFilterShapechanged[key] = value;
        //     });

        //     $.each(dynamicFilterShapechanged, function( index, value ) {
        //         $("input[name=filter-by-shape][value='"+index+"']").parent('li').wrap("<a href='"+value+"'></a>");
        //     });
        // }else{
        //     console.log("not available");
        // }

        // $('input[name="filter-by-shape"]:checked').each(function() {
        //     if (this.value != '') {
        //         $("input[name=filter-by-shape]").attr('onclick', 'return false;');
        //     }
        // });
    }


    $(".color-btn").each(function () {
        var $this = $(this);
        var metalType = $this.data("color");
        var slug = $this.data("slug");

        // Check if the color variation exists for this product
        $.ajax({
            type: 'POST',
            url: '{{route("get-variations-image-data")}}',
            dataType: 'JSON',
            data: {
                '_token': "{{csrf_token()}}",
                'slug': slug,
                'metal_type': metalType,
                'final_price': parseInt($('#selected_final_price').val()) || 0,
            },
            success: function (res) {
                // Remove the button if the variation doesn't exist
                if (!res || !res.vari_image) {
                     $this.remove();
                }
            },
            error: function () {
                console.error('Error fetching variation data for:', metalType);
            }
        });
    });





    
    $(document).on('click', "[id^=fetchdefaultimages]", function () {
    let productId = parseInt($(this).attr("id").replace("fetchdefaultimages", '')); // Extract product ID
    let sortedArray = @json($sortedArray);

    // Find the specific product in the array
    let product = sortedArray.find(p => p.id === productId);

    if (product && product.getProductImages?.image_url) {
        let imageUrl = 'https://admin.marlowsdiamonds.com/storage/' + product.getProductImages.image_url;

        // Update the image for the specific product
        $('#variationImageShown' + productId + ' img').attr('src', imageUrl);
    }
});



    $(document).on('click', "[id^=fetchvariationRoseimages]",function(){
        var tokenIndex = parseInt($(this).attr("id").replace("fetchvariationRoseimages", ''));
        getSelectedVariationsData(tokenIndex,$(this).data('color'),$(this).data('slug'));
    });
    $(document).on('click', "[id^=fetchvariationYellowimages]",function(){
        var tokenIndex = parseInt($(this).attr("id").replace("fetchvariationYellowimages", ''));
        getSelectedVariationsData(tokenIndex,$(this).data('color'),$(this).data('slug'));
    });

    function filterStylechanged() {
        getFilterStyleChangedWithClass('style-categories');
    }
    function getSelectedVariationsData(tokenIndex,metalType,slug){
        $.ajax({
            type: 'POST',
            url: '{{route("get-variations-image-data")}}',
            dataType: 'JSON',
            data: {
                '_token': "{{csrf_token()}}",
                'slug' : slug,
                'metal_type' : metalType,
            },
            success: function (res) {
                $('#variationImageShown'+tokenIndex+' img').attr('src', 'https://admin.marlowsdiamonds.com/storage/' + res.vari_image);
            }
        });
    }


    function getFilterStyleChangedWithClass(inputFieldNameValue) {
        var valuesCheckedValues = $("input[name='" + inputFieldNameValue + "']:checked")
            .map(function() {
                return $(this).val();
            }).get();

        if (valuesCheckedValues.length != 0) {



            var dynamicKeyValuePairs = {};
            $("input[name='" + inputFieldNameValue + "']:not(:checked)").each(function() {

                var key = $(this).val();
                var value = $(this).data('slug');
                dynamicKeyValuePairs[key] = value;
            });

            $.each(dynamicKeyValuePairs, function(index, value) {
                $("input[name=" + inputFieldNameValue + "][value='" + index + "']").parent('li').attr('onclick',
                    "javascript:window.location.href='" + value + "'; return false;");

                // $("input[name="+inputFieldNameValue+"][value='"+index+"']").parent('li').wrap("<a href='"+value+"'></a>");
            });
        }

        $('input[name="' + inputFieldNameValue + '"]:checked').each(function() {
            if (this.value != '') {
                $("input[name=" + inputFieldNameValue + "]").attr('onclick', 'return false;');
            }
        });
    }

    function filterRingTypechanged() {
        getFilterStyleChangedWithClass("ring-categories");
        // $('input[name="ring-categories"]:checked').each(function() {
        //     if (this.value != '') {
        //         $("input[name=ring-categories]").attr('onclick', 'return false;');
        //     }
        // });
    }

    function filterJewelleryTypechanged() {
        getFilterStyleChangedWithClass("jewellery-categories");
        // $('input[name="jewellery-categories"]:checked').each(function() {
        //     if (this.value != '') {
        //         $("input[name=jewellery-categories]").attr('onclick', 'return false;');
        //     }
        // });
    }

    $(document).on('mouseenter', '.product-hover-affect', function(event) {
        if ($(this).find('video').length) {
            $(this).find('video')[0].play()
        }
    }).on('mouseleave', '.top-level', function() {
        if ($(this).find('video').length) {
            $(this).find('video')[0].pause()
        }
    })

    $(document).on('touchstart', '.product-hover-affect', function() {
        // $(this).find('a.product-hov').css({
        //     '-webkit-transition': 'all 200ms ease-in',
        //     '-webkit-transform': 'scale(1.2)',
        //     '-ms-transition': 'all 200ms ease-in',
        //     '-ms-transform': 'scale(1.2)',
        //     '-moz-transition': 'all 200ms ease-in',
        //     '-moz-transform': 'scale(1.2)',
        //     'transition': 'all 200ms ease-in',
        //     'transform': 'scale(1.2)'
        // });
        // $(this).find('.product-hover-video').css({
        //     'display': "block",
        //     'position': "absolute",
        //     'top': "0",
        //     "width": "100%",
        //     "height": "100%",
        //     "background": "#fff"
        // });
        if ($(this).find('video').length) {
            $(this).find('video')[0].play()
        }
    });
    $(document).on('change', ".filter-item-data", function() {
        $("#showProductList").html('');
        sendDataValues(1, 'append');
    });

    $(document).on('change', "#sortingDSelect,#sortingMSelect", function() {

        if ($('#sortingDSelect').val() == '') {
            var sortingData = $('#sortingMSelect').val();
        } else if ($('#sortingMSelect').val() == '') {
            var sortingData = $('#sortingDSelect').val();
        } else {
            var sortingData = '';
        }

        $("#showProductList").html('');
        sendDataValues(1, 'append', sortingData);
    });

    // Ensure first option is selected on page load
    window.addEventListener('load', function() {
        document.getElementById('sortingDSelect').value = '';
    });
    //     $(document).on('change', "#sortingMSelect", function() {
    //        $("#showProductList").html('');
    //         sendDataValues(1,'append',$(this).val());
    //    });

    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getData(page);
            }
        }
    });

    // $(window).scroll(function() {
    //     var scroll = $('#scrollFlag').val();
    //     if (scroll == 0 && ($(window).scrollTop() >= parseInt($('#sectionHeight').val()))) {
    //         var page = $('#pagescroll').val();
    //         sendDataValues(page);
    //         // $('#scrollFlag').val(1);
    //     }
    // });

    $('#searchd').on('keyup', function(event) {
        let searchTextData = $(this).val();
        if (searchTextData.trim() != '' && searchTextData.length > 2) {
            $("#showProductList").html('');
            sendDataValues(1, 'html');
        } else if (searchTextData.length == 0) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
            $("#showProductList").html('');
            sendDataValues(1, 'html');
            // var page = $('#pagescroll').val();
            // sendDataValues(page, 'append');
        }
    });

    function sendDataValues(page, type = 'append', sorting = 'asc') {
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
                'per_page_product': 30
            },
            success: function(res) {
                // filterShapechanged();
                // resetFilterButton


                $('#pagescroll').val(res.nextPage);
                $('html, body').animate({
                    scrollTop: '680px'
                }, 700);
                if (res.status == 404 || res.productItems == "") {
                    // $('.category-list-item-searchsort').css('display','none');
                    $('.ajax-load').html("0 Product Found");
                    $('#productCountData').text("");
                    return false;
                }
                $('.ajax-load').hide();
                // $('.category-list-item-searchsort').css('display','inherit');
                if (type == 'append') {
                    $("#showProductList").html(res.productItems);
                } else {
                    $("#showProductList").html(res.productItems);
                }
                $('#productCountData').text('Showing ' + res.product_count + ' of ' + res
                .totalProductCount);
                $('#sectionHeight').val($('#showProductList').height());
                $('#scrollFlag').val(0);
            }
        });
    }
</script>





{{-- filter script start from here --}}

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".filter-item-data").forEach(input => {
            input.addEventListener("click", function() {
                const parentAccordion = input.closest(".accordion-item");
                if (parentAccordion) {
                    const collapseElement = parentAccordion.querySelector(
                    ".accordion-collapse");
                    if (collapseElement && collapseElement.classList.contains("show")) {
                        
                        const collapseInstance = new bootstrap.Collapse(collapseElement, {
                            toggle: false, 
                        });
                        collapseInstance.hide();
                    }
                }

                updateSelectedFilters();
            });
        });
        const selectedFiltersContainer = document.getElementById("selected-filters-list");


        document.querySelectorAll(".filter-item-data").forEach(input => {
            input.addEventListener("change", function() {
                updateSelectedFilters();
            });
        });
       
        function updateSelectedFilters() {
            selectedFiltersContainer.innerHTML = "";
            const selectedFilters = document.querySelectorAll(".filter-item-data:checked");
            const filterCounts = {};
                function updateFilterCount(categorySlug) {
                    const categoryButton = document.querySelector(`#filter-count-${categorySlug}`);
                    if (categoryButton) {
                        const count = filterCounts[categorySlug] || 0;
                        categoryButton.innerText = `(${count})`;  // Update the count in the UI
                    }
                }

                 selectedFilters.forEach(filter => {
                    // console.log('filter', filter)
                 const filterName = filter.closest(".filter-item").querySelector("b").innerText;
                 const filterValue = filter.value;
                 const categorySlug = filter.closest(".accordion-collapse").id.replace('collapse', '');


                    if (!filterCounts[categorySlug]) {
                        filterCounts[categorySlug] = 0;
                    }
                    filterCounts[categorySlug]++;


                 updateFilterCount(categorySlug);
                const listItem = document.createElement("li");
                let removeButtonHtml = '';

                if ((filter.hasAttribute('checked') && filter.getAttribute('checked') !== 'false') || filter.type === 'radio') {
                listItem.innerHTML = `<b>${filterName}:</b> ${filterValue}`; 
               } else {
                removeButtonHtml = `<button class="remove-filter" data-filter-value="${filterValue}" data-filter-name="${filterName}" data-category="${categorySlug}">✖</button>`;
                listItem.innerHTML = `<b>${filterName}:</b> ${filterValue} ${removeButtonHtml}`;
              }
                selectedFiltersContainer.appendChild(listItem);
            });

            // Show a message if no filters are selected
            if (!selectedFilters.length) {
                const currentPath = window.location.pathname;
                const pathSegments = currentPath.split('/').filter(Boolean);

                if (pathSegments.length >= 2) {
                    const secondLastSegment = pathSegments[pathSegments.length - 2];
                    const lastSegment = pathSegments[pathSegments.length - 1];

                    const baseUrl = window.location.origin;
                    window.location.href = `${baseUrl}/${secondLastSegment}/${lastSegment}`;
                } else {
                    const baseUrl = window.location.origin;
                    const lastSegment = pathSegments[pathSegments.length - 1];
                    window.location.href = `${baseUrl}/${lastSegment}`;
                }
                return;
            }

            // Add click event listeners for remove buttons
            document.querySelectorAll(".remove-filter").forEach(button => {
                button.addEventListener("click", function() {
                    const filterValue = this.getAttribute("data-filter-value");
                    const categorySlug = this.getAttribute("data-category");
                    const filterCheckbox = Array.from(document.querySelectorAll(
                        ".filter-item-data")).find(
                        checkbox => checkbox.value === filterValue
                    );
                    if (filterCheckbox) {
                        filterCheckbox.checked = false;
                    }

                  if (filterCounts[categorySlug]) {
                   filterCounts[categorySlug]--;
                   }
                   this.closest("li").remove();
                   updateFilterCount(categorySlug);


                    updateSelectedFilters();
                    sendDataValues(1);
                });
            });


         for (let category in filterCounts) {
  
         const countElement = document.getElementById("filter-count-" + category.replace(/\s+/g, '-').toLowerCase());
          if (countElement) {
             countElement.innerText = `(${filterCounts[category]})`;
           }
          }
        }


         // Listen for changes on filter checkboxes
         document.querySelectorAll(".filter-item-data").forEach(input => {
          input.addEventListener("change", function () {
            const categorySlug = input.closest(".accordion-collapse").id.replace('collapse', '');
            if (!input.checked) {
                // Decrement the count if the checkbox is unchecked
                const categoryButton = document.querySelector(`#filter-count-${categorySlug}`);
                const currentCount = parseInt(categoryButton?.innerText.replace(/[()]/g, '')) || 0;
                const newCount = Math.max(0, currentCount - 1);
                if (categoryButton) {
                    categoryButton.innerText = `(${newCount})`;
                }
            }
            updateSelectedFilters(); // Refresh the UI and counts
        });
    });



        document.querySelectorAll(".filter-item-data").forEach(input => {
            input.addEventListener("change", updateSelectedFilters);
        });

        updateSelectedFilters();

// Reset filter button functionality
        document.getElementById("resetFilterButton").addEventListener("click", () => {
            document.querySelectorAll(".filter-item-data:checked").forEach(input => input.checked =
                false);
            updateSelectedFilters();
        });
    });
</script>









{{-- copy element starts from here --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var shareModal = document.getElementById('sharesocial');
    shareModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var productUrl = button.getAttribute('data-url');
        document.getElementById('copy-text').textContent = productUrl;

        // Update social media share links
        document.getElementById('facebookShare').href = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(productUrl)}`;
        document.getElementById('twitterShare').href = `https://twitter.com/intent/tweet?url=${encodeURIComponent(productUrl)}`;
        document.getElementById('pinterestShare').href = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(productUrl)}`;
        document.getElementById('whatsappShare').href = `https://api.whatsapp.com/send?text=${encodeURIComponent(productUrl)}`;
    });
});

// Copy to clipboard function
function copyToClipboard() {
    var text = document.getElementById('copy-text').textContent;
    navigator.clipboard.writeText(text).then(function() {
        alert("Link copied to clipboard!");
    }).catch(function(error) {
        console.error("Failed to copy text:", error);
        alert("Failed to copy text. Please try again.");
    });
}
</script>
{{-- copy element ends here --}}

{{-- filter script ends here --}}
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
                    toggle_switch.html(
                        '<i class="fa fa-angle-down" style="color:#993168"></i>  Filter');
                } else {
                    //change the button label to be 'Hide'
                    toggle_switch.html(
                        '<i class="fa fa-angle-up" style="color:#993168"></i>  Filter');
                }
            });
        });

        $(document).on('click', "[id^=productWishListRelated]", function() {
            var index = parseInt($(this).attr("id").replace("productWishListRelated", ''));
            var product_slug = $('#productWishListRelated' + index).data('productslug');
            addtobasketFunction('{{ route('set-product-wishlist') }}', product_slug, index);
        });

    });

    function addtobasketFunction(getUrl, product_slug, index) {
        var trdata = $('#finaldiamondprice .price').text().replace(/[^\0-9.-]+/g, '');
        var rrpPrice = $('#rrpPrice.rrpPriceval').text().replace(/[^\0-9.-]+/g, '');
        var savePriceval = $('#savePrice.save').text().replace(/[^\0-9.-]+/g, '');
        var shopPricedata = $('#shopPrice.shopPriceval').text().replace(/[^\0-9.-]+/g, '');

        let lab_grown_price = $("#finaldiamondprice .price").text().replace("£", "");

        let diamondCaratWeight;
        let diamondColour;
        var diamondShape;
        let diamondGrade;
        let diamondClarity;
        let diamondCertificate;
        if ($('.diamond_type:checked').val() == 'mined_diamond') {
            diamondCaratWeight = $('#carat').val();
            diamondColour = $('#diamond-colour').val();
            diamondShape = $('#selected_diamond_shape').val();
            diamondGrade = $('#diamond-grade').val();
            diamondClarity = $('#diamond-clarity').val();
            diamondCertificate = $('#diamond-certificate').val();
        } else if ($('.diamond_type:checked').val() == 'lab_grown') {
            diamondCaratWeight = $('#lab_grown_carat').val();
            diamondColour = $('#lab_grown_colour').val();
            diamondShape = $('#selected_diamond_shape').val();
            diamondGrade = '';
            diamondClarity = $('#lab_grown_clarity').val();
            diamondCertificate = '';
        }

        var variations = [];
        $('.type-variations-row select').each(function(i, sel) {

            if ($(sel).attr('name') != 'finger-size')
                variations.push($(sel).val());
        });


        $.ajax({
            type: 'POST',
            url: getUrl,
            data: {
                '_token': "{{ csrf_token() }}",
                'carat': $('#carat').val(),
                'variations': variations,
                'total-diamond-weight': $('#total-diamond-weight').val(),
                'color': $('#diamond-colour').val(),
                'clarity': $('#diamond-clarity').val(),
                'width-mm': $('#width-mm').val(),
                'grade': $('#diamond-grade').val(),
                'fingersize': $('#finger-size').val(),
                'metal_type': $('#metal-type').val(),
                'certificate': $('#diamond-certificate').val(),
                'choose_diamond': $('input[name="attribute_choose-your-diamond"]:checked').val(),
                'slug': product_slug,
                'price': parseInt(trdata) || 0,
                'rrpPrice': parseInt(rrpPrice) || 0,
                'savePrice': parseInt(savePriceval) || 0,
                'shopPrice': parseInt(shopPricedata) || 0,
                'diamond_type': $(".diamond_type:checked").val(),
                'discounted_price': parseInt($('#selected_discounted_price').val()) || 0,
                'final_price': parseInt($('#selected_final_price').val()) || 0,
                'setting_price': parseInt(trdata) || 0,
            },
            success: function(res) {
                if (res.success != '' && typeof res.success !== "undefined") {
                    if (res.cartcount) {
                        $(".cartcount").text(res.cartcount);
                    }
                    if (res.wishcount) {
                        if (index > 0) {
                            $('#productWishListRelated' + index).children('i').addClass('fa-heart');
                            $('#productWishListRelated' + index).children('i').removeClass('fa-heart-o');
                        } else {
                            $('#productWishList' + index).children('i').removeClass('fa-heart-o');
                            $('#productWishList' + index).children('i').addClass('fa-heart');
                        }

                        if (res.wishcount > 0) {
                            $('.my-whishlist-blk a i').removeClass('fa-heart-o');
                            $('.my-whishlist-blk a i').addClass('fa-heart');
                        }
                    }
                    toastr.success(res.success);
                } else {
                    if (res.error) {
                        if (index > 0) {
                            $('#productWishListRelated' + index).children('i').removeClass('fa-heart');
                            $('#productWishListRelated' + index).children('i').addClass('fa-heart-o');
                        } else {
                            $('#productWishList' + index).children('i').removeClass('fa-heart');
                            $('#productWishList' + index).children('i').addClass('fa-heart-o');
                        }
                        if (res.wishcount == 0) {
                            $('.my-whishlist-blk a i').removeClass('fa-heart');
                            $('.my-whishlist-blk a i').addClass('fa-heart-o');
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
            nav: true,
            responsive: {
                320: {
                    items: 1
                },
                480: {
                    items: 2
                },
                769: {
                    items: 3
                },
                991: {
                    items: 5
                },
                1100: {
                    items: 6
                }
            }
        });
    });
</script>
@endsection
