@extends('layouts.front.app')
@inject('footer_settings', 'App\Models\Settings')
@section('css')
	<style>
		.thumbnail{position:relative;padding:0;margin-bottom:20px}
		.thumbnail img{width:80%}
		.thumbnail .caption{margin:7px}
		.main-section{background-color:#f8f8f8}
		.dropdown{float:right;padding-right:30px}
		.btn{border:0;margin:10px 0;box-shadow:none !important}
		.dropdown .dropdown-menu{padding:20px;top:30px !important;width:350px !important;left:-110px !important;box-shadow:0 5px 30px #000}
		.total-header-section{border-bottom:1px solid #d2d2d2}
		.total-section p{margin-bottom:20px}
		.cart-detail{padding:15px 0}
		.cart-detail-img img{width:100%;height:100%;padding-left:15px}
		.cart-detail-product p{margin:0;color:#000;font-weight:500}
		.cart-detail .price{font-size:12px;margin-right:10px;font-weight:500}
		.cart-detail .count{color:#c2c2dc}
		.checkout{border-top:1px solid #d2d2d2;padding-top:15px}
		.checkout .btn-primary{border-radius:50px;height:50px}
		.dropdown-menu:before{content:" ";position:absolute;top:-20px;right:50px;border:10px solid transparent;border-bottom-color:#fff}
		.disabledAnchor a{pointer-events:none !important;cursor:default;color:#fff}span.price-not-found{font-size:14px;color:#8e2e65;font-weight:700}
		.error{color:#e74c3c !important}div#finaldiamondprice del{font-size:20px}

		
        .hide-items{ display: none; }
        .show-items{  display: flex; }
		.metaltypeval{font-size: 15px;font-weight: bold;color:black}
		.tableheading{font-size: 17px; font-weight: bold;color:#fff !important;background:#8e2e65 }
		.tablehover:hover {background-color: #8e2e65; color: #fff}
		.policy0icon{border: 1px solid #8e2e65;padding: 10px 15px 0px;width: 24%;text-align: center;border-radius: 10px;}
		.policysection{margin-top: 20px;display: flex;flex-wrap: wrap;justify-content: space-between;}
		.policyheading{color: #8e2e65;font-weight: bold;text-transform: capitalize;font-size: 13px;}
		.policy0icon{border: 1px solid #8e2e65;padding: 7px 1px 0px;width: 24%;text-align: center;border-radius: 10px;}
		.policyimg{width: 40px;margin: 0 0 11px;}
		.policysection a {color: #8e2e65;}
		@media only screen and (max-width: 600px) {.policy0icon{border: 1px solid #8e2e65;padding: 10px 15px 0px;width: 48%;text-align: center;border-radius: 10px;margin-top: 10px;}}
</style>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="{{ asset('assets/css/jquery.fancybox.css?').env('VERSION')}}" rel="stylesheet" />

@endsection

@section('content')

@section('dynamic_og_image')<meta property="og:image" content="{{env('APP_IMAGE_URL').'/storage/'.$prodImages[0]->image_url}}" />@endsection
<!-- product info and media -->


{{-- pop up content start from here --}}

<div class="modal fade sharesocial" id="sharesocial" tabindex="-1" aria-labelledby="sharesocialLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body">
            <h3 class="modal-title" id="sharesociallLabel">Share</h3>
            <div id="copy-link">
                <p id="copy-text">{{ URL::current() }}</p>
                <button class="copy-btn" onclick="copyToClipboard()">Copy</button>
            </div>
        </div>


		@php
        
		$baseUrl = 'https://marlows-diamonds.co.uk';
		$productUrl = $baseUrl . '/product/' . $data->slug;
		@endphp




        <div class="sharesocialicon">
            <ul>
                <li><a href="{{ Share::page(URL::current())->facebook()->getRawLinks() }}" target="_blank" class="btn btn-facebook">
						<i class="fa fa-facebook"></i>
					</a></li>
				<li>
					<a href="https://twitter.com/intent/tweet?text=Default+share+text&url={{ urlencode($productUrl) }}" target="_blank" class="btn btn-twitter">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</a>
				</li>
				<li>
					<a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode($productUrl) }}" target="_blank" class="btn btn-pinterest">
						<i class="fa fa-pinterest"></i>
					</a>
				</li>

				<li>
					<a href="https://api.whatsapp.com/send/?text={{ urlencode($productUrl) }}&type=custom_url&app_absent=0" target="_blank" class="btn btn-whatsapp">
						<i class="fa fa-whatsapp"></i>
					</a>
				</li>
            </ul>
        </div>





    </div>
    </div>
  </div>
{{-- ends here --}}

<div class="product-detail-wraper">
	<div class="container">
		<div class="product-detail-row flexed flex-flex-wrap">
			<div class="product-info-media">
			<div class="product-info-media-site-icon">
				<a href="#" class="product-gallery__trigger"><i class="fa fa-search" aria-hidden="true"></i></a>

				@php
					$wishlist = session()->get('wishlist', []);
                     $wishListClass = "fa-heart-o";
					if(array_key_exists($data->id,$wishlist)){
						$wishListClass = "fa-heart";
					}
				@endphp
				<a href="javascript:void(0);"  id="productWishListImage" ><i class="fa {{$wishListClass}} wishcount" aria-hidden="true"></i></a>

				<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sharesocial" class=""><i class="fa fa-share-alt" aria-hidden="true"></i></a>
			</div>
			<div id="carousel" class="owl-carousel">
				@if(!empty($data->getProductVariation[0]->vari_video))
					<div class="item product-items-carousel">
						@if(isset($data->getProductVariation) && !empty($data->getProductVariation[0]->vari_video))
							<a id="variationAnchorVideo" data-fancybox="gallery1" href="{{env('APP_IMAGE_URL').'/storage/'.$data->getProductVariation[0]->vari_video}}" data-caption="">
								<video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
										<source src="{{env('APP_IMAGE_URL').'/storage/'.$data->getProductVariation[0]->vari_video}}" type="video/mp4" type="video/mp4" />
								</video>
							</a>
						@else
							<a id="variationAnchorVideo" data-fancybox="gallery1" href="" data-caption="">
								<video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
									<source src="" type="video/mp4" type="video/mp4" />
								</video>
							</a>
						@endif
					</div>
				@endif
				@if($prodImages)
					@foreach($prodImages as $key=>$images)
						@php
							$explode = explode('/',$images->image_url);
							$explode1 = explode('.',$explode[1]);
						@endphp
						<div class="item product-items-carousel  @if($key==0) active @endif">		
							<a data-fancybox="gallery1" href="{{env('APP_IMAGE_URL').'/storage/'.$images->image_url}}" data-caption="{{$explode1[0]}}">
								<img class="thumbnail-src" src="{{env('APP_IMAGE_URL').'/storage/'.$images->image_url}}" alt="{{$explode1[0]}}">
							</a>
						</div>
					@endforeach
				@endif
			</div>
			<div id="thumbnail-carousel" class="owl-carousel">
				@if(isset($data->getProductVariation[0]->vari_video))
				<a class="btn-360" data-index="{{ $key }}" data-video="{{env('APP_IMAGE_URL').'/storage/'.$data->getProductVariation[0]->vari_video}}">
					<img src="/assets/images/360icon.jpg" alt="360">
                </a>
				@if($prodImages)
					@foreach($prodImages as $key=>$images)
						@php
							$explode = explode('/',$images->image_url);
							$explode1 = explode('.',$explode[1]);
						@endphp
						<div class="item thumbnail-item">
							<a href="javascript:void(0)" class="thumbnail-link" data-index="{{ $key }}">
								<img class="thumbnail-img" src="{{env('APP_IMAGE_URL').'/storage/'.$images->image_url}}" alt="{{$explode1[0]}}">
							</a>
						</div>
					@endforeach
				@endif
			 @endif
			</div>
				<!-- <video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
					@if(isset($data->getProductVariation) && !empty($data->getProductVariation[0]->vari_video))
						<source src="{{env('APP_IMAGE_URL').'/storage/'.$data->getProductVariation[0]->vari_video}}" type="video/mp4" type="video/mp4" />
					@else
						<source src="" type="video/mp4" type="video/mp4" />
					@endif
				</video> -->
				<div class="productdetailbtns">
					<a type="button" class="btn-bg-small" onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal" data-bs-target="#requestAppointment"> Book an Appointment </a>
					<a href="tel:447535425059" class="btn-bg-small">Contact Us</a>
					<a target="_blank" href="https://maps.app.goo.gl/Xqo2hCwJrVK4FbfB6" class="btn-bg-small">Get Directions</a>
				</div>
				<div id="myDivChanges"></div>
			</div>
			<?php 
				$getParentCategoryArray = explode(',',$data->cat_details);
				$getParentCategory = '';
				if(in_array('Engagement Rings',$getParentCategoryArray)){
					$getParentCategory = $getParentCategoryArray[0];
					$regular_price = $data->AdditionalPriceMetalType['regular_price'];
					$lab_price = $data->AdditionalPriceMetalType['lab_price'];
				}
			?>
			<input type="hidden" name="lab_price" id="lab_price" value="{{isset($lab_price)?$lab_price:742}}">
				
			<div class="product-info-main">
				<div class="product-title-name">
					<h1>{{isset($data->title)?$data->title:''}}</h1>
				</div>
				
				<div class="diamond-type">
					<label>Diamond Type</label>
					<div class="d-type-input">
						<input type="radio" name="attribute_choose-your-diamond" value="mined_diamond"  id="mined_item" class="diamond_type">
						<span>Mined Diamond</span>
					</div>
					<div class="d-type-input">
						<input type="radio" name="attribute_choose-your-diamond" value="lab_grown" id="lab_item" class="diamond_type" checked>
						<span>Lab Grown Diamond</span>
					</div>
				</div>
                <?php $default = "lab_grown"; ?>
				<a class="customise-ring" href="https://marlows-diamonds.co.uk/ring-size-guide" target="_blank"><b>Customise your Ring</b></a>

				<div class="product-type-variations" id="filterDataDesign">
					<div class="type-variations-row">
					</div>
				</div>
                @if($plainbandMulti==false)

				{{-- Show items for lab grown only --}}
				<div id="apiCustomDesign">
					<div class="type-variations-row1 lab_item mined_lab_items {{ $default == "lab_grown" ? 'show-items' : 'hide-items' }}">
						<div class="type-variations-col">
							<label for="lab_grown_carat" class="label"> Central Diamond Weight </label>
							<select class="form-control lab_price_update_items " name="carat" id="lab_grown_carat">
								<!--<option value="0.30-0.39" selected="selected">0.30-0.39</option>-->
								<option value="0.50-0.59">0.50-0.59</option>
								<option value="0.70-0.79">0.70-0.79</option>
								<option value="1.00-1.19" selected>1.00-1.19</option>
								<option value="1.50-1.69">1.50-1.69</option>
								<option value="2.00-2.49">2.00-2.49</option>
								<option value="2.50-2.99">2.50-2.99</option>
								<option value="3.00-3.99">3.00-3.99</option>
								<option value="4.00-4.99">4.00-4.99</option>
								<option value="5.00-5.99">5.00-5.99</option>

								
							</select>
						</div>
						<div class="type-variations-col">
							<label for="lab_grown_colour" class="label"> Colour </label>
							<select class="form-control lab_price_update_items " name="diamond-colour" id="lab_grown_colour">
								<option value="D" selected="selected">D - Exceptional White +</option>
								<option value="E">E - Exceptional White</option>
								<option value="F">F - Rare White +</option>
							</select>
						</div>
					</div>
				</div>

				{{-- Show items for lab grown only --}}
				<div class="type-variations-row1 lab_item mined_lab_items {{ $default == "lab_grown" ? 'show-items' : 'hide-items' }}">
					<div class="type-variations-col">
						<label for="lab_grown_clarity" class="label"> Clarity </label>
						<select class="form-control lab_price_update_items " name="diamond-clarity" id="lab_grown_clarity">
							<option value="VS1">VS1 - Very Small Inclusions</option>
							<option value="VS2" selected>VS2 - Very Small Inclusions</option>
							<option value="VVS1">VVS1 - Minute Inclusions</option>
							<option value="VVS2">VVS2 - Minute Inclusions</option>
						</select>
					</div>
				</div>

				{{-- Show items for mined only --}}
				<div id="apiCustomDesign">
					<div class="type-variations-row1 mined_item mined_lab_items {{ $default == "mined" ? 'show-items' : 'hide-items' }}">
						<div class="type-variations-col">
							<label for="carat" class="label"> Central Diamond Weight </label>
							<select class="form-control" name="carat" id="carat">
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
							<label for="diamond-colour" class="label"> Colour </label>
							<select class="form-control" name="diamond-colour" id="diamond-colour">
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

					<div class="type-variations-row1 mined_item mined_lab_items {{ $default == "mined" ? 'show-items' : 'hide-items' }}">
						<div class="type-variations-col">
							<label for="diamond-clarity" class="label"> Clarity </label>
							<select class="form-control" name="diamond-clarity" id="diamond-clarity">
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
                                <label for="diamond-grade" class="label"> Cut Grade </label>
                                <select class="form-control" name="diamond-grade" id="diamond-grade">
                                    <option value="">Choose an option</option>
                                    <option value="EX" selected="selected">Excellent</option>
                                    <option value="VG">Very Good</option>
                                    <option value="GD">Good</option>
                                </select>
                            </div>
                        @endif
                        <div class="type-variations-col{{($data->diamond_shape == 'ROUND')?'-one':''}}">
							<label for="diamond-certificate" class="label"> Certificate </label>
							<select class="form-control" name="diamond-certificate" id="diamond-certificate">
								<option value="GIA" selected="selected">GIA</option>
								<option value="IGI">IGI</option>
							</select>
						</div>
					</div>
					<div class="type-variations-row1 mined_item mined_lab_items {{ $default == "mined" ? 'show-items' : 'hide-items' }}">
					</div>
					<div class="view-diamond-sec mined_item_block mined_lab_items {{ $default == "mined" ? 'show-items' : 'hide-items' }}">
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


				<div class="product-decriptions product-description-common product-description-common_mined_item" style="display: none;">
					{!!$data->description ? $data->description : $data->description!!}
				</div>
				<div class="product-decriptions product-description-common product-description-common_lab_item">
					{!! $data->lab_description ? $data->description.'<br>'.$data->lab_description :  $data->description  !!}
				</div>
				<p class="delieveryDescription">
					{!! str_replace(
						'Contact us',
						'<a href="/contact" style="text-decoration: underline; color: #8e2e65;">Contact us</a>',
						$getVariationDescription->description
					) !!}
				</p>
				<p class="customringlink">If you want to customize your ring please <a href="javascript:void(0)" onclick="$('label.error').css('display', 'none');return false;"  data-bs-toggle="modal" data-bs-target="#requestAppointment"><b>Book an appointment</b></a></p>

				<div class="price-section">
					<div style="display: flex;">
						<h4><del style="color:#000" id="shopPrice"> </del> </h4>
						<div class="product-finder-price" id="finaldiamondprice" style="">
						</div>
					</div>
					<p><span style="color:green">You Save : <span id="savePrice"></span></span> |  <del id="rrpPrice"> </del> </p>
				</div>
				
				
				<input type="hidden" id="getLabDiamondPrices" name="getLabDiamondPrices" value="">


				<input type="hidden" id="certificate_url" name="certificate_url" value="">
				<input type="hidden" name="selected_variation_price" id="selected_variation_price" value="{{isset($variationDetails->regular_price)?$variationDetails->regular_price:$variationDetails->sale_price}}">
				<input type="hidden" name="selected_setting_price" id="selected_setting_price" value="0.00">
				<input type="hidden" name="selected_discounted_price" id="selected_discounted_price" value="0.00">
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
						<a type="button" class="btn-bg-small" onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal" data-bs-target="#requestAppointment">
						Request an Appointment
						</a>
					</div>
				</div>
				<div class="product-postactions">
					<a href="https://g.page/r/CXBl1avOXsIkEB0/review " class="review-action" target="_blank">
						Reviews
					</a>
					<!-- <a target="_blank" class="review-action" href="#">Reviews</a> -->
					<a class="store-locator store-locator-border-right" href="{{asset('visit-us')}}">Store Locator</a>
					<!-- <a target="_blank" id="productCertificateLink" class="view-certificate mined-certificate" href="#">View Certificate</a> -->
				</div>

				<?php
				$getMonthTextArray = getMonthwiseDiscountText();
				$getCurrentMonth = (int)date('m');
				$now = new DateTime("now");
				$lastDate = new DateTime('now');
				$lastDate->modify('last day of this month');
				$dist_future = $lastDate->format('m/d/Y');
				 ?>

				<div class="discount-offerproduct">
					<h3>{!! strtoupper($getMonthTextArray[$getCurrentMonth]) !!}</h3>
					<h4>Selected Lines only. <a href="/terms" style="text-decoration: underline; color: #fff;">T&C's </a> apply*</h4>
				</div>
				<div id="social-links" class="social-share-buttons">
					<!-- Facebook -->
					<a href="{{ Share::page(URL::current())->facebook()->getRawLinks() }}" target="_blank" class="btn btn-facebook">
						<i class="fa fa-facebook"></i>
					</a>

					<!-- Twitter -->
					<a href="{{ Share::page(URL::current())->twitter()->getRawLinks()['twitter'] }}" target="_blank" class="btn btn-twitter">
						<i class="fa fa-twitter" aria-hidden="true"></i>
					</a>

					<!-- LinkedIn -->
					<a href="{{ Share::page(URL::current())->pinterest()->getRawLinks()['pinterest'] }}" target="_blank" class="btn btn-linkedin">
						<i class="fa fa-pinterest"></i>
					</a>

					<!-- WhatsApp -->
					<a href="{{ Share::page(URL::current())->whatsapp()->getRawLinks()['whatsapp'] }}" target="_blank" class="btn btn-whatsapp">
						<i class="fa fa-whatsapp"></i>
					</a>
				</div>
				{{-- <div class="finance-available" ng-controller="DekopayController">
					<a href="javascript:void(0)" ng-click="financeOptions()">
						<i class="fa fa-credit-card" aria-hidden="true"></i>
						<p>Finance Available
							<span>see options</span>
						</p>
					</a>
					<div class="doko-img">
						<i class="diamond-icon search-dekopayicon"></i>
					</div>
					
					
				</div> --}}
				<div class="policysection">
					<div class="policy0icon">
					    <i class="diamond-icon search-lifetimewarranty"></i>
					    <h6 class="policyheading"><a href="/terms">Lifetime <br> Warranty (T&C)</a> </h6></div>
					<div class="policy0icon">
					    <i class="diamond-icon search-freedelivery"></i>
					    <h6 class="policyheading"><a href="/terms">Free Delivery & <br> Collection </a> </h6></div>
					<div class="policy0icon" >
					    <i class="diamond-icon search-diamondquality"></i>
					    <h6 class="policyheading"> <a href="/terms">Diamond Quality <br> Certificate </a> </h6></div>
					<div class="policy0icon">
					    <i class="diamond-icon search-returnpolicy"></i>
					    <h6 class="policyheading"><a href="/terms">30 Days<br> Return </a> </h6></div>
				</div>
			</div>
		</div>
	</div>
</div>





<div class="discount-sale-sec">
	<div class="container">
	<div class="discount-saleinner">
		<div class="diamond-sale">
			<h5>Diamond Spec: <span></span></h5>
		</div>
      <div class="pricetotalbag-sec">
		<div class="pricetotalbag">
			<div class="salesvates">
				{{-- <h5>Christmas Sale Price <span>£832.50 inc. VAT</span></h5> --}}
                <h5><del style="color:#000" id="shopPricefooter"> </del> </h5>
				<div class="product-finder-price" id="finaldiamondpricefooter">
				</div>
			</div>
			<div class="subpricetotal">
				{{-- <h5>Subtotal: <span>£925</span></h5> --}}
				<h5><span>You Save : <span id="savePricefooter"></span></span> |  <del id="rrpPricefooter"> </del> </h5>
			</div>
		</div>
		<div class="pricetotalbag-btn">
            <a id="addtobasketfooter" href="javascript:void(0);" class="btn-bg-small" role="button">Add to Basket</a>
			<a type="button" class="btn-bg-small" onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal" data-bs-target="#requestAppointment">
				Request An Appointment
				</a>
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


@php
	$getEngagementFaqs = getFaqByCategory(20);
@endphp

@if(isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
	<!-- FAQ Section start here -->
	<div class="faq-section engagement-ring-faq">
		<div class="container">
			<div class="head-para-three">
				<h2 class="heading-h-three">
					{{ isset($data->faq_title)?$data->faq_title:'Engagement Ring FAQ’s' }}
				</h2>
				<p>Some of the most common Q&A's</p>
			</div>
			<div class="faq-list">
				<div class="accordion" id="accordionExample">
					@foreach($getEngagementFaqs as $key => $faq)
					<div class="accordion-item">
						<h3 class="accordion-header" id="{{$faq->id}}">
							@if($key == 0)
							<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
								@else
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
									@endif
									{{isset($faq->title)?$faq->title:""}}
								</button>
						</h3>
						@if($key == 0)
						<div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
							@else
							<div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
								@endif
								<div class="accordion-body">
									{!! isset($faq->description)?$faq->description:"" !!}
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FAQ Section End -->
@endif
<!-- FAQ Section start here -->
<!-- <div class="faq-section">
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
</div> -->
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
					<p>Start your journey towards your finding your perfect engagement ring with our insightful diamond guide. Gain a better understanding of the different types of diamond engagement rings and the meaning behind diamond cut, colour, clarity, and carat. Download your free guide today!</p>
					<div class="viewguide-btn">
						<a class="btn-bg-small" href="{{asset('/certified-diamond-terminology-guide')}}">View Guide</a>
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



{{-- <div class="discount-sale-sec">
	<div class="container">
	<div class="discount-saleinner">
		<div class="diamond-sale">
			<h5>Diamond Spec: <span>0.20ctHSI2</span></h5>
		</div>

      <div class="pricetotalbag-sec">	

		<div class="pricetotalbag">
			<div class="salesvates">
				<h5>Christmas Sale Price <span>£832.50 inc. VAT</span></h5>
			</div>
			<div class="subpricetotal">
				<h5>Subtotal: <span>£925</span></h5>
			</div>
		</div>

		<div class="pricetotalbag-btn">
            <a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to Bag</a>

			<a type="button" class="btn-bg-small" onclick="$('label.error').css('display', 'none');return false;" data-bs-toggle="modal" data-bs-target="#requestAppointment">
				Book Appointment
				</a>
		</div>
</div>



	</div>
	</div>
</div> --}}

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



@endsection

@section('js')
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.4/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script>

		function changeDiamondType(classToPerform="") {

			if(classToPerform == 'mined_item'){
				$(".mined-certificate").removeAttr('style');
				$(".store-locator-border-right").css('border-right','1px solid #B0B0B0');
				$("#selected_diamond_price").val($('.refinedata').first().data('price'));
			}else{
				$(".mined-certificate").css('display','none');
				$(".store-locator-border-right").css('border-right','none')
			}
			$(".mined_lab_items").css('display','none');
			$("." + classToPerform).css('display','flex');
			$("." + classToPerform + "_block").css('display','block');

			/** show and hide description */
			$(".product-description-common").css('display','none');
			$(".product-description-common_"+classToPerform).css('display','block');

			// getFinalPrice();
		}
       

		$(".lab_price_update_items").on('change', function() {
			changeDiamondType($('.diamond_type:checked').attr("id"));
		});


		$(document).on('change', '.diamond_type' , function(event) {
			getCustomFilter();
			setTimeout(function(){
				changeDiamondType($(event.target).attr("id"));
			}, 500);
			// getCustomPriceFinalFunction();
			let getDiamondType = $(this).val();
			getSelectedDataVariation();
			if(getDiamondType == 'lab_grown'){
				getProdVideo('onChange',' 9ct White Gold ');
			}else if(getDiamondType == 'mined_diamond'){
				getProdVideo('onChange','Platinum');
			}
		});

		
        function blankForm(){
            $('input[name="title"]').val('');
            $('input[name="email"]').val('');
            $('input[name="phone"]').val('');
            $('textarea[name="description"]').val('');
            $("button[type='submit']").prop('disabled',false);
            $('#requestAppointment').modal('hide');
            // grecaptcha.reset();
        }

		$.validator.addMethod("phoneno", function(phone_number, element) {
			phone_number = phone_number.replace(/\s+/g, "");
			return phone_number.length > 9 ;
		}, "Please specify a valid phone number");

		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[a-z," "]+$/i.test(value);
		}, "Letters and spaces only please"); 

		$(document).ready(function(){
			$('[data-fancybox="gallery1"]').fancybox({ 
				afterLoad : function(instance, current) {
					current.$image.attr('alt', '{{$data->title}}' );
				}
			});
			toastr.options = {
				"preventDuplicates": true,
				"preventOpenDuplicates": true
			};

            // Custom method to check for spaces or empty values
			jQuery.validator.addMethod(
				"noSpacesOnly",
				function(value, element) {
					return $.trim(value).length > 0; // Ensures value isn't just spaces
				},
				"This field cannot be empty or contain only spaces."
			);

            $('form#contactForm').validate({
                rules: {
                    title: {
                        required: true,
						lettersonly: true,
						noSpacesOnly: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
					phone: {
						digits: true,
						phoneno:true
					},
                    description: {
                        required: true,
						noSpacesOnly: true
                    }
                },
                messages: {
                    title: {
                        required: 'Name is required',
						 noSpacesOnly: "Name cannot be empty and must not contain spaces."
                    },
                    email: {
                        required: 'Email is required',
                        email: 'Valid email is required',
                    },
                    phone: {
                        required: 'Phone is required',
						digits: 'Please enter a valid phone number with only digits',
                    },
                    description: {
                        required: 'Description is required',
						noSpacesOnly: "Description cannot be empty and must not contain spaces."
                    }
                },
                submitHandler: function (form) {
                    // if (grecaptcha.getResponse()) {
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
                                $("button[type='submit']").text("Send Message");
                                if(response.status == 200){
                                    toastr.success(response.success);
                                }else{
                                    toastr.info(response.error);
                                }
                                blankForm();
                            }
                        });
                    // } else {
                    //     alert('Please confirm captcha to proceed')
                    // }
                }
            });

            getRelatedProduct();
			getCustomFilter(); //getProdVideo();
			

			$(".viewdiamond-btn").click(function(){
				$(".diamond-table").toggle();
			});

			// TODO: getSelectedAttributePrice();

			$(document).on('change', "#metal-type,#finger-size,#lab_grown_carat,#lab_grown_colour,#lab_grown_clarity,#carat,#diamond-colour,#diamond-clarity,#diamond-certificate,#diamond-grade", function(){
				getSelectedAttributePrice();
				getProdVideo();
				getCustomPriceFinalFunction();
				getSelectedDataVariation();
				// if($('.diamond_type:checked').val() == 'lab_grown'){
				// 	getDescribeSelectedOptions();
				// }else if($('.diamond_type:checked').val() == 'mined_diamond'){
				// 	getDescribeSelectedOptionsMined();
				// }
			});

			$('#addtobasket').on('click',function(){
				addtobasketFunction('{{route("add.to.cart")}}','{{$data->slug}}','');
			});

			$('#addtobasketfooter').on('click',function(){
				addtobasketFunction('{{route("add.to.cart")}}','{{$data->slug}}','');
			});

			$(document).on('change', "[id^=productWishList]", function () {
      			var index = parseInt($(this).attr("id").replace("attributevari", ''),'{{$data->slug}}','');
			});
            $(document).on('change', "[id^=productWishListImage]", function () {
      			var index = parseInt($(this).attr("id").replace("attributevari", ''),'{{$data->slug}}','');
			});



			$(document).on('click', "[id^=productWishListRelated]", function () {
				var index = parseInt($(this).attr("id").replace("productWishListRelated", ''));
				var product_slug = $('#productWishListRelated'+index).data('productslug');
				addtobasketFunction('{{route("set-product-wishlist")}}',product_slug,index);
			});

			$("#productWishList").on('click',function(){
				addtobasketFunction('{{route("set-product-wishlist")}}','{{$data->slug}}','');
			});

			$("#productWishListImage").on('click',function(){
				addtobasketFunction('{{route("set-product-wishlist")}}','{{$data->slug}}','');
			});
			// $(document).on('change','#metal-type',function(){
			// 	getProdVideo('onChange');
			// });

			

			$(document).on('click','.refinedata',function(){
				getCustomPriceFinalFunction(getNumberFromCurrency($(this).data('price')));
				// $("#selected_diamond_price").val($(this).data('price'));
				// $("#certificate_url").val($(this).data('certurl'));
				// $("#productCertificateLink").attr('href',$(this).data('certurl'));
				// getFinalPrice();
			});
		});

		function getCustomFilter(){

			$.ajax({
                type: 'POST',
                url: '{{route("custom-filter")}}',
                data: {
                    '_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
					'diamond_type': $('.diamond_type:checked').val(),
                    'metal-type' : '{{ isset($requestData["metal-type"]) ? $requestData["metal-type"] : "" }}',
                },
                success: function (res) {
					$('#filterDataDesign .type-variations-row').html(res);
					getCustomPriceFinalFunction();
					getSelectedDataVariation();
					if($('.diamond_type:checked').val() == 'lab_grown'){
						// getDescribeSelectedOptions();
					}else if($('.diamond_type:checked').val() == 'mined_diamond'){
						// getDescribeSelectedOptionsMined();
						$("#metal-type option[value=' Silver ']").hide();
					}
                }
            });
		}

		function getProdVideo(action=null,metalType=null){
			if(metalType == null){
				var metal_type = $('#metal-type :selected').val();
			}else{
				var metal_type = metalType;
			}
			$.ajax({
				type: 'POST',
				url: '{{route("get-product-video")}}',
				data: {
					'_token': "{{csrf_token()}}",
					'slug' : '{{$data->slug}}',
					'metal_color' : metal_type,
				},
				success: function (res) {
					if(res.getSelectedVariationVideoImages.vari_video){
						var videoUrl = "{{ asset('storage/')}}/"+res.getSelectedVariationVideoImages.vari_video;
						// Update the video element's src attribute
						$('#variationVideo').attr('src', videoUrl);

						// Also update the source element if necessary
						$('#variationVideo source').attr('src', videoUrl);
						$('#variationAnchorVideo').attr('href', videoUrl);

						// $("#variationVideo")[0].play();
						// Load the new video
    					$('#variationVideo')[0].load();

						// Call the function to activate the carousel item with the video
    					activateCarouselItem();
					}
					
					if(res.getVariationDescription.description){
						$('.delieveryDescription').html(res.getVariationDescription.description);
						// if($('.diamond_type:checked').val() == 'lab_grown'){
						// }else if($('.diamond_type:checked').val() == 'mined_diamond'){
						// 	$('.delieveryDescription').html('');
						// }
					}
				}
			});
		}

		// Function to activate a specific carousel item
		function activateCarouselItem() {
			// Remove 'active' class from all carousel items
			$('#carousel .owl-item').removeClass('active');
			
			// Add 'active' class to the specific item containing the video
			$('#variationVideo').closest('.owl-item').addClass('active');
		}

		function getNumberFromCurrency(currency) {
			return Number(currency.replace(/[$,]/g,''))
		}

		function getCustomPriceFinalFunction(selectedDiamondPrice=null){
			$('#price-section').html('{{MY_CURRENCY_SYMBOL}} Pending...');
			// $('#rrpPrice').html('{{MY_CURRENCY_SYMBOL}} Pending...');
			// $('#shopPrice').html('{{MY_CURRENCY_SYMBOL}} Pending...');
			// $('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending...</span>');
			// $('#savePrice').html('{{MY_CURRENCY_SYMBOL}} Pending...');
			$('#getLabDiamondPrices').val('');
			
			var variations = [];
			$('.type-variations-row select').each(function(i, sel){

				if($(sel).attr('name')!='finger-size')
					variations.push($(sel).val());
			});

			let diamondCaratWeight;
			let diamondColour;
			var diamondShape;
			let diamondGrade;
			let diamondClarity;
			let diamondCertificate;
			if($('.diamond_type:checked').val() == 'mined_diamond'){
				diamondCaratWeight = $('#carat').val();
				diamondColour = $('#diamond-colour').val();
				diamondShape = $('#selected_diamond_shape').val();
				diamondGrade = $('#diamond-grade').val();
				diamondClarity = $('#diamond-clarity').val();
				diamondCertificate = $('#diamond-certificate').val();
			}else if($('.diamond_type:checked').val() == 'lab_grown'){
				diamondCaratWeight = $('#lab_grown_carat').val();
				diamondColour = $('#lab_grown_colour').val();
				diamondShape = $('#selected_diamond_shape').val();
				diamondGrade = '';
				diamondClarity = $('#lab_grown_clarity').val();
				diamondCertificate = '';
			}

			$.ajax({
                type: 'POST',
                url: '{{route("get-product-variation-prices")}}',
                dataType: 'json',
                data: {
                    '_token': "{{csrf_token()}}",
					'metal_type' : $('#metal-type').val(),
					'variations' : variations,
					'carat' : diamondCaratWeight,
					'color' : diamondColour,
					'grade' : diamondGrade,
					'clarity' : diamondClarity,
					'certificate' : diamondCertificate,
					'shape' : diamondShape,
					'selectedDiamondPrice' : selectedDiamondPrice,
					'slug': '{{$data->slug}}',
					'type': 1, 
					'diamond_type' : $('.diamond_type:checked').val()
                },
                success: function (res) {
					if(res.status == 200){
						if($('.diamond_type:checked').val() == 'lab_grown'){
							$('.delieveryDescription').html(res.delivery_description);
						}else if ($('.diamond_type:checked').val() == 'mined_diamond'){
							$('.delieveryDescription').html(res.delivery_description);
						}
						$('#rrpPrice').html('RRP: {{MY_CURRENCY_SYMBOL}} ' + res.allPrices.rrp_price.toFixed(2));
						$('#rrpPricefooter').html('RRP: {{MY_CURRENCY_SYMBOL}} ' + res.allPrices.rrp_price.toFixed(2));

						if(res.allPrices.shop_price == res.allPrices.discounted_price){
						    $('#shopPrice').html('');
							$('#shopPricefooter').html('');
						}else{
						    $('#shopPrice').html('{{MY_CURRENCY_SYMBOL}} ' + res.allPrices.shop_price.toFixed(2));
							$('#shopPricefooter').html('{{MY_CURRENCY_SYMBOL}} ' + res.allPrices.shop_price.toFixed(2));
						}
						$('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+res.allPrices.discounted_price.toFixed(2)+' </span>');

						$('#finaldiamondpricefooter').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} '+res.allPrices.discounted_price.toFixed(2)+' </span>');

						$('#savePrice').html('{{MY_CURRENCY_SYMBOL}} ' + (parseFloat(res.allPrices.rrp_price) - parseFloat(res.allPrices.discounted_price)).toFixed(2));

						$('#savePricefooter').html('{{MY_CURRENCY_SYMBOL}} ' + (parseFloat(res.allPrices.rrp_price) - parseFloat(res.allPrices.discounted_price)).toFixed(2));

						$('#getLabDiamondPrices').val(res.getLabDiamondPrices.toFixed(2));
					}else if(res.status == 500){
						$('#price-section').html('{{MY_CURRENCY_SYMBOL}} Pending...');
						// $('#finaldiamondprice').html('<span class="price" >{{MY_CURRENCY_SYMBOL}} Pending... </span>');
						// $('#rrpPrice').html('{{MY_CURRENCY_SYMBOL}} Pending...');
						// $('#shopPrice').html('{{MY_CURRENCY_SYMBOL}} Pending...');
						// $('#savePrice').html('{{MY_CURRENCY_SYMBOL}} Pending...');
						$('#getLabDiamondPrices').val('');
					}
                }
            });

		}

		function addtobasketFunction(getUrl,product_slug=null,index=null){
			let lab_grown_price = $("#finaldiamondprice .price").text().replace("£", "");
			
			let diamondCaratWeight;
			let diamondColour;
			var diamondShape;
			let diamondGrade;
			let diamondClarity;
			let diamondCertificate;
			if($('.diamond_type:checked').val() == 'mined_diamond'){
				diamondCaratWeight = $('#carat').val();
				diamondColour = $('#diamond-colour').val();
				diamondShape = $('#selected_diamond_shape').val();
				diamondGrade = $('#diamond-grade').val();
				diamondClarity = $('#diamond-clarity').val();
				diamondCertificate = $('#diamond-certificate').val();
			}else if($('.diamond_type:checked').val() == 'lab_grown'){
				diamondCaratWeight = $('#lab_grown_carat').val();
				diamondColour = $('#lab_grown_colour').val();
				diamondShape = $('#selected_diamond_shape').val();
				diamondGrade = '';
				diamondClarity = $('#lab_grown_clarity').val();
				diamondCertificate = '';
			}

			var variations = [];
			$('.type-variations-row select').each(function(i, sel){

				if($(sel).attr('name')!='finger-size')
					variations.push($(sel).val());
			});
			$.ajax({
                type: 'POST',
                url: getUrl,
                data: {
                    '_token': "{{csrf_token()}}",
					'carat' : diamondCaratWeight,
					'variations' : variations,
					'color' : diamondColour,
					'clarity' : diamondClarity,
					'grade' : diamondGrade,
					'fingersize' : $('#finger-size').val(),
					'metal_type' : $('#metal-type').val(),
					'certificate' : diamondCertificate,
					'slug' : product_slug,
					'setting_price': lab_grown_price, //parseFloat($('#price').val()) || 0;
					'price': lab_grown_price, //parseFloat($('#price').val()) || 0;
					'selectedDiamondPrice' : $('#getLabDiamondPrices').val(),
					'certificatelink': $('#certificate_url').val() || '',
					'shape': diamondShape,
					'type': 1,
					'certificate': $('#selected_diamond_certno').val() || '',
					'diamond_type' : $(".diamond_type:checked").val(),
                    'jsondata' : $('input[name="selectrefinedata"]:checked').data('jsonvalue'),


					// /**  Add lab information in cart */
					// 'lab_grown_clarity' : $("#lab_grown_clarity").val(),
					// 'lab_grown_colour' : $("#lab_grown_colour").val(),
					// 'lab_grown_carat' : $("#lab_grown_carat").val(),
					// 'lab_grown_price' : lab_grown_price,

                },
                success: function (res) {
					if(res.success != '' && typeof res.success !== "undefined"){
						if(res.cartcount){
							$(".cartcount").text(res.cartcount);
						}
						if(res.wishcount){
							if(index>0){
								$('#productWishListRelated'+index).children('i').addClass('fa-heart');
								$('#productWishListRelated'+index).children('i').removeClass('fa-heart-o');
							}else{
								$('#productWishList'+index).children('i').removeClass('fa-heart-o');
								$('#productWishList'+index).children('i').addClass('fa-heart');

								$('#productWishListImage'+index).children('i').removeClass('fa-heart-o');
								$('#productWishListImage'+index).children('i').addClass('fa-heart');

							}
							if(res.wishcount > 0){
								$('.my-whishlist-blk .wishcount').removeClass('fa-heart-o');
								$('.my-whishlist-blk .wishcount').addClass('fa-heart');
							}else{
								$('.my-whishlist-blk .wishcount').removeClass('fa-heart');
								$('.my-whishlist-blk .wishcount').addClass('fa-heart-o');
							}
						}
						toastr.success(res.success);
					}else{
						if(res.error){
							if(index>0){
								$('#productWishListRelated'+index).children('i').removeClass('fa-heart');
								$('#productWishListRelated'+index).children('i').addClass('fa-heart-o');
							}else{
								$('#productWishList'+index).children('i').removeClass('fa-heart');
								$('#productWishList'+index).children('i').addClass('fa-heart-o');

								$('#productWishImage'+index).children('i').removeClass('fa-heart');
								$('#productWishListImage'+index).children('i').addClass('fa-heart-o');

							}
							if(res.wishcount > 0){
								$('.my-whishlist-blk .wishcount').removeClass('fa-heart-o');
								$('.my-whishlist-blk .wishcount').addClass('fa-heart');
							}else{
								$('.my-whishlist-blk .wishcount').removeClass('fa-heart');
								$('.my-whishlist-blk .wishcount').addClass('fa-heart-o');
							}
						}
						toastr.error(res.error);
					}
                }
            });
		}

        getSelectedAttributePrice();
		var triggerLab = true;
		function getSelectedAttributePrice(){

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
						$("#selected_diamond_price").val($('.refinedata').first().data('price'));
					}else{
						$('#refineSearchData').html("No Data Found");
					}
                }
            });
		}

		function getSelectedDataVariation(){
          
			let designTable = `<table class="table  table-bordered  table-responsive">
						<tr class="tableheading text-white tablehover">
						<th>Type</th>
						<th>Selected</th>
						</tr>`;


			$('.type-variations-col').each(function() { 
				// var caret=document.getElementById('lab_grown_carat').val();
				let forId = $(this).find('label').attr('for');
				let forText = $(this).find('label').text();
				const diamondType = $('.diamond_type:checked').val();
				if ((diamondType === 'lab_grown') && (forId === 'diamond-certificate' || forId === 'diamond-colour' || forId === 'diamond-clarity' || forId === 'carat' || forId === 'diamond-grade')) {
				} else if ((diamondType === 'mined_diamond') && (forId === 'lab_grown_carat' || forId === 'lab_grown_colour' || forId === 'lab_grown_clarity' )) {
				} else {
					designTable += `
						<tr>
						<td>${forText}</td>
						<td>${$('#'+forId).val()}</td>
						</tr>
					`;
				}
			});
			designTable += `</table>`;
			$('#myDivChanges').html(designTable);
		}


    // start
	let designTable = `<table class="table table-bordered table-responsive">
                        <tr class="tableheading text-white tablehover">
                            <th>Type</th>
                            <th>Selected</th>
                        </tr>`;

// Loop through each type variation column and build the table rows
$('.type-variations-col').each(function() { 
    let forId = $(this).find('label').attr('for');
    let forText = $(this).find('label').text();
    const diamondType = $('.diamond_type:checked').val();

    // Exclude certain conditions based on the diamond type
    if ((diamondType === 'lab_grown') && (forId === 'diamond-certificate' || forId === 'diamond-colour' || forId === 'diamond-clarity' || forId === 'carat' || forId === 'diamond-grade')) {

    }
	 else if ((diamondType === 'mined_diamond') && (forId === 'lab_grown_carat' || forId === 'lab_grown_colour' || forId === 'lab_grown_clarity' )) {
    } else {
        designTable += `
            <tr>
                <td>${forText}</td>
                <td>${$('#'+forId).val()}</td>
            </tr>
        `;
    }
});

let tempContainer = document.createElement('div');
tempContainer.innerHTML = designTable;


const rows = tempContainer.querySelectorAll('tr:not(.tableheading)');
const selectedValues = [];

rows.forEach(row => {
    const selectedCell = row.querySelector('td:nth-child(2)');
    if (selectedCell) {
        selectedValues.push(selectedCell.textContent.trim());
    }
});


const result = selectedValues.join(', ');

document.querySelector('.diamond-sale h5 span').textContent = result;

	
	//ends




        function getRelatedProduct(){
            $.ajax({
                url: "{{ route('get.related.product.list') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    catid: '{{$data->categories}}',
                },
                success: function (response) {
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
	
	<!-- Product Schema code start -->
<?php 
$schemaProImages = []; // Initialize an empty array
foreach ($prodImages as $key => $images) {
	if($key == 0){
		$proimgURL = env('APP_IMAGE_URL') . '/storage/' . $images->image_url;
		$schemaProImages[] = ['proimgURL' => $proimgURL];
	}
}
// Extract proimgURL values into a simple array
$ImgurlArray = array_column($schemaProImages, 'proimgURL');
$ImagesURLS =  implode(', ', $ImgurlArray);
$getFinalPrice = getMinimumPriceFunction($data);

?>
<script type="application/ld+json">
{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "{{isset($data->title)?$data->title:''}}",
  "image": "{{ $ImagesURLS }}",
  "url": "{{url()->full()}}",
  "description":  "{{ isset($data->description) ? strip_tags($data->description) : '' }}",
  "brand": {
    "@type": "Brand",
    "name": "Marlow's Diamonds"
  },
  "sku": "{{ base64_encode($data->id) }}",
  "offers": {
    "@type": "Offer",
    "url": "{{url()->full()}}",
    "priceCurrency": "GBP",
	"price": "{{ $getFinalPrice['final_discounted_price'] }}",
    "availability": "https://schema.org/InStock",
    "itemCondition": "https://schema.org/NewCondition"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "bestRating": "5",
    "worstRating": "1",
    "ratingCount": "2626"
  }
}
</script>
<!-- Product Schema code end -->

{{-- video schema starts from here --}}
@php
$videoUrl = env('APP_IMAGE_URL') . '/storage/' . $data->getProductVariation[0]->vari_video;
$thumbnailUrl = str_replace('.mp4', '.jpg', $videoUrl);
$VideoThumbnailUrl = str_replace('.jpg', '.mp4', $videoUrl);
$uploadDate = isset($data->created_at) ? \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') : now()->format('Y-m-d');
@endphp

<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "VideoObject",
      "name": "{{isset($data->title)?$data->title:''}}",
      "description": "{{ isset($data->description) ? strip_tags($data->description) : '' }}",
      "thumbnailUrl": "{{ $VideoThumbnailUrl }}",
      "uploadDate": "{{ $uploadDate }}",
      "duration": "PT0M20S"
    }
    </script>
{{-- video schema ends here --}}


<script>
	$(document).ready(function() {
	      	var $owl = $('#carousel');
			$owl.children().each( function( index ) {
			  $(this).attr( 'data-position', index ); // NB: .attr() instead of .data()
			});
	        $owl.owlCarousel({
			  autoplay: false,
			  rewind: true,
			  responsiveClass: true,
			  autoplayTimeout: 15000,
			  smartSpeed: 300,
			  nav: true,
			  items : 1,
			  	onInitialized: function() {
					$owl.find('.owl-item').each((index, element)=>{
						const src = $(element).find('.thumbnail-src').attr('src');
						const video_extensions = ['mp4'];
						const extension = src.split(/[#?]/)[0].split('.').pop().trim();
						let thumbnailItem = `<li class="list-inline-item ${ index ? '' : 'active' }">`;
						thumbnailItem += `<a href="javascript:;" id="carousel-selector-${index}" class="carousel-thumbnail-item ${ index ? '' : 'selected' }" data-slide-to="${index}" data-target="#carousel">`;

						if(video_extensions.includes(extension)){
							thumbnailItem += `<video muted class="img-fluid" style="height:100px; width:100px;">`;
							thumbnailItem += `<source src="${src}" type="video/mp4" type="video/mp4" />`;
							thumbnailItem += `</video>`;
						}else{
							thumbnailItem += `<img src="${src}" class="img-fluid" style="height:100px; width:100px;">`;
						}
						thumbnailItem += `</li>`;

						$(".carousel-thumbnails").append(thumbnailItem);

					})
    			},
			}).on("changed.owl.carousel", function(el) {
				var index = el.item.index;
				$('.carousel-thumbnail-item').closest('li').removeClass('active');
				$('#carousel-selector-'+index).closest('li').addClass('active');
			});
			
            $(document).on('click','.product-gallery__trigger',function(e){
				e.preventDefault();
				$('#carousel .owl-item.active a').click();
				$('#carousel1 .product-items-carousel.active a').click();
            });

			$(document).on('click','.carousel-thumbnail-item', function(){
				const itemPosition = $(this).data('slide-to');
				$owl
				.trigger('to.owl.carousel', [itemPosition, 0])
				.trigger('stop.owl.autoplay')
				.trigger('play.owl.autoplay',[15000, 300]);
			});
	    });
    // copy element starts from here
    function copyToClipboard() {
        const copyText = document.getElementById('copy-text').innerText;
        navigator.clipboard.writeText(copyText).then(function() {
            alert('Link copied!');
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            alert('Failed to copy text. Please try again.');
        });
    }
	</script>

  {{-- thumbmail image start here --}}
 <script>
	$(document).ready(function(){
		$('#carousel').owlCarousel({
			items: 1,
			loop: true,
			autoplay: false,
			nav: true,
			dots: false,
		});
		$('#thumbnail-carousel').owlCarousel({
			items: 4,
			loop: true,
			nav: true,
			dots: false,
		});
		$('.thumbnail-link').on('click', function() {
			var index = $(this).data('index');
			$('#carousel').trigger('to.owl.carousel', [index+1, 300]);
		});


		$('.btn-360').on('click', function() {
			var videoUrl = $(this).data('video');
			$('#carousel').trigger('to.owl.carousel', [0, 300]);

			// Update the main carousel to show the 360 video
			var videoHtml = `<a id="variationAnchorVideo" data-fancybox="gallery1" href="${videoUrl}" data-caption="">
			<video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
			<source src="${videoUrl}" type="video/mp4" />
			</video></a>`;
			$('#carousel .owl-item.active').html(videoHtml);
		});
	});
</script>

@endsection
