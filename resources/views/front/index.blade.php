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
    <!-- home main-banner start -->
    <div class="home-main-banner">
        <div class="main-banner-wraper flex-flex-wrap flexed">
            <div class="main-banner-col banner-left-col">
                <div class="main-banner-left-text">
                    <h1>Find the Perfect Diamond Rings from Marlow’s</h1>
                    <p>A diamond is forever, so should be yours.</p>
                    <div class="shop-engage-btn">
                        <a class="btn-bg-large" href="{{ asset('engagement-rings') }}">SHOP ENGAGEMENT RINGS</a>
                    </div>
                </div>
            </div>
            <div class="main-banner-col banner-ryt-col">
                <div class="main-banner-ryt-img">
                    <img src="{{ asset('assets/images/ring-img.png') }}" alt="ring img">
                </div>
            </div>
        </div>
    </div>
    <!-- home main-banner endt -->


    <!-- Shop from the Best start here -->

    <div class="shopfrom-best">
        <div class="container">
            <div class="head-para-three">
                <h2 class="heading-h-three">Shop from the Best</h2>
            </div>
            <div class="product-item-slider">
                <div class="owl-carousel owl-theme owlsliderone st-arrows">
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="#"><img src="assets/images/diamond-jewellery.png" alt="rings"></a>
                            </div>
                            <div class="product-item-details">
                                <div class="product-titles">
                                    Diamond Jewellery
                                </div>
                                <div class="product-description">
                                    Select your favourite diamond jewellery from a range of GIA certified diamonds for your
                                    most special moments.
                                </div>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small" href="{{ asset('product-category/diamond-jewellery') }}">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="#"><img src="assets/images/engagement-ring.png" alt="rings"></a>
                            </div>
                            <div class="product-item-details">
                                <div class="product-titles">
                                    Engagement Ring
                                </div>
                                <div class="product-description">
                                    Choose from an exotic range of diamond Rings or have your very own bespoke design made
                                    for your special day.
                                </div>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small" href="{{ asset('engagement-rings') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="#"><img src="assets/images/wedding-ring.png" alt="rings"></a>
                            </div>
                            <div class="product-item-details">
                                <div class="product-titles">
                                    Wedding Rings
                                </div>
                                <div class="product-description">
                                    Something everlasting and as special as the marriage itself. Shop bespoke wedding rings
                                    from our collection.
                                </div>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small" href="{{ asset('product-category/wedding-rings') }}">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product-info">
                            <div class="product-image">
                                <a href="#"><img src="assets/images/multi-stone.png" alt="rings"></a>
                            </div>
                            <div class="product-item-details">
                                <div class="product-titles">
                                    Multi Stone Rings
                                </div>
                                <div class="product-description">
                                    Why stick to classic solitaires when you can have a stunning multi-stone ring in a
                                    unique arrangement?
                                </div>
                                <div class="product-action-btn">
                                    <a class="btn-bg-small"
                                        href="{{ asset('product-category/engagement-rings/multi-stone') }}">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Shop from the Best end here -->


    <!-- whay choose marlows start here -->
    <div class="whychoose-marlows">
        <div class="container">
            <div class="whychoose-wraper">
                <div class="head-para-three">
                    <div class="heading-h-three">
                        Why Choose Marlow’s Diamonds?
                    </div>
                    <p>For over three generations, we’ve been helping countless happy couples express love and commitment
                        and we believe in quality and commitment as much as you do..</p>
                </div>
                <div class="rating-img">
                    <img src="assets/images/top2.png" alt="rating star">
                </div>
                <div class="whychoose-rows flex-flex-wrap flexed">
                    <div class="whychoose-col">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <img src="assets/images/warranty.png" alt="">
                            </div>
                            <div class="whychoose-col-text">
                                Lifetime Warranty
                            </div>
                        </div>
                    </div>
                    <div class="whychoose-col">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <img src="assets/images/diamond.png" alt="">
                            </div>
                            <div class="whychoose-col-text">
                                GIA Certified Diamonds
                            </div>
                        </div>
                    </div>
                    <div class="whychoose-col">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <img src="assets/images/favourite.png" alt="">
                            </div>
                            <div class="whychoose-col-text">
                                50 Years Experience
                            </div>
                        </div>
                    </div>
                    <div class="whychoose-col">
                        <div class="whychoose-col-inner">
                            <div class="whychoose-col-img">
                                <img src="assets/images/exchange.png" alt="">
                            </div>
                            <div class="whychoose-col-text">
                                FREE 30 Day Returns
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- whay choose marlows end here -->


    <!-- Marlow's start here -->
    <div class="marlows-diamond">
        <div class="container">
            <div class="marlows-diamond-title heading-h-two">
                Marlow's Diamonds: Inspiring a Generation of Love.
            </div>
        </div>

    </div>


    <!-- Marlow's End here -->


    <!-- Best Selling Marlow's Diamond Jewellery start here -->
    @include('front.includes.featuredproduct')
    <!-- Best Selling Marlow's Diamond Jewellery end here -->


    <!--Shop from Marlow’s GIA Certified Diamond Rings start -->
    <div class="shopfrom-block">
        <div class="container">
            <div class="head-para-three">
                <h3 class="heading-h-three">
                    Shop from Marlow’s GIA Certified Diamond Rings
                </h3>
                <p>Diamond rings are more than just jewellery. We understand the symbolism that they represent. So that they
                    can witstand the test of time our<br> diamond jewellery is certified by the GIA, so they provide quality
                    and longevity.</p>
                <div class="explore-btn">
                    <a class="btn-bg-small" href="/product-category/engagement-rings">EXPLORE ENGAGEMENT RINGS</a>
                </div>
            </div>
            <div class="rating-img">
                <img src="assets/images/top3.png" alt="rating star">
            </div>

            <div class="rating-review-block">
                <div class="owl-carousel owl-theme slider-review">
                    @include('front.pages.reviews')
                </div>
            </div>
        </div>
    </div>
    <!--Shop from Marlow’s GIA Certified Diamond Rings end -->
    {!! isset($data->description) ? $data->description : '' !!}
    <!-- Join our mailing list section start -->
    <div class="joinour-mailing">
        <div class="container">
            <div class="joinour-wraper">
                <div class="joinour-heading">
                    <div class="heading-h-two white-text">
                        Join our mailing list
                    </div>
                    <p>Join our world full of diamonds and we’ll sparkle your inbox by keeping you up-to-date.</p>
                </div>
                <div class="joinour-mailing-form">
                    <form id="contactForm">
                        @csrf
                        <div class="form-rows flexed flex-flex-wrap">
                            <input type="hidden" name="custom_url" id="custom_url" value="{{ url()->full() }}">
                            <div class="form-col width-50">
                                <label>Your Name<sup>*</sup></label>
                                <input required="required"
                                    class="input-control {{ $errors->has('title') ? 'error' : '' }}" type="text"
                                    name="title" placeholder="Your Name">
                                <!-- Error -->
                                @if ($errors->has('title'))
                                    <div class="error">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-col width-50">
                                <label>Email<sup>*</sup></label>
                                <input required="required"
                                    class="input-control {{ $errors->has('email') ? 'error' : '' }}" type="text"
                                    name="email" placeholder="Email Address">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-rows flexed flex-flex-wrap">
                            <div class="form-col">
                                <label>Message</label>
                                <textarea required="required" name="description"
                                    class="input-control {{ $errors->has('description') ? 'error' : '' }}" placeholder="Message"></textarea>
                            </div>
                        </div>
                        <div class="google-capatcha form-controls">
                            <div class="g-recaptcha" name="g-recaptcha-response"
                                data-sitekey="6LfQrxUgAAAAAFD1c2BmyaKHy1F20WUJEloRiyie">
                            </div>
                            @if ($errors->has('g-recaptcha-response'))
                                <div class="error">
                                    {{ $errors->first('g-recaptcha-response') }}
                                </div>
                            @endif
                        </div>
                        <div class="action-btn">
                            <button class="white-bg-btn" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Join our mailing list section End -->
    @include('front.includes.instagram-section')

    <!-- insta photos section end -->
    @php
        $getPopups = getPromotionalPOPup();
    @endphp
    @if(isset($getPopups) && !empty($getPopups))
        <!-- Modal -->
        <div class="modal fade" id="showPromotionPopup" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ isset($getPopups->title)?$getPopups->title:'' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12">
                            {!! isset($getPopups->description)?$getPopups->description:'' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('js')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Lc9hhUgAAAAAJzmHHLuY__2pxT9bHMlIPzgGbwN', {
            action: 'contact'
        }).then(function(token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
    });

    $(document).ready(function(){
        $('#showPromotionPopup').modal('show');
    });


    function blankForm() {
        $('input[name="title"]').val('');
        $('input[name="email"]').val('');
        $('textarea[name="description"]').val('');
        $("button[type='submit']").prop('disabled', false);
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
            description: {
                required: 'Description is required',
            }
        },
        submitHandler: function(form) {
            if (grecaptcha.getResponse()) {
                var form_data = new FormData(form);
                $(form).find("button[type='submit']").prop('disabled', true);
                $("button[type='submit']").text("Please Wait...");
                $.ajax({
                    url: "{{ route('maillist') }}",
                    method: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(response) {
                        blankForm();
                        $("button[type='submit']").text("Subscribe");
                        // $(this).find("button[type='submit']").prop('disabled',true);
                        // console.log(response);
                        // return false;
                        if (response.status == 200) {
                            toastr.success(response.success);
                            // window.location.reload();
                        } else {
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
