@extends('layouts.front.app')
@section('content')



<!-- category header banner start -->
<div class="category-banner" style="background-image:url({{asset('storage/'.$data->image)}})">
	<div class="container">
		<div class="category-banner-text">
			<h1>MARLOWS DIAMONDS BIRMINGHAM & LONDON</h1>
			<h2>CERTIFIED DIAMOND JEWELLERS</h2>
			<p>Pop by one of our stores and take a look at our wide range of diamonds. We’ve helped generations of<br> people find their perfect diamond, come and talk to us today.</p>
		</div>
	</div>
</div>
<!-- category header banner end -->


<!-- Visit US map and form -->
<div class="visit-form-map">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="viti-map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2429.571318268873!2d-1.9142953840215433!3d52.486897046434166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4870bcedd249bb6d%3A0xba2e1f541ca072aa!2s46%20Warstone%20Ln%2C%20Birmingham%20B18%206JJ%2C%20UK!5e0!3m2!1sen!2sin!4v1649678690220!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
			<div class="col-lg-4">
			<!-- Success message -->
			@if(Session::has('success'))
				<div class="alert alert-success">
					{{Session::get('success')}}
				</div>
			@endif
				<div class="visit-form">
					<h3>NEED ASSISTANCE?</h3>
					<p>We're here to help...<br>Complete the contact form below and we will be in touch.</p>
					<form method="post" action="{{ route('contact') }}">
					@csrf
						<div class="form-controls">
							<input type="text" name="name" id="name" class="{{ $errors->has('name') ? 'error' : '' }}" placeholder="Your Name">
							<!-- Error -->
							@if ($errors->has('name'))
							<div class="error">
								{{ $errors->first('name') }}
							</div>
							@endif
						</div>
						<div class="form-controls">
							<input type="email" name="email" id="email" class="{{ $errors->has('email') ? 'error' : '' }}" placeholder="Your Email Address">
							@if ($errors->has('email'))
							<div class="error">
								{{ $errors->first('email') }}
							</div>
							@endif
						</div>
						<div class="form-controls">
							<input type="text" name="phone" id="phone" class="{{ $errors->has('phone') ? 'error' : '' }}" placeholder="Your Contact No.">
							@if ($errors->has('phone'))
							<div class="error">
								{{ $errors->first('phone') }}
							</div>
							@endif
						</div>
						<div class="form-controls">
							<textarea name="message" id="message" class="{{ $errors->has('message') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
							@if ($errors->has('message'))
							<div class="error">
								{{ $errors->first('message') }}
							</div>
							@endif
						</div>
						<div class="google-capatcha">

						</div>
						<div class="action-submit">
							<button type="submit" name="send" value="Submit">Send Message</button>
						</div>
					</form>
					<div class="visitform-text">
						<a href="#">Your information will <b>NOT</b> be used by third-parties for marketing. Please see our <u>privacy policy</u> for more information.</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Visit address box -->
<div class="visit-address-wraper">
	<div class="container">
		{!! isset($data->description)?$data->description:"" !!}
	</div>
</div>



@endsection