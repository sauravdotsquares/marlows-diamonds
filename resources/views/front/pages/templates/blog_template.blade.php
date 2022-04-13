@extends('layouts.front.app')
@section('content')


<style type="text/css">
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
  	</style>
<!-- header banner start -->
@if(isset($blog_details) && $blog_details != 1 )
	

<div class="category-banner" style="background-image:url({{asset('storage/'.$data->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{$data->title}}</h1>
			<h2>{{$data->subtitle}}</h2>
			<p><?php echo html_entity_decode($data->short_description);?></p>
		</div>
	</div>
</div>

@endif
<!-- header banner end -->
<!-- Blog Listing -->
<div class="bloglist-wraper">
	<div class="container">
	<div class="row" id="post-data">	
		
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
</div>			



<div class="ajax-load text-center" style="display:none">
	<p><img src="https://www.marlows-diamonds.co.uk/wp-content/plugins/ajax-load-more/core/img/spinner-ring.gif">Loading More post</p>
</div>

<script type="text/javascript">
	var page = 1;
	$( document ).ready(function() {
	    loadMoreData(page);
	});
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() == $(document).height()) {
			
	        page++;
	        loadMoreData(page);
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
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {
	              alert('server not responding...');
	        });
	}
</script>

@endsection