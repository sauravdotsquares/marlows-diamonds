<!-- Best Selling Marlow's Diamond Jewellery start here -->
@php
    $product_data = getFeaturedProducts();
@endphp
@if(count($product_data))
<div class="best-selling-marlows">
    <div class="container">
        <?php 
            $getRoutePath = Request::path();
        ?>
        @if(isset($getRoutePath) && $getRoutePath != 'lab-grown-diamond-engagement-rings')
        <div class="head-para-three">
            <h2 class="heading-h-three">Best Selling Marlow's Diamond Jewellery</h2>
            <p>Explore our collection of engagement rings for women in a variety of shapes and styles.</p>
        </div>
        @endif
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                @foreach($product_data as $key => $product)
                    @if($product->ProductVariationMinMaxPrice->MaxPrice > 0)
                        <div class="item">
                            <div class="product-info">
                                <div class="product-image">
                                    <a href="{{asset('product/'.$product->slug)}}">
                                        @if(isset($product->getProductImages) && !empty($product->getProductImages->thumb_image_url))
                                            <img src="{{ asset('storage/'.$product->getProductImages->thumb_image_url)}}" alt="{{$product->title}}">
                                        @elseif(isset($product->getProductImages) && !empty($product->getProductImages->image_url))
                                            <img src="{{ asset('storage/'.$product->getProductImages->image_url)}}" alt="{{$product->title}}">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-item-details">
                                    <div class="product-titles-small">
                                        <a href="{{asset('product/'.$product->slug)}}"> {{$product->title}}</a>
                                    </div>
                                    <div class="product-price">
                                        {{MY_CURRENCY_SYMBOL}}
                                        {{isset($product->ProductVariationMinMaxPrice->MaxPrice)?$product->ProductVariationMinMaxPrice->MaxPrice:0.00}}
                                    </div>
                                    <div class="product-action-btn">
                                        <a class="btn-bg-small" href="{{asset('product/'.$product->slug)}}">Select Options</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @if(isset($getRoutePath) && $getRoutePath != 'lab-grown-diamond-engagement-rings')
        <div class="text-center">
            <a class="btn-bg-small expdia" href="{{asset('/product-category/engagement-rings')}}">Explore all Diamond Engagement Rings Now</a>
        </div>
        @endif
    </div>
</div>
@endif
<!-- Best Selling Marlow's Diamond Jewellery end here -->
