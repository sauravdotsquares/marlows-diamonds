@extends('layouts.front.app')
@section('content')
<!--<div class="category-banner" style="background-image:url({{asset('storage/'.$data->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{$data->title}}</h1>
			<p>{!!$data->subtitle!!}</p>
		</div>
	</div>
</div>-->

<div class="ring-guide-banner">
<div class="container">
		<div class="row">
	<div class="col-md-6">
		<div class="ring-personal-desc">
			<h1>{{$data->title}}</h1>
			<p>Popping into one of our stores and having your finger measured is the most accurate way to determine your ring size, but if you need to find out from the comfort of your own home, we’re here to help with these handy tips.</p>
		</div>
	</div>

	<div class="col-md-6"><div class="ring-personal-img"><img src="https://devstaging.marlows-diamonds.co.uk/assets/images/ring-personal-gold.png" alt=""></div></div>
</div>
</div>

</div>


	<div class="container">

	<!--<div class="ring-guide-text">
			<h2>Popping into one of our stores and having your finger measured is the most accurate way to determine your ring size, but if you need to find out from the comfort of your own home, we’re here to help with these handy tips.</h2>
		</div>-->

		<div class="ring-size-tabing">
			<h3>UK to US Ring Size Conversion</h3>
			<nav>
			<div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
				<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
				<button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
				<button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
			</div>
		</nav>
		<div class="tab-content p-3 border bg-light" id="nav-tabContent">
			<div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
				<div class="panel-body table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
			</div>
			<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
<div class="panel-body table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
			</div>
			<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
