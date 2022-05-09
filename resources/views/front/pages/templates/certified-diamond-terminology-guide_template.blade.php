@extends('layouts.front.app')
@section('content')
<div class="category-banner" style="background-image:url(assets/images/PremiumContent-Header.jpg)">
	<div class="container">
		<div class="category-banner-text">
			<h1>{{$data->title}}</h1>
			<p>{!!$data->subtitle!!}</p>
		</div>
	</div>
</div>


<div class="certified-diamond-ring">
	<div class="container">
		<div class="row">
			<div class="col-lg-6  col-md-6">
				<div class="certified-diamond-img">
					<img src="assets/images/marlows-diamonds-terminology-guide-showcase.png" alt="mob">
				</div>	
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="certified-diamond-form">
					<h4>TERMINOLOGY GUIDE</h4>
					<h2>Certified Diamond Engagement Rings</h2>
					<p>Shopping for a certified diamond engagement ring for a loved one? We've outlined a list of the 
						terms that you should look out for before making that all-important purchase</p>
					<div class="guidehere-form">
						<span>Download your FREE Terminology guide here:</span>
						<form>
							<div class="form-group">
								<input class="form-control" type="text" placeholder="Your Name">
							</div>
							<div class="form-group">
								<input class="form-control" type="text" placeholder="Email Address">
							</div>
							<div class="capatch-box">
								[Capatha]
							</div>
							<div class="action-btn">
								<button type="submit" class="btn-bg-small">Download</button>
							</div>
						</form>
					</div>
					<div class="info-privacy">
						Your information will not be used by third-parties for marketing. We hold a strict Privacy policy.
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>



@endsection