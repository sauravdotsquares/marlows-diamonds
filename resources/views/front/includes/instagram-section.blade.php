<?php
$getInstaData = getInstagramDataDetails();
?>
@if(count($getInstaData) > 0)
<div class="share-moment">
    <div class="share-moment-heading"><div class="heading-h-two">Share your special moments with us<br><span> #marlowsengagements</span></div></div>
    <div class="insta-photo-list">
        <div class="owl-carousel owl-theme photo-slider">
            @foreach($getInstaData as $key => $insta)
                <div class="item">
                    <div class="instaphoto-info">
                        <div class="instaphoto-img">
                            <?php 
                                $instagramImageUrl = getImageOptimizeDetails('/images/'.$insta->image_url,'256','370');
                            ?>
                            <img src="{{ $instagramImageUrl }}" alt="{{isset($insta->alt)?$insta->alt:'GIA Certified Diamond Jewellery Supplier | London and Birmingham'}}" loading="lazy">
                        </div>
                        <div class="insta-link">
                            <a href="{{$insta->link}}" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="insta-btn" id="getdirection">
        <a class="btn-bg-small" href="https://www.instagram.com/marlows_diamonds/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> View on Instagram</a>
    </div>
</div>
@endif
<!-- <script src="{{asset('/assets/js/jquery.lazyload.min.js')}}" integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<!-- <script>
    $(document).ready(function(){
        //$('.instaphoto-img img').lazyload();
    })
</script> -->