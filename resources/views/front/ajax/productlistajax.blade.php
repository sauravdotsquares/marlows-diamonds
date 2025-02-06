
@section('css')
    <link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .leftright-imt-col.leftright-text.postcontent100 {
            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    </style>
@endsection
@foreach($sortedArray as $index => $product)
@inject('footer_settings', 'App\Models\Settings')
<?php
$getCategory = explode(",", $product->categories);




// $product = getEngagmentRingsLabPriceAdded($product);

$thumbnailGif = getThumbnailGif($product->id); ?>

@if ($index === 3 || $index === 11)
<!-- Add the image or modal content as a separate grid item -->
<div class="product-grid-items-item">
	@if ($index === 3)
	<a href = "https://marlows-diamonds.co.uk/live-diamond-search">
		<img src="/assets/images/banner_image.png" alt="Banner">
	</a>
	@else
	  
		<div class="modal-body">
		  <div class="col-lg-12">
			  <!-- Success message -->
			  @if(Session::has('success'))
				  <div class="alert alert-success">
					  {{Session::get('success')}}
				  </div>
			  @endif
				  <div class="visit-form">
					<h5 class="modal-title" id="exampleModalLabel">REQUEST AN APPOINTMENT</h5>
					  <form id="contactForm">
					  @csrf
						  <input type="hidden" name="custom_url" id="custom_url" value="{{url()->full()}}">
						  <div class="form-controls">
							  <input type="text" name="title" id="title" class="{{ $errors->has('title') ? 'error' : '' }}" placeholder="Your Name">
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
							  <textarea name="description" id="description" class="{{ $errors->has('description') ? 'error' : '' }}"  placeholder="Your Message"></textarea>
							  @if ($errors->has('description'))
							  <div class="error">
								  {{ $errors->first('description') }}
							  </div>
							  @endif
						  </div>
						  <div class="action-submit">
							  <button type="submit" name="send" value="Submit">Send Message</button>
						  </div>
					  </form>
  
				  </div>
		  </div>
		</div>

	@endif
</div>
@endif


<div class="product-grid-items-item {{ $thumbnailGif ? 'product-hover-affect' : '' }}">

	<div class="product-items-item-info">
		<div class="product-item-top">
			<div class="product-onsale">
				<!-- On Sale -->
			</div>
			@php
			$wishlist = session()->get('wishlist', []);
			$wishListClass = "fa-heart-o";
			if(array_key_exists($product->id,$wishlist)){
			$wishListClass = "fa-heart";
			}
			@endphp
    <a href="javascript:void(0);" class="share-file" type="button"  data-bs-toggle="modal" data-bs-target="#share2"><img
	src="/assets/images/share.png" alt="share"></a>
			<a href="javascript:void(0);" class="wishlist-heart" id="productWishListRelated{{$product->id}}" data-productslug="{{$product->slug}}"><i class="fa {{$wishListClass}} wishcount" aria-hidden="true"></i></a>
		</div>

		<?php
		$getMonthTextArray = getMonthwiseDiscountText();
		$getCurrentMonth = (int)date('m');
		$now = new DateTime("now");
		$lastDate = new DateTime('now');
		$lastDate->modify('last day of this month');
		$dist_future = $lastDate->format('m/d/Y');
		?>

		<div class="product-items-item-image">
			<div class="list-discount-btn">
				<div class="disbtn-box">{!! strtoupper($getMonthTextArray[$getCurrentMonth]) !!}</div>
				{{-- <div class="disbtn-box extradis">Extra 10% Off</div>
				<div class="disbtn-box freebtn">Free Gift</div> --}}
			</div>

			<a href="{{asset('product/'.$product->slug)}}" id="variationImageShown{{$product->id}}" class="{{ $thumbnailGif ? 'product-hov' : '' }}">
				@if(isset($product->getProductImages) && !empty($product->getProductImages['image_url']))
				{{-- <img src="{{ getImageOptimizeDetails('/storage/'.$product->getProductImages['image_url'],'217','217')}}" alt="{{$product->title}}" loading="lazy">--}}
				<img src="{{ env('APP_IMAGE_URL').'/storage/'.$product->getProductImages['image_url'] }}" alt="{{$product->title}}" loading="lazy">
				@endif
			</a>
		</div>





		{{-- <div class="color-buttons">

			@if (stripos($product->title, 'engagement ring') === false)


			<a class="color-default" id="fetchdefaultimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="Default">Default</a>
			
			<a class="color-btn silver" id="fetchvariationSilverimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="Silver">Silver</a>




			<a class="color-btn rose-gold" id="fetchvariationRoseimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="18ct Rose Gold">Rose Gold</a>
			<a class="color-btn yellow-gold" id="fetchvariationYellowimages{{ $product->id }}" data-slug="{{ $product->slug }}" data-color="18ct Yellow Gold">Yellow Gold</a>
			@endif
		</div> --}}




		<div class="product-items-item-details">
			<div class="product-items-item-name">
				<div class="list_product_title">
					<?php
					$titleSplits = [];
					if (isset($product->title) && !empty($product->title)) {
						$titleSplits = explode('|', $product->title);
					}
					?>
					@if(isset($product->slug) && !empty($product->slug))
					<a href="{{asset('product/'.$product->slug)}}" class="title-list-heading">{{isset($titleSplits[0])?$titleSplits[0]:''}}</a>
					@if(isset($titleSplits[1]) && !empty($titleSplits[1]))
					<a href="{{asset('product/'.$product->slug)}}">{{$titleSplits[1]}}</a>
					@endif
					@else
					<a href="#">{{isset($titleSplits[0])?$titleSplits[0]:''}}</a>
					<a href="#">{{isset($titleSplits[1])?$titleSplits[1]:''}}</a>
					@endif
				</div>
				
				<?php
				if (!in_array(50, $getCategory) && !in_array(53, $getCategory) && !in_array(54, $getCategory)) { ?>
					<?php
					if (isset($product->lab_grown) && $product->lab_grown != 0.0) { ?>
						<div class="price-section">
							<div style="display: flex;">
								@if(isset($product->discounted_lab_grown) && !empty($product->discounted_lab_grown))

									@if($product->discounted_lab_grown !== $product->lab_grown)
										<h4>
											<del style="color:#000" class="shopPriceval" id="shopPrice"> {{MY_CURRENCY_SYMBOL}} {{round(($product->lab_grown),2)}}</del>
										</h4>
									@endif
									<div class="product-finder-price" id="finaldiamondprice"><span class="price">{{MY_CURRENCY_SYMBOL}} {{ sprintf('%0.2f', $product->discounted_lab_grown) }} </span></div>
								@else
									<div class="product-finder-price" id="finaldiamondprice"><span class="price">{{MY_CURRENCY_SYMBOL}} {{sprintf('%0.2f', $product->lab_grown) }} </span></div>
								@endif
							</div>
								<p class="save_price"><span style="color:green">You Save : <span id="savePrice">{{MY_CURRENCY_SYMBOL}} {{sprintf('%0.2f', $product->lab_grown_rrp - $product->discounted_lab_grown)}}</span></span> | <del id="rrpPrice">RRP: {{MY_CURRENCY_SYMBOL}} {{sprintf('%0.2f', $product->lab_grown_rrp) }}</del> </p>
						</div>
					<?php } ?>
				<?php } else if (in_array(54, $getCategory)) { ?>
					<div class="price-section">
						<div style="display: flex;">
							<div class="product-finder-price" id="finaldiamondprice"><span class="price">{{MY_CURRENCY_SYMBOL}} {{sprintf('%0.2f', $product->mined_diamond)}} </span></div>
						</div>
					</div>
				<?php } elseif (in_array(53, $getCategory) || in_array(50, $getCategory)) { ?>
					<div class="price-section">
						<div style="display: flex;">
							<div class="product-finder-price" id="finaldiamondprice"><span class="price">{{MY_CURRENCY_SYMBOL}} {{sprintf('%0.2f', $product->mined_diamond)}} </span></div>
						</div>
						<p class="save_price"><span style="color:green">You Save : <span id="savePrice">{{MY_CURRENCY_SYMBOL}} {{$product->mined_diamond_rrp - $product->mined_diamond}}</span></span> | <del id="rrpPrice">RRP: {{MY_CURRENCY_SYMBOL}} {{$product->mined_diamond_rrp}}</del> </p>
					</div>
				<?php } ?>
				
			</div>
		</div>
	</div>
</div>
{{-- @endif --}}

{{-- model code --}}

<div class="modal fade sharesocial" id="share2" tabindex="-1" aria-labelledby="share2Label" aria-hidden="true">
    <div class="modal-dialog" >
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-body">
            <h3 class="modal-title" id="share2lLabel">Share</h3>
            <div id="copy-link">
                <p id="copy-text">{{ URL::current() }}</p>
                <button class="copy-btn" onclick="copyToClipboard()">Copy</button>
            </div>
        </div>


		<?php
					
		// echo "kartik<pre>";
			//  dd(Share::page(asset('product/'.$product->slug))->facebook()->getRawLinks()) ;
            //  dd(Share::page(asset('product/'.$product->slug))->twitter()->getRawLinks()) ;
			// die;

		?>

        <div class="sharesocialicon">
            <ul>
				<li><a href="{{ is_array(Share::page(asset('product/'.$product->slug))->facebook()->getRawLinks()) ? Share::page(asset('product/'.$product->slug))->facebook()->getRawLinks()['facebook'] : Share::page(asset('product/'.$product->slug))->facebook()->getRawLinks() }}" target="_blank">
					<i class="fa fa-facebook" aria-hidden="true"></i>
				</a></li>
				
				<li><a href="{{ is_array(Share::page(asset('product/'.$product->slug))->twitter()->getRawLinks()) ? Share::page(asset('product/'.$product->slug))->twitter()->getRawLinks()['twitter'] : Share::page(asset('product/'.$product->slug))->twitter()->getRawLinks() }}" target="_blank">
					<i class="fa fa-twitter" aria-hidden="true"></i>
				</a></li>
				
				



                {{-- <li><a href="{{$footer_settings->get_options('twitter')}}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li> --}}

                <li><a href="{{ Share::page(asset('product/'.$product->slug))->pinterest()->getRawLinks()['pinterest'] }}" target="_blank" class="btn btn-linkedin">
                    <i class="fa fa-pinterest"></i>
                </a></li>

                {{-- <li><a href="{{$footer_settings->get_options('youtube')}}" target="_blank"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li> --}}

                <li><a href="{{ Share::page(asset('product/'.$product->slug))->whatsapp()->getRawLinks()['whatsapp'] }}" target="_blank" class="btn btn-whatsapp">
                    <i class="fa fa-whatsapp"></i>
                </a></li>
				
            </ul>
        </div>
    </div>
    </div>
  </div>


@endforeach
{!! $getProductListFinal->links() !!}
{{--
@if($getAjaxResponses)
	$getProductListFinal->links() 
@endif
--}}


{{-- JS Script for discount start here --}}
<script>
    $(document).ready(function(){
    // Attach click event to body
    $('body').click(function(){
        // Clear search input value
        var removedDiv = $('.search-suggestion-list.ng-scope').remove();
        if(removedDiv){
            $('.search-suggestion.hide_1').css('border','none');
        }else{
            $('.search-suggestion.hide_1').css('border','1px solid #D0D0D0');
        }
    });

	

    // Prevent search input click event propagation
    $('.head-mini-search').click(function(event){
        event.stopPropagation();
    });
});
// $(".search-selection-text").focusin(function(){
//     $('.search-suggestion').css('display','block');
// });
// $(".search-selection-text").focusout(function(){
//     $('.search-suggestion').css('display','none');
// });

// let discountDate = "05/31/2024 23:59:32"; //{{$dist_future}}";
let discountText = "{{$getMonthTextArray[$getCurrentMonth]}}";
let discountDate = "{{$dist_future}}"+" "+"23:59:32";
var countDownDate = new Date(discountDate).getTime();
var myfunc = setInterval(function() {

var now = new Date().getTime();      
var timeleft = countDownDate - now;

// Calculating the days, hours, minutes and seconds left
var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);

// Result is output to the specific element
const daysToShow = days + "d "
const hoursToShow = hours + "h "
const minutesToShow = minutes + "m "
const secondsToShow = seconds + "s "

const timerToShow = daysToShow+' '+ hoursToShow+' '+ minutesToShow+' '+ secondsToShow;
$(".discount_timer").css('display','inline-block');
$(".discount_timer").text(timerToShow);
// $("#offer-text").text('Wedding Rings Sale - Up to 35% off');
$("#offer-text").text(discountText);
// console.log('first', hoursToShow);
// console.log('first', minutesToShow);
// console.log('first', secondsToShow);
// Display the message when countdown is over
if (timeleft < 0) {
    clearInterval(myfunc);
    $(".discount_timer").text('');
    $(".discount_timer").css('display','none');
    $(".offer-text").text('');
}
}, 1000);

document.addEventListener('DOMContentLoaded', function () {
const postBar = document.querySelector('.post-bar-wraper');
const popup = document.getElementById('exit-popup');
const closePopupBtn = document.getElementById('close-popup');

if (postBar) {
postBar.addEventListener('mouseover', function () {
    popup.style.display = 'block';
});
}

closePopupBtn.addEventListener('click', function () {
popup.style.display = 'none';
});
});
</script>


{{-- copy element starts from here --}}
<script>
    function copyToClipboard() {
        // Get the text to copy
        const copyText = document.getElementById('copy-text').innerText;

        // Use the Clipboard API to copy the text
        navigator.clipboard.writeText(copyText).then(function() {
            // Success callback
            alert('Link copied!');
        }).catch(function(err) {
            // Error callback
            console.error('Could not copy text: ', err);
            alert('Failed to copy text. Please try again.');
        });
    }
</script>
{{-- copy element ends here --}}

<script>
 
 $(".color-btn").each(function () {
        var $this = $(this);
        var metalType = $this.data("color");
        var slug = $this.data("slug");

        // Check if the color variation exists for this product
        $.ajax({
            type: 'POST',
            url: '{{route("get-variations-image-data")}}',
            dataType: 'JSON',
            data: {
                '_token': "{{csrf_token()}}",
                'slug': slug,
                'metal_type': metalType,
            },
            success: function (res) {
                // Remove the button if the variation doesn't exist
                if (!res || !res.vari_image) {
                    $this.remove();
                }
            },
            error: function () {
                console.error('Error fetching variation data for:', metalType);
            }
        });
    });


</script>