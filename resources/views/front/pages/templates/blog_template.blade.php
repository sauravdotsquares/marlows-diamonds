@extends('layouts.front.app')
@section('content')


<style>
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
  	</style>
<!-- header banner start -->
<?php
    $customImage = isset($data->image)?$data->image:'';
    $title = '';
    $customSubTitle = '';
    $customShortDescription = '';

    if(isset($data->blog_title_details) && !empty($data->blog_title_details)){
        $title =$data->name;
        $customSubTitle = $data->blog_title_details->subtitle;
        $customShortDescription = $data->blog_title_details->short_description;
        $customImage = isset($data->blog_title_details->image)?$data->blog_title_details->image:'';
    }
?>
<div class="category-banner" style="background-image:url({{asset('storage/'.$customImage)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{isset($data->title)?$data->title:$title}}</h1>
			<h2>{{isset($data->subtitle)?$data->subtitle:$customSubTitle}}</h2>
			<p><?php echo html_entity_decode(isset($data->short_description)?$data->short_description:$customShortDescription);?></p>
		</div>
	</div>
</div>

<!-- header banner end -->
<!-- Blog Listing -->
<div class="bloglist-wraper">
	<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div id="post-data" class="post-data-col"></div>
		</div>
		<div class="col-lg-3">
			<div class="blog-search-field">
				<div class="formgroup">
					<input type="text" name="search" class="typeahead ng-pristine ng-valid ng-empty ng-touched" placeholder="Search for product.." ng-model="search" ng-keyup="searchProducts()" autocomplete="off">
					<button class="seach-btn" type="button"><img src="http://127.0.0.1:8000/assets/images/search.png" alt="search"></button>
				</div>
			</div>

			<div class="blogdetails-sidebar">
				<div class="blogall-categ">
					<div class="sidebar-title">
						All Categories
					</div>
					<ul>
																				
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-wedding-rings">Wedding Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/uncategorized">Uncategorized</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/princess-cut-engagement-ring">Princess Cut Engagement Ring</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/precious-stones">Precious Stones</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/other-jewellery">Other Jewellery</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/multi-stone-diamond-rings">Multi Stone Diamond Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/loose-diamonds">Loose Diamonds</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/gold-jewellery">Gold Jewellery</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/gia-certified-diamond-rings">GIA Certified Diamond Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/fancy-shaped-diamond-rings">Fancy Shaped Diamond Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-eternity-rings">Eternity Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/essential-guide-to-diamonds">Essential Guide to Diamonds</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamonds">Diamonds</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-rings">Diamond Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-pendants">Diamond Pendants</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-industry-insight">Diamond Industry Insight</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-eternity-ring">Diamond Eternity Ring</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-engagement-ring">Diamond Engagement Ring</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/diamond-earrings">Diamond Earrings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/custom-engagement-rings">Custom Engagement Rings</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/category/certified-diamonds">Certified Diamonds</a></li>
						
												</ul>
				</div>
				<div class="blogall-latest-resc">
					<div class="sidebar-title">
						Latest Resources
					</div>
					<ul>
																				
						<li><a href="http://127.0.0.1:8000/blog/why-round-shape-diamond-is-preferred-choice-for-engagement-rings">Why round shape diamond is preferred choice for engagement rings?</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/5-engagement-ring-trends-to-look-out-for-in-2022">5 Engagement Ring Trends to Look Out for in 2022</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/value-comparison-lab-grown-diamonds-vs-earth-mined-diamonds">Value Comparison – Lab Grown Diamonds vs. Earth Mined Diamonds</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/oval-engagement-rings-are-trending-heres-why">Oval Engagement Rings Are Trending – Here’s Why?</a></li>
						
													
						<li><a href="http://127.0.0.1:8000/blog/astrological-benefits-of-diamond-you-didnt-know-about">Astrological Benefits of Diamond You Didn’t Know About</a></li>
						
												</ul>
				</div>
			</div>
		</div>
	</div> 
	<input type="hidden" id="sectionHeight" value="">
	<input type="hidden" id="scrollFlag" value="">
	</div>
</div>
<div class="ajax-load text-center" style="display:none">
	<p><img src="{{ asset('/images/spinner.gif') }}">Loading More post</p>
</div>
<!-- Section Reviews -->
<div class="container">
<div class="rating-review-block">
	<div class="owl-carousel owl-theme slider-review">
	    @include('front.pages.reviews')
	</div>
</div>
</div>





<script>
	const slugForData = "<?php echo !empty($blogCategorySlug) ? $blogCategorySlug : request()->segment(1) ?>"
	var page = 1;
	$( document ).ready(function() {
	    loadMoreData(page);
	});
	$(window).scroll(function() {
	    var scroll = $('#scrollFlag').val();
            if (scroll==0 && ($(window).scrollTop() >= parseInt($('#sectionHeight').val()-300))) {
	        page++;
	        loadMoreData(page);
	        $('#scrollFlag').val(1);
	    }
	});

	function loadMoreData(page){
	  $.ajax(
	        {
	            url: '{{url("post/get-data")}}',
	            type: "post",
				data: {
                        '_token': "{{csrf_token()}}",
                        'page':page,
						'slug' : slugForData
                        // 'slug':'{{request()->segment(1)}}'
                    },
	            beforeSend: function()
	            {
	                $('.ajax-load').show();
	            }
	        })
	        .done(function(data)
	        {
	            if(data.html == ""){
	                $('.ajax-load').html("No more records found");
	                return;
	            }
	            $('.ajax-load').hide();
	            $("#post-data").append(data.html);
	            $('#sectionHeight').val($( '#post-data' ).height());
                $('#scrollFlag').val(0);
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {
	              alert('server not responding...');
	        });
	}
</script>

@endsection
