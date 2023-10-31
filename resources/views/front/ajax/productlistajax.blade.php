@foreach($getProductListFinal as $product)

	<?php $thumbnailGif = getThumbnailGif($product->id); ?>

	<div class="product-grid-items-item {{ $thumbnailGif ? 'product-hover-affect' : '' }}">

		<div class="product-items-item-info">
			<div class="product-item-top">
			<div class="product-onsale">
				<!-- On Sale -->
			</div>
									@php
							$wishlist = session()->get('wishlist', []);
							// dd($wishlist);
							// dump($product->id);
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
						<img src="{{ env('APP_IMAGE_URL').'/storage/'.$product->getProductImages->image_url }}" alt="{{$product->title}}">
					@endif

					<?php if($thumbnailGif){ ?>
						{{-- <video class="product-hover-video" muted="muted">
							<source src="{{ asset('storage/ProductsVariVideos/R1-143-White_Square-_1651731110.mp4')}}" type="video/mp4">
						  </video> --}}		
						  
						  
						  	<?php if($thumbnailGif->extension == "gif"){ ?>
								<img src="{{ env('APP_IMAGE_URL').'/storage/'.$thumbnailGif->image_url }}" class="product-hover-video" >
						  	<?php }else if($thumbnailGif->extension == "mp4"){ ?>
								<video class="product-hover-video" muted="muted" playsinline >
									<source src="{{ env('APP_IMAGE_URL').'/storage/'.$thumbnailGif->image_url }}" type="video/mp4">
								</video>
							<?php } ?>
					<?php } ?>
					
				</a>
			</div>
			<div class="product-items-item-details">
				<div class="product-items-item-name">

					<?php 
						$titleSplits = [];
						if(isset($product->title) && !empty($product->title)){
							$titleSplits = explode('|',$product->title);
						}
					?>
					@if(isset($product->slug) && !empty($product->slug))
						<a href="{{asset('product/'.$product->slug)}}" class="title-list-heading">{{isset($titleSplits[0])?$titleSplits[0]:''}}</a>
						@if(isset($titleSplits[1]) && !empty($titleSplits[1]))
							<a href="{{asset('product/'.$product->slug)}}">{{$titleSplits[1]}}</a>
						@endif
					@else
						<a href="#">{{isset($titleSplits[0])?$titleSplits[0]:''}}</a>
						<a href="#">{{isset($titleSplits[1])?$titleSplits[1]:''}}</a>
					@endif

					 <?php if(!empty($product->ProductVariationMinMaxPrice->MinPrice) && !empty($product->ProductVariationMinMaxPrice->MinPrice) && $product->ProductVariationMinMaxPrice->MinPrice != 0){ ?>
                        <!-- <p> <strong>Price: </strong> <span>  {{MY_CURRENCY_SYMBOL}} {{round(($product->ProductVariationMinMaxPrice->MinPrice),2)}} </span> </p> -->
					<?php } ?> 
				</div>
			</div>
		</div>
	</div>
@endforeach
@if($getAjaxResponses)
	{{ $getProductListFinal->links() }}
@endif