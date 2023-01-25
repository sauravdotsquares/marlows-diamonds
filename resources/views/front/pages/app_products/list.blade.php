@extends('layouts.front.app')
@section('content')

{{-- Header --}}
<div class="category-banner" style="background-image:url({{asset('assets/images/engagement-rings-banner.png')}})">
    <div class="container">
        <div class="category-banner-text">
            <h1>{!! isset($category->title)?$category->title:'' !!}</h1>
            <p>{!! isset($category->short_description)?$category->short_description:'' !!}</p>
        </div>
    </div>
</div>

{{-- Products list and right sidebar --}}
<div class="category-listing-wrap">
    <div class="container">

        <div class="category-listing-row">
            <div class="category-list-wrap">
                
                <div class="product-grid-wrap">
                    <div class="product-grid-row flexed flex-flex-wrap" id="showProductList">                        
                    </div>
                </div>
                <div class="show-more-button">
                </div>
                {!! isset($category->description)?$category->description:'' !!}
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
<input type="hidden" id="pagescroll" value="1">

@section('js')
<script src="{{ asset('admin/js/list_view.js') }}"></script>
<script>
    var data_not_found_image = "";
    
    initViewForList({
        csrf: "{{ csrf_token() }}",
        url: "{{ route('app_products.list', $category->slug) }}",
        noRecords:".item-box",
        contentAppendAt: $("#showProductList"),
        showMoreAppendAt: $(".show-more-button"),
        html: function(data) {

            const imageBaseUrl = "<?php echo asset('uploads'); ?>";
            if(typeof data.thumb_image!='undefined' && typeof data.thumb_image.image!='undefined'){
                var thumbImg = imageBaseUrl + '/' + data.thumb_image.image;
            }else{
                var thumbImg = "<?php echo asset('images/waiting_img.png'); ?>";
            }

            const detailUrl = `<?php echo url()->to('p/detail/') ; ?>/${data.slug}`;

            return `<div class="product-grid-items-item item-box">
                    <div class="product-items-item-info">
                        <div class="product-items-item-image">
                            <a href="${detailUrl}">
                                <img src="${thumbImg}" alt="${data.title}">
                            </a>
                        </div>
                        <div class="product-items-item-details">
                            <div class="product-items-item-name">
                                <a href="${detailUrl}">${data.title}</a>
                                <p> 
                                    <strong>Price</strong> 
                                    <span> ${data.minimum} - ${data.maximum}</span> 
                                </p>
                            </div>
                        </div>
                    </div>
            </div>`;
        },
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
    })

        // var page = 1;
        // loadMoreData(page);

        $(window).scroll(function() {
            var scroll = $('#scrollFlag').val();
            if (scroll==0 && ($(window).scrollTop() >= parseInt($('#sectionHeight').val()))) {
                var page = $('#pagescroll').val();
                loadMoreData(page);
                $('#scrollFlag').val(1);
            }
        });

        function loadMoreData(page){
            $.ajax(
                {
                    url: '{{url("product/get-product-list")}}?page='+page,
                    type: "post",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'cate_id':'{{ !empty($data) ? $data->id : ''}}',
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
                    if(data.html == ""){
                        $('.ajax-load').html("No more products found");
                        return false;
                    }
                    $('.ajax-load').hide();
                    $("#showProductList").append(data.html);
                    $('#sectionHeight').val($( '#showProductList' ).height());
                    $('#scrollFlag').val(0);
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


