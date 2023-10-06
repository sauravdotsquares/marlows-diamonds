@extends('layouts.front.app')

@section('css')
	<style>
		.thumbnail {position: relative;padding: 0px;margin-bottom: 20px;}
		.thumbnail img {width: 80%;}
		.thumbnail .caption{margin: 7px;}
		.main-section{background-color: #F8F8F8;}
		.dropdown{float:right;padding-right: 30px;}
		.btn{border:0px;margin:10px 0px;box-shadow:none !important;}
		.dropdown .dropdown-menu{padding:20px;top:30px !important;width:350px !important;left:-110px !important;box-shadow:0px 5px 30px black;}
		.total-header-section{border-bottom:1px solid #d2d2d2;}
		.total-section p{margin-bottom:20px;}
		.cart-detail{padding:15px 0px;}
		.cart-detail-img img{width:100%;height:100%;padding-left:15px;}
		.cart-detail-product p{margin:0px;color:#000;font-weight:500;}
		.cart-detail .price{font-size:12px;margin-right:10px;font-weight:500;}
		.cart-detail .count{color:#C2C2DC;}
		.checkout{border-top:1px solid #d2d2d2;padding-top: 15px;}
		.checkout .btn-primary{border-radius:50px;height:50px;}
		.dropdown-menu:before{content: " ";position:absolute;top:-20px;right:50px;border:10px solid transparent;border-bottom-color:#fff;}
		.disabledAnchor a{pointer-events: none !important;cursor: default;color:white;}span.price-not-found {font-size: 14px;color: #8e2e65;font-weight: bold;}
		.error {color: #e74c3c !important;}div#finaldiamondprice del {font-size: 20px;}
	</style>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.css" rel="stylesheet" />

@endsection

@section('content')

<!-- product info and media -->

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">
			<div class="product-info-media">
				<a href="#" class="product-gallery__trigger"><i class="fa fa-search" aria-hidden="true"></i></a>

					<div id="carousel" class="owl-carousel photo-slider">

						{{-- @if($prodImages)
							@foreach($prodImages as $key=>$images)
								@php
									$explode = explode('/',$images->image_url);
									$explode1 = explode('.',$explode[1]);
								@endphp
								<div class="item @if($key==0) active @endif">
									<a data-fancybox="gallery1" href="{{asset('/uploads/'.$images->image_url)}}" data-caption="{{$explode1[0]}}"></a>
								</div>
							@endforeach
						@endif --}}

						<?php if(!empty($prodImages)){ ?>
							<?php foreach ($prodImages as $key => $images) { ?>
								<div class="item @if($key==0) active @endif">
									<a data-fancybox="gallery1" href="{{ url( 'uploads/' . $images->image_url) }}" data-caption="{{  $images->original_image_name }}"></a>
									<img src="{{ env('APP_IMAGE_URL').'uploads/' . $images->image_url }}">
								</div>
							<?php } ?>
						<?php } ?>						
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
					<h1>{{ !empty($data->title) ? $data->title :''}}</h1>
				</div>
				<div class="product-type-variations" id="filterDataDesign">
					<div class="type-variations-row">
					</div>
				</div>

                @if($plainbandMulti==false)
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

							@if(!empty($data->diamond_shape) && $data->diamond_shape == 'ROUND')
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
                @endif

				<div class="product-decriptions">
					{!! $data->description !!}
				</div>
				<div class="product-finder-price" id="finaldiamondprice"></div>
				
				<input type="hidden" id="certificate_url" name="certificate_url" value="">
				<input type="hidden" name="selected_variation_price" id="selected_variation_price" value="{{ !empty($variationDetails) ? isset($variationDetails->regular_price) ? $variationDetails->regular_price: $variationDetails->sale_price : ''  }}">
				<input type="hidden" name="selected_setting_price" id="selected_setting_price" value="0.00">
				<input type="hidden" name="selected_discounted_price" id="selected_discounted_price" value="0.00">
				<input type="hidden" name="selected_diamond_price" id="selected_diamond_price" value="0.00">
				<input type="hidden" name="selected_final_price" id="selected_final_price" value="0.00">
				<input type="hidden" name="selected_diamond_shape" id="selected_diamond_shape" value="{{ $data->diamond_shape }}">
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
						<a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to basket</a>
					</div>
					<div class="product-req-appointment">
						<a type="button" class="btn-bg-small" data-bs-toggle="modal" data-bs-target="#requestAppointment"> Request an Appointment </a>
					</div>
				</div>
				<div class="product-postactions">
					<a href="https://www.google.com/search?q=marlows+diamond+google+review&amp;oq=marlows+diamond+google+review&amp;aqs=chrome..69i57.8073j0j1&amp;sourceid=chrome&amp;ie=UTF-8#lrd=0x4870bcedd24f2c3d:0x1dc68827b10987fa,1,,," class="review-action" target="_blank"> Reviews </a>
					<a class="store-locator" href="{{asset('visit-us')}}">Store Locator</a>
					<a target="_blank" id="productCertificateLink" class="view-certificate" href="#">View Certificate</a>
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


@include('front.pages.app_products.elements.faqs')
@include('front.pages.app_products.elements.guide')

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

					<form id="contactForm">
					@csrf
                        <input type="hidden" name="custom_url" id="custom_url" value="{{url()->full()}}">
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
						<div class="g-recaptcha" data-sitekey="6LfQrxUgAAAAAFD1c2BmyaKHy1F20WUJEloRiyie">
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

@endsection

@section('js')

	<script src="{{$url}}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script>

			function blankForm(){
				$('input[name="title"]').val('');
				$('input[name="email"]').val('');
				$('input[name="phone"]').val('');
				$('textarea[name="description"]').val('');
				$("button[type='submit']").prop('disabled',false);
				$('#requestAppointment').modal('hide');
				grecaptcha.reset();
			}

		$(document).ready(function(){
            $('form#contactForm').validate({
                rules: {
                    title: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                    },
                    description: {
                        required: true,
                    }
                },
                messages: {
                    title: {
                        required: 'Name is required',
                    },
                    email: {
                        required: 'Email is required',
                        email: 'Valid email is required',
                    },
                    phone: {
                        required: 'Phone is required',
                    },
                    description: {
                        required: 'Description is required',
                    }
                },
                submitHandler: function (form) {
                    if (grecaptcha.getResponse()) {
                        var form_data = new FormData(form);
                        $(form).find("button[type='submit']").prop('disabled',true);
                        $("button[type='submit']").text("Please Wait...");
                        $.ajax({
                            url: "{{ route('contact') }}",
                            method: "POST",
                            cache:false,
                            contentType:false,
                            processData: false,
                            data: form_data,
                            success: function (response) {
                                blankForm();
                                $("button[type='submit']").text("Send Message");
                                // $(this).find("button[type='submit']").prop('disabled',true);
                                // console.log(response);
                                // return false;
                                if(response.status == 200){
                                    toastr.success(response.success);
                                    // window.location.reload();
                                }else{
                                    toastr.info(response.error);
                                }
                            }
                        });
                    } else {
                        alert('Please confirm captcha to proceed')
                    }
                }
            });

            getRelatedProduct();

			getCustomFilter(); //getProdVideo();

			$(".viewdiamond-btn").click(function(){
				$(".diamond-table").toggle();
			});

			getSelectedAttributePrice();

			$('#carat').on('change',function(){
                console.log("checking");
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
		});



		function getCustomFilter(){

			$.ajax({
                type: 'POST',
                url: '{{route("app_products.customfilternew")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
                    'metal-type' : '{{ isset($requestData["metal-type"]) ? $requestData["metal-type"] : "" }}',
                },
                success: function (res) {

					$('#filterDataDesign .type-variations-row').html(res);
                    //getProdVideo();

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
					'setting_price': getNumberFromCurrency($('#selected_variation_price').val()) || 0, //parseFloat($('#price').val()) || 0;
					'price': getNumberFromCurrency($('#selected_final_price').val()) || 0, //parseFloat($('#price').val()) || 0;
					'certificatelink': $('#certificate_url').val() || '',
					'shape': $('#selected_diamond_shape').val() || '',
					'certificate': $('#selected_diamond_certno').val() || '',
                    'jsondata':$('input[name="selectrefinedata"]:checked').data('jsonvalue'),
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



			$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending... </span>');
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
                    if(res.statuscode == 200){
                        // $('#finaldiamondprice').html(res.finalPrice);
                        if(res.finalPrice == res.discountedPrice){
                            $('#finaldiamondprice').html('<span class="price"> {{MY_CURRENCY_SYMBOL}} '+res.discountedPrice+' </span>');
                        }else{
                            $('#finaldiamondprice').html('<del>{{MY_CURRENCY_SYMBOL}} '+Math.round(res.finalPrice)+'</del> <span class="price" > {{MY_CURRENCY_SYMBOL}} '+res.discountedPrice+' </span>');
                        }
						$('#selected_final_price').val(res.finalPrice);
						$('#selected_diamond_price').val(res.diamondPrice);
						$('#selected_discounted_price').val(res.discountedPrice);
						$('#selected_setting_price').val(res.settingPrice);
						$('#selected_diamond_certno').val(res.Stock_NO);
						$('#certificate_url').val(res.CertificateLink);
						$('#productCertificateLink').attr('href',res.CertificateLink);
						$('#addtobasket').removeClass('disabledAnchor');
                    }else{
                        $('#finaldiamondprice').html('<span class="price-not-found"> Sorry we have no diamonds matching your selection. </span>');
                        $('#refineSearchData').html("No Data Found");
                        // $('#finaldiamondprice').text('Sorry we have no diamonds matching your selection.');
                        $('#selected_final_price').val('');
						$('#selected_diamond_price').val('');
						$('#selected_diamond_certno').val('');
						$('#certificate_url').val('');
						$('#productCertificateLink').attr('href','');
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
            $('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending... </span>');
			$.ajax({
                type: 'POST',
                url: '{{route("products-final-price")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'variation_price' : parseFloat($('#selected_variation_price').val()),
					'setting_price' : parseFloat($('#selected_setting_price').val().split(",").join("")),
					'discounted_price' : parseFloat($('#selected_discounted_price').val().split(",").join("")),
					'diamond_price' : parseFloat($('#selected_diamond_price').val().split(",").join("")),
					'slug': '{{$data->slug}}'
                },
                success: function (res) {
                    // console.log("res");
                    // console.log(res);
                    // return false;
					$('#finaldiamondprice').html("");
					if(res.finalPrice != ''){
						// $('#finaldiamondprice').text(res);
                        if(res.finalPrice == res.discountedPrice){
                            $('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+res.finalPrice+' </span>');
                            $('#selected_final_price').val(res.finalPrice);
                        }else{
                            // $('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+res+' </span>');
                            $('#finaldiamondprice').html('<del>{{MY_CURRENCY_SYMBOL}} '+Math.round(res.finalPrice)+'</del> <span class="price" > {{MY_CURRENCY_SYMBOL}} '+res.discountedPrice+' </span>');
                            // $('#selected_final_price').val(res.finalPrice);
                        }

						$('#addtobasket').removeClass('disabledAnchor');
					}else{
						$('#finaldiamondprice').html('<span class="price-not-found"> Sorry we have no diamonds matching your selection. </span>');
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
