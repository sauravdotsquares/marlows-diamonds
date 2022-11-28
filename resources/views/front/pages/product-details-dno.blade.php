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
		.dropdown-menu:before{content: " ";position:absolute;top:-20px;right:50px;border:10px solid transparent;border-bottom-color:#fff;}span.price-not-found {font-size: 14px;color: #8e2e65;font-weight: bold;}
		.error {color: #e74c3c !important;}
		div#finaldiamondprice span del {font-size: 20px;}
	</style>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="{{ asset('assets/vendors/fancybox-master/dist/jquery.fancybox.min.css') }}" rel="stylesheet" />


@endsection

@section('content')

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">

			<div class="product-info-media">
				{{-- <a href="#" class="product-gallery__trigger"><i class="fa fa-search" aria-hidden="true"></i></a> --}}
                @if($plainbandMulti==false)
                    <div id="carousel" class="owl-carousel">
                        @if($variationImages)
                            @foreach($variationImages as $images)
                                <div class="item product-items-carousel">
                                    <a data-fancybox="gallery2" href="{{asset('/storage/'.$images->vari_image)}}" data-caption="{{isset($data->title)?$data->title:''}}">
                                        <img src="{{asset('/storage/'.$images->vari_image)}}" alt="{{isset($data->title)?$data->title:''}}">
                                    </a>
                                </div>
                            @endforeach
                        @endif
							


                        @if(isset($prodImages) && $prodImages)
                            @foreach($prodImages as $images)
                                @if(isset($images->image_url) && !empty($images->image_url))
                                    @php
                                        $explode = explode('/',$images->image_url);
                                        $explode1 = explode('.',$explode[1]);
                                    @endphp
                                    @if(isset($images->is_featured) && $images->is_featured != 1)
                                        <div class="item product-items-carousel">
                                            <a data-fancybox="gallery2" href="{{asset('/storage/'.$images->image_url)}}" data-caption="{{$explode1[0]}}">
                                                <img src="{{asset('/storage/'.$images->image_url)}}" alt="{{isset($data->title)?$data->title:''}}">
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                @else
                    <video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
                        @if(isset($data->getProductVariation) && !empty($data->getProductVariation[0]->vari_video))
                            <source src="{{ asset('storage/'.$data->getProductVariation[0]->vari_video)}}" type="video/mp4" type="video/mp4" />
                        @else
                            <source src="" type="video/mp4" type="video/mp4" />
                        @endif
                    </video>
                @endif
			</div>
			<div class="product-info-main">
				<div class="product-title-name">
					<h1>{{isset($data->title)?$data->title:''}}</h1>
				</div>

				@if($plainband==false)
					@if(!in_array('exclusive-to-marlows', $all_categories_slug) )
					<div class="diamond-type">
						<label>Choose Your Diamond</label>
						@if(isset($requestData["diamond_type"]) && $requestData["diamond_type"] == 'mined')
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond"  checked value="mined">
								<span>Mined Diamond</span>
							</div>
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond" value="lab_grown">
								<span>Lab Grown Diamond</span>
							</div>
						@else
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond" value="mined">
								<span>Mined Diamond</span>
							</div>
							<div class="d-type-input">
								<input type="radio" name="attribute_choose-your-diamond" checked value="lab_grown">
								<span>Lab Grown Diamond</span>
							</div>
						@endif
					</div>
					@endif
				@endif

				<div class="product-type-variations" id="filterDataDesign">
					<div class="type-variations-row">
					</div>
				</div>
				<div id="apiCustomDesign">

				</div>
				<div class="product-decriptions">
					{!!$data->description!!}
				</div>
                <div class="product-finder-price"  id="discountedTotalPrice">

                </div>
                <div class="product-finder-price" id="finaldiamondprice">

				</div>
				{{-- <div class="product-finder-price">
					<span class="price">{{MY_CURRENCY_SYMBOL}} <span id="finaldiamondprice">0.00</span> </span>
				</div> --}}

				<input type="hidden" name="selected_variation_price" id="selected_variation_price" value="{{isset($data->getProductVariation[0]->regular_price)?$data->getProductVariation[0]->regular_price:0.00}}">
                <input type="hidden" name="selected_discounted_price" id="selected_discounted_price" value="0.00">
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

				{{-- <div class="finance-available" ng-controller="DekopayController">
					<a href="javascript:void(0)" ng-click="financeOptions()">
						<i class="fa fa-credit-card" aria-hidden="true"></i>
						<p>Finance Available
							<span>see options</span>
						</p>
					</a>
					<div class="doko-img">
						<img src="{{asset('')}}assets/images/Deko_square_colour_whiteBG200px_wide.png" alt="doko">
					</div>
				</div> --}}

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

<!-- Modal -->
{{-- @include('front.includes.dekopay-finance-options') --}}
<?php
    if($plainbandMulti){
        $plainbandMulti = 1;
    }else{
        $plainbandMulti = 0;
    }
?>
@endsection

@section('js')
	<script src="{{$url}}"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="{{ asset('assets/vendors/fancybox-master/dist/jquery.fancybox.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script>

		const imagesPath = "{{asset('/storage/')}}/";
		const customSlider = "{{ !empty($customSlider) ? $customSlider : '0'  }}"

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

            $(document).on('change','#metal-type',function(){
				getProdVideo('onChange');

			});
		})

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
					if(action!=null && action=='onChange'){

                        // getSelectedVariationsData();
                    }
						// getFinalPrice();
				}
			});
		}

		function getSelectedVariationsData(){
			$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending... </span>');
			var diamond_type = $('input[name="attribute_choose-your-diamond"]:checked').val();
			var variations = [];
			$('.type-variations-row select').each(function(i, sel){

				if($(sel).attr('name')!='finger-size')
					variations.push($(sel).val());
			});
            var multistone = '{{$plainbandMulti}}';
            var jewellery = '{{$plainbandJewellery}}';
			var data_slug = '{{url("/")}}';
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

					if(typeof res.formula!='undefined' && res.formula){

						$('#selected_variation_price').val(res.regular_price);
						$('#selected_final_price').val(Math.round(regular_p));

						if(res.statusCode == 500){
							$('#finaldiamondprice').html('<span class="price-not-found"> Sorry we have no diamonds matching your selection. </span>');
						}else if(!regular_p){
							$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+ res.regular_price_with_vat_discount  + ' </span>');
						}else{
							if(regular_p == res.regular_price_with_vat_discount){
								$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+ res.regular_price_with_vat_discount + ' </span>');
							}else{
								$('#finaldiamondprice').html('<span><del>{{MY_CURRENCY_SYMBOL}} '+ regular_p +'</del> </span> <span class="price" >{{MY_CURRENCY_SYMBOL}} '+ parseFloat(res.regular_price_with_vat_discount).toFixed(2) + ' </span>');

								$('#selected_discounted_price').val(res.regular_price_with_vat_discount);
							}
						}

					}else{
						if(res.regular_price!='' || res.regular_price!='0.00'){
							
							var regular_p = Math.round(res.regular_price_with_vat);
							
							// console.log('regular_p',regular_p)
							// if(diamond_type=='lab_grown' && regular_p<=3000){
							// 	regular_p_final = regular_p-(regular_p*0.35);
							// }else if(diamond_type=='lab_grown' && regular_p>3000){
							// 	regular_p_final = regular_p-(regular_p*0.5);
							// }else{
							// 	regular_p_final = regular_p;
							// }
							// if(multistone == 1){
							//     regular_p_final = regular_p_final* 1.5;
							// }
							// if(jewellery == 1){
							//     regular_p_final = regular_p_final* 1.1;
							// }
							$('#selected_variation_price').val(res.regular_price);
							$('#selected_final_price').val(Math.round(regular_p));
							if(res.statusCode == 500){
								$('#finaldiamondprice').html('<span class="price-not-found"> Sorry we have no diamonds matching your selection. </span>');
							}else if(!regular_p){
								console.log('regular_p','regular_p', regular_p)
								$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+ Math.round(res.regular_price_with_vat_discount)+ ' </span>');
							}else{
								if(regular_p == res.regular_price_with_vat_discount){
									console.log('regular_p', regular_p)
									$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+ Math.round(res.regular_price_with_vat_discount)+ ' </span>');
								}else{
									console.log('regular_p', regular_p, 1258)
									$('#finaldiamondprice').html('<span><del>{{MY_CURRENCY_SYMBOL}} '+Math.round(regular_p)+'</del> </span> <span class="price color-red" >{{MY_CURRENCY_SYMBOL}} '+ Math.round(res.regular_price_with_vat_discount)+ ' </span>');

									$('#selected_discounted_price').val(res.regular_price_with_vat_discount);
								}
							}
							// $('#finaldiamondprice').text();
						}else{
							console.log('From here')
							var sale_p = Math.round(res.sale_price_with_vat);

							if(diamond_type=='lab_grown' && sale_p<=3000){
								sale_p_final = sale_p-(regular_p*0.35);

							}else if(diamond_type=='lab_grown' && sale_p>3000){
								sale_p_final = sale_p-(sale_p*0.5);

							}else{
								sale_p_final = sale_p;
							}
							if(multistone == 1){
								sale_p_final = sale_p_final* 1.5;
							}
							if(jewellery == 1){
								sale_p_final = sale_p_final* 1.1;
							}
							$('#selected_variation_price').val(res.sale_price);
							$('#selected_final_price').val(Math.round(sale_p_final));
							// $('#finaldiamondprice').text(Math.round(sale_p_final));
							$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+Math.round(sale_p_final)+' </span>');
						}
					}



					if( parseInt(customSlider) && typeof res.vari_image!='undefined' && res.vari_image && res.vari_image!=null){
						const items = $('#carousel').find('.owl-item');
						const itemToAddInCarousel = `<div class="item product-items-carousel custom-item-carousel" data-position="${items.length+1}">
															<a data-fancybox="gallery2" href="${imagesPath + res.vari_image}" data-caption="${res.vari_image}">
																<img src="${imagesPath + res.vari_image}" alt="${res.vari_image}">
															</a>
													</div>`;
						

						// const items = $('#carousel').find('.owl-item');
						$('#carousel').find('.owl-item').each((index, element)=>{
							if($(element).find('.custom-item-carousel').length){
								$('#carousel').trigger('remove.owl.carousel',index);
							}
						});
						
						const pendingItems = $('#carousel').find('.owl-item');
						$('#carousel')
						.trigger('add.owl.carousel', [itemToAddInCarousel])
						.trigger('refresh.owl.carousel')
						.trigger('to.owl.carousel', [pendingItems.length, 0])
						.trigger('refresh.owl.carousel')
						.trigger('stop.owl.autoplay')
						.trigger('play.owl.autoplay',[7000, 300])
					}else if(res.vari_image!='' && res.vari_image!=null){
						// console.log('Im here')

						const items = $('#carousel').find('.owl-item');
						items.each((index, element)=>{
							$(element).find('.product-items-carousel').attr('data-position', index);
						});

						console.log($("#carousel .owl-stage .owl-item").find('a[href*="'+res.vari_image+'"]').parent().data( 'position' ));

						if(res.vari_image!='' && res.vari_image!=null){
							variation_image = data_slug+'/storage/'+res.vari_image;
							var $speed = 0;
							$('#carousel').trigger('to.owl.carousel', [$("#carousel .owl-stage .owl-item").find('a[href*="'+variation_image+'"]').parent().data( 'position' ), $speed])
						}
					}

					/** TODO: remove in carousel */
					/** TODO: Add image in carousel */

					// if(res.vari_image!='' && res.vari_image!=null){
					// 	variation_image = data_slug+'/storage/'+res.vari_image;
					// 	var $speed = 0;
					// 	$('#carousel').trigger('to.owl.carousel', [$("#carousel .owl-stage .owl-item").find('a[href*="'+variation_image+'"]').parent().data( 'position' ), $speed])
					// }

				}
			});
		}
		function getCustomFilter(){
			$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending... </span>');
			$.ajax({
                type: 'POST',
                url: '{{route("custom-filter")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
                    'type' : '{{$plainbandMulti}}',
                    'metal-type' : '{{ isset($requestData["metal-type"]) ? $requestData["metal-type"] : "" }}',
                    'carat' : '{{ isset($requestData["carat"]) ? $requestData["carat"] : "" }}',
                    'width-mm': '{{ isset($requestData["width-mm"]) ? $requestData["width-mm"] : "" }}',
                    'total-diamond-weight': '{{ isset($requestData["total-diamond-weight"]) ? $requestData["total-diamond-weight"] : "" }}',
                },
                success: function (res) {

					$('#filterDataDesign .type-variations-row').html(res);
					getSelectedVariationsData();
                    return false;
                }
            });
		}

		function addtobasketFunction(getUrl){
            var trdata = $('#finaldiamondprice .price').text().replace(/[^0-9]/gi, '');
			$.ajax({
                type: 'POST',
                url: getUrl,
                data: {
                    '_token': "{{csrf_token()}}",
					'carat' : $('#carat').val(),
					'total-diamond-weight' : $('#total-diamond-weight').val(),
					'color' : $('#diamond-colour').val(),
					'clarity' : $('#diamond-clarity').val(),
					'width-mm' : $('#width-mm').val(),
					'grade' : $('#diamond-grade').val(),
					'fingersize' : $('#finger-size').val(),
					'metalcolor' : $('#metal-type').val(),
					'certificate' : $('#diamond-certificate').val(),
                    'choose_diamond': $('input[name="attribute_choose-your-diamond"]:checked').val(),
					'slug' : '{{$data->slug}}',
					'price':parseInt(trdata) || 0, //parseFloat($('#price').val()) || 0;
					'discounted_price':parseInt($('#selected_discounted_price').val()) || 0, //parseFloat($('#price').val()) || 0;
					'final_price':parseInt($('#selected_final_price').val()) || 0, //parseFloat($('#price').val()) || 0;
                    'setting_price': parseInt(trdata) || 0, //parseFloat($('#price').val()) || 0;
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
	      var $owl = $('#carousel');

			$owl.children().each( function( index ) {
			  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
			});
	        $owl.owlCarousel({
			  autoplay: true,
			  rewind: true, /* use rewind if you don't want loop */
			  /*margin: 20,*/
			   /*
			  animateOut: 'fadeOut',
			  animateIn: 'fadeIn',
			  */
			  responsiveClass: true,
			  //autoHeight: true,
			  autoplayTimeout: 7000,
			  smartSpeed: 300,
			  nav: true,
			  items : 1,
			});

            $(document).on('click','.product-gallery__trigger',function(e){
                    e.preventDefault();
                    $('#carousel-zoom .item:first-child a').click();
            });

	    });
	</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
