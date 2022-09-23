@foreach($getProductListFinal as $product)


	<div class="product-grid-items-item {{ $product->slug == "aaliyah" ? 'product-hover-affect' : '' }}">
		<div class="product-items-item-info">
			<div class="product-items-item-image">
				<a href="{{asset('product/'.$product->slug)}}"  class="{{ $product->slug == "aaliyah" ? 'product-hov' : '' }}" >
					@if(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
						<img src="{{ asset('storage/'.$product->getProductImages->image_url)}}" alt="{{$product->title}}">
					@endif

					<?php if($product->slug == "aaliyah"){ ?>
						<video class="product-hover-video" muted="muted">
							<source src="{{ asset('storage/ProductsVariVideos/R1-143-White_Square-_1651731110.mp4')}}" type="video/mp4">
						  </video>						  
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
				</div>
                {{-- <div class="product-price">
                    {{MY_CURRENCY_SYMBOL}} {{$product->ProductVariationMinMaxPrice->MaxPrice}}
                </div> --}}
			</div>
		</div>
	</div>
@endforeach
