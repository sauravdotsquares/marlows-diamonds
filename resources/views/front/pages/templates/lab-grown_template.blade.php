@extends('layouts.front.app')
@section('content')



<!-- category header banner start -->
<div class="category-banner" style="background-image:url(assets/images/Marlows-Lab-Grown-Diamonds-Banner.png)">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{$data->title}}</h1>
			<p>{!!$data->subtitle!!}</p>
		</div>
	</div>
</div>
<div class="takeonlab">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-6">
				<div class="takeon-left">
					<div class="leftright-heading heading-h-three">
						Find Your Perfect Match
					</div>
					<p>At Marlow’s, we’re recognised as the UK’s Diamond experts. For over three generations, we’ve been sourcing some of the most treasured diamonds for our clients.
						Whether they’ve been gifted as loose diamonds or set within one of our stunning <a href="/engagement-rings" target="_blank">diamond engagement rings</a> and proposed with, the way we source diamonds is evolving.</p>
					<p>Investing in lab-grown diamonds poses many benefits compared to real diamonds, as well as offering a responsible method of sourcing. Let us explain the importance of growing diamonds in the 21st century,
						and how something that sparkles so similar to a real diamond is actually so different!
					</p>
					<p>We’re about to get technical so stay with us!</p>
					<div class="faq-list">
						<div class="accordion" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOnes">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnes" aria-expanded="true" aria-controls="collapseOnes">
										What are Lab-Grown Diamonds?
									</button>
								</h2>
								<div id="collapseOnes" class="accordion-collapse collapse show" aria-labelledby="headingOnes" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Lab-grown, cultured, engineered, and man-made diamonds are all ways to describe diamonds created under high-pressure high temperature (HPHT)
											and Chemical Vapour Deposition (CVD) in labs found mainly in the USA and China.</p>
										<p>The process of creating a diamond out of a diamond seed takes around a week. And these engineered diamonds have the same beauty and characteristics of natural earth mined diamonds -
											that take millions of years to form.
										</p>
										<p>Lab diamonds aren’t to be confused with cubic zirconia or moissanite. In comparison, they do not display “real” diamond characteristics,
											such as the weight and the white sparkle that is reflected.</p>
									</div>
								</div>

							</div>
						</div>

					</div>

				</div>
			</div>

			<div class="col-lg-5 col-md-6">
				<div class="takeon-right">
					<img src="/assets/images/Marlows-Lab-Grown-Showcase.png" alt="images">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Best Selling Marlow's Diamond Jewellery start here -->
@include('front.includes.featuredproduct')
<!-- Best Selling Marlow's Diamond Jewellery end here -->

{!!$data->description!!}

<!-- FAQ Section start here -->
<div class="faq-section engagement-ring-faq">
	<div class="container">
		<div class="head-para-three">
			<div class="heading-h-three">
				Lab-grown diamonds FAQ’s
			</div>
			<p>Some of the most common Lab-grown diamonds Q&A's</p>
		</div>
		<div class="faq-list">
			<div class="accordion" id="accordionExample">
				@php
				$getEngagementFaqs = getFaqByCategory(7);
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
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-two.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-three.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-four.jpg" alt="insta photo">
		    		</div>
		    		<div class="insta-link">
		    			<a href="https://www.instagram.com/marlows_diamonds"><i class="fa fa-instagram" aria-hidden="true"></i></a>
		    		</div>
		    	</div>
		    </div>
		    <div class="item">
		    	<div class="instaphoto-info">
		    		<div class="instaphoto-img">
		    			<img src="assets/images/insta-img-five.jpg" alt="insta photo">
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