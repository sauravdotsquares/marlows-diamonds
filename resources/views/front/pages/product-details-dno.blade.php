@extends('layouts.front.app')

@section('css')
	<style>
		.thumbnail {
			position: relative;
			padding: 0px;
			margin-bottom: 20px;
		}
		.thumbnail img {
			width: 80%;
		}
		.thumbnail .caption{
			margin: 7px;
		}
		.main-section{
			background-color: #F8F8F8;
		}
		.dropdown{
			float:right;
			padding-right: 30px;
		}
		.btn{
			border:0px;
			margin:10px 0px;
			box-shadow:none !important;
		}
		.dropdown .dropdown-menu{
			padding:20px;
			top:30px !important;
			width:350px !important;
			left:-110px !important;
			box-shadow:0px 5px 30px black;
		}
		.total-header-section{
			border-bottom:1px solid #d2d2d2;
		}
		.total-section p{
			margin-bottom:20px;
		}
		.cart-detail{
			padding:15px 0px;
		}
		.cart-detail-img img{
			width:100%;
			height:100%;
			padding-left:15px;
		}
		.cart-detail-product p{
			margin:0px;
			color:#000;
			font-weight:500;
		}
		.cart-detail .price{
			font-size:12px;
			margin-right:10px;
			font-weight:500;
		}
		.cart-detail .count{
			color:#C2C2DC;
		}
		.checkout{
			border-top:1px solid #d2d2d2;
			padding-top: 15px;
		}
		.checkout .btn-primary{
			border-radius:50px;
			height:50px;
		}
		.dropdown-menu:before{
			content: " ";
			position:absolute;
			top:-20px;
			right:50px;
			border:10px solid transparent;
			border-bottom-color:#fff;
		}
	</style>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css" rel="stylesheet" />


@endsection

@section('content')

<?php
	// echo "<pre>";
	// print_r($data->getProductVariation[0]->regular_price);
	// die;
?>

<!-- product info and media -->
<!-- @php
Session::forget('recently_view');
	if(session('recently_view')){
		//echo '<pre>';print_r(Session::get('recently_view')); die;
		$arrayS = Session::get('recently_view');
	}else
		$arrayS = array();
	
	$title = isset($data->title)?$data->title:'';
	if(!in_array(array('title'=>$title),$arrayS)){
		$arr = array_merge($arrayS,array(['title'=>$title]));
	}else{
		$arr = $arrayS;
	}
	
	//echo '<pre>';print_r($arr); die;
	
	
	
	//$product = collect([$unique]);
	Session::push('recently_view', $arr);
	//echo '<pre>';print_r(Session::get('recently_view')); die;
@endphp -->
<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">

			<div class="product-info-media">
				<a href="#" class="product-gallery__trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
				
					<div id="carousel-zoom">
						
						@if($prodImages)

							@foreach($prodImages as $images)
								@php
									$explode = explode('/',$images->image_url);
									$explode1 = explode('.',$explode[1]);
								@endphp
								<div class="item">
									<a data-fancybox="gallery1" href="{{asset('/storage/'.$images->image_url)}}" data-caption="{{$explode1[0]}}"></a>
								</div>
							@endforeach
						@endif
						
					</div>
					<div id="carousel" class="owl-carousel">
						
						@if($prodImages)

							@foreach($prodImages as $images)
								@php
									$explode = explode('/',$images->image_url);
									$explode1 = explode('.',$explode[1]);
								@endphp
								<div class="item">
									<a data-fancybox="gallery2" href="{{asset('/storage/'.$images->image_url)}}" data-caption="{{$explode1[0]}}"><img src="{{asset('/storage/'.$images->image_url)}}" alt="{{$explode1[0]}}"></a>
								</div>
							@endforeach
						@endif
						
					</div>
				
			</div>
			<div class="product-info-main">
				<div class="product-title-name">
					<h1>{{isset($data->title)?$data->title:''}}</h1>
				</div>
				<div class="diamond-type">
					<label>Choose Your Diamond</label>
					<div class="d-type-input">
						<input type="radio" name="attribute_choose-your-diamond" checked value="mined">
						<span>Mined Diamond</span>
					</div>
					<div class="d-type-input">
						<input type="radio" name="attribute_choose-your-diamond" value="lab_grown">
						<span>Lab Grow Diamond</span>
					</div>
				</div>
				<div class="product-type-variations" id="filterDataDesign">
					<div class="type-variations-row">

					</div>
				</div>
				<div id="apiCustomDesign">

				</div>
				<div class="product-decriptions">
					{!!$data->description!!}
				</div>
				<div class="product-finder-price">
					<span class="price">{{MY_CURRENCY_SYMBOL}} <span id="finaldiamondprice">0.00</span> </span>
				</div>

				<input type="hidden" name="selected_variation_price" id="selected_variation_price" value="{{isset($data->getProductVariation[0]->regular_price)?$data->getProductVariation[0]->regular_price:0.00}}">
				<input type="hidden" name="selected_diamond_price" id="selected_diamond_price" value="0.00">
				<input type="hidden" name="selected_final_price" id="selected_final_price" value="0.00">

				<div class="product-add-cart">
					<div class="product-to-wishlist">
						@php
							$wishlist = session()->get('wishlist', []);
							$wishListClass = "fa-heart-o";
							if(array_key_exists($data->id,$wishlist)){
								$wishListClass = "fa-heart";
							}
						@endphp
						<a href="javascript:void(0);" id="productWishList"><i class="fa {{$wishListClass}} wishcount" aria-hidden="true"></i></a>
					</div>

					<div class="product-to-basket">
						
						<a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to basket</a>
					</div>
					<div class="product-req-appointment">
						<a type="button" class="btn-bg-small" data-bs-toggle="modal" data-bs-target="#requestAppointment">
						Request an Appointment
						</a>
					</div>
				</div>
				
				<div class="finance-available" ng-controller="DekopayController">
					<a href="javascript:void(0)" ng-click="financeOptions()">
						<i class="fa fa-credit-card" aria-hidden="true"></i>
						<p>Finance Available
							<span>see options</span>
						</p>
					</a>
					<div class="doko-img">
						<img src="{{asset('')}}assets/images/Deko_square_colour_whiteBG200px_wide.png" alt="doko">
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- Related Product start heRe -->
<div class="related-products-section">
	<div class="container">
		<div class="head-para-three">
			<div class="heading-h-three">
				Related products
			</div>
		</div>
		<div class="related-products-list">
			<div id="relatedProductData" class="related-product">
				
			</div>

		</div>
	</div>
