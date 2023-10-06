@foreach($getProductListFinal as $product)
<div class="item">
    <div class="product-grid-item">
        <div class="product-items-item-info">
            <div class="product-items-item-image">
                <a href="{{asset('product/'.$product->slug)}}">
                    @if(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
                        <img src="{{ env('APP_IMAGE_URL').'/storage/'.$product->getProductImages->image_url }}" alt="{{$product->title}}">
                    @endif
                </a>
            </div>
            <div class="product-items-item-details">
                <div class="product-items-item-name">
                    <a href="{{asset('product/'.$product->slug)}}">{{isset($product->title)?$product->title:''}}</a>
                </div>
                <div class="product-price">
                    {{MY_CURRENCY_SYMBOL}}
                    {{$product->ProductVariationMinMaxPrice->MinPrice}}-{{$product->ProductVariationMinMaxPrice->MaxPrice}}
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
