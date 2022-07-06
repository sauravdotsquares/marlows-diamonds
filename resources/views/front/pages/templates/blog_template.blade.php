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
	<div class="row" id="post-data">

	</div>
	<input type="hidden" id="sectionHeight" value="">
	<input type="hidden" id="scrollFlag" value="">
	</div>
</div>
<div class="ajax-load text-center" style="display:none">
	<p><img src="https://www.marlows-diamonds.co.uk/wp-content/plugins/ajax-load-more/core/img/spinner-ring.gif">Loading More post</p>
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
                        'slug':'{{request()->segment(1)}}'
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
