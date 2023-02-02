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
								<video class="product-hover-video" muted="muted">
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
					
					<?php if(!empty($product->minimumValue) && !empty($product->maximumValue)){ ?>
						<p> <strong>Price</strong> <span>  £{{$product->minimumValue}} - £{{$product->maximumValue}} </span> </p>
					<?php } ?>

				</div>
                {{-- <div class="product-price">
                    {{MY_CURRENCY_SYMBOL}} {{$product->ProductVariationMinMaxPrice->MaxPrice}}
                </div> --}}
			</div>
		</div>
	</div>
@endforeach
