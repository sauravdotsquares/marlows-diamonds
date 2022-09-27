@extends('layouts.front.app')
@section('content')

<!-- header banner start -->
<div class="category-banner" style="background-image:url({{asset('storage/'.$data->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{!!isset($data->subtitle)?$data->subtitle:""!!}</h1>
			<p>{!!isset($data->short_description)?$data->short_description:""!!}</p>
		</div>
	</div>
</div>
<!-- header banner end -->

<!-- CHoose a dreamy start here-->
<div class="choosedreamy-wrap">
	<div class="container">
		<div class="head-para-three">
			<h2 class="heading-h-three">Choose A Dreamy Setting for Your Engagement Ring</h2>
		</div>
		<div class="rings-grid-wrap">
			<div class="row">
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="#"><img src="assets/images/CR10-SE45_0003.jpg" alt="SOLITAIRE ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								SOLITAIRE ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Solitaire rings are classics for a reason. Their single stone setting exudes beauty like no other with a jaw-dropping centrepiece. This is the best of all diamond engagement rings if you want a flashy simple design.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="#">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="#"><img src="assets/images/DSR21-Images_0003.jpg" alt="HALO ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								HALO ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Halo rings are solitaires made better! Complimented by a halo of smaller diamonds, the centre stone looks gorgeous in every way. If you love solitaires but want something extra, then this is the diamond ring for you.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="#">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="#"><img src="assets/images/CX9-SL28_00003-1.jpg" alt="SHOULDER SET ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								SHOULDER SET ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Want more sparkle? Go for shoulder set rings with a band of encrusted diamonds that make your ring all the more special. A dazzling solitaire with little diamonds along the way can make all the difference.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="#">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="#"><img src="assets/images/R3-143_0003.jpg" alt="MULTI-STONE ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<div class="ring-pr-title">
								MULTI-STONE ENGAGEMENT RINGS
							</div>
							<div class="ring-pr-desc">
								<p>Why stop at one when you can have many? Make a statement with diamond engagement rings in multi-stone settings. Unique styles and combinations are waiting for you.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="#">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>



<!-- CHoose a dreamy end here-->

<!-- Banner Text Section-->
<div class="findmatch-wrap">
	<div class="container">
		<div class="leftright-img-text-wraper">
			<div class="leftright-imt-rows flexed flex-flex-wrap flex-items-center">
				<div class="leftright-imt-col leftright-img">
					<img src="assets/images/banner-hand.jpg" alt="banner-hand">
				</div>
				<div class="leftright-imt-col leftright-text">
					<div class="leftright-heading heading-h-three">
						Find Your Perfect Match
					</div>
					<p>You found your perfect match so the engagement ring you propose with should also be a perfect match for your partner. Marlow’s Diamonds brings to you a curated assortment of diamond engagement rings in the most beautiful designs, stone settings, diamonds shapes, and ring sizes.</p>
					<p>Why us? Because our diamonds are as special as your relationship. Our engagement rings are made only with ethically sourced diamonds. With us, you can be assured of quality because our diamonds are graded by the GIA. Adorning our sparkling stones will bring you joy and warmth for the rest of your lives.</p>
					<div class="viewguide-btn">
							<a class="btn-bg-small" href="#">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Best Selling Marlow's Diamond Jewellery start here -->

