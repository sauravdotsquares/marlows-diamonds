@extends('layouts.front.app')
@section('content')

{{$data->title}}

<!-- Blog Listing -->
<div class="bloglist-wraper">
	<div class="container">
		<div class="row">
		@foreach($showdata as $key=>$value)
			<div class="col-lg-4 col-sm-6">
				<div class="blos-listbox">
					<div class="blos-listbox-img">
						<a href="{{$value->slug}}"><img src="{{asset('storage/app/'.$value->image)}}" /></a>
					</div>
					<div class="blos-listbox-text">
						<div class="blos-list-date">
							<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
						</div>
						<div class="blos-list-title">
							<a href="#">{{isset($value->title)?$value->title:""}}</a>
						</div>
						<div class="blos-list-desc">
							<p>{{isset($value->short_description)?$value->short_description:""}}</p>
						</div>
						<div class="blog-readmore">
							<a class="btn-bg-small" href="#">Read More</a>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			
			

		</div>
	</div>
</div>




@endsection