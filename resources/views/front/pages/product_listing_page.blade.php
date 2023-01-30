@extends('layouts.front.app')
@section('content')

<div class="category-banner" style="background-image:url({{asset('')}}assets/images/engagement-rings-banner.png)">
    <div class="container">
        <div class="category-banner-text">
            <h1>{!! isset($data->title)?$data->title:'' !!}</h1>
            <p>{!! isset($data->short_description)?$data->short_description:'' !!}</p>
        </div>
    </div>
</div>

<div class="category-listing-wrap" ng-controller="ProductController" ng-cloak>
    <div class="container" >
        <div class="category-listing-row">
            <div class="category-list-wrap">
                
                <div class="product-grid-wrap">
                    <div class="product-grid-row flexed flex-flex-wrap" id="showProductList">
                        {!! $productItems !!}
                    </div>
                </div>
                <div class="ajax-load text-center" style="display:{{ $isNextPage ? 'block' : 'none' }};">
                    <input type="hidden" name="nextPageNumber" id="nextPageNumber" value="{{ $nextPage }}" />
                    <img src="{{asset('assets/images/spinner-ring.gif')}}"><p>Loading More Products</p>
                    <button style="display: none;" class="ajax-load-btn">Load more data</button>
                </div>

                {!! isset($data->description)?$data->description:'' !!}
            </div>
            
            <div class="category-sidebar-wrap">

                <div class="sidebar-main-cart">
                    <div class="sidebar-title">
                        Shopping Cart
                    </div>
                    @if(session('cart'))
                    <div class="side-cart-row">
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="side-cart-item">
                                <div class="cart-image-item">
                                    @if(isset($details['selected_parameter']['imagelink']) && !empty($details['selected_parameter']['imagelink']))
                                        <img src="{{$details['selected_parameter']['imagelink']}}" width="100" height="100"
                                        class="img-responsive" />
                                    @elseif(isset($details['image']) && !empty($details['image']))
                                        <img src="{{asset('storage/'.$details['image'])}}" width="100" height="100"
                                        class="img-responsive" />
                                    @else
                                        <img src="https://www.marlows-diamonds.co.uk/wp-content/uploads/2019/07/MarlowsDiamonds-Logo-225x107.png" width="100" height="100" class="img-responsive" />
                                    @endif
                                </div>
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

                            </div>
                        @endforeach
                        <div class="side-cart-actions">
                            <a class="view-basket btn-bg-small" href="{{route('product.cart')}}">View Basket</a>
                            <a class="btn-bg-small" href="{{route('product.checkout')}}">Checkout</a>
                        </div>
                    </div>
                    @else
                        <div class="shopping_cart_content">
                            <p class="mini-cart__empty-message">No products in the basket.</p>
                        </div>
                    @endif
                </div>
                @if(session('recentproducts'))
                <div class="side-recentlyview">
                    <div class="sidebar-title">
                        Recently Viewed
                    </div>
                    <div class="side-recently-item">
                        @php $i = 0; @endphp
                        @foreach(array_reverse(session('recentproducts')) as $ProductDetails)
                            @if($i <= 8)
                                <div class="side-recently-col">
                                    <a class="side-recently-pr-name" href="{{asset('product/'.$ProductDetails['slug'])}}">{{$ProductDetails['name']}}</a>
                                    <a class="side-recently-pr-img" href="{{asset('product/'.$ProductDetails['slug'])}}"><img src="{{asset('storage/'.$ProductDetails['image'])}}"
                                            alt="image"></a>
                                </div>
                            @endif
                            @php $i++; @endphp
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>
</div>


@section('js')

<script>
$(document).ready(function(){
    $('.show-more-content').hide();
    $('.show-more').click(function(){
        $(this).parents('.reviewr-review-text').toggleClass("show-text-col");
    });
});

</script>
    <script>


    $(document).on('mouseenter','.product-hover-affect', function (event) {
        console.log('mouse enter')
        if($(this).find('video').length){
            $(this).find('video')[0].play()
        }
    }).on('mouseleave','.top-level',  function(){
        console.log('mouse leave')
        if($(this).find('video').length){
            $(this).find('video')[0].pause()
        }
    })
    
    $(document).on('touchstart','.product-hover-affect',function() {
        $(this).find('a.product-hov').css({
            '-webkit-transition' : 'all 200ms ease-in',
            '-webkit-transform' : 'scale(1.2)',
            '-ms-transition' : 'all 200ms ease-in',
            '-ms-transform' : 'scale(1.2)',
            '-moz-transition' : 'all 200ms ease-in',
            '-moz-transform' : 'scale(1.2)',
            'transition' : 'all 200ms ease-in',
            'transform': 'scale(1.2)'
        });
        $(this).find('.product-hover-video').css({
            'display': "block",
            'position': "absolute",
            'top': "0",
            "width": "100%",
            "height" : "100%",
            "background" : "#fff"
        });
        if($(this).find('video').length){
            $(this).find('video')[0].play()
        }
    });   


        // loadMoreData();

        /** On scroll get more data */
        var triggerScrollEvent = true;
        $(document).ready(function() {
            $(document).on('scroll',function(){
                if(triggerScrollEvent){
                    if($(".ajax-load").isInViewport()){
                        triggerScrollEvent = false;
                        $(".ajax-load-btn").trigger('click');
                    }
                }
            });
        });

        $(document).on('click',".ajax-load-btn", function(){
            triggerScrollEvent = false;
            $('.ajax-load').show();
            loadMoreData();
        });

        function loadMoreData(){
            const page = $("#nextPageNumber").val();
            $.ajax({
                url: '{{url("product-listing-data")}}?page='+page,
                type: "post",
                data: {
                    '_token': "{{csrf_token()}}",
                    'page':page,
                    "slug" : "{{ $slug }}",
                    "slug2" : "{{ $slug2 }}",
                    "slug3" : "{{ $slug3 }}"
                },
            }).done(function(data){
                triggerScrollEvent = true;
                if(data.status){
                    $('.ajax-load').hide();
                }
                $("#showProductList").append(data.productItems);
                $("#nextPageNumber").val(data.nextPage);

                if(!data.isNextPage){
                    triggerScrollEvent = false;

                }

            }).fail(function(jqXHR, ajaxOptions, thrownError){
                triggerScrollEvent = true;
                alert('server not responding...');
            });
        }

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route("remove.from.cart") }}',
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
@endsection
<!-- Category Listing Wrap end -->
<!-- Section Reviews -->
<div class="container">
	<div class="rating-review-block">
		<div class="owl-carousel owl-theme slider-review">
		@include('front.pages.reviews')
		</div>
	</div>
</div>

@endsection


