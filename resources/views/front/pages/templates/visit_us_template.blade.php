@extends('layouts.front.app')
@section('content')
    @section('css')
    <style>
        .error {
            color: #e74c3c !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @endsection


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

				<div id="div-1-1-content"  class="viti-map div-1-1-content dc-11 open">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2429.571318268873!2d-1.9142953840215433!3d52.486897046434166!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4870bcedd249bb6d%3A0xba2e1f541ca072aa!2s46%20Warstone%20Ln%2C%20Birmingham%20B18%206JJ%2C%20UK!5e0!3m2!1sen!2sin!4v1649678690220!5m2!1sen!2sin" width="950" height="555" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
				<div id="div-1-2-content" class="viti-map dc-12"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2483.8525101227824!2d-0.16446100000000002!3d51.497574!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4876054098ba5097%3A0x18add362c927fd34!2s20%20Beauchamp%20Pl%2C%20London%20SW3%201NQ%2C%20UK!5e0!3m2!1sen!2sin!4v1652681925563!5m2!1sen!2sin" width="850" height="555" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
			</div>
			<div class="col-lg-4">
			<!-- Success message -->
			{{-- @if(Session::has('success'))
				<div class="alert alert-success">
					{{Session::get('success')}}
				</div>
			@endif --}}
				<div class="visit-form">
					<h3>NEED ASSISTANCE?</h3>
					<p>We're here to help...<br>Complete the contact form below and we will be in touch.</p>
					<form id="contactForm">
					    @csrf
                        <input type="hidden" name="custom_url" id="custom_url" value="{{url()->full()}}">
						<div class="form-controls">
							<input type="text" name="title" id="title" class="{{ $errors->has('title') ? 'error' : '' }}" placeholder="Your Name">
							<!-- Error -->
							@if ($errors->has('title'))
							<div class="error">
								{{ $errors->first('title') }}
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
							<textarea name="description" id="description" class="{{ $errors->has('description') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
							@if ($errors->has('description'))
							<div class="error">
								{{ $errors->first('description') }}
							</div>
							@endif
						</div>
						<div class="google-capatcha form-controls">
						<div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6LfQrxUgAAAAAFD1c2BmyaKHy1F20WUJEloRiyie">
						</div>
						@if ($errors->has('g-recaptcha-response'))
							<div class="error">
								{{ $errors->first('g-recaptcha-response') }}
							</div>
							@endif
						</div>
						<div class="action-submit">
							<button type="submit" name="send" value="Submit">Send Message</button>
						</div>

					</form>
					<div class="visitform-text">
						Your information will <b>NOT</b> be used by third-parties for marketing. Please see our <u><a href="/privacy-policy">privacy policy</a></u> for more information.
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

<script>
var firstDiv = $("#div-1-1");
var secondDiv = $("#div-1-2");

$(document).ready(function() {
  //On Click of 1st Div, we're also toggling the 2nd DIV in case if it was open
  // Can handle in a better way as well
  // Same goes for the 2nd div
  firstDiv.click(() => {
    $(".dc-11").addClass("open");
    $(".dc-12").removeClass("open");
  });

  secondDiv.click(() => {
    $(".dc-12").addClass("open");
    $(".dc-11").removeClass("open");
  });
});
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
         grecaptcha.ready(function() {
             grecaptcha.execute('6Lc9hhUgAAAAAJzmHHLuY__2pxT9bHMlIPzgGbwN', {action: 'contact'}).then(function(token) {
                if (token) {
                  document.getElementById('recaptcha').value = token;
                }
             });
         });
</script>
<style>
    .outer-block {
    width: 200px;
    margin: auto;
    }

    .block {
    display: flex;
    }

    .block>div {
    flex: 1;
    text-align: center;
    border: 2px solid red;
    height: 80px;
    }

    .open {
    display: block !important;
    }

    .dc-11 {

    display: none;
    }

    .dc-12 {

    display: none;
    }
</style>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    function blankForm(){
        $('input[name="title"]').val('');
        $('input[name="email"]').val('');
        $('input[name="phone"]').val('');
        $('textarea[name="description"]').val('');
        $("button[type='submit']").prop('disabled',false);
        grecaptcha.reset();
    }

    $('form#contactForm').validate({
        rules: {
            title: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
            },
            description: {
                required: true,
            }
        },
        messages: {
            title: {
                required: 'Name is required',
            },
            email: {
                required: 'Email is required',
                email: 'Valid email is required',
            },
            phone: {
                required: 'Phone is required',
            },
            description: {
                required: 'Description is required',
            }
        },
        submitHandler: function (form) {
            if (grecaptcha.getResponse()) {
                var form_data = new FormData(form);
                $(form).find("button[type='submit']").prop('disabled',true);
                $("button[type='submit']").text("Please Wait...");
                $.ajax({
                    url: "{{ route('contact') }}",
                    method: "POST",
                    cache:false,
                    contentType:false,
                    processData: false,
                    data: form_data,
                    success: function (response) {
                        blankForm();
                        $("button[type='submit']").text("Subscribe");
                        // $(this).find("button[type='submit']").prop('disabled',true);
                        // console.log(response);
                        // return false;
                        if(response.status == 200){
                            toastr.success(response.success);
                            // window.location.reload();
                        }else{
                            toastr.info(response.error);
                        }
                    }
                });
            } else {
                alert('Please confirm captcha to proceed')
            }
        }
    });
</script>
@endsection
