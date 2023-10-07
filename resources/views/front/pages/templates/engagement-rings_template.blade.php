@extends('layouts.front.app')
@section('content')

<!-- header banner start -->
<div class="category-banner" style="background-image:url({{env('APP_IMAGE_URL').'/storage/'.$data->image}})">
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
			<h2 class="heading-h-three">Choose A Dream Setting for Your Engagement Ring</h2>
		</div>
		<div class="rings-grid-wrap">
			<div class="row">
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/engagement-rings/solitaire"><img src="{{env('APP_IMAGE_URL').'/assets/images/CR10-SE45_0003.jpg'}}" alt="SOLITAIRE ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<h3 class="ring-pr-title">
								SOLITAIRE ENGAGEMENT RINGS
							</h3>
							<div class="ring-pr-desc">
								<p>Solitaire rings are classics for a reason. Their single stone setting exudes beauty like no other with a jaw-dropping centrepiece. This is the best of all diamond engagement rings if you want a flashy simple design.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/engagement-rings/solitaire">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/engagement-rings/halo/"><img src="{{env('APP_IMAGE_URL').'/assets/images/DSR21-Images_0003.jpg'}}" alt="HALO ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<h3 class="ring-pr-title">
								HALO ENGAGEMENT RINGS
							</h3>
							<div class="ring-pr-desc">
								<p>Halo rings are solitaires made better! Complimented by a halo of smaller diamonds, the centre stone looks gorgeous in every way. If you love solitaires but want something extra, then this is the diamond ring for you.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/engagement-rings/halo/">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/engagement-rings/shoulder-set/"><img src="{{env('APP_IMAGE_URL').'/assets/images/CX9-SL28_00003-1.jpg'}}" alt="SHOULDER SET ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<h3 class="ring-pr-title">
								SHOULDER SET ENGAGEMENT RINGS
							</h3>
							<div class="ring-pr-desc">
								<p>Want more sparkle? Go for shoulder set rings with a band of encrusted diamonds that make your ring all the more special. A dazzling solitaire with little diamonds along the way can make all the difference.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/engagement-rings/shoulder-set/">Shop Now</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-3">
					<div class="ring-pr-items">
						<div class="ring-pr-image">
							<a href="/engagement-rings/multi-stone/"><img src="{{env('APP_IMAGE_URL').'/assets/images/R3-143_0003.jpg'}}" alt="MULTI-STONE ENGAGEMENT RINGS"></a>
						</div>
						<div class="ring-pr-details">
							<h3 class="ring-pr-title">
								MULTI-STONE ENGAGEMENT RINGS
							</h3>
							<div class="ring-pr-desc">
								<p>Why stop at one when you can have many? Make a statement with diamond engagement rings in multi-stone settings. Unique styles and combinations are waiting for you.</p>
							</div>
							<div class="ring-pr-shop-btn">
								<a class="btn-bg-small" href="/engagement-rings/multi-stone/">Shop Now</a>
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
					<img src="{{env('APP_IMAGE_URL').'/assets/images/banner-hand.jpg'}}" alt="banner-hand">
				</div>
				<div class="leftright-imt-col leftright-text">
					<h2 class="leftright-heading heading-h-three">
						Find Your Perfect Ring for Your Partner
					</h2>
					<p>Once you've found your perfect match, you should choose the perfect engagement ring that suits her personality and look. We bring to you a curated assortment of diamond engagement rings in the most beautiful designs, stone settings, diamond shapes, and ring sizes.</p>
					<p>Our diamond engagement rings are fully natural and unique, designed in our lab. We only use ethically sourced diamonds in our engagement rings. Additionally, we offer diamonds that are graded by the GIA, so you can be confident that they are of high quality. Adorning our sparkling stones will bring you joy and warmth for the rest of your lives.</p>
					<div class="viewguide-btn">
						<a class="btn-bg-small" href="/diamond-engagement-rings">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Best Selling Marlow's Diamond Jewellery start here -->
@include('front.includes.featuredproduct')
<!-- Best Selling Marlow's Diamond Jewellery end here -->


<!-- two banner section end -->

<!-- Your Journery of a lifetime start here start-->
<div class="journery-life-wraper">
	<div class="container">
		{!! isset($data->description)?$data->description:"" !!}


	</div>
</div>
<!-- Your Journery of a lifetime start here end-->


<!-- Best Post Carousel Block start here -->
@include('front.includes.postcarouselblock')
<!-- Best Post Carousel Block start here -->

<!-- FAQ Section start here -->
<div class="faq-section engagement-ring-faq">
	<div class="container">
		<div class="head-para-three">
			<h2 class="heading-h-three">
				Engagement Ring FAQ’s
			</h2>
			<h3 style="font-size: 15px;">Some of the most common Engagement Ring Q&A's</h3>
		</div>
		<div class="faq-list">
			<div class="accordion" id="accordionExample">

				@php
				$getEngagementFaqs = getEngagementFaqs();
				@endphp

				@foreach($getEngagementFaqs as $key => $faq)
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

@include('front.includes.instagram-section')
<!-- insta photos section start -->
{{-- <div class="share-moment">
	<div class="share-moment-heading"><div class="heading-h-two">Share your special moments with us<br> #marlowsengagements</div></div>
	<div class="insta-photo-list">
		<div class="owl-carousel owl-theme photo-slider">
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="{{env('APP_IMAGE_URL').'/assets/images/insta-img-one.jpg'}}" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="{{env('APP_IMAGE_URL').'/assets/images/insta-img-two.jpg'}}" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="{{env('APP_IMAGE_URL').'/assets/images/insta-img-three.jpg'}}" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="{{env('APP_IMAGE_URL').'/assets/images/insta-img-four.jpg'}}" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="{{env('APP_IMAGE_URL').'/assets/images/insta-img-five.jpg'}}" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>

		</div>
	</div>
	<div class="insta-btn">
		<a class="btn-bg-small" href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i> View on Instagram</a>
	</div>
</div> --}}


<!-- insta photos section end -->
@endsection