@extends('layouts.front.app')
@section('content')

<?php 

    // echo "checking<pre>";
    // print_r($getProduct);
    // die;

?>

<!-- category header banner start -->
<div class="category-banner" style="background-image:url({{asset('')}}assets/images/engagement-rings-banner.png)">
    <div class="container">
        <div class="category-banner-text">
            <h1>{{isset($data->name)?$data->name:''}}</h1>
            <!-- <h2>AVAILABLE IN A VARIETY OF CUTS AND STYLES</h2> -->
            {!! isset($data->description)?$data->description:'' !!}
        </div>
    </div>
</div>
<!-- category header banner end -->

<!-- Category Listing Wrap Start -->
<div class="category-listing-wrap" ng-controller="ProductController">
    <div class="container"  ng-init="productCatFilters('{{$cat1}}','{{$cat2}}','{{$cat3}}')">
        <div class="category-listing-row">
            <div class="category-list-wrap">
                <div class="category-product-filter flexed flex-flex-wrap <%showsubCatOnly%>">
                    <div class="product-filter-col" ng-if="subCats.length>0">
                        <div class="pr-filter-title">
                            Ring Style
                        </div>
                        <div class="filter-tags-row flexed flex-flex-wrap ">
                            <div class="filter-tags-col <%subCat.active_status%>" ng-repeat="subCat in subCats">
                                <div class="category-product-filter-icon">
                                    <a href="<%subCat.url%>"><img src="{{asset('storage')}}<%subCat.hover_icon%>" alt="icon"></a>
                                </div>
                                <div class="category-product-filter-text">
                                    <a href="<%subCat.url%>"><%subCat.name%></a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="product-filter-col"  ng-if="subSubCats.length>0">
                        <div class="pr-filter-title">
                            Diamond Cut
                        </div>
                        <div class="filter-tags-row flexed flex-flex-wrap cols-ryt-tags">
                            <div class="filter-tags-col <%subSubCat.active_status%>"  ng-repeat="subSubCat in subSubCats">
                                <div class="category-product-filter-icon">
                                    <a href="<%subSubCat.url%>"><img src="{{asset('storage')}}<%subCat.hover_icon%>" alt="icon"></a>
                                </div>
                                <div class="category-product-filter-text">
                                    <a href="<%subSubCat.url%>"><%subSubCat.name%> </a>
                                </div>
                            </div>
                            


                        </div>

                    </div>

                </div>

                <!-- Category listing -->
                <div class="product-grid-wrap">
                    <div class="product-grid-row flexed flex-flex-wrap" id="showProductList">
                        <!-- <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/R1-143_0003-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">AALIYAH | Four Claw split shoulder Solitaire Diamond Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/MTSS-707_00003-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">ABBIE | Marquise shape solitaire Diamond Engagement Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item ">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/R1-1027_0003-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">ADDISON | Slim Twist Set Diamond Engagement Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/R1-241-Images_0003-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">ALEXA | Four Claw thin set Diamond Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/CX28-AS9_0003-1-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">AMAYA | Princess cut Knife Edge Set Engagement Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/MTSS-710_00003-1-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">AMBER | Heart shape knife edge Straight edge Solitaire Engagement
                                            Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/MTSS-652_00003-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">ANNIE | Slim set Emerald Cut Engagement Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-grid-items-item">
                            <div class="product-items-item-info">
                                <div class="product-items-item-image">
                                    <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}"><img src="{{asset('')}}assets/images/R1-174_0003-225x225.jpg" alt="image"></a>
                                </div>
                                <div class="product-items-item-details">
                                    <div class="product-items-item-name">
                                        <a href="{{asset('product/phoenix-wide-band-princess-cut-solitaire-ring-2')}}">ARIANA | NSEW Taper Set Solitaire Diamond Ring</a>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="ajax-load text-center" style="display:block">
                    <img src="{{asset('assets/images/spinner-ring.gif')}}"><p>Loading More post</p>
                </div>

            </div>

            <!-- Category SIdebar start -->
            <div class="category-sidebar-wrap">
                @if(session('cart'))
                <div class="sidebar-main-cart">
                    <div class="sidebar-title">
                        Shopping Cart
                    </div>
                    <div class="side-cart-row">
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="side-cart-item">
                                <div class="side-cart-delete">
                                    <a href="javascript:void(0);" data-id="{{ $id }}" class="remove-from-cart">x</a>
                                </div>

                                <div class="side-cart-pr-name">
                                    {!! $details['name'] !!}
                                </div>
                                <div class="side-cart-quantity">
                                    {{ $details['quantity'] }} ×
                                    <span class="side-cart-amount">{{MY_CURRENCY_SYMBOL}}{{ number_format($details['price'],2) }}</span>
                                </div>
                                <div class="side-cart-total">
                                    <strong>Subtotal: </strong> {{MY_CURRENCY_SYMBOL}}{{ number_format($details['price'] * $details['quantity'],2) }} (incl. VAT)
                                </div>
                                <div class="side-cart-actions">
                                    <a class="view-basket btn-bg-small" href="{{route('product.cart')}}">View Basket</a>
                                    <a class="btn-bg-small" href="{{route('product.checkout')}}">Checkout</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="side-recentlyview">
                    <div class="sidebar-title">
                        Recently Viewed
                    </div>
                    <div class="side-recently-item">
                        <div class="side-recently-col">
                            <a class="side-recently-pr-name" href="#">BRIE | Marquise shape Halo and shoulder channel
                                set Engagement Ring</a>
                            <a class="side-recently-pr-img" href="#"><img src="{{asset('')}}assets/images/RC2019B_00003-225x225.jpg"
                                    alt="image"></a>
                        </div>
                        <div class="side-recently-col">
                            <a class="side-recently-pr-name" href="#">CARMEN | Pear shape solitiare Diamond Engagement
                                Ring</a>
                            <a class="side-recently-pr-img" href="#"><img src="{{asset('')}}assets/images/RC2019B_00003-225x225.jpg"
                                    alt="image"></a>
                        </div>
                        <div class="side-recently-col">
                            <a class="side-recently-pr-name" href="#">AURORA | NSEW Thin band Petite Diamond Ring</a>
                            <a class="side-recently-pr-img" href="#"><img src="{{asset('')}}assets/images/RC2019B_00003-225x225.jpg"
                                    alt="image"></a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Category SIdebar end -->
        </div>

    </div>
