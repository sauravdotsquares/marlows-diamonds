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
		.disabledAnchor a{
			pointer-events: none !important;
			cursor: default;
			color:white;
		}
	</style>

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css" rel="stylesheet" />

@endsection

@section('content')

<!-- product info and media -->

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">
			<div class="product-info-media">
				<a href="#" class="product-gallery__trigger"><i class="fa fa-search" aria-hidden="true"></i></a>

					<div id="carousel" class="owl-carousel">

						@if($prodImages)

							@foreach($prodImages as $key=>$images)
								@php
									$explode = explode('/',$images->image_url);
									$explode1 = explode('.',$explode[1]);
								@endphp
								<div class="item @if($key==0) active @endif">
									<a data-fancybox="gallery1" href="{{asset('/storage/'.$images->image_url)}}" data-caption="{{$explode1[0]}}"></a>
								</div>
							@endforeach
						@endif

					</div>

				<video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
					@if(isset($data->getProductVariation) && !empty($data->getProductVariation[0]->vari_video))
						<source src="{{ asset('storage/'.$data->getProductVariation[0]->vari_video)}}" type="video/mp4" type="video/mp4" />
					@else
						<source src="" type="video/mp4" type="video/mp4" />
					@endif
				</video>


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
					<div class="type-variations-row">
						<div class="type-variations-col">
							<label class="label"> Carat </label>
							<select class="form-control" name="carat" id="carat">
								<option value="">Choose an option</option>
								<option value="0.30-0.39" selected="selected">0.30-0.39</option>
								<option value="0.40-0.49">0.40-0.49</option>
								<option value="0.50-0.59">0.50-0.59</option>
								<option value="0.60-0.69">0.60-0.69</option>
								<option value="0.70-0.79">0.70-0.79</option>
								<option value="0.80-0.89">0.80-0.89</option>
								<option value="0.90-0.99">0.90-0.99</option>
								<option value="1.00-1.19">1.00-1.19</option>
								<option value="1.20-1.49">1.20-1.49</option>
								<option value="1.50-1.69">1.50-1.69</option>
								<option value="1.70-1.99">1.70-1.99</option>
								<option value="2.00-2.49">2.00-2.49</option>
								<option value="2.50-2.99">2.50-2.99</option>
								<option value="3.00-3.99">3.00-3.99</option>
							</select>
						</div>
						<div class="type-variations-col">
							<label class="label"> Colour </label>
							<select class="form-control" name="diamond-colour" id="diamond-colour">
                    			<option value="">Choose an option</option>
								<option value="D" selected="selected">D - Exceptional White +</option>
								<option value="E">E - Exceptional White</option>
								<option value="F">F - Rare White +</option>
								<option value="G">G - Rare White</option>
								<option value="H">H - White</option>
								<option value="I">I - Slightly Tinted White</option>
								<option value="J">J - Slightly Tinted White</option>
								<option value="K">K - Tinted White</option>
							</select>
						</div>
					</div>

					<div class="type-variations-row">
						<div class="type-variations-col">
							<label class="label"> Clarity </label>
							<select class="form-control" name="diamond-clarity" id="diamond-clarity">
                    			<option value="">Choose an option</option>
								<option value="IF">IF - Internally Flawless</option>
								<option value="VVS1">VVS1 - Minute Inclusions</option>
								<option value="VVS2">VVS2 - Minute Inclusions</option>
								<option value="VS1">VS1 - Very Small Inclusions</option>
								<option value="VS2">VS2 - Very Small Inclusions</option>
								<option value="SI1">SI1 - Small Inclusions</option>
								<option value="SI2" selected="selected">SI2 - Small Inclusions</option>
							</select>
						</div>
                        @if(isset($data->diamond_shape) && $data->diamond_shape == 'ROUND')
                            <div class="type-variations-col">
                                <label class="label"> Cut Grade </label>
                                <select class="form-control" name="diamond-grade" id="diamond-grade">
                                    <option value="">Choose an option</option>
                                    <option value="EX" selected="selected">Excellent</option>
                                    <option value="VG">Very Good</option>
                                    <option value="GD">Good</option>
                                </select>
                            </div>
                        @endif
                        <div class="type-variations-col{{($data->diamond_shape == 'ROUND')?'-one':''}}">
							<label class="label"> Certificate </label>
							<select class="form-control" name="diamond-certificate" id="diamond-certificate">
                    			<option value="">Choose an option</option>
								<option value="GIA" selected="selected">GIA</option>
								<option value="IGI">IGI</option>
							</select>
						</div>
					</div>
					<div class="type-variations-row">
						{{-- <div class="type-variations-col{{($data->diamond_shape == 'ROUND')?'-one':''}}">
							<label class="label"> Certificate </label>
							<select class="form-control" name="diamond-certificate" id="diamond-certificate">
                    			<option value="">Choose an option</option>
								<option value="GIA" selected="selected">GIA</option>
								<option value="IGI">IGI</option>
							</select>
						</div> --}}
					</div>
					<div class="view-diamond-sec">
						<div class="viewall-diamond-btn"><a class="btn-bg-large viewdiamond-btn"
								href="javascript:void(0)">View Available Diamonds</a></div>
						<div class="diamond-table">
							<div class="refine-heading">Refine Your Search</div>
							<div class="diamond-table-outer">
								<table width="100%" class="diamond-table-items">
									<thead>
										<tr>
											<th>Shape</th>
											<th>Carat</th>
											<th>Colour</th>
											<th>Clarity</th>
                                            @if(isset($data->diamond_shape) && $data->diamond_shape == 'ROUND')
											<th class="cut_grade_th" style="display: block;">Cut</th>
                                            @endif
											<th>Cert</th>
											<th>Price</th>
											<th>Certificate</th>
											<th>Image</th>
											<th>Select</th>
										</tr>
									</thead>
									<tbody id="refineSearchData">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="product-decriptions">
					{!!$data->description!!}
				</div>
				<div class="product-finder-price">
					<span class="price">{{MY_CURRENCY_SYMBOL}} <span id="finaldiamondprice">0.00</span> </span>
				</div>
				<input type="hidden" id="certificate_url" name="certificate_url" value="">
				<input type="hidden" name="selected_variation_price" id="selected_variation_price" value="{{isset($variationDetails->regular_price)?$variationDetails->regular_price:$variationDetails->sale_price}}">
				<input type="hidden" name="selected_diamond_price" id="selected_diamond_price" value="0.00">
				<input type="hidden" name="selected_final_price" id="selected_final_price" value="0.00">
				<input type="hidden" name="selected_diamond_shape" id="selected_diamond_shape" value="{{$data->diamond_shape}}">
				<input type="hidden" name="selected_diamond_certno" id="selected_diamond_certno" value="">

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
					<a href="https://www.google.com/search?q=marlows+diamond+google+review&amp;oq=marlows+diamond+google+review&amp;aqs=chrome..69i57.8073j0j1&amp;sourceid=chrome&amp;ie=UTF-8#lrd=0x4870bcedd24f2c3d:0x1dc68827b10987fa,1,,," class="review-action" target="_blank">
						Reviews
					</a>
					<!-- <a target="_blank" class="review-action" href="#">Reviews</a> -->
					<a class="store-locator" href="{{asset('visit-us')}}">Store Locator</a>
					<a target="_blank" id="productCertificateLink" class="view-certificate" href="#">View Certificate</a>
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
								<a class="btn-bg-small" href="/terms">View T&C's</a>
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
						<div class="google-capatcha form-controls">
						<div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6LfQrxUgAAAAAFD1c2BmyaKHy1F20WUJEloRiyie">
						</div>
						@if ($errors->has('g-recaptcha-response'))
							<div class="error">
								{{ $errors->first('g-recaptcha-response') }}
							</div>
							@endif	
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
            getRelatedProduct();

			getCustomFilter(); //getProdVideo();

			$(".viewdiamond-btn").click(function(){
				$(".diamond-table").toggle();
			});

			getSelectedAttributePrice();

			$('#carat').on('change',function(){
				getSelectedAttributePrice();
			});
			$('#diamond-colour').on('change',function(){
				getSelectedAttributePrice();
			});
			$('#diamond-clarity').on('change',function(){
				getSelectedAttributePrice();
			});
			$('#diamond-grade').on('change',function(){
				getSelectedAttributePrice();
			});
			$('#diamond-certificate').on('change',function(){
				getSelectedAttributePrice();
			});



			$('#addtobasket').on('click',function(){
				addtobasketFunction('{{route("add.to.cart")}}');
			});

			$("#productWishList").on('click',function(){
				addtobasketFunction('{{route("set-product-wishlist")}}')
			});

			$(document).on('change','#metal-type',function(){
				getProdVideo('onChange');

			});
			$(document).on('click','.refinedata',function(){

				$("#selected_diamond_price").val($(this).data('price'));
				$("#certificate_url").val($(this).data('certurl'));
				$("#productCertificateLink").attr('href',$(this).data('certurl'));

				getFinalPrice();

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

					$('#filterDataDesign .type-variations-row').html(res);
                    getProdVideo();

                }
            });
		}
		function getProdVideo(action=null){
			var metal_type = $('#metal-type :selected').val();

			$.ajax({
				type: 'POST',
				url: '{{route("get-product-video")}}',
				data: {
					'_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
					'metal_color' : metal_type,
				},
				success: function (res) {
					if(res.vari_video){
						var videoUrl = "{{ asset('storage/')}}/"+res.vari_video;
						$('#variationVideo').attr('src', videoUrl);
						$("#variationVideo")[0].play();
					}
					if(res.regular_price!='' || res.regular_price!='0.00')
						$('#selected_variation_price').val(res.regular_price);
					else
						$('#selected_variation_price').val(res.sale_price);
					if(action!=null && action=='onChange')
						getFinalPrice();
				}
			});
		}
		function getNumberFromCurrency(currency) {
			return Number(currency.replace(/[$,]/g,''))
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
					'price': getNumberFromCurrency($('#selected_final_price').val()) || 0, //parseFloat($('#price').val()) || 0;
					'certificatelink': $('#certificate_url').val() || '',
					'shape': $('#selected_diamond_shape').val() || '',
					'certificate': $('#selected_diamond_certno').val() || '',
                },
                success: function (res) {
					// console.log(res);
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

		function getSelectedAttributePrice(){
			$('#finaldiamondprice').text("Pending...");
			$('#addtobasket').addClass('disabledAnchor');

			var caratVal = $('#carat').val();
			var diamondColor = $('#diamond-colour').val();
			var diamondClarity = $('#diamond-clarity').val();
			var diamondGrade = $('#diamond-grade').val();
			var diamondCertificate = $('#diamond-certificate').val();
			var diamondShape = $('#selected_diamond_shape').val();
			var variation_price = $('#selected_variation_price').val();
			$.ajax({
                type: 'POST',
                url: '{{route("products-final-price-with-diamond")}}',
                dataType: 'json',
                data: {
                    '_token': "{{csrf_token()}}",
                    'variation_price' : variation_price,
					'carat' : caratVal,
					'color' : diamondColor,
					'clarity' : diamondClarity,
					'grade' : diamondGrade,
					'certificate' : diamondCertificate,
					'shape' : diamondShape,
					'slug': '{{$data->slug}}'
                },
                success: function (res) {
					$('#finaldiamondprice').html("");

					if(res){
						$('#finaldiamondprice').text(res.finalPrice);
						$('#selected_final_price').val(res.finalPrice);
						$('#selected_diamond_price').val(res.diamondPrice);
						$('#selected_diamond_certno').val(res.Stock_NO);
						$('#certificate_url').val(res.CertificateLink);
						$('#productCertificateLink').attr('href',res.CertificateLink);
						$('#addtobasket').removeClass('disabledAnchor');
					}
                }

            });

			$.ajax({
                type: 'POST',
                url: '{{route("custom-api-filter-data")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'carat' : caratVal,
					'color' : diamondColor,
					'clarity' : diamondClarity,
					'grade' : diamondGrade,
					'certificate' : diamondCertificate,
					'shape' : diamondShape,
					'slug': '{{$data->slug}}'
                },
                success: function (res) {
					$('#refineSearchData').html("");
					if(res.html != ''){
						$('#refineSearchData').html(res.html);
						//getCustomPrice();
					}else{
						$('#refineSearchData').html("No Data Found");
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
					'diamond_price' : parseFloat($('#selected_diamond_price').val()),
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
        $(document).on('click','.product-gallery__trigger',function(e){
	      		e.preventDefault();
	      		$('#carousel .item.active a').click();
	      });
	</script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
