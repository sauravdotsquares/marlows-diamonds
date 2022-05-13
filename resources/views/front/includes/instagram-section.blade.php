<?php
$getInstaData = getInstagramDataDetails();
?>
@if(count($getInstaData) > 0)
<div class="share-moment">
    <div class="share-moment-heading"><div class="heading-h-two">Share your special moments with us<br> #marlowsengagements</div></div>
    <div class="insta-photo-list">
        <div class="owl-carousel owl-theme photo-slider">
            @foreach($getInstaData as $key => $insta)
                <div class="item">
                    <div class="instaphoto-info">
                        <div class="instaphoto-img">
                            <img src="{{ asset('storage/'.$insta->image_url) }}" height="256px" width="256px" alt="insta photo">
                        </div>
                        <div class="insta-link">
                            <a href="{{$insta->link}}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="insta-btn">
        <a class="btn-bg-small" href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> View on Instagram</a>
    </div>
</div>
@endif