</div>
<!-- Related Product end heRe -->


<!-- FAQ Section start here -->
<div class="faq-section">
	<div class="container">
		<div class="head-para-three">
			<div class="heading-h-three">
				Engagement Ring FAQ’s
			</div>
			<p>Some of the most common Engagement Ring Q&A's</p>
		</div>
		<div class="faq-list">
			<div class="accordion" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingOne">
						<button class="accordion-button" type="button" data-bs-toggle="collapse"
							data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							How Much Should I Spend On An Engagement Ring?
						</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
						data-bs-parent="#accordionExample">
						<div class="accordion-body">
							Traditionally its said the people spend roughly 3 months salary on an engagement ring.
							Ignore that. Go with what you can afford, and what you feel is right to spend. The ring is a
							symbol of your love. It's not about the cost of the ring. The last thing your partner would
							want is to see you struggle and delay holidays or even the wedding!
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingTwo">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
							data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							What If The Ring Doesn't Fit?
						</button>
					</h2>
					<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
						data-bs-parent="#accordionExample">
						<div class="accordion-body">
							We offer a free resizing service if it turns out the ring is either too tight or too loose,
							just contact us to arrange a time to come into store for a consultation.
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingThree">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
							data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							Do You Offer Finance Options?
						</button>
					</h2>
					<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
						data-bs-parent="#accordionExample">
						<div class="accordion-body">
							At Marlow's we don't like compromise, everyone should be able to afford their perfect
							engagement ring! Which is why we offer a range of options to allow you to spread the cost of
							your engagement ring from 6 months up to 48 months!
						</div>
					</div>
				</div>
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingFour">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
							data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
							Do You Offer Delivery & Returns?
						</button>
					</h2>
					<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
						data-bs-parent="#accordionExample">
						<div class="accordion-body">
							We provide speedy and secure delivery to a range of countries worldwide.<br>
							Provided goods can be returned as sold within 30 days of receipt, we can exchange any goods,
							or send replacements. We provide the option of a full refund, again within 30 days, if the
							goods are deemed ’faulty’, or different from those ordered. The 30-day refund period may be
							extended if prior consent is obtained from J.E.Marlow &amp; Sons Limited.<br>
							Refund procedure: Please email hello@marlows-diamonds.co.uk or call 0121-236-4415 for
							assistance with refund options. We will deal with any complaints in a fair, confidential,
							effective way that is available online and easy to use, should you have any complaints
							please contact us on 0121-236-4415 or email on hello@marlows-diamonds.co.uk
							<div class="vew-tc-btn">
								<a class="btn-bg-small" href="#">View T&C's</a>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- FAQ Section end here -->

