@foreach($posts as $post)

<div class="col-lg-4 col-sm-6">
				<div class="blos-listbox">
					<div class="blos-listbox-img">
						<a href="{{url('/blog-resources/'.$post->slug)}}">
						 @if(!empty(($post->image)))
                           <img src="{{asset('storage/'.$post->image)}}"  alt="blog1">
                         @else <img src="{{url('/images/marlowsdiamonds-logo.png')}}"  alt="blog1">
						 @endif
						</a>
					</div>
					<div class="blos-listbox-text">
						<div class="blos-list-date">
							<span><i class="fa fa-user" aria-hidden="true"></i> MarlowsDiamonds at </span>
							<span><i class="fa fa-clock-o" aria-hidden="true"></i> {{isset($post->created_at)?$post->created_at->format('M d, Y'):""}}</span>
						</div>
						<div class="blos-list-title">
							<a href="{{url('/blog-resources/'.$post->slug)}}">{{isset($post->title)?$post->title:""}}</a>
						</div>
						<div class="blos-list-desc">
							<p>{{isset($post->short_description)?$post->short_description:""}}</p>
						</div>
						<div class="blog-readmore">
							<a class="btn-bg-small" href="{{url('/blog-resources/'.$post->slug)}}">Read More</a>
						</div>
					</div>
				</div>
			</div>
@endforeach


