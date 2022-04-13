@extends('layouts.front.app')
@section('content')



<!--  Bread Crumb of blog start-->
<div class="container">
	<div class="breadcrumb-navs">
		<ul>
			<li>
				<a href="#">Home</a>
			</li>
			<li>
				<a href="#">Custom Engagement Rings</a>
			</li>
			<li>
				<a href="#">{{$data->title}}</a>
			</li>

		</ul>
	</div>
</div>

<!--  Bread Crumb of blog end-->
<div class="blogdetails-wrap">
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<div class="blogdetails-left">
					<div class="blog-title">
						<h1>{{$data->title}}</h1>
					</div>
					<div class="blos-list-date">
							<span>Published by</span>
							<span><i class="fa fa-user" aria-hidden="true"></i>  <a href="#"> MarlowsDiamonds at</a> </span>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i> {{isset($data->created_at)?$data->created_at->format('M d, Y'):""}}</span>
						</div>
					<div class="blog-main-img">
						<img src="{{asset('storage/'.$data->image)}}" alt="1">
					</div>
					<div class="blogdetail-desc">
						<?php echo html_entity_decode($data->description);?>
					</div>
				</div>	
			</div>
			<div class="col-lg-3">
				<div class="blogdetails-sidebar">
					<div class="blogall-categ">
						<div class="sidebar-title">
							All Categories
						</div>
						<ul>
							@php
								$getCategories = getCategories();
							@endphp
							@foreach($getCategories as $category)
							<li><a href="/{{isset($category->slug)?$category->slug:""}}">{{isset($category->name)?$category->name:""}}</a></li>
							@endforeach
						</ul>
					</div>
					<div class="blogall-latest-resc">
						<div class="sidebar-title">
							Latest Resources
						</div>
						<ul>
							@php
								$getRecentPosts = getRecentPosts();
							@endphp
							@foreach($getRecentPosts as $post)
							<li><a href="/blog-resources/{{isset($post->slug)?$post->slug:""}}">{{isset($post->title)?$post->title:""}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>				
			</div>
			
		</div>
	</div>
</div>

<!-- Related Blog Section start -->

<div class="related-post-blog">
	<div class="container">
		<div class="head-para-three">
			<div class="heading-h-three">
				Related Posts
			</div>			
		</div>
		<div class="related-post-slider">
			<div class="owl-carousel owl-theme related-post st-arrows">
			    <div class="item">
			    	<div class="blos-listbox">
						<div class="blos-listbox-img">
							<a href="#"><img src="assets/images/shutterstock_1730457079.jpg" alt="blog1"></a>
						</div>
						<div class="blos-listbox-text">
							<div class="blos-list-date">
								<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
								<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
							</div>
							<div class="blos-list-title">
								<a href="#">Why round shape diamond is preferred choice for engagement rings?</a>
							</div>
							<div class="blos-list-desc">
								<p>When you think of engagement rings, what shape comes to your mind first? Round cut, right? Well, the popularity of round cut diamond is so much</p>
							</div>
							<div class="blog-readmore">
								<a class="btn-bg-small" href="#">Read More</a>
							</div>
						</div>
					</div>
			    </div>
			    <div class="item">
			    	<div class="blos-listbox">
						<div class="blos-listbox-img">
							<a href="#"><img src="assets/images/Untitled-design-18.png" alt="blog5"></a>
						</div>
						<div class="blos-listbox-text">
							<div class="blos-list-date">
								<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
								<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
							</div>
							<div class="blos-list-title">
								<a href="#">Astrological Benefits of Diamond You Didn’t Know About</a>
							</div>
							<div class="blos-list-desc">
								<p>“Diamonds are a girl’s best friend”. Indeed! But did you know that diamonds are not just about beauty and fashion? If you are planning to surprise</p>
							</div>
							<div class="blog-readmore">
								<a class="btn-bg-small" href="#">Read More</a>
							</div>
						</div>
					</div>
			    </div>
			    <div class="item">
			    	<div class="blos-listbox">
						<div class="blos-listbox-img">
							<a href="#"><img src="assets/images/shutterstock_1700507515-scaled.jpg" alt="blog4"></a>
						</div>
						<div class="blos-listbox-text">
							<div class="blos-list-date">
								<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
								<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
							</div>
							<div class="blos-list-title">
								<a href="#">Oval Engagement Rings Are Trending – Here’s Why?</a>
							</div>
							<div class="blos-list-desc">
								<p>Ariana Grande, Kourtney Kardashian, Hailey Bieber, Serena Williams, Blake Lively (just to name a few) are famous celebrities who rocked the Oval-cut engagement rings and made this</p>
							</div>
							<div class="blog-readmore">
								<a class="btn-bg-small" href="#">Read More</a>
							</div>
						</div>
					</div>
			    </div>
			    <div class="item">
			    	<div class="blos-listbox">
						<div class="blos-listbox-img">
							<a href="#"><img src="assets/images/shutterstock_1700507515-scaled.jpg" alt="blog4"></a>
						</div>
						<div class="blos-listbox-text">
							<div class="blos-list-date">
								<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
								<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
							</div>
							<div class="blos-list-title">
								<a href="#">Oval Engagement Rings Are Trending – Here’s Why?</a>
							</div>
							<div class="blos-list-desc">
								<p>Ariana Grande, Kourtney Kardashian, Hailey Bieber, Serena Williams, Blake Lively (just to name a few) are famous celebrities who rocked the Oval-cut engagement rings and made this</p>
							</div>
							<div class="blog-readmore">
								<a class="btn-bg-small" href="#">Read More</a>
							</div>
						</div>
					</div>
			    </div>
			</div>
		</div>
	</div>
</div>

<!-- Related Blog Section End -->


@endsection