<!-- image and text start here -->
<div class="product-image-text-sec">
	<div class="container">
		<div class="leftright-img-text-wraper">
			<div class="leftright-imt-rows flexed flex-flex-wrap flex-items-center">
				<div class="leftright-imt-col leftright-text">
					<div class="leftright-heading heading-h-three">
						Choose Your Diamond with Marlow’s Terminology Guide
					</div>
					<p>Whilst Diamonds are stunning they can be difficult to judge with naked eyes. With our diamond
						guide, you can better understand the different types of diamonds and what shapes are the perfect
						fit for you. Download your free guide today!</p>
					<div class="viewguide-btn">
						<a class="btn-bg-small" href="#">View Guide</a>
					</div>
				</div>
				<div class="leftright-imt-col leftright-img">
					<img src="/assets/images/perfect-ring.jpg" alt="perfect-ring">
				</div>

			</div>
		</div>
	</div>
</div>
<!-- image and text end here -->

<!-- Section Reviews -->
<div class="container">
	<div class="rating-review-block">
					<div class="owl-carousel owl-theme slider-review">
					@include('front.pages.reviews')
					</div>	
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="requestAppointment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request an appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-lg-12">
			<!-- Success message -->
			@if(Session::has('success'))
				<div class="alert alert-success">
					{{Session::get('success')}}
				</div>
			@endif
				<div class="visit-form">

					<form method="post" action="{{ route('contact') }}">
					@csrf
						<div class="form-controls">
							<input type="text" name="title" id="title" class="{{ $errors->has('title') ? 'error' : '' }}" placeholder="Your Name">
							<!-- Error -->
							@if ($errors->has('name'))
							<div class="error">
								{{ $errors->first('name') }}
							</div>
							@endif
						</div>
						<div class="form-controls">
							<input type="email" name="email" id="email" class="{{ $errors->has('email') ? 'error' : '' }}" placeholder="Your Email Address">
							@if ($errors->has('email'))
							<div class="error">
								{{ $errors->first('email') }}
							</div>
							@endif
						</div>
						<div class="form-controls">
							<input type="text" name="phone" id="phone" class="{{ $errors->has('phone') ? 'error' : '' }}" placeholder="Your Contact No.">
							@if ($errors->has('phone'))
							<div class="error">
								{{ $errors->first('phone') }}
							</div>
							@endif
						</div>
						<div class="form-controls">
							<textarea name="description" id="description" class="{{ $errors->has('description') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
							@if ($errors->has('description'))
							<div class="error">
								{{ $errors->first('description') }}
							</div>
							@endif
						</div>
						<div class="google-capatcha">

						</div>
						<div class="action-submit">
							<button type="submit" name="send" value="Submit">Send Message</button>
						</div>
					</form>

				</div>
		</div>
      </div>

    </div>
  </div>
</div>

<!-- Modal -->
@include('front.includes.dekopay-finance-options')

@endsection

