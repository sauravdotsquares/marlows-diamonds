

@extends('layouts.front.app')
@section('content')
<!-- category header banner start -->
<div class="category-banner" style="background-image:url(assets/images/blog-main-bg.jpg)">
   <div class="container">
      <div class="category-banner-text">
         <h1>{!!isset($data->title)?$data->title:""!!}</h1>
         <h2>{!!isset($data->subtitle)?$data->subtitle:""!!}</h2>
         <p>{!!isset($data->short_description)?$data->short_description:""!!}</p>
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
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                           @else
                           <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
                              @endif
                              <!--<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqcollapseThree" aria-expanded="true" aria-controls="faqcollapseThree"> -->
                              {{$faq->title}}
                           </button>
                        </h2>
                        @if($key1 == 0)
                        <div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
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
				@include('front.pages.reviews')
				</div>	
			</div>
</div><!-- insta photos section start -->
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
                  <a href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-two.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-three.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-four.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
         <div class="item">
            <div class="instaphoto-info">
               <div class="instaphoto-img">
                  <img src="assets/images/insta-img-five.jpg" alt="insta photo">
               </div>
               <div class="insta-link">
                  <a href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="insta-btn">
      <a class="btn-bg-small" href="https://www.instagram.com/marlows_diamonds" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> View on Instagram</a>
   </div>
</div>
<!-- insta photos section end -->	
@endsection

