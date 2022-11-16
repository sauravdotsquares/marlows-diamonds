@extends('layouts.front.app')

@section('css')
	<style>
		.thumbnail {position: relative;padding: 0px;margin-bottom: 20px;}
		.thumbnail img {width: 80%;}
		.thumbnail .caption{margin: 7px;}
		.main-section{background-color: #F8F8F8;}
		.dropdown{float:right;padding-right: 30px;}
		.btn{border:0px;margin:10px 0px;box-shadow:none !important;}
		.dropdown .dropdown-menu{padding:20px;top:30px !important;width:350px !important;left:-110px !important;box-shadow:0px 5px 30px black;}
		.total-header-section{border-bottom:1px solid #d2d2d2;}
		.total-section p{margin-bottom:20px;}
		.cart-detail{padding:15px 0px;}
		.cart-detail-img img{width:100%;height:100%;padding-left:15px;}
		.cart-detail-product p{margin:0px;color:#000;font-weight:500;}
		.cart-detail .price{font-size:12px;margin-right:10px;font-weight:500;}
		.cart-detail .count{color:#C2C2DC;}
		.checkout{border-top:1px solid #d2d2d2;padding-top: 15px;}
		.checkout .btn-primary{border-radius:50px;height:50px;}
		.dropdown-menu:before{content: " ";position:absolute;top:-20px;right:50px;border:10px solid transparent;border-bottom-color:#fff;}
		.disabledAnchor a{pointer-events: none !important;cursor: default;color:white;}span.price-not-found {font-size: 14px;color: #8e2e65;font-weight: bold;}
		.error {color: #e74c3c !important;}div#finaldiamondprice del {font-size: 20px;}
	</style>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css" rel="stylesheet" />

@endsection



@section('content')

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">

			<div class="product-info-media">
				
                <div id="carousel" class="owl-carousel">
                    @if($product->images)
                        @foreach($product->images as $images)
                            <div class="item">
                                <a data-fancybox="gallery2" href="{{asset('/uploads/'.$images->image)}}" data-caption="{{isset($product->title)?$product->title:''}}">
                                    <img src="{{asset('/uploads/'.$images->image)}}" alt="{{isset($product->title)?$product->title:''}}">
                                </a>
                            </div>
                        @endforeach
                    @endif

                    {{-- @if(isset($prodImages) && $prodImages)
                        @foreach($prodImages as $images)
                            @if(isset($images->image_url) && !empty($images->image_url))
                                @php
                                    $explode = explode('/',$images->image_url);
                                    $explode1 = explode('.',$explode[1]);
                                @endphp
                                @if(isset($images->is_featured) && $images->is_featured != 1)
                                    <div class="item">
                                        <a data-fancybox="gallery2" href="{{asset('/storage/'.$images->image_url)}}" data-caption="{{$explode1[0]}}">
                                            <img src="{{asset('/storage/'.$images->image_url)}}" alt="{{isset($data->title)?$data->title:''}}">
                                        </a>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif --}}
                </div>
                
			</div>

			<div class="product-info-main">
				<div class="product-title-name">
					<h1>{{isset($product->title)?$product->title:''}}</h1>
				</div>

				{{-- @if($plainband==false) --}}
					<div class="diamond-type">
						<label>Choose Your Diamond</label>
						@if(isset($requestData["diamond_type"]) && $requestData["diamond_type"] == 'mined')
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond"  checked value="mined">
								<span>Mined Diamond</span>
							</div>
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond" value="lab_grown">
								<span>Lab Grown Diamond</span>
							</div>
						@else
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond" value="mined">
								<span>Mined Diamond</span>
							</div>
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond" checked value="lab_grown">
								<span>Lab Grown Diamond</span>
							</div>
						@endif
					</div>
				{{-- @endif --}}

				<div class="product-type-variations" id="filterDataDesign">
					<div class="type-variations-row">
					</div>
				</div>

				<div id="apiCustomDesign"></div>

				<div class="product-decriptions">
					{!! $product->description!!}
				</div>
                <div class="product-finder-price"  id="discountedTotalPrice">
                </div>
                <div class="product-finder-price" id="finaldiamondprice">
				</div>

				<input type="hidden" name="selected_variation_price" id="selected_variation_price" value="{{isset($product->getProductVariation[0]->regular_price)?$product->getProductVariation[0]->regular_price:0.00}}">
                <input type="hidden" name="selected_discounted_price" id="selected_discounted_price" value="0.00">
				<input type="hidden" name="selected_diamond_price" id="selected_diamond_price" value="0.00">
				<input type="hidden" name="selected_final_price" id="selected_final_price" value="0.00">

				<div class="product-add-cart">
					<div class="product-to-wishlist">
						@php
							$wishlist = session()->get('wishlist', []);
							$wishListClass = "fa-heart-o";
							if(array_key_exists($product->id,$wishlist)){
								$wishListClass = "fa-heart";
							}
						@endphp
						<a href="javascript:void(0);" id="productWishList"><i class="fa {{$wishListClass}} wishcount" aria-hidden="true"></i></a>
					</div>

					<div class="product-to-basket">

						<a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to basket</a>
					</div>
					<div class="product-req-appointment">
						<a type="button" class="btn-bg-small" data-bs-toggle="modal" data-bs-target="#requestAppointment">
						Request an Appointment
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection

@section('js')
<script>
$(document).ready(function() {
    var $owl = $('#carousel');

    $owl.children().each( function( index ) {
        $(this).attr( 'data-position', index );
    });
    $owl.owlCarousel({
        autoplay: true,
        rewind: true, 
        responsiveClass: true,
        autoplayTimeout: 7000,
        smartSpeed: 300,
        nav: true,
        items : 1,
    });

    $(document).on('click','.product-gallery__trigger',function(e){
        e.preventDefault();
        $('#carousel-zoom .item:first-child a').click();
    });
});

</script>

@endsection