</div>
<!-- Category Listing Wrap end -->


<!-- Section Reviews -->
<div class="container">
    <div class="rating-review-block">
        <div class="owl-carousel owl-theme slider-review">
            <div class="item">
                <div class="reviews-cont">
                    <div class="reviewr-name">
                        Sana Anwar
                    </div>
                    <div class="reviewr-star">
                        <img src="{{asset('')}}assets/images/stars.png" alt="star">
                    </div>
                    <div class="reviewr-review-text">
                        I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                        bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                        The staff are friendly and...<a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="reviews-cont">
                    <div class="reviewr-name">
                        Sana Anwar
                    </div>
                    <div class="reviewr-star">
                        <img src="{{asset('')}}assets/images/stars.png" alt="star">
                    </div>
                    <div class="reviewr-review-text">
                        I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                        bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                        The staff are friendly and...<a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="reviews-cont">
                    <div class="reviewr-name">
                        Sana Anwar
                    </div>
                    <div class="reviewr-star">
                        <img src="{{asset('')}}assets/images/stars.png" alt="star">
                    </div>
                    <div class="reviewr-review-text">
                        I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                        bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                        The staff are friendly and...<a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="reviews-cont">
                    <div class="reviewr-name">
                        Sana Anwar
                    </div>
                    <div class="reviewr-star">
                        <img src="{{asset('')}}assets/images/stars.png" alt="star">
                    </div>
                    <div class="reviewr-review-text">
                        I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                        bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                        The staff are friendly and...<a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="reviews-cont">
                    <div class="reviewr-name">
                        Sana Anwar
                    </div>
                    <div class="reviewr-star">
                        <img src="{{asset('')}}assets/images/stars.png" alt="star">
                    </div>
                    <div class="reviewr-review-text">
                        I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                        bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                        The staff are friendly and...<a href="#">Read More</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<input type="hidden" id="pagescroll" value="1">

@endsection

@section('js')
    <script type="text/javascript">
        loadMoreData(page);
        var page = $('#pagescroll').val();
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                var page = $('#pagescroll').val();
                loadMoreData(page);
            }
        });

        function loadMoreData(page){
            $.ajax(
                {
                    url: '{{url("product/get-product-list")}}?page='+page,
                    type: "post",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'cate_id':'{{$data->id}}',
                        'page':page,
                    },
                    beforeSend: function()
                    {
                        $('.ajax-load').show();
                    }
                })
                .done(function(data)
                {
                    $('#pagescroll').val(data.page.current_page+1);
                    // console.log(data.page.current_page);

                    if(data.html == ""){
                        $('.ajax-load').html("No more products found");
                        return false;
                    }
                    $('.ajax-load').hide();
                    $("#showProductList").append(data.html);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError)
                {
                        alert('server not responding...');
                });
        }

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
    
            var ele = $(this);
    
            if(confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: $(this).attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>

    <script>
        // $(document).ready(function(){
        //     getProductList();
        // });

        // function getProductList(){
        //     console.log("Checking list");
        //     $.ajax({
        //         type: 'POST',
        //         url: '',
        //         data: {
        //             '_token': "{{csrf_token()}}",
        //         },
        //         success: function (res) {
        //             console.log(res);
        //             return false;
        //             // if (res) {
        //             //     $("#categories").append('<option value="">Select Category</option>' + res);
        //             // }
        //         }
        //     });
        // }

    </script>
@endsection