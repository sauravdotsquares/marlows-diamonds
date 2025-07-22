@extends('layouts.front.app')
@section('content')
<!-- Related Blog Section End -->
@endsection

@section('js')
<script>
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
      // Send data to backend
      fetch('/save-instagram-posts', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ posts: postsToRender })
      })
      .then(res => res.json())
      .then(result => {
        console.log('Saved to backend:', result);
      })
      .catch(error => {
        console.error('Error saving posts:', error);
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
</script>
@endsection