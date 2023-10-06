@extends('layouts.front.app')
@section('content')



<!--  Bread Crumb of blog start-->

<div class="container">
	<div class="breadcrumb-navs">
		<ul>
			<li>
				<a href="{{env('APP_URL')}}">Home</a>
			</li>
			<li>
				<a href="{{asset($data->cat_name->slug)}}">{{isset($data->cat_name->name)?$data->cat_name->name:'Uncategorized'}}</a>
			</li>
			<li>
				{{--  Change after SEO discuss 05Jan2023 seo_change --}}
				<a href="{{asset('blog/'.$data->slug)}}">{{isset($data->title)?$data->title:'Title'}}</a>
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
							<span><i class="fa fa-user" aria-hidden="true"></i>   MarlowsDiamonds at </span>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i> {{isset($data->created_at)?$data->created_at->format('M d, Y'):""}}</span>
						</div>
					<div class="blog-main-img">
						@if(!empty(($data->image)))
                           <img src="{{ env('APP_IMAGE_URL').'/storage/'.$data->image }}" alt="{{$data->title}}">
                        @endif
					</div>
					<div class="blogdetail-desc">
						<?php echo html_entity_decode($data->description);?>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="blog-search-field">
				</div>
	
				<div class="blogdetails-sidebar blog-list-sidebar blog-list-sidebar-first mobile-sidebar">
					<div class="blogall-latest-resc">
					<div class="accordion" id="accordion_categoreis">
						<div class="accordion-item">
						  <h2 class="accordion-header" id="headingOne">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
								All Categories
							</button>
						  </h2>
						  <div id="collapseOne" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordion_categoreis">
							<div class="accordion-body">
								<ul>
									@php
										$getCategories = getCategories();
									@endphp
									@foreach($getCategories as $category)	
										<li><a href="{{ route('blog_list', $category->slug) }}">{{isset($category->name)?$category->name:""}}</a></li>
									@endforeach
								</ul>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
	
				<div class="blogdetails-sidebar blog-list-sidebar blog-list-sidebar-first mobile-sidebar">
					<div class="blogall-latest-resc">
					<div class="accordion" id="accordion_posts">
						<div class="accordion-item">
						  <h2 class="accordion-header" id="headingOne">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Latest Resources
							</button>
						  </h2>
						  <div id="collapseTwo" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordion_posts">
							<div class="accordion-body">
								<ul>
									@php
										$getRecentPosts = getRecentPosts();
									@endphp
									@foreach($getRecentPosts as $post)
										<li><a href="{{  url('/blog/'. (isset($post->slug)? $post->slug : "") ) }}">{{isset($post->title)?$post->title:""}}</a></li>
									@endforeach
								</ul>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				
				<div class="blogdetails-sidebar blog-list-sidebar blog-list-sidebar-first desktop-sidebar">
					<div class="blogall-latest-resc">
						<div class="sidebar-title">
							All Categories
						</div>
						<ul>
							@php
								$getCategories = getCategories();
							@endphp
							@foreach($getCategories as $category)	
								<li><a href="{{ route('blog_list', $category->slug) }}">{{isset($category->name)?$category->name:""}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
	
				<div class="blogdetails-sidebar blog-list-sidebar desktop-sidebar">
					<div class="blogall-latest-resc">
						<div class="sidebar-title">
							Latest Resources
						</div>
						<ul>
							@php
								$getRecentPosts = getRecentPosts();
							@endphp
							@foreach($getRecentPosts as $post)
								<li><a href="{{  url('/blog/'. (isset($post->slug)? $post->slug : "") ) }}">{{isset($post->title)?$post->title:""}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@php
	$getEngagementFaqs = getFaqByCategory(explode(',',$data->faq_category));
@endphp

@if(isset($getEngagementFaqs) && sizeof($getEngagementFaqs))
	<!-- FAQ Section start here -->
	<div class="faq-section engagement-ring-faq">
		<div class="container">
			<div class="head-para-three">
				<h2 class="heading-h-three">
					{{ isset($data->faq_title)?$data->faq_title:"FAQ's" }}
				</h2>
				<p>Some of the most common Q&A's</p>
			</div>
			<div class="faq-list">
				<div class="accordion" id="accordionExample">
					@foreach($getEngagementFaqs as $key => $faq)
					<div class="accordion-item">
						<h3 class="accordion-header" id="{{$faq->id}}">
							@if($key == 0)
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
							@else
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$faq->id}}" aria-expanded="true" aria-controls="collapse{{$faq->id}}">
							@endif
									{{isset($faq->title)?$faq->title:""}}
								</button>
						</h3>
						@if($key == 0)
							<div id="collapse{{$faq->id}}" class="accordion-collapse collapse show" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
						@else
							<div id="collapse{{$faq->id}}" class="accordion-collapse collapse" aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
						@endif
								<div class="accordion-body">
									{!! isset($faq->description)?$faq->description:"" !!}
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- FAQ Section End -->
@endif
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
				@php
					$getRelatedPosts = getRelatedPosts();
				@endphp
				@foreach($getRelatedPosts as $post)
				<div class="item">
			    	<div class="blos-listbox">
						<div class="blos-listbox-img">
							<a href="{{ url('/blog/' . (isset($post->slug)?$post->slug:"")) }}">
								@if(!empty(($post->image)))
									<img src="{{ env('APP_IMAGE_URL').'/storage/'.$post->image }}" alt="{{$post->title}}">
								@else 
									<img src="{{ env('APP_IMAGE_URL').'/images/marlowsdiamonds-logo.png' }}" alt="{{$post->title}}">
								@endif
							</a>
						</div>
						<div class="blos-listbox-text">
							<div class="blos-list-date">
								<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
								<span><i class="fa fa-clock-o" aria-hidden="true"></i> {{isset($post->created_at)?$post->created_at->format('M d, Y'):""}} </span>
							</div>
							<div class="blos-list-title">
								<a href="{{ url('/blog/' . (isset($post->slug)?$post->slug:"")) }}">{{isset($post->title)?$post->title:""}}</a>
							</div>
							<div class="blos-list-desc">
								{{isset($post->short_description)?$post->short_description:""}}
							</div>
							<div class="blog-readmore">
								<a class="btn-bg-small" href="{{ url('/blog/' . (isset($post->slug)?$post->slug:"")) }}">Read More</a>
							</div>
						</div>
					</div>
			    </div>
				@endforeach
			</div>
		</div>
	</div>
</div>

<!-- Related Blog Section End -->


@endsection


@section('js')
<script>
	const searchRedirect = "{{ url('blog') }}";
	$(document).ready(function() {
		$(document).on('click','.blog-detail-search-button', function(){
			redirectToBlog();
		});

		$(".blog-details-search-input").keyup(function(event) {
			if (event.keyCode === 13) { redirectToBlog(); }
		});

	});


	function redirectToBlog(){
		const searchKeyword = $(".blog-details-search-input").val();
		if(typeof searchKeyword!='undefined' && searchKeyword && searchKeyword!=''){
			const fullUrl = searchRedirect + '?searchKeyword=' + searchKeyword;
			window.location = fullUrl;
		}
	}

</script>
@endsection