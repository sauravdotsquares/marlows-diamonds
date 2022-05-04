@if(isset($getSearchedData) && count($getSearchedData))
@foreach($getSearchedData as $key => $product)
<?php 
    // echo "in ythe ajax files in foreachj <pre>";
    // print_r($product->ProductVariationMinMaxPrice);
    // die;

?>
<div class="search-suggestion-list">
    <a href="{{asset('product/'.$product->slug)}}">
        <div class="search-suggestion-img">
            @if(isset($product->getProductImages->image_url) && !empty($product->getProductImages->image_url))
                <img src="{{ asset('storage/'.$product->getProductImages->image_url)}}" alt="img">
            @else
                <img src="" alt="img">
            @endif
        </div>
        <div class="search-suggestion-text">
            <div class="search-suggestion-title">
                {{isset($product->title)?$product->title:''}}
            </div>
            <div class="search-suggestion-price">
                @if(isset($product->ProductVariationMinMaxPrice) && $product->ProductVariationMinMaxPrice->MinPrice == $product->ProductVariationMinMaxPrice->MaxPrice)
                <span>{{MY_CURRENCY_SYMBOL}} {{$product->ProductVariationMinMaxPrice->MinPrice}}</span>
                @else
                <span>{{MY_CURRENCY_SYMBOL}} {{$product->ProductVariationMinMaxPrice->MinPrice}}</span>
                    -
                <span>{{MY_CURRENCY_SYMBOL}} {{$product->ProductVariationMinMaxPrice->MaxPrice}}</span>
                @endif
            </div>

        </div>
    </a>
</div>
@endforeach
@else
    <p>No results </p>
@endif