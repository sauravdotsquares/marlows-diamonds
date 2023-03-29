@extends('layouts.front.app')
@section('content')
@section('css')
<link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css">
<style>
    .ui-slider-handle{
        width: 35px !important;
        font-size: small !important;
        color: #FF0000 !important;
        text-align: center !important;
    }

    .ui-slider .ui-slider-handle{
        height: 1.5em; color: #8e2e65 !important;}
.ui-widget-header{background: #8e2e65 !important;}
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus{
    border-color: #8e2e65 !important; outline: none; box-shadow: none; background: #fff !important;
    }
    .error {
        color: #e74c3c !important;
    }
</style>


@endsection

    <div class="category-banner" style="background-image:url({{ asset('') }}assets/images/engagement-rings-banner.png)">
        <div class="container">
            <div class="category-banner-text">
                <h1>{!! !empty($categoryData->title) ? $categoryData->title : '' !!}</h1>
                <p>{!! !empty($categoryData->short_description) ? $categoryData->short_description : '' !!}</p>
            </div>
        </div>
    </div>

    <div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
        <div class="container">
            <div class="category-listing-row">
                <div class="category-list-wrap">
                    <div class="search-result"> @include('front.includes.productCard')</div>
                    <div class="loading-data-element"></div>
                    <input type="hidden" name="nextPageNumber" id="nextPageNumber" value="{{ $nextPage }}" />
                    <div class="ajax-load text-center" style="display:none;">
                        <img alt="Product loader" src="{{ asset('assets/images/spinner-ring.gif') }}">
                        <p>Loading More Products</p>
                        <button style="display: none;" class="ajax-load-btn">Load more data</button>
                    </div>
                    {{-- {!! isset($categoryData->description) ? $categoryData->description : '' !!} --}}
                </div>

                <div class="category-sidebar-wrap">



                    <div class="filter-container">

                        <input type="text" name="title" class="search-item" id="search" value=""
                            placeholder="Search here">

                        @foreach ($filter_items as $filter_key => $filter_item)
                            <div class="filter-item">
                                <input type="hidden" name="filter_item_slug" class="filter_item_slug"
                                    value="{{ $filter_item->slug }}" />
                                <div class="category-filter-title">
                                    <h3>{{ $filter_item->name }}</h3>
                                </div>
                                <ul>
                                    @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                                        <li>
                                            @if (isset($product_item_item->item_type) && $product_item_item->item_type == 'categories')
                                                <a class="filter-item-data" data-id="{{ $product_item_item->item_id }}"
                                                    href="{{ asset('/' . $product_item_item->item_slug) }}">{{ $product_item_item->item_name }}</a>
                                            @else
                                                <input type="{{$filter_item->input_type}}" name="{{ $filter_item->slug }}" {{(in_array(Str::lower($product_item_item->item_value),$slugs)) ? ' checked ' : ''}} {{(in_array(Str::lower(Str::replace(' ','-',$product_item_item->item_name)),$slugs)) ? ' checked ' : ''}}
                                                    value="{{ $product_item_item->item_value }}"
                                                    class="filter-item-data"> {{ $product_item_item->item_name }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach


                        <div class="reset-filer-container">
                            <a href="{{url()->current()}}"><button class="reset-filer-btn">Reset search</button></a>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- Section Reviews -->
    <div class="container">
        <div class="rating-review-block">
            <div class="owl-carousel owl-theme slider-review">
                @include('front.pages.reviews')
            </div>
        </div>
    </div>

@endsection





@section('js')
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>



        $(document).ready(function() {


            console.log($('#sliderRangeSetMin').val());
        console.log($('#sliderRangeSetMax').val());

$("#slider").slider({
            range: true,
            min: $('#sliderRangeSetMin').val(),
            max: $('#sliderRangeSetMax').val(),
            step: 1,
            values: [$('#sliderRangeSetMin').val(), $('#sliderRangeSetMax').val()],
            slide: function(event, ui) {
                var value1 = $("#slider").slider("values", 0);
                var value2 = $("#slider").slider("values", 1);
                $("#sliderRangeSetMin").val(value1);
                $("#sliderRangeSetMax").val(value2);


                for (var i = 0; i < ui.values.length; ++i) {
                    // console.log('Checking');
                    $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
                }

            },
            change: function(){

                var value1 = $("#slider").slider("values", 0);
                var value2 = $("#slider").slider("values", 1);
                // $("#slider").find(".ui-slider-handle:first").text(value1);
                // $("#slider").find(".ui-slider-handle:last").text(value2);

                angular.element(document.getElementById('diamondMainController')).scope().getDiamondResults();
            },
        });

        $("#sliderRangeSetMin").change(function (event) {
            var value1 = parseFloat($("#sliderRangeSetMin").val());
            var highVal = value1 * 2;
            $("#slider").slider("option", {"max": highVal, "value": value1});
        });

        $("#sliderRangeSetMax").change(function (event) {
            var value1 = parseFloat($("#sliderRangeSetMax").val());
            var highVal = value1 * 2;
            $("#slider").slider("option", {"max": highVal, "value": value1});
        });

		var stepsSlider = document.getElementById('range-slider');
		var input0 = document.getElementById('input-carat-min');
		var input1 = document.getElementById('input-carat-max');
		var inputs = [input0, input1];

            $('.show-more-content').hide();
            $('.show-more').click(function() {
                $(this).parents('.reviewr-review-text').toggleClass("show-text-col");
            });
        });
    </script>
    <script>
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
            // console.log('{{ route('getfilteredproducts') }}');
            // var index = parseInt($(this).attr("id").replace("filter-item-data-Array", ''));

            $.ajax({
                type: 'GET',
                url: '{{ route('getfilteredproducts') }}',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'ids': $('.filter-item-data:checked').serializeArray(),
                    'path':'{{$path}}'
                },
                success: function(res) {
                    $('.search-result').html(res);
                    console.log("res");
                    console.log(res);
                    return false;
                    if (res.status == 200) {
                        // removed msg
                        $('.search-result').html(res);
                        $('#imgeremovenew' + index).remove();
                        $('#imgeremovenewClose' + index).remove();
                    }
                    // getAttribute();
                    return false;
                }
            });
            // var dataString = 'ids='+ ids;
            // console.log(dataString);
        });

        // function sendDataValues() {

        // }

        // $(document).on('click', '.filter-item-data', function() {

        //     $(this).toggleClass('active');
        //     getFilterValues();
        // });

        // function getFilterValues() {
        //     let dataToSend = {};
        //     const filterItem = $('.filter-item-data.active');
        //     // console.log("check detailsadasd dadsd");
        //     // console.log(filterItem);
        //     for (var item in filterItem) {
        //         if (typeof filterItem[item] == 'object') {
        //             const itemRef = $(filterItem[item]);
        //             // console.log("itemRef"+itemRef);
        //             const itemValue = itemRef.attr('data-id');
        //             console.log("itemValue " + itemValue);
        //             const itemName = itemRef.parents('.filter-item').find('.filter_item_slug').val();
        //             // console.log("itemName"+itemName);
        //             if (itemName && itemValue) {
        //                 if (dataToSend[itemName]) {
        //                     const existingItems = dataToSend[itemName].split();
        //                     console.log("existingItems" + existingItems);
        //                     console.log(existingItems);
        //                     existingItems.push(itemValue);
        //                     dataToSend[itemName] = existingItems.join(',');
        //                     console.log("checki ");
        //                     console.log(dataToSend[itemName]);
        //                     console.log("check if");
        //                 } else {
        //                     console.log("check else");
        //                     dataToSend[itemName] = itemValue;
        //                 }
        //             }
        //         }
        //     }
        //     var size = Object.keys(dataToSend).length;
        //     if (size) {
        //         const keyword = $(".search-item").val();
        //         let path = window.location.href.split('?')[0];
        //         // console.log('path', path);
        //         window.history.pushState({
        //             ...dataToSend,
        //             keyword: keyword
        //         }, '', path);
        //         const newData = new URLSearchParams({
        //             ...dataToSend,
        //             keyword: keyword
        //         }).toString();
        //         console.log("testing" + newData);
        //         return newData;
        //     } else {
        //         return null;
        //     }
        // }


        // var typingTimer;                //timer identifier
        // var doneTypingInterval = 1000;  //time in ms, 5 seconds for example
        // var $input = ".search-item";

        // $(document).on('keyup',$input, function(){
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(doneTyping, doneTypingInterval);
        // });

        // $(document).on('click','.category-filter-item', function(){
        //     // $('.category-filter-item').removeClass('active');
        //     $(this).addClass('active');
        //     setTimeout(()=>{
        //         doneTyping();
        //     },100)
        // });

        // $(document).on('click','.metal-type-filter-item', function(){
        //     // $('.metal-type-filter-item').removeClass('active');
        //     $(this).toggleClass('active');



        //     setTimeout(()=>{
        //         doneTyping();
        //     },100)
        // });

        // function doneTyping () {
        // 	$("#showProductList").empty();
        //     $("#nextPageNumber").val(1);
        //     clearTimeout(typingTimer);
        //     loadMoreData();
        // }

        //     /** On scroll get more data */
        //     var triggerScrollEvent = true;
        //     $(document).ready(function() {
        //         $(document).on('scroll',function(){
        //             if(triggerScrollEvent){
        //                 if($(".loading-data-element").isInViewport()){
        //                     triggerScrollEvent = false;
        //                     $(".ajax-load-btn").trigger('click');
        //                 }
        //             }
        //         });
        //     });

        //     $(document).on('click',".ajax-load-btn", function(){
        //         triggerScrollEvent = false;
        //         $('.ajax-load').show();
        //         loadMoreData();
        //     });


        //     $(".reset-filer-btn").on('click', function(){
        //         $("#nextPageNumber").val('1');
        //         $(".search-item").val('');
        //         $(".category-filter-item").removeClass('active');
        //         $(".metal-type-filter-item").removeClass('active');
        //         setTimeout(()=>{
        //             $("#showProductList").empty();
        //             $("#nextPageNumber").val(1);
        //             loadMoreData(true);
        //         },100)
        //     });


        //     function loadMorePassData () {
        //         const page = $("#nextPageNumber").val();
        //         const searchKeyword = $(".search-item").val();
        //         const categorySearch = $(".category-filter-item.active").attr('data-id');
        //         const metalTypeSearch = $(".metal-type-filter-item.active").attr('data-id');

        //         var url = new URL(location.href);
        //         url.searchParams.set('keyword', (searchKeyword ? searchKeyword : ''));
        //         url.searchParams.set('category', (categorySearch ? categorySearch : ''));
        //         url.searchParams.set('metal_type', (metalTypeSearch ? metalTypeSearch : ''));
        //         if (history.pushState) {
        //             window.history.pushState({path:url.href},'',url.href);
        //         }
        //         return {
        //             '_token': "{{ csrf_token() }}",
        //             keyword: searchKeyword,
        //             category: categorySearch,
        //             metal_type : metalTypeSearch,
        //             page: page
        //         };
        //     }

        //     function getFilterData () {

        //     }

        //     function loadMoreData(resetSearch=false){

        //         // const dataToPass = loadMorePassData(resetSearch);
        //         const page = $("#nextPageNumber").val();
        //         const searchKeyword = $(".search-item").val();
        //         const categorySearch = $(".category-filter-item.active").attr('data-id');
        //         const metalTypeSearch = $(".metal-type-filter-item.active").attr('data-id');

        //         var url = new URL(location.href);
        //         url.searchParams.set('keyword', (searchKeyword ? searchKeyword : ''));
        //         url.searchParams.set('category', (categorySearch ? categorySearch : ''));
        //         url.searchParams.set('metal_type', (metalTypeSearch ? metalTypeSearch : ''));
        //         if (history.pushState) {
        //             window.history.pushState({path:url.href},'',url.href);
        //         }

        //         if(resetSearch){
        //             var url = {
        //                 href: window.location.href.split('?')[0]
        //             };
        //             if (history.pushState) {
        //                 window.history.pushState({path:url.href},'',url.href);
        //             }
        //         }



        //         $.ajax({
        //             url: encodeURI(window.location.href),
        //             type: "post",
        //             data: {
        //                 '_token': "{{ csrf_token() }}",
        //                 'page':page
        //             },
        //         }).done(function(data){
        //             triggerScrollEvent = true;
        //             if(data.status){
        //                 $('.ajax-load').hide();
        //             }
        //             $("#showProductList").append(data.productItems);
        //             $("#nextPageNumber").val(data.nextPage);

        //             if(!data.isNextPage){
        //                 triggerScrollEvent = false;
        //             }

        //         }).fail(function(jqXHR, ajaxOptions, thrownError){
        //             triggerScrollEvent = true;
        //             alert('server not responding...');
        //         });
        //     }

        //     $(".remove-from-cart").click(function (e) {
        //         e.preventDefault();
        //         var ele = $(this);
        //         if(confirm("Are you sure want to remove?")) {
        //             $.ajax({
        //                 url: '{{ route('remove.from.cart') }}',
        //                 method: "DELETE",
        //                 data: {
        //                     _token: '{{ csrf_token() }}',
        //                     id: $(this).attr("data-id")
        //                 },
        //                 success: function (response) {
        //                     window.location.reload();
        //                 }
        //             });
        //         }
        //     });
    </script>
@endsection
