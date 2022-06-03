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
				<a href="{{asset('blog-resources/'.$data->slug)}}">{{isset($data->title)?$data->title:'Title'}}</a>
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
                           <img src="{{asset('storage/'.$data->image)}}" alt="1">
                        @endif
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
				@php
					$getRelatedPosts = getRelatedPosts();
				@endphp
				@foreach($getRelatedPosts as $post)
				<div class="item">
			    	<div class="blos-listbox">
						<div class="blos-listbox-img">
							<a href="/blog-resources/{{isset($post->slug)?$post->slug:""}}"><img src="{{asset('storage/'.$post->image)}}" alt="1"></a>
						</div>
						<div class="blos-listbox-text">
							<div class="blos-list-date">
								<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
								<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
							</div>
							<div class="blos-list-title">
								<a href="/blog-resources/{{isset($post->slug)?$post->slug:""}}">{{isset($post->title)?$post->title:""}}</a>
							</div>
							<div class="blos-list-desc">
								{{isset($post->short_description)?$post->short_description:""}}
							</div>
							<div class="blog-readmore">
								<a class="btn-bg-small" href="/blog-resources/{{isset($post->slug)?$post->slug:""}}">Read More</a>
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
