<!-- Choose Your Diamond Engagement ring from Marlow's  -->
@php
    $product_data = getFeaturedProducts();
@endphp
@if(count($product_data))

<div class="best-selling-marlows">
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three">Diamond Engagement Rings by Marlow's</h2>
            <p>Explore a variety of designs and settings from a classic solitaire to trilogy</p>
        </div>
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                @foreach($product_data as $key => $product)
                @if($product->title != 'SADIE - 2 Rows Round Cut Diamond Wedding Ring')
                    <?php
                        // $getProductListingPrices = getMinimumPriceFunction($product);
                        $getProductListingPrices = $product->getMinimumPriceFunction;

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
                                                    <h4><del style="color:#000" class="shopPriceval" id="shopPrice"> {{config('constants.MY_CURRENCY_SYMBOL')}} {{sprintf('%0.2f', $getProductListingPrices['final_shop_price'])}}</del> </h4>
                                                    @endif

                                                    <div class="product-finder-price" id="finaldiamondprice"><span class="price">{{config('constants.MY_CURRENCY_SYMBOL')}} {{sprintf('%0.2f', $getProductListingPrices['final_discounted_price'])}} </span></div>
                                                </div>
                                                @if($getProductListingPrices['final_rrp_price'] != $getProductListingPrices['final_discounted_price'])
                                                    <p><span style="color:green">You Save : <span id="savePrice">{{config('constants.MY_CURRENCY_SYMBOL')}} {{ sprintf('%0.2f', $getProductListingPrices['final_rrp_price'] - $getProductListingPrices['final_discounted_price']) }}</span></span> |  <del id="rrpPrice">RRP: {{config('constants.MY_CURRENCY_SYMBOL')}} {{ sprintf('%0.2f', $getProductListingPrices['final_rrp_price']) }}</del> </p>
                                                @endif
                                        <?php } ?>
                                    </div>
                                   <!--  <div class="product-action-btn">
                                        <a class="btn-bg-small" href="{{asset('product/'.$product->slug)}}">Select Options</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="text-center">
            <a class="btn-bg-small expdia" href="{{asset('/engagement-rings')}}">All Diamond Engagement Rings</a>
        </div>
    </div>
</div>
@endif
<!-- Choose Your Diamond Engagement ring from Marlow's  -->
