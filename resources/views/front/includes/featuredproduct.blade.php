<!-- Best Selling Marlow's Diamond Jewellery start here -->
@php
    $product_data = getAllCategoryProducts();
@endphp
@if(count($product_data))

<div class="best-selling-marlows marlow-best-selling">
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three">Best Selling Marlow's Diamond Jewellery</h2>
            <p>Diamond are more than just jewellery. We understand the symbolism that they represent. So that they can withstand the test of time our diamond jewellery is certified by the GIA, so they provide quality and longevity.</p>
        </div>
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                @foreach($product_data as $key => $product)
                    <?php 
                        $getProductListingPrices = getMinimumPriceFunction($product);
                    ?>
                    {{--@if($product->ProductVariationMinMaxPrice->MaxPrice > 0) --}}
                        <div class="item">
                            <div class="product-info">
                                <div class="product-image">
                                    <a href="{{asset('product/'.$product->slug)}}">
                                        @if(isset($product->getProductImages) && !empty($product->getProductImages->thumb_image_url))
                                            <img src="{{ env('APP_IMAGE_URL').'/storage/'.$product->getProductImages->thumb_image_url }}" alt="{{$product->title}}">
                                        @elseif(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
                                            <img src="{{ env('APP_IMAGE_URL').'/storage/'.$product->getProductImages->image_url }}" alt="{{$product->title}}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-item-details">
                                    <div class="product-titles-small">
                                        <a href="{{asset('product/'.$product->slug)}}">
                                            {{$product->title}}
                                        </a>
                                    </div>
                                    <div class="price-section">
                                        <?php if(!empty($getProductListingPrices['final_shop_price']) && $getProductListingPrices['final_shop_price'] != 0.0){ ?>
                                                <div style="display: flex;">
                                                    <!-- <h4><del style="color:#000" id="shopPrice"></del> </h4> -->
                                                    @if($getProductListingPrices['final_discounted_price'] != $getProductListingPrices['final_shop_price'])
                                                    <h4><del style="color:#000" class="shopPriceval" id="shopPrice"> {{MY_CURRENCY_SYMBOL}} {{ sprintf('%0.2f', $getProductListingPrices['final_shop_price'])}}</del> </h4>
                                                    @endif
                                                    
                                                    <div class="product-finder-price" id="finaldiamondprice"><span class="price">{{MY_CURRENCY_SYMBOL}} {{ sprintf('%0.2f', $getProductListingPrices['final_discounted_price'])}} </span></div>
                                                </div>
                                                @if($getProductListingPrices['final_rrp_price'] != $getProductListingPrices['final_discounted_price'])
                                                    <p><span style="color:green">You Save : <span id="savePrice">{{MY_CURRENCY_SYMBOL}} {{sprintf('%0.2f', $getProductListingPrices['final_rrp_price'] - $getProductListingPrices['final_discounted_price']) }}</span></span> |  <del id="rrpPrice">RRP: {{MY_CURRENCY_SYMBOL}} {{ sprintf('%0.2f', $getProductListingPrices['final_rrp_price'])}}</del> </p>
                                                @endif
                                        <?php } ?> 
                                    </div>
                                   <!--  <div class="product-action-btn">
                                        <a class="btn-bg-small" href="{{asset('product/'.$product->slug)}}">Select Options</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                @endforeach
            </div>
        </div>
       <!--  <div class="text-center">
            <a class="btn-bg-small expdia" href="{{asset('/diamond-engagement-rings')}}">Explore all Diamond Engagement Rings Now</a>
        </div> -->
    </div>
</div>
@endif
<!-- Best Selling Marlow's Diamond Jewellery end here -->
