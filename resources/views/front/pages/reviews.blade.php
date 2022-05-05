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
			<img src="/assets/images/stars.png" alt="star">
		</div>
		<div class="reviewr-review-text">
			{!! isset($review->description)?$review->description:"" !!}<a class="show-more" href="javascript:void(0)">Read more</a>
		</div>
	</div>
</div>
@endforeach


@section('js')
<script>
	$(document).ready(function(){
		$('.show-more-content').hide();
		$('.show-more').click(function(){
			$(this).parents('.reviewr-review-text').toggleClass("show-text-col");       
		});
	});
</script>
@endsection


