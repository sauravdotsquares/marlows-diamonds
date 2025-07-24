<?php
 $getInstaData = getInstagramDataDetails();
?>
{{-- @if(count($getInstaData) > 0) --}}
<div class="share-moment">
    <div class="share-moment-heading"><div class="heading-h-two">Share your special moments with us<br><span> #marlowsengagements</span></div></div>
    <div class="insta-photo-list">
        <div class="owl-carousel owl-theme photo-slider">
          @foreach($getInstaData as $key => $insta)
          @if($key >= 10)
                  @break
              @endif
                <div class="item">
                    <div class="instaphoto-info">
                        <div class="instaphoto-img">
                          <img src="{{ $insta->image_url}}" alt="{{ $insta->alt ?? 'Instagram Image' }}" loading="lazy">
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
{{-- @endif --}}
{{-- <script>
  fetch('https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,timestamp,username&access_token=IGAARcSE6ZBZBB1BZAE9mN0xMTWU3OTgzODY1NXJCbTFEOExrZA29VSVpTVlFldmROM09aSzRwZAEdhVkRmc2tMWS1DbUlFR0lIU0syVGxvM1dlNkFETWNNMmp1NnlfeXp0WWFsV01JU29hREFNdVVfNGpld1JtVGVva0VNZAXFSTzY0UQZDZD&limit=50')
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("insta-feed");
      if (!data || !data.data) return;

      const postsToRender = [];

      let count = 0;
      data.data.forEach(post => {
        if (count >= 50) return;
        if (post.media_type !== 'VIDEO') {
          count++;
          postsToRender.push(post);
        }
      });
      // Initialize Owl Carousel
      if (typeof $ !== 'undefined' && $('.photo-slider').owlCarousel) {
        $('.photo-slider').owlCarousel({
          loop: true,
          margin: 10,
          nav: true,
          responsive: {
            0: { items: 1 },
            600: { items: 2 },
            767: { items: 3 },
            1000: { items: 5 }
          }
        });
      }
    });
</script> --}}

