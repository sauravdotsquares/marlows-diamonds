@foreach($getProductListFinal as $product)
	<div class="product-grid-items-item">
		<div class="product-items-item-info">
			<div class="product-items-item-image">

				<a href="{{asset('product/'.$product->slug)}}">
					@if(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
						<img src="{{ asset('storage/'.$product->getProductImages->image_url)}}" alt="image">
					@endif
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
			</div>
		</div>
	</div>
@endforeach