<div class="best-selling-marlows">
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three"> Marlow's Diamond Blog</h2>
        </div>
        <div class="blog-carousel-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                @foreach(getEngagementRingsPosts() as $key => $getRelatedPosts)
                    <div class="item">
                        <div class="blog-carousel-info">
                            <div class="blog-carousel-image">
                                <a href="{{asset('blog/'.$getRelatedPosts->slug)}}">
                                    @if(isset($getRelatedPosts->image) && !empty($getRelatedPosts->image))
                                        <img src="{{ asset('storage/'.$getRelatedPosts->image)}}"  onerror="this.src='{{asset('/images/marlowsdiamonds-logo.png')}}'" alt="{{$getRelatedPosts->title}}">
                                    @else
                                        <img src="{{asset('/images/marlowsdiamonds-logo.png')}}" onerror="this.src='{{asset('/images/marlowsdiamonds-logo.png')}}'"/>
                                    @endif
                                </a>
                            </div>
                            <div class="blog-carousel-item-details">
                                <div class="blog-carousel-titles-small">
                                    <a href="{{asset('blog/'.$getRelatedPosts->slug)}}"> {{$getRelatedPosts->title}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
