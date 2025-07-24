<div id="location_data_section" class="visit-our-showrooms">
	<div class="container mt-5">
		<div class="heading-h-three">
			Our Showrooms
          </div>

	  <ul class="nav nav-tabs visit-showrooms-tab" id="myTab" role="tablist">
	    <li class="nav-item" role="presentation">
	      <a class="nav-link active" id="birmingham-tab" data-toggle="tab" href="#birmingham" role="tab" aria-controls="birmingham" aria-selected="true">Birmingham</a>
	    </li>
	    <li class="nav-item" role="presentation">
	      <a class="nav-link" id="london-tab" data-toggle="tab" href="#london" role="tab" aria-controls="london" aria-selected="false">London</a>
	    </li>
	  </ul>
	  <div class="tab-content visit-showrooms-content" id="myTabContent">
	    <div class="tab-pane fade show active" id="birmingham" role="tabpanel" aria-labelledby="birmingham-tab">
	    	<div class="visit-showrooms-image">
	      <div class="row">
	        <div class="col-md-6">

	          <img src="/assets/images/visit-store-birmingham.webp" class="img-fluid" alt="Birmingham Store">

	        </div>
	        <div class="col-md-6">

	          <img src="/assets/images/visit-store-birmingham-store.webp" class="img-fluid" alt="Birmingham Store">

	        </div>
	      </div>
	    </div>
	      <div class="visit-showrooms-contact">
	      <div class="row">
 			 <div class="col-md-4">
 			 	<div class="visit-showrooms-detail">
 			 		<div class="visit-icon">
 			 	<img src="/assets/images/visit-coll.png" class="img-fluid" alt="">
 			 </div>
	          {{-- <h3>Call Us</h3> --}}
	          <p class="py-2"><a href="tel:01212364415">0121 236 4415</a></p>
	        </div>
	      </div>
	       <div class="col-md-4">
	       	<div class="visit-showrooms-detail">
	       		<div class="visit-icon">
	       	<img src="/assets/images/visit-location.png" class="img-fluid" alt="">
	       </div>
	          {{-- <h3>Find Us</h3> --}}
	          <p class="py-2">46 Warstone Ln, Hockley, Birmingham B18 6JJ</p>
			  <a target="_blank" class="location_view_desktop" href="https://maps.app.goo.gl/Xqo2hCwJrVK4FbfB6">Get Direction</a>
	        </div>
	      </div>
	        <div class="col-md-4">
	        	<div class="visit-showrooms-detail">
	        		<div class="visit-icon">
	        		<img src="/assets/images/visit-mail.png" class="img-fluid" alt="">
	        	</div>
	          {{-- <h3>Email Us</h3> --}}
	          <p class="py-2"> <a href="mailto:hello@marlows-diamonds.co.uk" class="visit-get-direction">hello@marlows-diamonds.co.uk</a></p>
	        </div>
	      </div>
	    </div>
	      </div>
	    </div>
	    <div class="tab-pane fade" id="london" role="tabpanel" aria-labelledby="london-tab">
	    	<div class="visit-showrooms-image">
	      <div class="row mt-4">
	        <div class="col-md-6">

	          <img src="/assets/images/visit-store-img.webp" class="img-fluid" alt="Birmingham Store Image">

	        </div>
	        <div class="col-md-6">

	          <img src="/assets/images/visit-store-img-inner.webp" class="img-fluid" alt="Birmingham Store Image">

	        </div>
	      </div>
	    </div>
	      <div class="visit-showrooms-contact">
	      <div class="row">
 			 <div class="col-md-4">
 			 	<div class="visit-showrooms-detail">
 			 		<div class="visit-icon">
 			 	<img src="/assets/images/visit-coll.png" class="img-fluid" alt="">
 			 </div>
	          {{-- <h3>Call Us</h3> --}}
	          <p class="py-2"><a href="tel:020 7405 1477">020 7405 1477</a></p>
	        </div>
	      </div>
	       <div class="col-md-4">
	       	<div class="visit-showrooms-detail">
	       		<div class="visit-icon">
	       	<img src="/assets/images/visit-location.png" class="img-fluid" alt="">
	       </div>
	          {{-- <h3>Find Us</h3> --}}
	          <p class="py-2">20 Beauchamp Pl, Knightsbridge, London SW3 1NQ</p>
			  <a target="_blank" class="location_view_desktop" href="https://maps.app.goo.gl/1XkDadPTxSN46Wdc6">Get Direction</a>
	        </div>
	      </div>
	        <div class="col-md-4">
	        	<div class="visit-showrooms-detail">
	        		<div class="visit-icon">
	        		<img src="/assets/images/visit-mail.png" class="img-fluid" alt="">
	        	</div>
	          {{-- <h3>Email Us</h3> --}}
	          <p class="py-2"><a href="mailto:london@marlows -diamonds.co.uk" class="visit-get-direction">london@marlows -diamonds.co.uk</a></p>
	        </div>
	      </div>
	      </div>
	    </div>
	    </div>
<div class="explore-btn">
                    <a class="btn-bg-small" href="{{ route('contact') }}">BOOK APPOINTMENT</a>
                </div>


	  </div>
	</div>
</div>

<script>
  $(document).ready(function() {
    // Handle tab clicks
    $('#myTab a').on('click', function (e) {
      e.preventDefault();
      $(this).tab('show');
    });
  });
</script>