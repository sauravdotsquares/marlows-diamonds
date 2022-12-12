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

	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> --}}
	<link rel="stylesheet" href="{{ asset('assets/vendors/toastr/build/toastr.min.css') }}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css" rel="stylesheet" />

@endsection



@section('content')

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">

			{{-- Product images or videos --}}
			<div class="product-info-media">
                <div id="carousel" class="owl-carousel">
                    @if($product->images)
                        @foreach($product->images as $images)
                            <div class="item">
                                <a data-fancybox="gallery{{$images->id}}" href="{{asset('/uploads/'.$images->image)}}" data-caption="{{isset($product->title)?$product->title:''}}">
                                    <img src="{{asset('/uploads/'.$images->image)}}" alt="{{isset($product->title)?$product->title:''}}">
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
			</div>

			{{-- Product detail --}}
			<div class="product-info-main">
				<div class="product-title-name">
					<h1>{{isset($product->title)?$product->title:''}}</h1>
				</div>
				{!! $varitaions_html !!}
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
						<a href="javascript:void(0);" class="wishlist-button" id="productWishList">
							<i class="fa {{$wishListClass}}" id="wishlist_icon" aria-hidden="true"></i>
						</a>
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
	const csrf = "{{ csrf_token() }}";
	const addToWishlistUrl = "{{ route('wishlist.wishlist_add') }}";
	const productSlug = '{{  $product->slug }}';
</script>

<script src="{{ asset('assets/vendors/toastr/build/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/custom/product_details.js') }}"></script>
<script>
$(document).ready(function() {
    var $owl = $('#carousel'); 
	var uniqueId  = null;
	const imageBaseUrl = "{{asset('/uploads/')}}/";

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

	getProductPrice();
	function getProductPrice() {
		$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending... </span>');
		const ids = getSelectedAttributeIds();
		// var ids = [];
		// $('.attr-selection').each((index,element)=>{
		// 	if($(element).attr('type') == 'radio'){
		// 		if($(element).is(':checked')){
		// 			ids.push($(element).val());
		// 		}
		// 	}else{
		// 		ids.push($(element).val());
		// 	}			
		// });
		$.ajax({
			url: '{{ route("app_products.price") }}',
			type: "post",
			data: {
				'_token': "{{csrf_token()}}",
				'productSlug':'{{  $product->slug }}',
				'varitaion' : ids.join(',')
			},
			beforeSend: function(){
				$('.ajax-load').show();
			},
			success: function(data) {
				if(data.status){

					if(data.price.price_after_combination == data.price.price_after_discount){
						// If discounted price and main price are same
						$('#finaldiamondprice').html('<span class="price"> {{MY_CURRENCY_SYMBOL}} '+data.price.price_after_discount+' </span>');
					}else{
						$('#finaldiamondprice').html('<del>{{MY_CURRENCY_SYMBOL}} '+data.price.price_after_combination+'</del> <span class="price" > {{MY_CURRENCY_SYMBOL}} '+data.price.price_after_discount+' </span>');
					}


					if(typeof data.image!='undefined' && data.image && typeof data.image.image!='undefined' && data.image.image){
						const imagesExtension = ['jpg','png','jpeg','webp'];
						const extension = data.image.extension;
						if(imagesExtension.includes(extension)){

							const carouselItem = `<div class="item custom-item-carousel">
                                <a data-fancybox="product_gallery" href="${imageBaseUrl + data.image.image }" data-caption="${data.image.original_name}">
                                    <img src="${imageBaseUrl + data.image.image }" alt="${data.image.original_name}">
                                </a>
                            </div>`;

							$('#carousel').find('.owl-item').each((index, element)=>{
								if($(element).find('.custom-item-carousel').length){
									$('#carousel').trigger('remove.owl.carousel',index);
								}
							});

							const pendingItems = $owl.find('.owl-item');
							$owl
							.trigger('add.owl.carousel', [carouselItem])
							.trigger('refresh.owl.carousel')
							.trigger('to.owl.carousel', [pendingItems.length, 0])
							.trigger('refresh.owl.carousel')
							.trigger('stop.owl.autoplay')
							.trigger('play.owl.autoplay',[7000, 300])

						}else{
							console.log('File is video');
						}
					}else{
						console.log('Image not found');
					}


				}else{
					// alert(data.message);
				}
			},
			error: function(params) {
				
			}
		})
	}

	/** get price */
	$(document).on('change','.attr-selection',function(e){
		getProductPrice();
	});
	

});

</script>

@endsection