<div class="panel-body table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                        <th>Ring Size</th>
                                        <th>Circumference (mm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                    <tr>
                                        <td>A</td>
                                        <td>37.8</td>
                                        <td>J</td>
                                        <td>48.7</td>
                                        <td>S</td>
                                        <td>60.2</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
			</div>

		</div>
<h5>Measure your UK ring size in mm before using our UK to US ring size chart to find your perfect fit in US (and Canadian) measurements.</h5>
	</div>
</div>

<div class="printing-ring-chart">
<div class="container">
<div class="row">

<div class="col-sm-12 col-md-12 col-lg-8">
	<div class="guide-chart-desc">
		<h3>How to measure UK ring size at home</h3>
		<p>We’ve created a printable ring sizer chart (actual size) to make finding your perfect ring size easy – just follow these simple steps!</p>

		<ol>
			<li>Download and print off our ring sizer on A4 paper</li>
			<li>Cut around the sizer tool</li>
			<li>Place the tool around your finger</li>
			<li>Pull the end through the slot</li>
			<li>Pull it to fit snugly around your finger</li>
			<li>Make sure it slides over your knuckle</li>
			<li>Find the letter the arrow is pointing to and reveal your ring size</li>
			<li>Remember that thicker band widths need a larger size</li>
		</ol>
		<p>Please note that this is only a guide and will not take into account the style of ring.</p>

		<a href="#" class="btn-bg-large">Download The ring size guide</a>
	</div>
	</div>

	<div class="col-sm-12 col-md-12 col-lg-4">
		<div class="guide-chart-img">
			<a href="{{asset('assets/images/marlos-ring-size.jpg')}}" target="_blank"><img src="{{asset('assets/images/marlos-ring-size-2.jpg')}}" alt=""></a>
		</div>
	</div>


</div>
</div>

</div>


<div class="search-engage">
	
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="search-engage-box">
					<a href="#">
				<div class="search-engage-img"><img src="https://devstaging.marlows-diamonds.co.uk/assets/images/enage-ring1.jpg" alt=""></div>

				<div class="search-engage-desc">
				<h3>Searching for the perfect engagement ring?</h3>
				<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
				<a href="#" class="btn-bg-large">View More</a>
				</div>
					</a>
				</div>
			</div>

			<div class="col-md-6">
				<div class="search-engage-box">
					<a href="#">
				<div class="search-engage-img"><img src="https://devstaging.marlows-diamonds.co.uk/assets/images/enage-ring2.jpg" alt=""></div>

				<div class="search-engage-desc">
				<h3>Searching for the perfect engagement ring?</h3>
				<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
				<a href="#" class="btn-bg-large">View More</a>
				</div>
					</a>
				</div>
			</div>

		</div>
	</div>

</div>

<div class="sizing-tip-sec">
	
	<div class="container">
		<div class="sizing-tip-sec-inner">
		<div class="row">
			<div class="sizing-tip-desc">
		<h2>How to measure a ring in secret</h2>
		<p>When you’re measuring ring size, don’t forget these useful tips.</p>
	</div>
			<div class="col-sm-6 col-md-6 col-lg-4">
				<div class="sizing-tip-box">
					<span><img src="https://devstaging.marlows-diamonds.co.uk/assets/images/engage-ring-1.png" alt=""></span>
					<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-6 col-lg-4">
				<div class="sizing-tip-box">
					<span><img src="https://devstaging.marlows-diamonds.co.uk/assets/images/enage-ring-3.jpg" alt=""></span>
					<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
				</div>
			</div>

			<div class="col-sm-6 col-md-6 col-lg-4">
				<div class="sizing-tip-box">
					<span><img src="https://devstaging.marlows-diamonds.co.uk/assets/images/engage-ring-2.png" alt=""></span>
					<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
				</div>
			</div>



</div>
		</div>
	</div>

</div>


<div class="ring-personal-tips">
<div class="container">
		<div class="row">
	<div class="col-md-6">
		<div class="ring-personal-desc">
			<h3>Ready to shop rings or need some proposal tips?</h3>
			<p>Whether you’re looking for an engagement ring, wedding ring or a designer piece, explore our ring collection and find the one you love. Need some ideas on how to propose? Our helpful guide has you covered.</p>
			<a href="#" class="btn-bg-large">Shop All Rings</a>
		</div>
	</div>

	<div class="col-md-6"><div class="ring-personal-img"><img src="{{asset('assets/images/ring-personal-gold.png')}}" alt=""></div></div>
</div>
</div>

</div>



<div class="guide-secret">
	
    <div class="container">
        <div class="head-para-three">
            <h2 class="heading-h-three"> How to measure UK ring size in secret</h2>
            <p>Want to know how to measure ring size in top secret style? These helpful tips will be your go-to guide. Here’s how to find their ring size and make it the most unforgettable surprise of their life…</p>
        </div>
        <div class="product-item-slider">
            <div class="owl-carousel owl-theme owlslidertwo st-arrows">
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                        	<h3>Try On For Size</h3>
                        	<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                        	<h3>Try On For Size</h3>
                        	<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="product-info">
                        <div class="product-item-details">
                        	<h3>Try On For Size</h3>
                        	<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="friendy-expert-sec">
	<div class="friendly-img"><img src="{{asset('assets/images/friendly-expert.jpg')}}" alt=""></div>

<div class="friendy-expert-desc"><h3>Lorem ipsum dolar simple</h3>
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution</p>
<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has</p>

<a href="#" class="btn-bg-large">Fing Out More</a>
</div>
</div>



<div class="inspiration-sec">
	<div class="container">
		<div class="row">
		<div class="col-sm-12 col-md-6 col-lg-4 ">
		<div class="inspiration-box">
			<a href="#">
				<div class="inspiration-img"><img src="{{asset('assets/images/inspiration-img-1.jpg')}}" alt=""></div>
				<h3>Diamond Buying Guide</h3>
			</a>
		</div>
	</div>


		<div class="col-sm-12 col-md-6 col-lg-4 ">
		<div class="inspiration-box">
			<a href="#">
				<div class="inspiration-img"><img src="{{asset('assets/images/inspiration-img-2.jpg')}}" alt=""></div>
				<h3>Diamond Buying Guide</h3>
			</a>
		</div>
	</div>

		<div class="col-sm-12 col-md-6 col-lg-4 ">
		<div class="inspiration-box">
			<a href="#">
				<div class="inspiration-img"><img src="{{asset('assets/images/inspiration-img-3.jpg')}}" alt=""></div>
				<h3>Diamond Buying Guide</h3>
			</a>
		</div>
	</div>
</div>

	</div>
</div>





@endsection