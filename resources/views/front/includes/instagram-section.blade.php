<?php
$getInstaData = getInstagramDataDetails();
?>
@if(count($getInstaData) > 0)
<div class="share-moment">
    <div class="share-moment-heading">
        <div class="heading-h-two">
            Share your special moments with us<br><span> #marlowsengagements</span>
        </div>
    </div>
    <div class="insta-photo-list">
        <div class="owl-carousel owl-theme photo-slider">
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                        <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta1.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="couple" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLpMDMlIeIU/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                        <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta2.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="passion love" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLjaaTJofec/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta3.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="round cut shoulders" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLe535qoW1K" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta4.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="necklace" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLb_4gtIjza" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta5.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="princess cut" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLZMsJbo8Yf/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta6.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="gift" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLSc6qIoTeB/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta7.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="ring" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DLIJnuBIJXv/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta8.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="necklace" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DKq3dy3IsoC/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php 
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta9.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="complimentary gift" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DKhVr2fI86h/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="instaphoto-info">
                    <div class="instaphoto-img">
                         <?php
                            $instagramImageUrl = getOptimizedImage('/images/insta/insta10.jpg','256','370');
                        ?>
                        <img src="{{ $instagramImageUrl }}" alt="hello june" loading="lazy">
                    </div>
                    <div class="insta-link">
                        <a href="https://www.instagram.com/p/DKWOqItINjx/" target="_blank" rel="follow"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
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