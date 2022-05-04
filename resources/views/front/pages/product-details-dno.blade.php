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

@endsection

@section('content')

<?php 
	// echo "<pre>";
	// print_r($data->getProductVariation[0]->regular_price);
	// die;
?>

<!-- product info and media -->

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">
			<div class="product-info-media">
				<!-- <video id="variationVideo" style="width: 100%;" loop autoplay preload="auto" muted="1" playsinline>
					<source src="{{ asset('storage/'.$data->getProductVariation[0]->vari_video)}}" type="video/mp4" type="video/mp4" />
				</video> -->
				@if(isset($data->getProductImages->image_url))
				<img id="productFeatureImage" src="{{ asset('storage/'.$data->getProductImages->image_url) }}" alt="">
				@endif
			</div>
			<div class="product-info-main">
				<div class="product-title-name">
					<h1>{{isset($data->title)?$data->title:''}}</h1>
				</div>
				<!-- <div class="diamond-type">
					<label>Diamond Type</label>
					<div class="d-type-input">
						<input type="radio" name="attribute_choose-your-diamond" checked value="Mined Diamond">
						<span>Mined Diamond</span>
					</div>
					<div class="d-type-input">
						<input type="radio" name="attribute_choose-your-diamond" value="Lab Grown Diamonds">
						<span>Lab Grow Diamond</span>
					</div>
				</div> -->
				<div class="product-type-variations" id="filterDataDesign">
					<div class="type-variations-row">

					</div>
				</div>
				<div id="apiCustomDesign">
					
				</div>
				<div class="product-decriptions">
					<p>A unique style for Aaliyah. The round brilliant cut diamond is held elegantly in a fluted four
						claw setting, allowing maximum passage of light - R1-143</p>
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
						<!-- <a class="btn-bg-small" href="#">Add to basket</a> -->
						<!-- <a id="addtobasket" href="{{ route('add.to.cart', $data->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to basket</a> </p> -->
						<a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to basket</a>
					</div>
					<div class="product-req-appointment">
						<a type="button" class="btn-bg-small" data-bs-toggle="modal" data-bs-target="#requestAppointment">
						Request an Appointment
						</a>
					</div>
				</div> 
				<div class="product-postactions">
					<!-- <a target="_blank" class="review-action" href="#">Reviews</a> -->
					<a href="https://www.google.com/search?q=marlows+diamond+google+review&amp;oq=marlows+diamond+google+review&amp;aqs=chrome..69i57.8073j0j1&amp;sourceid=chrome&amp;ie=UTF-8#lrd=0x4870bcedd24f2c3d:0x1dc68827b10987fa,1,,," class="review-action" target="_blank">
						Reviews
					</a>
					<a class="store-locator" href="{{asset('visit-us')}}">Store Locator</a>
					<a target="_blank" class="view-certificate" href="#">View Certificate</a>
				</div>
				<div class="finance-available">
					<a type="button" data-bs-toggle="modal" data-bs-target="#financeAvailableModal">
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
			<div class="owl-carousel owl-theme related-product st-arrows">
				<div class="item">
					<div class="product-grid-item">
						<div class="product-items-item-info">
							<div class="product-items-item-image">
								<a href="#"><img src="assets/images/R1-143_0003-225x225.jpg" alt="image"></a>
							</div>
							<div class="product-items-item-details">
								<div class="product-items-item-name">
									<a href="#">AALIYAH | Four Claw split shoulder Solitaire Diamond Ring</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="product-grid-item">
						<div class="product-items-item-info">
							<div class="product-items-item-image">
								<a href="#"><img src="assets/images/MTSS-707_00003-225x225.jpg" alt="image"></a>
							</div>
							<div class="product-items-item-details">
								<div class="product-items-item-name">
									<a href="#">ABBIE | Marquise shape solitaire Diamond Engagement Ring</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="product-grid-item">
						<div class="product-items-item-info">
							<div class="product-items-item-image">
								<a href="#"><img src="assets/images/R1-1027_0003-225x225.jpg" alt="image"></a>
							</div>
							<div class="product-items-item-details">
								<div class="product-items-item-name">
									<a href="#">ADDISON | Slim Twist Set Diamond Engagement Ring</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="product-grid-item">
						<div class="product-items-item-info">
							<div class="product-items-item-image">
								<a href="#"><img src="assets/images/R1-241-Images_0003-225x225.jpg" alt="image"></a>
							</div>
							<div class="product-items-item-details">
								<div class="product-items-item-name">
									<a href="#">ALEXA | Four Claw thin set Diamond Ring</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="product-grid-item">
						<div class="product-items-item-info">
							<div class="product-items-item-image">
								<a href="#"><img src="assets/images/R1-241-Images_0003-225x225.jpg" alt="image"></a>
							</div>
							<div class="product-items-item-details">
								<div class="product-items-item-name">
									<a href="#">ALEXA | Four Claw thin set Diamond Ring</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="product-grid-item">
						<div class="product-items-item-info">
							<div class="product-items-item-image">
								<a href="#"><img src="assets/images/R1-241-Images_0003-225x225.jpg" alt="image"></a>
							</div>
							<div class="product-items-item-details">
								<div class="product-items-item-name">
									<a href="#">ALEXA | Four Claw thin set Diamond Ring</a>
								</div>
							</div>
						</div>
					</div>
				</div>
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
							<input type="text" name="name" id="name" class="{{ $errors->has('name') ? 'error' : '' }}" placeholder="Your Name">
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
							<textarea name="message" id="message" class="{{ $errors->has('message') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
							@if ($errors->has('message'))
							<div class="error">
								{{ $errors->first('message') }}
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
<div class="modal fade" id="financeAvailableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<input type="text" name="name" id="name" class="{{ $errors->has('name') ? 'error' : '' }}" placeholder="Your Name">
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
						<textarea name="message" id="message" class="{{ $errors->has('message') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
						@if ($errors->has('message'))
						<div class="error">
							{{ $errors->first('message') }}
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

@endsection

@section('js')

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<script>
		$(document).ready(function(){
			console.log("checking");
			getCustomFilter();

			$(".viewdiamond-btn").click(function(){
				$(".diamond-table").toggle();
			});
			getFinalPrice();

			$('#addtobasket').on('click',function(){
				addtobasketFunction('{{route("add.to.cart")}}');
			});

			$("#productWishList").on('click',function(){
				addtobasketFunction('{{route("set-product-wishlist")}}')
			});

			$(document).on('change','#metal-type',function(){
				$('#finaldiamondprice').text("Pending...");
				$.ajax({
					type: 'POST',
					url: '{{route("get-product-video")}}',
					data: {
						'_token': "{{csrf_token()}}",
						'slug' : '{{$data->slug}}',
						'metal_color' : $(this).val(),
					},
					success: function (res) {
						if(res.vari_image){
							var imageUrl = "{{ asset('storage/')}}/"+res.vari_image;
							$('#productFeatureImage').attr('src', imageUrl);
							getFinalPrice();
						}
					}
				});
			});
		})

		function getCustomFilter(){
			
			$.ajax({
                type: 'POST',
                url: '{{route("custom-filter")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
                },
                success: function (res) {
                    
					$('#filterDataDesign').html(res);
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
					'metalcolor' : $('#metal-colour').val(),
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

	</script>
@endsection