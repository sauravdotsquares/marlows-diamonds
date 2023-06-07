@foreach($getProductListFinal as $product)

	<?php $thumbnailGif = getThumbnailGif($product->id); ?>

	<div class="product-grid-items-item {{ $thumbnailGif ? 'product-hover-affect' : '' }}">
		<div class="product-items-item-info">
			<div class="product-items-item-image">
				
				<a href="{{asset('product/'.$product->slug)}}"  class="{{ $thumbnailGif ? 'product-hov' : '' }}" >
					@if(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
						<img src="{{ asset('storage/'.$product->getProductImages->image_url)}}" alt="{{$product->title}}">
					@endif

					<?php if($thumbnailGif){ ?>
						{{-- <video class="product-hover-video" muted="muted">
							<source src="{{ asset('storage/ProductsVariVideos/R1-143-White_Square-_1651731110.mp4')}}" type="video/mp4">
						  </video> --}}

						  
						  	<?php if($thumbnailGif->extension == "gif"){ ?>
						  		<img src="{{ asset('storage/' . $thumbnailGif->image_url )}}" class="product-hover-video" >
						  	<?php }else if($thumbnailGif->extension == "mp4"){ ?>
								<video class="product-hover-video" muted="muted" playsinline >
									<source src="{{ asset('storage/'.  $thumbnailGif->image_url)}}" type="video/mp4">
								</video>
							<?php } ?>
					<?php } ?>

				</a>
			</div>
			<div class="product-items-item-details">
				<div class="product-items-item-name">
					@if(isset($product->slug) && !empty($product->slug))
						<a href="{{asset('product/'.$product->slug)}}">{{isset($product->title)?$product->title:''}}</a>
					@else
						<a href="#">{{isset($product->title)?$product->title:''}}</a>
					@endif

					<!-- <?php //if(!empty($product->ProductVariationMinMaxPrice->MinPrice) && !empty($product->ProductVariationMinMaxPrice->MinPrice) && $product->ProductVariationMinMaxPrice->MinPrice != 0){ ?>
                        <p> <strong>Price</strong> <span>  {{MY_CURRENCY_SYMBOL}} {{round(($product->ProductVariationMinMaxPrice->MinPrice),2)}} </span> </p>
					<?php //} ?> -->
				</div>
			</div>
		</div>
	</div>
@endforeach
@if($getAjaxResponses)
	{{ $getProductListFinal->links() }}
@endif