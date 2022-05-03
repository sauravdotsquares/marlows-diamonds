@extends('layouts.front.app')
@section('content')

<!-- guide main -->
<div class="buying-engagementguide-page">
	<div class="main-guide-blok">
		<div class="container">
			<h1>Guide To Buying An Engagement<br> Ring Online During Lockdown</h1>
			<p>This is the only guide you need when buying an engagement ring online.</p>
			<p>We understand there’s a lot of things to consider when buying an engagement ring from an online jeweller, and that’s why we’ll guide you <br>
				through every step of the way to find the perfect choice of engagement ring with our expert help!
			</p>			
		</div>
	</div>

	<!-- Newsletter -->
	<div class="buying-guuides-newsletter">
		<div class="container">
			<!-- Join our mailing list section start -->
			<div class="joinour-mailing">
				<div class="joinour-wraper">
					<div class="joinour-heading">
						<div class="heading-h-two white-text">
							Subscribe to our Newsletter!
						</div>
						<p>Sign up to our newsletter to enter our yearly draw and win back the value of your first order!</p>
					</div>
					<div class="joinour-mailing-form">
						<form action="" method="post" action="{{ route('maillist') }}">
							@csrf
							<div class="form-rows flexed flex-flex-wrap">
								<div class="form-col width-50">
									<label>Yor Name<sup>*</sup></label>
									<input class="input-control {{ $errors->has('title') ? 'error' : '' }}" type="text" name="title" placeholder="Your Name">
									<!-- Error -->
									@if ($errors->has('title'))
									<div class="error">
										{{ $errors->first('title') }}
									</div>
									@endif
								</div>
								<div class="form-col width-50">
									<label>Email<sup>*</sup></label>
									<input class="input-control {{ $errors->has('email') ? 'error' : '' }}" type="text" name="email" placeholder="Email Address">
									@if ($errors->has('email'))
									<div class="error">
										{{ $errors->first('email') }}
									</div>
									@endif
								</div>
							</div>
							<div class="form-rows flexed flex-flex-wrap">
								<div class="form-col">
									<label>Message</label>
									<textarea name="description" class="input-control {{ $errors->has('description') ? 'error' : '' }}" placeholder="Message"></textarea>
									
								</div>
							</div>
							<div class="action-btn">
								<button class="white-bg-btn">Subscribe</button>

							</div>
						</form>

					</div>
					@if(Session::has('success'))
						<div class="alert alert-success">
							{{Session::get('success')}}
						</div>
					@endif
				</div>
			</div>
			
		</div>
	</div>
		<!-- Join our mailing list section End -->

	<!-- should buy --->
	<div class="should-buy-wraper">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="should-buy-col">
						<h2>Should You Buy Diamond Engagement Rings Online? Guide To Buying An Engagement Ring Online During Lockdown</h2>
					</div>	
				</div>
				<div class="col-md-6">
					<div class="should-buy-col">
						<p>We understand there’s a lot of things to consider when buying an engagement ring from an online jeweller, 
							and that’s why we’ll guide you through every step of the way to find the perfect choice of engagement ring with our expert help!</p>
						<p>This guide will help you better your knowledge of diamonds and their key factors, which are crucial to ensuring you get a fair 
							purchase and the true quality of the diamond is reflected in the price.</p>
					</div>	
				</div>
			</div>
		</div>
	</div>

	<!-- guides even odd list of image text -->	
	<div class="buying-guides-img-text">
		<div class="container">
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6">
						<div class="buying-guidelist-text">
							<h3>Is Buying An Engagement Ring Online A Good Idea?</h3>
							<p>The idea of whether you should buy an engagement ring 
								online is only as good as the jeweller. So, to this 
								question, we’d say YES! However, keep in mind that it's not straightforward,
								especially if you don’t know where to start or what ring style to go for.
								But don’t worry if you’re currently in this predicament, as we’ve got you covered.</p>
						</div>		
					</div>
					<div class="col-lg-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-06.jpg" alt="img guide">
						</div>		
					</div>
				</div>
			</div>	
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-04.jpg" alt="img guide">
						</div>		
					</div>
					<div class="col-lg-6">
						<div class="buying-guidelist-text">
							<h3>Planning To Propose Over Lockdown?</h3>
							<p>Despite the current pandemic, the rate of people popping the big question has not dropped at all - if anything, we’ve seen this number grow.
								 With quarantined couples put to the test, many of them realised that they are capable of being committed to their relationship for life.</p>
							<p>Buying an engagement ring during lockdown brings its own challenges, with nowhere open to allow you to view the rings in person and 
								consultations being taken digitally. But even before COVID was a thing, choosing the right engagement ring online was never 
								going to be an easy task. With that in mind, here are some essentials that you should have prepared if you’re ordering a ring as a surprise.</p>	 
						</div>		
					</div>
				</div>
			</div>	
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6">
						<div class="buying-guidelist-text">
							<h3>Things To Consider When Buying An Engagement Ring Online</h3>
							<p>If you were looking for a guide to choosing an engagement ring, to help you choose
								 the best style, stone or ring colour - you’ve found it. Learn the key lingo and get expert inspiration along the way.</p>
								 <p>Buying an engagement ring online can be a daunting task, so where do you begin? Start by asking yourself the following questions one step at a time.
									  Build your knowledge of engagement rings and learn the difference between various metals, stones and settings, and don’t forget the essentials.</p>
						</div>		
					</div>
					<div class="col-lg-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-05.jpg" alt="img guide">
						</div>		
					</div>
				</div>
			</div>	
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-03.jpg" alt="img guide">
						</div>		
					</div>
					<div class="col-lg-6">
						<div class="buying-guidelist-text">
							<h3>Should You Buy A GIA Certified Diamond Engagement Ring?</h3>
							<p>Our first piece of advice is that you need to buy a GIA Certified diamond engagement ring.
								 Not only because we stock a stunning range of GIA certified diamond engagement rings, 
								 but also because you’ll receive a true representation of the product quality. So, rather than trusting a jeweller that
								  speaks about the relevant diamond terms, trust one that has had them certified</p>
						</div>		
					</div>
				</div>
			</div>	
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6">
						<div class="buying-guidelist-text">
							<h3>What Should The Budget Be?</h3>
							<p>This is custom heading element</p>
							<p>There’s no ideal budget figure for an engagement ring because the national average changes depending on where you search. Plus, 
								the jeweller will always suggest that you spend more to get the highest quality ring possible. The only ideal ring budget
								 will be one that allows you to comfortably afford the most beautiful option for your partner, without having to struggle 
								 or compromise on things like the wedding and honeymoon.</p>
							<p>This is custom heading element</p>
						</div>		
					</div>
					<div class="col-lg-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-02.jpg" alt="img guide">
						</div>		
					</div>
				</div>
			</div>	
			<!-- list end -->
			<!-- list -->
			<div class="buying-guide-listss">
				<div class="row">
					<div class="col-lg-6">
						<div class="buying-guidelist-img">
							<img src="assets/images/Marlows-01.jpg" alt="img guide">
						</div>		
					</div>
					<div class="col-lg-6">
						<div class="buying-guidelist-text">
							<h3>What Is The Right Ring Size?</h3>
							<p>Are you buying an engagement ring without knowing size? The ring size is sometimes overlooked until the final moments of engagement 
								ring shopping, but if you don’t want any disappointment then it’s best to be clued up before going online and hunting 
								for the perfect engagement ring. After all, you want the proposal to be as perfect as possible.</p>
							<p>However, finding the right engagement ring size is not a straightforward task if you want to keep things secret. Fortunately, 
								we can recommend a few ways to find out the ring size without spilling the beans.</p>	
						</div>		
					</div>
				</div>
			</div>	
			<!-- list end -->	
		</div>
	</div>

</div>
<!-- main end of page middle text-->




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
                        The staff are friendly and</div>
                        
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
                        The staff are friendly and</div>
                        
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
                        The staff are friendly and</div>
                        
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
                        The staff are friendly and</div>
                        
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
                        The staff are friendly and</div>
                        
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
	<div class="share-moment-heading"><div class="heading-h-two">Share your special moments with us<br> #marlowsengagements</div></div>
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