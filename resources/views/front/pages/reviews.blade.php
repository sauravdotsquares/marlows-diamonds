@php
	$getReviews = getReviews();
@endphp

@foreach($getReviews as $review)
<div class="item">
	<div class="reviews-cont">
		<div class="reviewr-name">
			{{isset($review->title)?$review->title:""}}
		</div>
		<div class="reviewr-star">
			<img src="assets/images/stars.png" alt="star">
		</div>
		<div class="reviewr-review-text">
			{!! isset($review->description)?$review->description:"" !!}<a href="#">Read More</a>
		</div>
	</div>
</div>
@endforeach
