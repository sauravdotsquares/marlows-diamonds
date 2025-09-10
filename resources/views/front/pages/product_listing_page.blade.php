@extends('layouts.front.app')

{{-- criteo start --}}
@section('criteo-tracking')
    <script type="text/javascript">
        window.criteo_q = window.criteo_q || [];

        // Device type detection (JS only)
        var deviceType = /iPad/.test(navigator.userAgent) ? "t" :
            /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ?
            "m" : "d";

        window.criteo_q.push({
                event: "setAccount",
                account: 119681
            }, {
                event: "setSiteType",
                type: deviceType
            },

            @if (Auth::check())
                {
                    event: "setEmail",
                    email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}",
                    hash_method: "sha256"
                }, {
                    event: "setCustomerId",
                    id: {{ Auth::user()->id }}
                },
            @endif

            {
                event: "viewList",
                item: {!! json_encode($sortedArray->pluck('id')->map(fn($id) => "ig_$id")) !!}
            }
        );
    </script>
@endsection
{{-- criteo ends --}}

@inject('footer_settings', 'App\Models\Settings')

@section('css')
    <link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script> --}}

    <link rel="stylesheet" href="{{ asset('custom/css/product_listing_page/product_listing_page.css') }}">
@endsection


@section('content')

    @php
        $pathData = explode('/', strtolower($path));
    @endphp
    @if (in_array('diamond-engagement-rings', $pathData) || in_array('engagement-rings', $pathData))
        <link rel="stylesheet" href="{{ asset('custom/css/product_listing_page/diamond_engagement_rings.css') }}">
    @elseif (in_array('wedding-rings', $pathData) || in_array('eternity-rings', $pathData))
        <link rel="stylesheet" href="{{ asset('custom/css/product_listing_page/wedding_rings_eternity_rings.css') }}">
    @elseif (in_array('diamond-jewellery', $pathData))
        <link rel="stylesheet" href="{{ asset('custom/css/product_listing_page/diamond_jewellery.css') }}">
    @elseif (in_array('diamonds-rings', $pathData))
        <link rel="stylesheet" href="{{ asset('custom/css/product_listing_page/diamonds_rings.css') }}">
    @endif

    @if (isset($categoryData->banner_image_url) && !empty($categoryData->banner_image_url))
        @section('dynamic_og_image')
            <meta property="og:image" content="{{ env('APP_IMAGE_URL') . '/storage/' . $categoryData->banner_image_url }}" />
        @endsection
        <div class="category-banner banner">
            <img src="{{ asset('assets/BannerCategory/1199_4.png') }}" loading="lazy" alt=""
                class="diamondribgbanner diamondribgbanner-dektop">
            <img src="{{ asset('assets/BannerCategory/526_4.png') }}" loading="lazy" alt=""
                class="diamondribgbanner diamondribgbanner-mobile">
        </div>
    @else
        @section('dynamic_og_image')
            <meta property="og:image" content="{{ asset('assets/images/engagement-rings-banner.png') }}" />
        @endsection
        <div class="category-banner"
            style="background-image:url({{ asset('') }}assets/images/engagement-rings-banner.png)">
        </div>
    @endif

    <div class="container">
        <div class="category-banner-text">
            <div class="category-banner-textcontent">
                <h1>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h1>
                <p>{!! !empty($categoryData->short_description) ? $categoryData->short_description : '' !!}</p>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    <div class="container product-panel-new">
        <div class="row">
            <div class="col-sm-12">
                <p class="burgarmenu">
                    <a href="{{ url('/') }}">Home </a>
                    <span>
                        @php
                            $url = $path;
                            if (isset($url) && !empty($url)) {
                                echo ' / ';
                            }

                            echo getBreadcrumbCategoryName($url);
                        @endphp
                    </span>
                </p>
            </div>
        </div>


        <div class="filter-header">
            <div class="selected-filters" id="selected-filters">
            </div>
        </div>

        <div class="category-list-item-searchsort dropdown-content-desktop">
            <input type="text" class="search-item empty search-mobile" id="searchm" value=""
                placeholder="Search for product" aria-label="Search">
            <p class="product-count-mobile"><span id="productCountDataMobile">Showing {{ $product_count }} of
                    {{ isset($productListingData['totalProductCount']) ? $productListingData['totalProductCount'] : 12 }}</span>
            </p>
        </div>

        <div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
            <div class="container">
                <div class="category-listing-row">
                    <div class="category-sidebar-wrap category-sidebar-left">
                        <a href="javascript:void(0)" class="clearallfilter-desktop resetFilterButton"
                            id="resetFilterButton">Sort by Style & Design</a>
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

                        {{-- Filter start from here --}}
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
                                                style="background: #fff; border:none;">
                                                <h6><b>{{ $filter_item->name }}</b> <span
                                                        id="filter-count-{{ $filter_item->slug }}"></span></h6>
                                            </button>
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
                                                                @php
                                                                    $checkVariable = 'false';
                                                                    $checkVariableNew = 'checked';
                                                                @endphp
                                                            @elseif(in_array(Str::lower(Str::replace(' ', '-', $product_item_item->item_name)), $slugs))
                                                                @php
                                                                    $checkVariable = 'false';
                                                                    $checkVariableNew = 'checked';
                                                                @endphp
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
                                                                                        class="sliderValue"
                                                                                        value="100">
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
                                                                @php
                                                                    $getCategoryWiseCount = '';

                                                                    if ($filter_item->slug == 'ring-categories') {
                                                                        $getCategoryWiseCount = getCategoryWiseCount(
                                                                            $product_item_item->item_slug,
                                                                            'ring-categories',
                                                                        );

                                                                        if (
                                                                            $product_item_item->filter_category_slug ==
                                                                            'diamond-band'
                                                                        ) {
                                                                            $getParameterArray = explode(
                                                                                '/',
                                                                                Request::path(),
                                                                            );
                                                                            if (count($getParameterArray) == 1) {
                                                                                $getParameterArray[2] =
                                                                                    'mens/' .
                                                                                    $product_item_item->filter_category_slug;
                                                                            } else {
                                                                                $getParameterArray[2] =
                                                                                    $product_item_item->filter_category_slug;
                                                                            }

                                                                            $url =
                                                                                URL::to('/') .
                                                                                '/' .
                                                                                implode('/', $getParameterArray);
                                                                        } elseif (
                                                                            $product_item_item->filter_category_slug ==
                                                                            'plain-band'
                                                                        ) {
                                                                            $getParameterArray = explode(
                                                                                '/',
                                                                                Request::path(),
                                                                            );
                                                                            if (count($getParameterArray) == 1) {
                                                                                $getParameterArray[2] =
                                                                                    'mens/' .
                                                                                    $product_item_item->filter_category_slug;
                                                                            } else {
                                                                                $getParameterArray[2] =
                                                                                    $product_item_item->filter_category_slug;
                                                                            }
                                                                            $url =
                                                                                URL::to('/') .
                                                                                '/' .
                                                                                implode('/', $getParameterArray);
                                                                        } else {
                                                                            if (
                                                                                !empty(
                                                                                    $product_item_item->filter_category_slug
                                                                                )
                                                                            ) {
                                                                                $url =
                                                                                    URL::to('/') .
                                                                                    '/' .
                                                                                    $product_item_item->filter_category_slug;
                                                                            } else {
                                                                                $url = 'javascript:void(0);';
                                                                            }
                                                                        }
                                                                    } elseif (
                                                                        $filter_item->slug == 'jewellery-categories'
                                                                    ) {
                                                                        $getCategoryWiseCount = getCategoryWiseCount(
                                                                            $product_item_item->item_slug,
                                                                        );
                                                                        $url =
                                                                            URL::to('/') .
                                                                            $product_item_item->filter_category_slug;
                                                                    } elseif ($filter_item->slug == 'filter-by-shape') {
                                                                        $getCategoryWiseCount = getCategoryWiseCount(
                                                                            $product_item_item->item_slug,
                                                                            'filter-by-shape',
                                                                        );

                                                                        $url =
                                                                            URL::to('/') .
                                                                            $product_item_item->filter_category_slug;
                                                                    } elseif (
                                                                        $filter_item->slug == 'style-categories'
                                                                    ) {
                                                                        $getCategoryWiseCount = getCategoryWiseCount(
                                                                            $product_item_item->item_slug,
                                                                        );

                                                                        $url =
                                                                            URL::to('/') .
                                                                            $product_item_item->filter_category_slug;
                                                                    } elseif ($filter_item->slug == 'metal_type') {
                                                                        $url = 'javascript:void(0);';
                                                                    } elseif ($filter_item->slug == 'category') {
                                                                        $getCategoryWiseCount = getCategoryWiseCount(
                                                                            $product_item_item->item_slug,
                                                                        );

                                                                        $url =
                                                                            URL::to('/') .
                                                                            '/' .
                                                                            $product_item_item->filter_category_slug;
                                                                    }
                                                                @endphp
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

                        {{-- Filter ends here --}}
                    </div>


                    {{-- Product Listing starts from here --}}
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
                                    <input type="text" class="search-item empty" id="searchd" value=""
                                        placeholder="Search for product" aria-label="Search">
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
                        <div id="products-section" style="display:none;">
                            <script>
                                // document.addEventListener("DOMContentLoaded", function () {
                                // Once DOM is ready (foreach already rendered by Blade/PHP)
                                document.getElementById("loader-overlay").style.display = "flex";
                                document.getElementById("products-section").style.display = "flex";
                                // });
                            </script>
                            <div class="search-result" style="margin-top: -15px;">
                                <div class="product-grid-wrap">
                                    <div class="product-grid-row flexed flex-flex-wrap" id="showProductList">
                                        @foreach ($sortedArray as $index => $product)
                                            @php
                                                $thumbnailGif = getThumbnailGif($product->id);
                                                $getCategory = explode(',', $product->categories);
                                            @endphp

                                            @if ($index === 3 || $index === 11)
                                                <!-- Add the image or modal content as a separate grid item -->
                                                <div class="product-grid-items-item">
                                                    @if ($index === 3)
                                                        <a href = "https://marlows-diamonds.co.uk/live-diamond-search">
                                                            <img class="diamond-engage-banner"
                                                                src="/assets/images/banner_image.png" loading="lazy"
                                                                alt="Banner" width="343" height="505">
                                                        </a>
                                                    @else
                                                        <div class="modal-body productvisitform">
                                                            <div class="col-lg-12">
                                                                <!-- Success message -->
                                                                @if (Session::has('success'))
                                                                    <div class="alert alert-success">
                                                                        {{ Session::get('success') }}
                                                                    </div>
                                                                @endif
                                                                <div class="visit-form">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Request
                                                                        an appointment</h5>

                                                                    <form id="contactForm">
                                                                        @csrf
                                                                        <input type="hidden" name="custom_url"
                                                                            id="custom_url" value="{{ url()->full() }}">
                                                                        <div class="form-controls">
                                                                            <input type="text" name="title"
                                                                                id="title"
                                                                                class="{{ $errors->has('title') ? 'error' : '' }}"
                                                                                placeholder="Your Name">
                                                                            <!-- Error -->
                                                                            @if ($errors->has('name'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('name') }}
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="form-controls">
                                                                            <input type="email" name="email"
                                                                                id="email"
                                                                                class="{{ $errors->has('email') ? 'error' : '' }}"
                                                                                placeholder="Your Email Address">
                                                                            @if ($errors->has('email'))
                                                                                <div class="error">
                                                                                    {{ $errors->first('email') }}
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="form-controls">
                                                                            <input type="text" name="phone"
                                                                                id="phone"
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
                                                                            <button type="submit" name="send"
                                                                                value="Submit">Send Message</button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <!-- Continue rendering the product card for every product -->
                                            <div
                                                class="product-grid-items-item {{ $thumbnailGif ? 'product-hover-affect' : '' }}">
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
                                                        <a href="javascript:void(0);" class="share-file" type="button"
                                                            data-bs-toggle="modal" data-bs-target="#sharesocial"
                                                            data-url="{{ url('product/' . $product->slug) }}">
                                                            <img src="/assets/images/share.png" loading="lazy"
                                                                alt="share" width="18" height="18">
                                                        </a>
                                                        <a href="javascript:void(0);" class="wishlist-heart"
                                                            id="productWishListRelated{{ $product->id }}"
                                                            data-productslug="{{ $product->slug }}"
                                                            aria-label="wishlist">
                                                            <i class="fa {{ $wishListClass }} wishcount"
                                                                aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                    @php
                                                        $getMonthTextArray = getMonthwiseDiscountText();
                                                        $getCurrentMonth = (int) date('m');
                                                        $now = new DateTime('now');
                                                        $lastDate = new DateTime('now');
                                                        $lastDate->modify('last day of this month');
                                                        $dist_future = $lastDate->format('m/d/Y');
                                                    @endphp

                                                    <div class="product-items-item-image">
                                                        <div class="list-discount-btn">
                                                            <div class="disbtn-box">{!! strtoupper($getMonthTextArray[$getCurrentMonth]) !!}</div>
                                                        </div>
                                                        <a href="{{ url('product/' . $product->slug) }}"
                                                            id="variationImageShown{{ $product->id }}"
                                                            class="{{ $thumbnailGif ? 'product-hov' : '' }}">
                                                            @if (isset($product->getProductImages) && !empty($product->getProductImages['image_url']))
                                                                <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $product->getProductImages['image_url'] }}"
                                                                    alt="{{ $product->title }}" loading="lazy">
                                                            @endif
                                                        </a>
                                                    </div>


                                                    <div class="color-buttons"
                                                        @if (strpos(request()->url(), 'exclusive-to-marlows') !== false) style="display: none;" @endif>

                                                        <a class="color-default"
                                                            id="fetchdefaultimages{{ $product->id }}"
                                                            data-slug="{{ $product->slug }}" data-color="Default"
                                                            data-src="{{ env('APP_IMAGE_URL') . '/storage/' . $product->getProductImages['image_url'] }}">Default</a>


                                                        <a class="color-btn rose-gold"
                                                            id="fetchvariationRoseimages{{ $product->id }}"
                                                            data-slug="{{ $product->slug }}"
                                                            data-color="18ct Rose Gold">Rose Gold</a>
                                                        <a class="color-btn yellow-gold"
                                                            id="fetchvariationYellowimages{{ $product->id }}"
                                                            data-slug="{{ $product->slug }}"
                                                            data-color="18ct Yellow Gold">Yellow Gold</a>
                                                    </div>


                                                    <div class="product-items-item-details">
                                                        <div class="product-items-item-name">
                                                            <div class="list_product_title">
                                                                @php
                                                                    $titleSplits = [];
                                                                    if (
                                                                        isset($product->title) &&
                                                                        !empty($product->title)
                                                                    ) {
                                                                        $titleSplits = explode('|', $product->title);
                                                                    }
                                                                @endphp
                                                                @if (isset($product->slug) && !empty($product->slug))
                                                                    <a href="{{ url('product/' . $product->slug) }}"
                                                                        class="title-list-heading">{{ isset($titleSplits[0]) ? $titleSplits[0] : '' }}</a>
                                                                    @if (isset($titleSplits[1]) && !empty($titleSplits[1]))
                                                                        <a
                                                                            href="{{ url('product/' . $product->slug) }}">{{ $titleSplits[1] }}</a>
                                                                    @endif
                                                                @else
                                                                    <a
                                                                        href="#">{{ isset($titleSplits[0]) ? $titleSplits[0] : '' }}</a>
                                                                    <a
                                                                        href="#">{{ isset($titleSplits[1]) ? $titleSplits[1] : '' }}</a>
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
                                                                                <del style="color:#000"
                                                                                    class="shopPriceval" id="shopPrice">
                                                                                    {{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                                    {{ round($product->lab_grown, 2) }}</del>
                                                                            </h4>
                                                                        @endif

                                                                        <div class="product-finder-price"
                                                                            id="finaldiamondprice">
                                                                            <span class="price">{{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                                {{ sprintf('%0.2f', $product->discounted_lab_grown) }}</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="product-finder-price"
                                                                            id="finaldiamondprice">
                                                                            <span class="price">{{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                                {{ sprintf('%0.2f', $product->lab_grown) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <p class="save_price">
                                                                    <span style="color:green">You Save : <span
                                                                            id="savePrice">
                                                                            {{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                            {{ sprintf('%0.2f', $product->lab_grown_rrp - $product->discounted_lab_grown) }}</span>
                                                                    </span> | <del id="rrpPrice">RRP:
                                                                        {{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                        {{ sprintf('%0.2f', $product->lab_grown_rrp) }}</del>
                                                                </p>
                                                            </div>
                                                        @endif
                                                    @elseif (in_array(54, $getCategory))
                                                        <div class="price-section">
                                                            <div style="display: flex;">
                                                                <div class="product-finder-price" id="finaldiamondprice">
                                                                    <span class="price">{{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                        {{ sprintf('%0.2f', $product->mined_diamond) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif (in_array(53, $getCategory) || in_array(50, $getCategory))
                                                        <div class="price-section">
                                                            <div style="display: flex;">
                                                                <div class="product-finder-price" id="finaldiamondprice">
                                                                    <span class="price">{{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                        {{ sprintf('%0.2f', $product->mined_diamond) }}</span>
                                                                </div>
                                                            </div>
                                                            <p class="save_price">
                                                                <span style="color:green">You Save : <span id="savePrice">
                                                                        {{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                        {{ $product->mined_diamond_rrp - $product->mined_diamond }}</span>
                                                                </span> | <del id="rrpPrice">RRP:
                                                                    {{ config("constants.MY_CURRENCY_SYMBOL") }}
                                                                    {{ $product->mined_diamond_rrp }}</del>
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
                        </div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Once DOM is ready (foreach already rendered by Blade/PHP)
                                document.getElementById("loader-overlay").style.display = "none";
                                // document.getElementById("products-section").style.display = "none";
                            });
                        </script>
                        <div class="loading-data-element"></div>
                        <input type="hidden" name="nextPageNumber" id="nextPageNumber" value="{{ $nextPage }}" />
                        <div class="ajax-load text-center" style="display:none;">
                        </div>
                        <div class="ajax-loader">
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        {{-- first section  starts from here --}}

        @if (isset($categoryData->pre_content) && $categoryData->pre_content->count())
            @php
                $count = $categoryData->pre_content->count();
                $customCss = match (true) {
                    $count == 1 => 'col-lg-12 col-sm-12 col-md-12',
                    $count == 2 => 'col-lg-6 col-sm-6 col-md-6',
                    $count == 3 => 'col-lg-4 col-sm-6 col-md-4',
                    default => 'col-lg-3 col-sm-6 col-md-3',
                };
            @endphp
        @else
            @if (Str::contains(request()->url(), 'engagement-rings/'))
                <div class="head-para-three">
                    @php
                        $currentUrl = $_SERVER['REQUEST_URI'];
                        $urlParts = explode('/', trim($currentUrl, '/'));
                        $shapeSlug = end($urlParts);
                        $shapeName = ucwords(str_replace('-', ' ', $shapeSlug));
                    @endphp
                    <h2 class="heading-h-three"> Explore More @php echo $shapeName; @endphp Shape Engagement Rings Styles</h2>

                </div>
                <div class="category_listing engagement_rings"
                    style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    @foreach ($filter_items as $filter_key => $filter_item)
                        @if ($filter_item->slug == 'style-categories')
                            @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                                <div class="item">
                                    @if (isset($product_item_item->category_images) && !empty($product_item_item->category_images))
                                        <img src="{{ getImageOptimizeDetails('/storage/' . $product_item_item->category_images, '217', '217') }}"
                                            loading="lazy" alt="{{ $product_item_item->item_name }}">
                                    @else
                                        <img src="{{ getImageOptimizeDetails('/storage/Products/CX9-SC48_00003_1650365432.jpg', '217', '217') }}"
                                            loading="lazy" alt="{{ $product_item_item->item_name }}">
                                    @endif
                                    <p>
                                        @if (isset($product_item_item->parent_category_slug) &&
                                                !empty($product_item_item->parent_category_slug->parent_cate->slug))
                                            <a style="color: #8e2e65; font-weight: bold;  font-size: 18px;  text-decoration: none;"
                                                href="{{ url($product_item_item->parent_category_slug->parent_cate->slug . '/' . $product_item_item->item_slug) }}">{{ $product_item_item->item_name }}</a>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            @else
                {{-- precontent start --}}

                {{-- For the wedding ring mens --}}

                @if (Str::endsWith(request()->url(), '/wedding-rings/mens'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Men's Wedding Rings</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">

                        <div class="item" style="width: 216.5px;">
                            <img src="https://marlows-diamonds.co.uk/tempfolderpath/1695626574WED025-F-G-VS-SI_T_W_1650703527.jpg"
                                loading="lazy" alt="Diamond Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/mens/diamond-band">Men's Diamond
                                    Band</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/WED003_T_W_1650709427.jpg"
                                loading="lazy" alt="Plain Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/mens/plain-band"> Men's Plain
                                    Band</a>
                            </p>
                        </div>
                    </div>
                @endif









                {{-- For the wedding ring womens --}}

                @if (Str::endsWith(request()->url(), '/wedding-rings/womens'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Women's Wedding Rings</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <div class="item" style="width: 216.5px;">
                            <img src="https://marlows-diamonds.co.uk/tempfolderpath/1695626574WED025-F-G-VS-SI_T_W_1650703527.jpg"
                                loading="lazy" alt="Diamond Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/womens/diamond-band">Women's Diamond
                                    Band</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/WED003_T_W_1650709427.jpg"
                                loading="lazy" alt="Plain Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/womens/plain-band">Women's Plain
                                    Band</a>
                            </p>
                        </div>
                    </div>
                @endif







                {{-- For the wedding diamond band --}}

                @if (Str::contains(request()->url(), '/wedding-rings/mens/diamond-band'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Men's Band</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/WED003_T_W_1650709427.jpg"
                                loading="lazy" alt="Plain Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/mens/plain-band">Men's Plain Band</a>
                            </p>
                        </div>
                    </div>
                @endif





                {{-- For the men's plain band --}}

                @if (Str::contains(request()->url(), '/wedding-rings/mens/plain-band'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Men's Band</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">


                        <div class="item" style="width: 216.5px;">
                            <img src="https://devstaging.marlows-diamonds.co.uk/storage/Products/WED030_T_W-1.jpg"
                                loading="lazy" alt="Men's Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/wedding-rings/mens/diamond-band">Men's
                                    Diamond Band</a>
                            </p>
                        </div>


                    </div>
                @endif





                {{-- For the women's diamond band --}}

                @if (Str::contains(request()->url(), '/wedding-rings/womens/diamond-band'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Women's Band</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/WED003_T_W_1650709427.jpg"
                                loading="lazy" alt="Plain Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/womens/plain-band">Women's Plain
                                    Band</a>
                            </p>
                        </div>
                    </div>
                @endif










                {{-- For the wedding plain band --}}

                @if (Str::contains(request()->url(), '/wedding-rings/womens/plain-band'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Women's Band</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <div class="item" style="width: 216.5px;">
                            <img src="https://marlows-diamonds.co.uk/tempfolderpath/1695626626ET106-F-VS_T_W-1.jpg"
                                loading="lazy" alt="Diamond Band" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/wedding-rings/womens/diamond-band">Women's Diamond
                                    Band</a>
                            </p>
                        </div>

                    </div>
                @endif












                {{-- For the diamond-jewellery --}}

                @if (Str::endsWith(request()->url(), '/diamond-jewellery'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Diamond Jewellery</h2>
                    </div>
                    <div class="owl-carousel owl-theme listing-slider"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">

                        <div class="item" style="width: 216.5px;">
                            <img src="	https://admin.marlowsdiamonds.com/storage/Products/D_S028_T_W-1_1650533593.jpg"
                                loading="lazy" alt="Bracelets" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/bracelets">Bracelets</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://devstaging.marlows-diamonds.co.uk/storage/Products/D_S022_90_W_1650547324.jpg"
                                loading="lazy" alt="Earrings" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/earrings">Earrings</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/DS004_T_W-1_1650622901.jpg"
                                loading="lazy" alt="Necklaces" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/necklaces">Necklaces</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S025_90_W_1650633402.jpg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/pendants">Pendants</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/1822000435tanzanite-1.jpeg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/exclusive-to-marlows">Exclusive
                                    to Marlows</a>
                            </p>
                        </div>

                    </div>
                @endif









                {{-- For the Bracelets --}}

                @if (Str::contains(request()->url(), '/diamond-jewellery/bracelets'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Diamond Jewellery</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">

                        <div class="item" style="width: 216.5px;">
                            <img src="	https://admin.marlowsdiamonds.com/storage/Products/D_S028_T_W-1_1650533593.jpg"
                                loading="lazy" alt="Earrings" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/earrings">Earrings</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/DS004_T_W-1_1650622901.jpg"
                                loading="lazy" alt="Necklaces" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/necklaces">Necklaces</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S025_90_W_1650633402.jpg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/pendants">Pendants</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/1822000435tanzanite-1.jpeg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/exclusive-to-marlows">Exclusive
                                    to Marlows</a>
                            </p>
                        </div>

                    </div>
                @endif






                {{-- For the Earrings --}}

                @if (Str::contains(request()->url(), '/diamond-jewellery/earrings'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Diamond Jewellery</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <div class="item" style="width: 216.5px;">
                            <img src="	https://admin.marlowsdiamonds.com/storage/Products/D_S028_T_W-1_1650533593.jpg"
                                loading="lazy" alt="Bracelets" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/bracelets">Bracelets</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/DS004_T_W-1_1650622901.jpg"
                                loading="lazy" alt="Necklaces" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/necklaces">Necklaces</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S025_90_W_1650633402.jpg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/pendants">Pendants</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/1822000435tanzanite-1.jpeg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/exclusive-to-marlows">Exclusive
                                    to Marlows</a>
                            </p>
                        </div>

                    </div>
                @endif








                {{-- For the Necklaces --}}

                @if (Str::contains(request()->url(), '/diamond-jewellery/necklaces'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Diamond Jewellery</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <div class="item" style="width: 216.5px;">
                            <img src="	https://admin.marlowsdiamonds.com/storage/Products/D_S028_T_W-1_1650533593.jpg"
                                loading="lazy" alt="Bracelets" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/bracelets">Bracelets</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S022_90_W_1650547324.jpg"
                                loading="lazy" alt="Earrings" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/earrings">Earrings</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S025_90_W_1650633402.jpg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/pendants">Pendants</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/1822000435tanzanite-1.jpeg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/exclusive-to-marlows">Exclusive
                                    to Marlows</a>
                            </p>
                        </div>

                    </div>
                @endif








                {{-- For the pendants --}}

                @if (Str::contains(request()->url(), '/diamond-jewellery/pendants'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Diamond Jewellery</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <div class="item" style="width: 216.5px;">
                            <img src="	https://admin.marlowsdiamonds.com/storage/Products/D_S028_T_W-1_1650533593.jpg"
                                loading="lazy" alt="Bracelets" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/bracelets">Bracelets</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/DS004_T_W-1_1650622901.jpg"
                                loading="lazy" alt="Necklaces" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/necklaces">Necklaces</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S022_90_W_1650547324.jpg"
                                loading="lazy" alt="Earrings" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/earrings">Earrings</a>
                            </p>
                        </div>


                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/1822000435tanzanite-1.jpeg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/exclusive-to-marlows">Exclusive
                                    to Marlows</a>
                            </p>
                        </div>

                    </div>
                @endif





                {{-- For the exclusive --}}

                @if (Str::contains(request()->url(), '/diamond-jewellery/exclusive-to-marlows'))
                    <div class="head-para-three">
                        <h2 class="heading-h-three">Explore More Options for Diamond Jewellery</h2>
                    </div>
                    <div class="category_listing"
                        style="text-align: center; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <div class="item" style="width: 216.5px;">
                            <img src="	https://admin.marlowsdiamonds.com/storage/Products/D_S028_T_W-1_1650533593.jpg"
                                loading="lazy" alt="Bracelets" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/bracelets">Bracelets</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/DS004_T_W-1_1650622901.jpg"
                                loading="lazy" alt="Necklaces" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/necklaces">Necklaces</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S025_90_W_1650633402.jpg"
                                loading="lazy" alt="Pendants" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/pendants">Pendants</a>
                            </p>
                        </div>

                        <div class="item" style="width: 216.5px;">
                            <img src="https://admin.marlowsdiamonds.com/storage/Products/D_S022_90_W_1650547324.jpg"
                                loading="lazy" alt="Earrings" style="max-width: 100%; height: auto;" />
                            <p>
                                <a href="https://marlows-diamonds.co.uk/diamond-jewellery/earrings">Earrings</a>
                            </p>
                        </div>
                    </div>
                @endif
            @endif
            {{-- precontent ends --}}







        @endif

        {{-- ends here --}}


        <!-- Choose a dreamy start here-->
        <div class="choosedreamy-wrap">
            <div class="container">
                <div class="head-para-three">
                    {{-- <h2 class="heading-h-three">{{ $categoryData->pre_content[0]->title }}</h2> --}}
                    @if (!empty($categoryData->pre_content) && isset($categoryData->pre_content[0]->title))
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
                                                <a
                                                    href="{{ isset($preContentData->button_url) ? $preContentData->button_url : '' }}">
                                                    <img src="{{ env('APP_IMAGE_URL') . '/storage/' . $preContentData->image_url }}"
                                                        loading="lazy"
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
                                                            {{ isset($preContentData->button_title) ? $preContentData->button_title : 'Shop Now' }}
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
                                                    loading="lazy"
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
                                                        {{ isset($preContentData->button_title) ? $preContentData->button_title : 'Shop Now' }}
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
                                    @php
                                        $conditionalCss = 'postcontent100';
                                    @endphp
                                @else
                                    @php
                                        $conditionalCss = '';
                                    @endphp
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
                                            loading="lazy"
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
        {{-- @include('front.includes.postcarouselblock') --}}
        {!! Cache::remember('productListingPagePostcarouselblock', 900, function () {
            return view('front.includes.postcarouselblock')->render();
        }) !!}
        <!-- Best Post Carousel Block start here -->

        <!-- FAQ Section start here -->

        <!-- Section Reviews -->
        <div class="container review-section">
            <div class="rating-review-block">
                <div class="owl-carousel owl-theme slider-review">
                    {{-- @include('front.pages.reviews') --}}
                    {!! Cache::remember('productListingPageReviews', 1800, function () {
                        return view('front.pages.reviews')->render();
                    }) !!}
                </div>
            </div>
        </div>


        @php
            $faqCategoryKey = md5($categoryData->faq_category);
        @endphp
        {!! Cache::remember('productListingPageFaqCategoryWise_{$faqCategoryKey}', 3600, function () use (
            $categoryData,
        ) {
            return view('front.includes.faq-category-wise', compact('categoryData'))->render();
        }) !!}

        {{-- @include('front.includes.instagram-section') --}}
        {!! Cache::remember('instagramSection', 3600, function () {
            return view('front.includes.instagram-section')->render();
        }) !!}

    </div>
    <div class="engagement-ring-img">
        <img src="{{ getImageOptimizeDetails('/images/viewguide.webp', '1349', '537') }}" loading="lazy"
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

    <div class="modal fade sharesocial" id="sharesocial" tabindex="-1" aria-labelledby="sharesocialLabel"
        aria-hidden="true">
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
                        <li><a href="#" id="facebookShare" target="_blank"><i class="fa fa-facebook"
                                    aria-hidden="true"></i></a></li>
                        <li><a href="#" id="twitterShare" target="_blank"><i class="fa fa-twitter"
                                    aria-hidden="true"></i></a></li>
                        <li><a href="#" id="pinterestShare" target="_blank" class="btn btn-linkedin"><i
                                    class="fa fa-pinterest"></i></a></li>
                        <li><a href="#" id="whatsappShare" target="_blank" class="btn btn-whatsapp"><i
                                    class="fa fa-whatsapp"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection


{{-- Custom JS for this page --}}
@section('js')
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>

    {{-- Blade variables --}}
    <script>
        const dataPhpVariable = @json($data);
        const contactRoute = "{{ route('contact') }}";
        const pathPhpVariable = '{{ $path }}';
        const getVariationsImageDataRoute = "{{ route('get-variations-image-data') }}";
        const CSRFTOKEN = "{{ csrf_token() }}";
        const getFilteredProductsRoute = "{{ route('getfilteredproducts') }}";
        const setProductWishlistRoute = "{{ route('set-product-wishlist') }}";
    </script>

    <script src="{{ mix('js/product_listing_page.js') }}"></script>

    {{-- <script src="{{ asset('custom/js/product_listing_page/product_listing_page.js') }}"></script> --}}
@endsection
