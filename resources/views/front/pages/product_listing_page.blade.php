@extends('layouts.front.app')
@section('content')

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
                    {!! isset($categoryData->description) ? $categoryData->description : '' !!}
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
                                    <?php
                                    $i = 1;
                                    ?>
                                    @foreach ($filter_item->product_items as $product_item_key => $product_item_item)
                                        <li>
                                            @if (isset($product_item_item->item_type) && $product_item_item->item_type == 'categories')
                                                <a class="filter-item-data" data-id="{{ $product_item_item->item_id }}"
                                                    href="{{ asset('/' . $product_item_item->item_slug) }}">{{ $product_item_item->item_name }}</a>
                                            @else
                                                <input type="checkbox" name="{{ $filter_item->slug }}"
                                                    value="{{ $product_item_item->item_value }}"
                                                    class="filter-item-data"> {{ $product_item_item->item_name }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach


                        <div class="reset-filer-container">
                            <button class="reset-filer-btn">Reset search</button>
                        </div>

                    </div>

                    <div class="sidebar-main-cart">
                        <div class="sidebar-title">
                            Shopping Cart
                        </div>
                        @if (session('cart'))
                            <div class="side-cart-row">
                                @php $total = 0 @endphp
                                @foreach (session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                    <div class="side-cart-item">
                                        <div class="cart-image-item">
                                            @if (isset($details['selected_parameter']['imagelink']) && !empty($details['selected_parameter']['imagelink']))
                                                <img src="{{ $details['selected_parameter']['imagelink'] }}" width="100"
                                                    height="100" class="img-responsive" />
                                            @elseif(isset($details['image']) && !empty($details['image']))
                                                <img src="{{ asset('storage/' . $details['image']) }}" width="100"
                                                    height="100" class="img-responsive" />
                                            @else
                                                <img src="https://www.marlows-diamonds.co.uk/wp-content/uploads/2019/07/MarlowsDiamonds-Logo-225x107.png"
                                                    width="100" height="100" class="img-responsive" />
                                            @endif
                                        </div>
                                        <div class="side-cart-delete">
                                            <a href="javascript:void(0);" data-id="{{ $id }}"
                                                class="remove-from-cart">x</a>
                                        </div>

                                        <div class="side-cart-pr-name">
                                            {!! $details['name'] !!}
                                        </div>
                                        <div class="side-cart-quantity">
                                            {{ $details['quantity'] }} ×
                                            <span
                                                class="side-cart-amount">{{ MY_CURRENCY_SYMBOL }}{{ number_format($details['price'], 2) }}</span>
                                        </div>
                                        <div class="side-cart-total">
                                            <strong>Subtotal: </strong>
                                            {{ MY_CURRENCY_SYMBOL }}{{ number_format($details['price'] * $details['quantity'], 2) }}
                                            (incl. VAT)
                                        </div>

                                    </div>
                                @endforeach
                                <div class="side-cart-actions">
                                    <a class="view-basket btn-bg-small" href="{{ route('product.cart') }}">View Basket</a>
                                    <a class="btn-bg-small" href="{{ route('product.checkout') }}">Checkout</a>
                                </div>
                            </div>
                        @else
                            <div class="shopping_cart_content">
                                <p class="mini-cart__empty-message">No products in the basket.</p>
                            </div>
                        @endif
                    </div>
                    @if (session('recentproducts'))
                        <div class="side-recentlyview">
                            <div class="sidebar-title">
                                Recently Viewed
                            </div>
                            <div class="side-recently-item">
                                @php $i = 0; @endphp
                                @foreach (array_reverse(session('recentproducts')) as $ProductDetails)
                                    @if ($i <= 8)
                                        <div class="side-recently-col">
                                            <a class="side-recently-pr-name"
                                                href="{{ asset('product/' . $ProductDetails['slug']) }}">{{ $ProductDetails['name'] }}</a>
                                            <a class="side-recently-pr-img"
                                                href="{{ asset('product/' . $ProductDetails['slug']) }}"><img
                                                    src="{{ asset('storage/' . $ProductDetails['image']) }}"
                                                    alt="image"></a>
                                        </div>
                                    @endif
                                    @php $i++; @endphp
                                @endforeach
                            </div>
                        </div>
                    @endif
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
    <script>
        $(document).ready(function() {
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
