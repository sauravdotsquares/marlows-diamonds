@extends('layouts.front.app')
@section('content')

<?php

    // echo "checking<pre>";
    // print_r($getProduct);
    // die;

?>

<!-- category header banner start -->
<div class="category-banner" style="background-image:url({{asset('')}}assets/images/engagement-rings-banner.png)">
    <div class="container">
        <div class="category-banner-text">
            <h1>{!! isset($data->title)?$data->title:'' !!}</h1>
            <!-- <h2>AVAILABLE IN A VARIETY OF CUTS AND STYLES</h2> -->
            <p>{!! isset($data->short_description)?$data->short_description:'' !!}</p>
        </div>
    </div>
</div>
<!-- category header banner end -->

<!-- Category Listing Wrap Start -->
<div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
    <div class="container"  ng-init="productCatFilters('{{$cat1}}','{{$cat2}}','{{$cat3}}')">
        <div class="category-listing-row">
            <div class="category-list-wrap">
                <div class="category-product-filter flexed flex-flex-wrap <%showsubCatOnly%>" ng-if="display_filter">
                    <div class="product-filter-col" ng-if="subCats.length>0">
                        <div class="pr-filter-title" ng-if="parent_cat=='engagement-rings'">
                            Ring Style
                        </div>
                        <div class="filter-tags-row flexed flex-flex-wrap ">
                            <div class="filter-tags-col <%subCat.active_status%>" ng-repeat="subCat in subCats">
                                <div class="category-product-filter-icon">
                                    <a href="<%subCat.url%>"><img src="{{asset('storage')}}<%subCat.hover_icon%>" alt="icon"></a>
                                </div>
                                <div class="category-product-filter-text">
                                    <a href="<%subCat.url%>"><%subCat.name%></a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="product-filter-col"  ng-if="subSubCats.length>0">
                        <div class="pr-filter-title" ng-if="parent_cat=='engagement-rings'">
                            Diamond Cut
                        </div>
                        <div class="filter-tags-row flexed flex-flex-wrap cols-ryt-tags <%parent_cat%>">
                            <div class="filter-tags-col <%subSubCat.active_status%>"  ng-repeat="subSubCat in subSubCats">
                                <div class="category-product-filter-icon">
                                    <a href="<%subSubCat.url%>"><img src="{{asset('storage')}}<%subSubCat.hover_icon%>" alt="icon"></a>
                                </div>
                                <div class="category-product-filter-text">
                                    <a href="<%subSubCat.url%>"><%subSubCat.name%> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category listing -->
                <div class="product-grid-wrap">
                    <div class="product-grid-row flexed flex-flex-wrap" id="showProductList">

                    </div>
                    <input type="hidden" name="sectionHeight" id="sectionHeight" value="">
                    <input type="hidden" name="scrollFlag" id="scrollFlag" value="">
                </div>

                <div class="ajax-load text-center" style="display:block">
                    <img alt="Product loader" src="{{asset('assets/images/spinner-ring.gif')}}"><p>Loading More Products</p>
                </div>

                {!! isset($data->description)?$data->description:'' !!}
            </div>
            <!-- Category SIdebar start -->
            <div class="category-sidebar-wrap">

                <div class="sidebar-main-cart">
                    <div class="sidebar-title">
                        Shopping Cart
                    </div>
                    @if(session('cart'))
                    <div class="side-cart-row">
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <?php 
                                if(isset($details['deposited_price']) && !empty($details['deposited_price'])){
                                    $price = $details['deposited_price'];
                                }else{
                                    $price = $details['price']
                                }
                            ?>
                            <div class="side-cart-item">
                                <div class="cart-image-item">
                                    @if(isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                                        <img src="{{$details['customArray']['ImageLink']}}" width="100" height="100"
                                        class="img-responsive" />
                                    @elseif(isset($details['image']) && !empty($details['image']))
                                        <img src="{{asset('storage/'.$details['image'])}}" width="100" height="100"
                                        class="img-responsive" />
                                    @else
                                        <img src="{{asset('images/waiting_img.png')}}" width="100" height="100" class="img-responsive" />
                                    @endif
                                </div>
                                <div class="side-cart-delete">
                                    <a href="javascript:void(0);" data-id="{{ $id }}" class="remove-from-cart">x</a>
                                </div>

                                <div class="side-cart-pr-name">
                                    {!! $details['name'] !!}
                                </div>
                                <div class="side-cart-quantity">
                                    {{ $details['quantity'] }} ×
                                    <span class="side-cart-amount">{{MY_CURRENCY_SYMBOL}}{{ number_format($details['price'],2) }}</span>
                                </div>
                                <div class="side-cart-total">
                                    <strong>Deposited: </strong> {{MY_CURRENCY_SYMBOL}}{{ number_format($price * $details['quantity'],2) }} (incl. VAT)
                                </div>

                            </div>
                        @endforeach
                        <div class="side-cart-actions">
                            <a class="view-basket btn-bg-small" href="{{route('product.cart')}}">View Basket</a>
                            <a class="btn-bg-small" href="{{route('product.checkout')}}">Checkout</a>
                        </div>
                    </div>
                    @else
                        <div class="shopping_cart_content">

                            <p class="mini-cart__empty-message">No products in the basket.</p>


                        </div>
                    @endif
                </div>
                @if(session('recentproducts'))
                <div class="side-recentlyview">
                    <div class="sidebar-title">
                        Recently Viewed
                    </div>
                    <div class="side-recently-item">
                        @php $i = 0; @endphp
                        @foreach(array_reverse(session('recentproducts')) as $ProductDetails)
                            @if($i <= 8)
                                <div class="side-recently-col">
                                    <a class="side-recently-pr-name" href="{{asset('product/'.$ProductDetails['slug'])}}">{{$ProductDetails['name']}}</a>
                                    <a class="side-recently-pr-img" href="{{asset('product/'.$ProductDetails['slug'])}}"><img src="{{asset('storage/'.$ProductDetails['image'])}}"
                                            alt="image"></a>
                                </div>
                            @endif
                            @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <!-- Category SIdebar end -->
        </div>
    </div>
</div>
<input type="hidden" id="pagescroll" value="1">

@section('js')

<script>
$(document).ready(function(){
    $('.show-more-content').hide();
    $('.show-more').click(function(){
        $(this).parents('.reviewr-review-text').toggleClass("show-text-col");
    });
});

</script>
    <script>

        function addVideoHoverCss($element=null){
            if($element){
                $element.find('a.product-hov').css({
                    '-webkit-transition' : 'all 200ms ease-in',
                    '-webkit-transform' : 'scale(1.2)',
                    '-ms-transition' : 'all 200ms ease-in',
                    '-ms-transform' : 'scale(1.2)',
                    '-moz-transition' : 'all 200ms ease-in',
                    '-moz-transform' : 'scale(1.2)',
                    'transition' : 'all 200ms ease-in',
                    'transform': 'scale(1.2)'
                });
            }
            return true;
        }

    $(document).on('mouseenter','.product-hover-affect', function (event) {
        //addVideoHoverCss($(this));
        // $(this).find('a.product-hov').css({
        //     '-webkit-transition' : 'all 200ms ease-in',
        //     '-webkit-transform' : 'scale(1.2)',
        //     '-ms-transition' : 'all 200ms ease-in',
        //     '-ms-transform' : 'scale(1.2)',
        //     '-moz-transition' : 'all 200ms ease-in',
        //     '-moz-transform' : 'scale(1.2)',
        //     'transition' : 'all 200ms ease-in',
        //     'transform': 'scale(1.2)'
        // });
        if($(this).find('video').length){
            $(this).find('video')[0].play()
        }
    }).on('mouseleave','.top-level',  function(){
        //addVideoHoverCss($(this));
        // $(this).find('a.product-hov').css({
        //     '-webkit-transition' : 'all 200ms ease-in',
        //     '-webkit-transform' : 'scale(1.2)',
        //     '-ms-transition' : 'all 200ms ease-in',
        //     '-ms-transform' : 'scale(1.2)',
        //     '-moz-transition' : 'all 200ms ease-in',
        //     '-moz-transform' : 'scale(1.2)',
        //     'transition' : 'all 200ms ease-in',
        //     'transform': 'scale(1.2)'
        // });
        if($(this).find('video').length){
            $(this).find('video')[0].pause()
        }
    });

    $(document).on('touchstart','.product-hover-affect',function() {
        const isIosDevice = isIOS();
        if(!isIosDevice){
            addVideoHoverCss($(this));
            // $(this).find('a.product-hov').css({
            //     '-webkit-transition' : 'all 200ms ease-in',
            //     '-webkit-transform' : 'scale(1.2)',
            //     '-ms-transition' : 'all 200ms ease-in',
            //     '-ms-transform' : 'scale(1.2)',
            //     '-moz-transition' : 'all 200ms ease-in',
            //     '-moz-transform' : 'scale(1.2)',
            //     'transition' : 'all 200ms ease-in',
            //     'transform': 'scale(1.2)'
            // });

            $(this).find('.product-hover-video').css({
                'display': "block",
                'position': "absolute",
                'top': "0",
                "width": "100%",
                "height" : "100%",
                "background" : "#fff"
            });
        
            if($(this).find('video').length){
                $(this).find('video')[0].play()
            }
        }else{
            $(this).find('a.product-hov').removeClass('product-hov');
        }
    })
    // .on('touchend' ,function() {
    //     console.log('touchend');
    //     if($(this).find('video').length){
    //         $(this).find('video')[0].play()
    //     }
    // })


        var page = 1;
        loadMoreData(page);


        $(window).scroll(function() {
            var scroll = $('#scrollFlag').val();
            if (scroll==0 && ($(window).scrollTop() >= parseInt($('#sectionHeight').val()))) {
                var page = $('#pagescroll').val();
                loadMoreData(page);
                $('#scrollFlag').val(1);
            }
        });

        function loadMoreData(page){
            $.ajax(
                {
                    url: '{{url("product/get-product-list")}}?page='+page,
                    type: "post",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'cate_id':'{{$data->id}}',
                        'page':page,
                    },
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    $('#pagescroll').val(data.page.current_page+1);
                    // console.log(data.page.current_page);

                    if(data.html == ""){
                        $('.ajax-load').html("No more products found");
                        return false;
                    }
                    $('.ajax-load').hide();
                    $("#showProductList").append(data.html);
                    $('#sectionHeight').val($( '#showProductList' ).height());
                    $('#scrollFlag').val(0);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                        alert('server not responding...');
                });
        }

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: $(this).attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
@endsection
<!-- Category Listing Wrap end -->
<!-- Section Reviews -->
<div class="container">
	<div class="rating-review-block">
		<div class="owl-carousel owl-theme slider-review">
		@include('front.pages.reviews')
		</div>
	</div>
</div>

@endsection