@section('js')
	<script src="{{$url}}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
	<script>
		$(document).ready(function(){
			
			getCustomFilter();

            getRelatedProduct();

			$(".viewdiamond-btn").click(function(){
				$(".diamond-table").toggle();
			});
			//getFinalPrice();

			$('#addtobasket').on('click',function(){
				addtobasketFunction('{{route("add.to.cart")}}');
			});

			$("#productWishList").on('click',function(){
				addtobasketFunction('{{route("set-product-wishlist")}}')
			});
			$(document).on('change','.type-variations-col select, .d-type-input input',function(){
				getSelectedVariationsData();
				
			});

		})
		function getSelectedVariationsData(){
			$('#finaldiamondprice').text("Pending...");
			var diamond_type = $('input[name="attribute_choose-your-diamond"]:checked').val();
			var variations = [];
			$('.type-variations-row select').each(function(i, sel){ 
				
				if($(sel).attr('name')!='finger-size')
					variations.push($(sel).val());
			});
			var data_slug = '{{url("/")}}';
			console.log(variations);
			$.ajax({
				type: 'POST',
				url: '{{route("get-variations-data")}}',
				dataType: 'JSON',
				data: {
					'_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
					'diamond_type' : diamond_type,
					'variations' : variations,
				},
				success: function (res) {
					if(res.regular_price!='' || res.regular_price!='0.00'){
						var regular_p = Math.round(res.regular_price_with_vat);
						
						if(diamond_type=='lab_grown' && regular_p<=3000){
							regular_p_final = regular_p-(regular_p*0.35);
							
						}else if(diamond_type=='lab_grown' && regular_p>3000){
							regular_p_final = regular_p-(regular_p*0.5); 
							
						}else{
							regular_p_final = regular_p;
							
						}
						$('#selected_variation_price').val(res.regular_price);
						$('#selected_final_price').val(Math.round(regular_p_final));
						$('#finaldiamondprice').text(Math.round(regular_p_final));
					}
					else{
						var sale_p = Math.round(res.sale_price_with_vat);
						
						if(diamond_type=='lab_grown' && sale_p<=3000){
							sale_p_final = sale_p-(regular_p*0.35);
							
						}else if(diamond_type=='lab_grown' && sale_p>3000){
							sale_p_final = sale_p-(sale_p*0.5); 
							
						}else{
							sale_p_final = sale_p;
							
						}
						$('#selected_variation_price').val(res.sale_price);
						$('#selected_final_price').val(Math.round(sale_p_final));
						$('#finaldiamondprice').text(Math.round(sale_p_final));
					}

					if(res.vari_image!='' && res.vari_image!=null){
						variation_image = res.vari_image;
						$('#carousel .owl-item.active .item a').attr('href',data_slug+'/storage/'+res.vari_image);
						$('#carousel .owl-item.active .item img').attr('src',data_slug+'/storage/'+res.vari_image);
						//$("#carousel .owl-stage .owl-item").removeClass('active');
						//$("#carousel .owl-stage .owl-item.variation_image").remove();
			
						//$("#carousel .owl-stage").prepend('<div class="owl-item active variation_image" style="width: 654.5px;"><div class="item"><a data-fancybox="gallery2" href="'+data_slug+'/storage/'+res.vari_image+'" data-caption="DS013_90_W_1651666442"><img src="'+data_slug+'/storage/'+res.vari_image+'" alt="DS013_90_W_1651666442"></a></div></div>');
						//jQuery("#carousel").owlCarousel();
					}
				}
			});
		}
		function getCustomFilter(){
			$('#finaldiamondprice').text("Pending...");
			$.ajax({
                type: 'POST',
                url: '{{route("custom-filter")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
                },
                success: function (res) {

					$('#filterDataDesign .type-variations-row').html(res);
					getSelectedVariationsData();
                    return false;
                }
            });
		}

		function addtobasketFunction(getUrl){
			$.ajax({
                type: 'POST',
                url: getUrl,
                data: {
                    '_token': "{{csrf_token()}}",
					'carat' : $('#carat').val(),
					'color' : $('#diamond-colour').val(),
					'clarity' : $('#diamond-clarity').val(),
					'grade' : $('#diamond-grade').val(),
					'fingersize' : $('#finger-size').val(),
					'metalcolor' : $('#metal-type').val(),
					'certificate' : $('#diamond-certificate').val(),
					'slug' : '{{$data->slug}}',
					'price': parseFloat($('#finaldiamondprice').text()) || 0, //parseFloat($('#price').val()) || 0;
                },
                success: function (res) {
					console.log(res);
					if(res.success != '' && typeof res.success !== "undefined"){
						if(res.cartcount){
							$(".cartcount").text(res.cartcount);
						}
						if(res.wishcount){
							$(".wishcount").removeClass('fa-heart-o');
							$(".wishcount").addClass('fa-heart');
						}
						toastr.success(res.success);
					}else{
						toastr.info(res.error);
					}
                }
            });
		}

		function getFinalPrice(){
			$('#addtobasket').addClass('disabledAnchor');
			$.ajax({
                type: 'POST',
                url: '{{route("products-final-price")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'variation_price' : parseFloat($('#selected_variation_price').val()),
					'slug': '{{$data->slug}}'
                },
                success: function (res) {
					$('#finaldiamondprice').html("");
					if(res != ''){
						$('#finaldiamondprice').text(res);
						$('#selected_final_price').val(res);
						$('#addtobasket').removeClass('disabledAnchor');
					}else{
						$('#finaldiamondprice').text("");
					}
                }
            });
		}

        function getRelatedProduct(){
            $.ajax({
                url: "{{ route('get.related.product.list') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    catid: '{{$data->categories}}',
                },
                success: function (response) {
                    // console.log(response.html);
                    $('#relatedProductData').html(" ");
                    if(response.html){
                        $('#relatedProductData').append(response.html);
                    }
                    // return false;
                    // window.location.reload();
                }
            });
        }

        $(document).ready(function() {
	      
	      jQuery("#carousel").owlCarousel({
			  //autoplay: true,
			  rewind: true, /* use rewind if you don't want loop */
			  /*margin: 20,*/
			   /*
			  animateOut: 'fadeOut',
			  animateIn: 'fadeIn',
			  */
			  responsiveClass: true,
			  //autoHeight: true,
			  //autoplayTimeout: 7000,
			  smartSpeed: 800,
			  nav: true,
			  items : 1,
			});

	      $(document).on('click','.product-gallery__trigger',function(e){
	      		e.preventDefault();
	      		$('#carousel .owl-item.active a').click();
	      });

	    });
	</script>

@endsection
