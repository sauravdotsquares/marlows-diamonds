@foreach($getProductListFinal as $product)

	<?php $thumbnailGif = getThumbnailGif($product->id); ?>
	<?php 
		$getProductListingPrices = getMinimumPriceFunction($product);
	?>
	<div class="product-grid-items-item {{ $thumbnailGif ? 'product-hover-affect' : '' }}">

		<div class="product-items-item-info">
			<div class="product-item-top">
			<div class="product-onsale">
				<!-- On Sale -->
			</div>
						@php
							$wishlist = session()->get('wishlist', []);
							$wishListClass = "fa-heart-o";
							if(array_key_exists($product->id,$wishlist)){
								$wishListClass = "fa-heart";
							}
						@endphp
						<a href="javascript:void(0);" class="wishlist-heart" id="productWishListRelated{{$product->id}}" data-productslug="{{$product->slug}}"><i class="fa {{$wishListClass}} wishcount" aria-hidden="true"></i></a>
			</div>

			<div class="product-items-item-image">
			
				<a href="{{asset('product/'.$product->slug)}}"  class="{{ $thumbnailGif ? 'product-hov' : '' }}" >
					@if(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
						{{-- <img src="{{ getImageOptimizeDetails('/storage/'.$product->getProductImages->image_url,'217','217')}}" alt="{{$product->title}}" loading="lazy">--}}
						<img src="{{ env('APP_IMAGE_URL').'/storage/'.$product->getProductImages->image_url }}" alt="{{$product->title}}" loading="lazy">
					@endif

					<?php if($thumbnailGif){ ?>
						{{-- <video class="product-hover-video" muted="muted">
							<source src="{{ asset('storage/ProductsVariVideos/R1-143-White_Square-_1651731110.mp4')}}" type="video/mp4">
						  </video> --}}		
						  
						  
						  	<?php if($thumbnailGif->extension == "gif"){ ?>
								<img src="{{ env('APP_IMAGE_URL').'/storage/'.$thumbnailGif->image_url }}" class="product-hover-video" loading="lazy">
						  	<?php }else if($thumbnailGif->extension == "mp4"){ ?>
								{{-- <img class="product-hover-video" src="https://devstaging.marlows-diamonds.co.uk/storage/Products/MTSS-707_00006_1652274814.jpg" alt="{{$product->title}}"> --}}
								{{-- <video class="product-hover-video" muted="muted" playsinline >
									<source src="{{ env('APP_IMAGE_URL').'/storage/'.$thumbnailGif->image_url }}" type="video/mp4">
								</video> --}}
							<?php }else{ ?>
								<img class="product-hover-video" src="{{ env('APP_IMAGE_URL').'/storage/'.$thumbnailGif->image_url }}" alt="{{$product->title}}">
							<?php } ?>
					<?php } ?>
					
				</a>
			</div>
			<div class="product-items-item-details">
				<div class="product-items-item-name">
					<div class="list_product_title">
						<?php 
							$titleSplits = [];
							if(isset($product->title) && !empty($product->title)){
								$titleSplits = explode('|',$product->title);
							}
						?>
						@if(isset($product->slug) && !empty($product->slug))
							<a href="{{asset('product/'.$product->slug)}}" class="title-list-heading">{{isset($titleSplits[0])?mb_convert_case($titleSplits[0], MB_CASE_TITLE, 'UTF-8'):''}}</a>
							@if(isset($titleSplits[1]) && !empty($titleSplits[1]))
								<a href="{{asset('product/'.$product->slug)}}">{{$titleSplits[1]}}</a>
							@endif
						@else
							<a href="#">{{isset($titleSplits[0])?$titleSplits[0]:''}}</a>
							<a href="#">{{isset($titleSplits[1])?$titleSplits[1]:''}}</a>
						@endif
					</div>
					<?php if(!empty($getProductListingPrices) && $getProductListingPrices != 0){ ?>
						<div class="price-section">
							<div style="display: flex;">
								<h4><del style="color:#000" id="shopPrice"></del> </h4>
								<div class="product-finder-price" id="finaldiamondprice"><span class="price">{{MY_CURRENCY_SYMBOL}} {{round(($getProductListingPrices['final_shop_price']),2)}} </span></div>
							</div>
							@if($getProductListingPrices['final_rrp_price'] != $getProductListingPrices['final_shop_price'])
								<p><span style="color:green">You Save : <span id="savePrice">{{MY_CURRENCY_SYMBOL}} {{$getProductListingPrices['final_rrp_price'] - $getProductListingPrices['final_shop_price']}}</span></span> |  <del id="rrpPrice">RRP: {{MY_CURRENCY_SYMBOL}} {{$getProductListingPrices['final_rrp_price']}}</del> </p>
							@endif
						</div>
					<?php } ?> 
				</div>
			</div>
		</div>
	</div>
@endforeach
{!! $getProductListFinal->links() !!}
{{-- 
@if($getAjaxResponses)
	$getProductListFinal->links() 
@endif
--}}