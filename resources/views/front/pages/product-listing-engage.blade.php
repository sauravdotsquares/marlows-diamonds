@extends('layouts.front.app')
@section('content')

<!-- header banner start -->
<div class="category-banner engagement-banner" style="background-image:url({{asset('storage/'.$data1->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{!!isset($data->subtitle)?$data->subtitle:"Engagement Rings"!!}</h1>
			<p>{!!(isset($data->short_description) && !empty($data->short_description))?$data->short_description:"Getting engaged is one of the most special and memorable moments of one's life."!!}</p>
			<div class="ring-pr-shop-btn">
				<a class="btn-bg-small" href="{{asset('/product-category/engagement-rings')}}">Shop Now</a>
			</div>
		</div>
	</div>
</div>
<!-- header banner end -->

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
                    <img src="{{asset('assets/images/spinner-ring.gif')}}"><p>Loading More Products</p>
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
                            <div class="side-cart-item">
                                <div class="cart-image-item">
                                    @if(isset($details['selected_parameter']['imagelink']) && !empty($details['selected_parameter']['imagelink']))
                                        <img src="{{$details['selected_parameter']['imagelink']}}" width="100" height="100"
                                        class="img-responsive" />
                                    @elseif(isset($details['image']) && !empty($details['image']))
                                        <img src="{{asset('storage/'.$details['image'])}}" width="100" height="100"
                                        class="img-responsive" />
                                    @else
                                        <img src="https://www.marlows-diamonds.co.uk/wp-content/uploads/2019/07/MarlowsDiamonds-Logo-225x107.png" width="100" height="100" class="img-responsive" />
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
                                    <strong>Subtotal: </strong> {{MY_CURRENCY_SYMBOL}}{{ number_format($details['price'] * $details['quantity'],2) }} (incl. VAT)
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

<!-- CHoose a dreamy start here-->
<div class="choosedreamy-wrap">
	<div class="container">
		<div class="head-para-three">
			<h2 class="heading-h-three">Choose A Dreamy Setting for Your Engagement Ring</h2>
		</div>
		<div class="rings-grid-wrap">
			<div class="row">
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/product-category/engagement-rings/solitaire/"><img src="{{asset('')}}assets/images/CR10-SE45_0003.jpg" alt="ring"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								SOLITAIRE ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Solitaire rings are classics for a reason. Their single stone setting exudes beauty like no other with a jaw-dropping centrepiece. This is the best of all diamond engagement rings if you want a flashy simple design.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/product-category/engagement-rings/solitaire/">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/product-category/engagement-rings/halo/"><img src="{{asset('')}}assets/images/DSR21-Images_0003.jpg" alt="ring"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								HALO ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Halo rings are solitaires made better! Complimented by a halo of smaller diamonds, the centre stone looks gorgeous in every way. If you love solitaires but want something extra, then this is the diamond ring for you.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/product-category/engagement-rings/halo/">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/product-category/engagement-rings/shoulder-set/"><img src="{{asset('')}}assets/images/CX9-SL28_00003-1.jpg" alt="ring"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								SHOULDER SET ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Want more sparkle? Go for shoulder set rings with a band of encrusted diamonds that make your ring all the more special. A dazzling solitaire with little diamonds along the way can make all the difference.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/product-category/engagement-rings/shoulder-set/">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/product-category/engagement-rings/multi-stone/"><img src="{{asset('')}}assets/images/R3-143_0003.jpg" alt="ring"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								MULTI-STONE ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Why stop at one when you can have many? Make a statement with diamond engagement rings in multi-stone settings. Unique styles and combinations are waiting for you.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/product-category/engagement-rings/multi-stone/">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>



<!-- CHoose a dreamy end here-->

<!-- Banner Text Section-->
<div class="findmatch-wrap">
	<div class="container">
		<div class="leftright-img-text-wraper">
			<div class="leftright-imt-rows flexed flex-flex-wrap flex-items-center">
				<div class="leftright-imt-col leftright-img">
					<img src="{{asset('')}}assets/images/banner-hand.jpg" alt="banner-hand">
				</div>
				<div class="leftright-imt-col leftright-text">
					<div class="leftright-heading heading-h-three">
						Find Your Perfect Match
					</div>
					<p>You found your perfect match so the engagement ring you propose with should also be a perfect match for your partner. Marlow’s Diamonds brings to you a curated assortment of diamond engagement rings in the most beautiful designs, stone settings, diamonds shapes, and ring sizes.</p>
					<p>Why us? Because our diamonds are as special as your relationship. Our engagement rings are made only with ethically sourced diamonds. With us, you can be assured of quality because our diamonds are graded by the GIA. Adorning our sparkling stones will bring you joy and warmth for the rest of your lives.</p>
					<div class="viewguide-btn">
							<a class="btn-bg-small" href="/product-category/engagement-rings/shoulder-set/">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Best Selling Marlow's Diamond Jewellery start here -->
@include('front.includes.featuredproduct')
<!-- Best Selling Marlow's Diamond Jewellery end here -->

<!-- two banner section end -->

<!-- Your Journery of a lifetime start here start-->
<div class="journery-life-wraper">
	<div class="container">
	{!! isset($data->description)?$data->description:"" !!}


	</div>
</div>
<!-- Your Journery of a lifetime start here end-->


<!-- FAQ Section start here -->
<div class="faq-section engagement-ring-faq">
	<div class="container">
		<div class="head-para-three">
			<div class="heading-h-three">
				Engagement Ring FAQ’s
			</div>
			<p>Some of the most common Engagement Ring Q&A's</p>
		</div>
            <div class="faq-list">
                <div class="accordion" id="accordionExample">
                    @php
                        $getEngagementFaqs = getEngagementFaqs(8);
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

<!-- FAQ Section end here -->

<!-- Section Reviews -->
<div class="container">
<div class="rating-review-block">
				<div class="owl-carousel owl-theme slider-review">
				@include('front.pages.reviews')
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
@include('front.includes.instagram-section')
@endsection