<div class="best-selling-marlows">
	<div class="container">
		<div class="head-para-three">
			<h3 class="heading-h-three">Best Selling Engagement Rings</h3>
		</div>
		<div class="product-item-slider">
			<div class="owl-carousel owl-theme owlslidertwo st-arrows">
			    <div class="item">
			    	<div class="product-info">
			    		<div class="product-image">
			    			<a href="#"><img src="assets/images/RC2027_00003-400x400.jpg" alt="SADIE | Eternity Style Ring"></a>
			    		</div>
			    		<div class="product-item-details">
			    			<div class="product-titles-small">
			    				<a href="#"> SADIE | Eternity Style Ring</a>
			    			</div>
			    			<div class="product-price">
			    				 £ 1,068.60
			    			</div>
			    			<div class="product-action-btn">
			    				<a class="btn-bg-small" href="#">Select Options</a>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			    <div class="item">
			    	<div class="product-info">
			    		<div class="product-image">
			    			<a href="#"><img src="assets/images/RC2027_00003-400x400.jpg" alt="SADIE | Eternity Style Ring"></a>
			    		</div>
			    		<div class="product-item-details">
			    			<div class="product-titles-small">
			    				<a href="#"> SADIE | Eternity Style Ring</a>
			    			</div>
			    			<div class="product-price">
			    				 £ 1,068.60
			    			</div>
			    			<div class="product-action-btn">
			    				<a class="btn-bg-small" href="#">Select Options</a>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			     <div class="item">
			    	<div class="product-info">
			    		<div class="product-image">
			    			<a href="#"><img src="assets/images/RC2027_00003-400x400.jpg" alt="SADIE | Eternity Style Ring"></a>
			    		</div>
			    		<div class="product-item-details">
			    			<div class="product-titles-small">
			    				<a href="#"> SADIE | Eternity Style Ring</a>
			    			</div>
			    			<div class="product-price">
			    				 £ 1,068.60
			    			</div>
			    			<div class="product-action-btn">
			    				<a class="btn-bg-small" href="#">Select Options</a>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			     <div class="item">
			    	<div class="product-info">
			    		<div class="product-image">
			    			<a href="#"><img src="assets/images/RC2027_00003-400x400.jpg" alt=" SADIE | Eternity Style Ring"></a>
			    		</div>
			    		<div class="product-item-details">
			    			<div class="product-titles-small">
			    				<a href="#"> SADIE | Eternity Style Ring</a>
			    			</div>
			    			<div class="product-price">
			    				 £ 1,068.60
			    			</div>
			    			<div class="product-action-btn">
			    				<a class="btn-bg-small" href="#">Select Options</a>
			    			</div>
			    		</div>
			    	</div>
			    </div>
			     <div class="item">
			    	<div class="product-info">
			    		<div class="product-image">
			    			<a href="#"><img src="assets/images/RC2027_00003-400x400.jpg" alt="SADIE | Eternity Style Ring"></a>
			    		</div>
			    		<div class="product-item-details">
			    			<div class="product-titles-small">
			    				<a href="#"> SADIE | Eternity Style Ring</a>
			    			</div>
			    			<div class="product-price">
			    				 £ 1,068.60
			    			</div>
			    			<div class="product-action-btn">
			    				<a class="btn-bg-small" href="#">Select Options</a>
			    			</div>
			    		</div>
			    	</div>
			    </div>

			</div>
		</div>
	</div>
</div>
<!-- Best Selling Marlow's Diamond Jewellery end here -->

<!-- two banner section end -->

<!-- Your Journery of a lifetime start here start-->
<div class="journery-life-wraper">
	<div class="container">
	{!! isset($data->description)?$data->description:"" !!}


	</div>
</div>
<!-- Your Journery of a lifetime start here end-->


<!-- FAQ Section start here -->
<div class="faq-section engagement-ring-faq">
	<div class="container">
		<div class="head-para-three">
			<div class="heading-h-three">
				Engagement Ring FAQ’s
			</div>
			<p>Some of the most common Engagement Ring Q&A's</p>
		</div>
		<div class="faq-list">
			<div class="accordion" id="accordionExample">

				@php
				$getFaqs = getFaqs();
				@endphp

				@foreach($getFaqs as $key => $faq)
					<div class="accordion-item">
						<h2 class="accordion-header" id="{{$faq->id}}">
							@if($key == 0)
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
							@else
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
							@endif
							{{isset($faq->title)?$faq->title:""}}
						  </button>
						</h2>
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


<!-- FAQ Section end here -->

<!-- Section Reviews -->
<div class="container">
<div class="rating-review-block">
				<div class="owl-carousel owl-theme slider-review">
				@include('front.pages.reviews')
				</div>
			</div>
</div>


<!-- insta photos section start -->
@include('front.includes.instagram-section')
{{-- <div class="share-moment">
	<div class="share-moment-heading"><div class="heading-h-two">Share your special moments with us<br> #marlowsengagements</div></div>
	<div class="insta-photo-list">
		<div class="owl-carousel owl-theme photo-slider">
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-one.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-two.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-three.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-four.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-five.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>

		</div>
	</div>
	<div class="insta-btn">
		<a class="btn-bg-small" href="#"><i class="fa fa-instagram" aria-hidden="true"></i> View on Instagram</a>
	</div>
</div> --}}


<!-- insta photos section end -->
@endsection
