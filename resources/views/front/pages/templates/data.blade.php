@foreach($posts as $post)
<div class="col-lg-4 col-sm-6">
				<div class="blos-listbox">
					<div class="blos-listbox-img">
						<a href="{{$post->slug}}"><img src="{{asset('storage/'.$post->image)}}"  alt="blog1"></a>
					</div>
					<div class="blos-listbox-text">
						<div class="blos-list-date">
							<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i> December 13, 2021</span>
						</div>
						<div class="blos-list-title">
							<a href="#">{{isset($post->title)?$post->title:""}}</a>
						</div>
						<div class="blos-list-desc">
							<p>{{isset($post->short_description)?$post->short_description:""}}</p>
						</div>
						<div class="blog-readmore">
							<a class="btn-bg-small" href="#">Read More</a>
						</div>
					</div>
				</div>
			</div>
@endforeach


