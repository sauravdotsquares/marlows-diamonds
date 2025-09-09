@php
    $getReviews = getReviews();
@endphp
@foreach ($getReviews as $review)
    <div class="item">
        <div class="reviews-cont">
            <div class="reviewr-name">
                {{ isset($review->title) ? $review->title : '' }}
            </div>
            <div class="reviewr-star">
                <i class="diamond-icon search-reviewssection"></i>

                <div>

                </div>
                {{-- <i class="diamond-icon search-reviewssection"></i> --}}
            </div>
            <div class="reviewr-review-text">
                {!! isset($review->description) ? $review->description : '' !!}<a class="show-more" href="javascript:void(0)">Read more</a>
            </div>
        </div>
    </div>
@endforeach
