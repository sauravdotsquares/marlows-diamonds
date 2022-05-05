

@extends('layouts.front.app')
@section('content')
<!-- category header banner start -->
<div class="category-banner" style="background-image:url(assets/images/blog-main-bg.jpg)">
   <div class="container">
      <div class="category-banner-text">
         <h1>GUIDE TO BUYING CERTIFIED DIAMONDS</h1>
         <h2>ENGAGEMENT RING FAQ's</h2>
         <p>If you may require further assistance, feel welcome to <a href="#">Contact our Support Team</a></p>
      </div>
   </div>
</div>
<!-- category header banner end -->
<div class="faq-main-list">
   <div class="container">
      <div class="row">
         @php
         $getFaqs = getFaqs();		
         @endphp
         @foreach($getFaqs as $key => $faqcat)
         <div class="col-lg-6">
            <div class="faq-list-inner">
               <div class="faqin-head">{{isset($faqcat->title)?$faqcat->title:""}}</div>
               <div class="faq-list">
                  <div class="accordion" id="accordionExample">
                     @foreach($faqcat->getFAQData as $key1 => $faq)
                     <div class="accordion-item">
                        <h2 class="accordion-header" id="faqheadingThree">
                           @if($key1 == 0)
                           <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                           @else
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                              @endif
                              <!--<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapseThree" aria-expanded="true" aria-controls="faqcollapseThree"> -->
                              {{$faq->title}}
                           </button>
                        </h2>
                        @if($key1 == 0)
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                           @else
                           <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                              @endif
                              <!--<div id="faqcollapseThree" class="accordion-collapse collapse" aria-labelledby="faqheadingThree" data-bs-parent="#accordionExample">-->
                              <div class="accordion-body">
                                 {!!$faq->description!!}
                              </div>
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>
         
      
      @endforeach
   </div>
   </div>
</div>
</div>





<!-- Section Reviews -->
<div class="container">
   <div class="rating-review-block">
      <div class="owl-carousel owl-theme slider-review">
         <div class="item">
            <div class="reviews-cont">
               <div class="reviewr-name">
                  Sana Anwar
               </div>
               <div class="reviewr-star">
                  <img src="{{asset('')}}assets/images/stars.png" alt="star">
               </div>
               <div class="reviewr-review-text">
                  <div class="less-contents">I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                     bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                     The staff are friendly and
                  </div>
                  <div class="show-more-content">
                     accommodating. They do regular cleaning of my set and any problem I have had they have been happy to help. 
                     I would definitely recommend this place. A million times better than the high Street and the aftercare is top notch!
                  </div>
                  <a class="show-more" href="javascript:void(0)">Read more</a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="reviews-cont">
               <div class="reviewr-name">
                  Sana Anwar
               </div>
               <div class="reviewr-star">
                  <img src="{{asset('')}}assets/images/stars.png" alt="star">
               </div>
               <div class="reviewr-review-text">
                  <div class="less-contents">I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                     bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                     The staff are friendly and
                  </div>
                  <div class="show-more-content">
                     accommodating. They do regular cleaning of my set and any problem I have had they have been happy to help. 
                     I would definitely recommend this place. A million times better than the high Street and the aftercare is top notch!
                  </div>
                  <a class="show-more" href="javascript:void(0)">Read more</a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="reviews-cont">
               <div class="reviewr-name">
                  Sana Anwar
               </div>
               <div class="reviewr-star">
                  <img src="{{asset('')}}assets/images/stars.png" alt="star">
               </div>
               <div class="reviewr-review-text">
                  <div class="less-contents">I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                     bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                     The staff are friendly and
                  </div>
                  <div class="show-more-content">
                     accommodating. They do regular cleaning of my set and any problem I have had they have been happy to help. 
                     I would definitely recommend this place. A million times better than the high Street and the aftercare is top notch!
                  </div>
                  <a class="show-more" href="javascript:void(0)">Read more</a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="reviews-cont">
               <div class="reviewr-name">
                  Sana Anwar
               </div>
               <div class="reviewr-star">
                  <img src="{{asset('')}}assets/images/stars.png" alt="star">
               </div>
               <div class="reviewr-review-text">
                  <div class="less-contents">I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                     bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                     The staff are friendly and
                  </div>
                  <div class="show-more-content">
                     accommodating. They do regular cleaning of my set and any problem I have had they have been happy to help. 
                     I would definitely recommend this place. A million times better than the high Street and the aftercare is top notch!
                  </div>
                  <a class="show-more" href="javascript:void(0)">Read more</a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="reviews-cont">
               <div class="reviewr-name">
                  Sana Anwar
               </div>
               <div class="reviewr-star">
                  <img src="{{asset('')}}assets/images/stars.png" alt="star">
               </div>
               <div class="reviewr-review-text">
                  <div class="less-contents">I am a customer if the Birmingham store and I am very pleased with my purchase 6 years on. I
                     bought a white gold diamond necklace and earrings set and am still delighted with my purchase.
                     The staff are friendly and
                  </div>
                  <div class="show-more-content">
                     accommodating. They do regular cleaning of my set and any problem I have had they have been happy to help. 
                     I would definitely recommend this place. A million times better than the high Street and the aftercare is top notch!
                  </div>
                  <a class="show-more" href="javascript:void(0)">Read more</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- insta photos section start -->
<div class="share-moment">
   <div class="share-moment-heading">
      <div class="heading-h-two">Share your special moments with us<br> #marlowsengagements</div>
   </div>
   <div class="insta-photo-list">
      <div class="owl-carousel owl-theme photo-slider">
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-one.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-two.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-three.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-four.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-five.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="insta-btn">
      <a class="btn-bg-small" href="#"><i class="fa fa-instagram" aria-hidden="true"></i> View on Instagram</a>
   </div>
</div>
<!-- insta photos section end -->	
@endsection

