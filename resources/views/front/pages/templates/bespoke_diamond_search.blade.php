@extends('layouts.front.app')
@section('content')
@section('css')
<link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet" type="text/css">
@endsection
<div class="perfect-certified-wrap" ng-controller="DiamondSearchController"  ng-init="getDiamondResults()">
	<div class="container">
		<div class="perfect-certified-head">
			<h1>{!!$data->subtitle!!}</h1>
			<h2>{!!$data->short_description!!}</h2>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="chooseyour-diamond-side">
					<div class="diamond-heaing-two">		
						Choose your Diamond
					</div>
					<form class="cart my-cart-form" name="search" action="" method="post" encytype="mulipart/form-data">
					<div class="choose-diamnond-filter">
						<div class="diamond-shapes row align-items-center">
							<div class="diamond-field-labels col-lg-3">
								Shape
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="shape-list">

									<ul>
										<li class="active-diamond">

											<button type="button" class="btn active-diamond  shape_btn">
												<img src="assets/images/round-1.png" alt="">
												<span>Round</span>
												<input checked="checked" value="Round" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/pear-1.png" alt="pearl">
												<span>Pear</span>
												<input value="PEAR" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/marquee-1.png" alt="marquise">
												<span>Marquise </span>
												<input value="MARQUISE" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/heart-1.png" alt="heart">
												<span>Heart</span>
												<input value="HEART" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/asscher.png" alt="Asscher">
												<span>Asscher</span>
												<input value="ASSCHER" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/priceless-1.png" alt="priceless">
												<span>Princess</span>
												<input value="PRINCESS" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/radiant.png" alt="radiant">
												<span>Radiant</span>
												<input value="RADIANT" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/emerald-1.png" alt="Emerald">
												<span>Emerald</span>
												<input value="EMERALD" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/oval-1.png" alt="Oval">
												<span>Oval</span>
												<input value="OVAL" class="" type="radio" name="shape">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/cushion.png" alt="cushion">
												<span>Cushion</span>
												<input value="CUSHION" class="" type="radio" name="shape">
											</button>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								Carat
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<!-- <div class="diamond-fil-cols">
										<div class="diamond-filter-in">
											<input type="range" id="carat" name="carat" min="0.30" max="5">
										</div>
									</div> -->
									<div class="range_carat_wap"  style="width: 83%;">
										<div id="range-slider"></div>
										<input type="hidden" id="input-carat-min" name="carat">
										<input type="hidden" id="input-carat-max" name="carat-max">
									 </div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								Colour
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li class="selected-this">
													<a href="#">D</a>
												</li>
												<li>
													<a href="#">E</a>
												</li>
												<li>
													<a href="#">F</a>
												</li>
												<li>
													<a href="#">G</a>
												</li>
												<li>
													<a href="#">H</a>
												</li>
												<li>
													<a href="#">I</a>
												</li>
												<li>
													<a href="#">J</a>
												</li>
												<li>
													<a href="#">K</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								Clarity
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<a href="#">IF</a>
												</li>
												<li>
													<a href="#">VVS1</a>
												</li>
												<li>
													<a href="#">VVS2</a>
												</li>
												<li>
													<a href="#">VS1</a>
												</li>
												<li>
													<a href="#">VS2</a>
												</li>
												<li>
													<a href="#">SI1</a>
												</li>
												<li>
													<a href="#">SI2</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								 Cut Grade 
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<a href="#">Excellent</a>
												</li>
												<li>
													<a href="#">Very Good</a>
												</li>
												<li>
													<a href="#">Good</a>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								 Polish 
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<a href="#">Excellent</a>
												</li>
												<li>
													<a href="#">Very Good</a>
												</li>
												<li>
													<a href="#">Good</a>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								 Symmetry  
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<a href="#">Excellent</a>
												</li>
												<li>
													<a href="#">Very Good</a>
												</li>
												<li>
													<a href="#">Good</a>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								 Fluorescence   
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<a href="#">None</a>
												</li>
												<li>
													<a href="#">Faint</a>
												</li>
												<li>
													<a href="#">Medium</a>
												</li>
												<li>
													<a href="#">Strong</a>
												</li>
												<li>
													<a href="#">Very Strong</a>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row">
							<div class="diamond-field-labels col-lg-3">
								 Certificate   
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<a href="#">GIA</a>
												</li>
												<li>
													<a href="#">IGI</a>
												</li>
											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												THIS IS THE WEIGHT OF THE CENTRAL MAIN STONE OF YOUR ENGAGEMENT RING.ONE CARTA IS EQUAL TO 1/5 OF A GRAM MAKING DIAMONDS THE MOST EXPENSIVE MINERAL FOUND ON EARTH
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="chooseshop-btn text-center">
							<a class="btn-bg-small" href="#">Search</a>
						</div>
					</div>

					</form>
				</div>
			</div>
			<div class="col-lg-8">
				<div class="live-diamond-search">
					<div class="diamond-heaing-two">		
						{!!$data->description!!}
					</div>	
					<div class="diamond-search-tb-wrap">
						<div class="diamond-search-table">
							<table cellpadding="0" cellpadding="0" border="0">
								<thead>
									<tr>
										<th>Shape</th>
										<th>Carat</th>
										<th>Colour</th>
										<th>Clarity</th>
										<th>Cut</th>
										<th>Cert</th>
										<th>Diamond Price inc VAT</th>
										<th>Certificate</th>
										<th>Image</th>
										<th>Select</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>ROUND</td>
										<td>0.30</td>
										<td>K</td>
										<td>SI1</td>
										<td>GD</td>
										<td>GIA</td>
										<td>£278.11</td>
										<td> <a class="table-view-btn" href="#">View</a> </td>
										<td></td>
										<td><input type="radio"></td>
									</tr>
									<tr>
										<td>ROUND</td>
										<td>0.30</td>
										<td>K</td>
										<td>SI1</td>
										<td>GD</td>
										<td>GIA</td>
										<td>£278.11</td>
										<td> <a class="table-view-btn" href="#">View</a> </td>
										<td></td>
										<td><input type="radio"></td>
									</tr>
									<tr>
										<td>ROUND</td>
										<td>0.30</td>
										<td>K</td>
										<td>SI1</td>
										<td>GD</td>
										<td>GIA</td>
										<td>£278.11</td>
										<td> <a class="table-view-btn" href="#">View</a> </td>
										<td><a class="table-view-diamond" href="#">View Diamond</a></td>
										<td><input type="radio"></td>
									</tr>
									<tr>
										<td>ROUND</td>
										<td>0.30</td>
										<td>K</td>
										<td>SI1</td>
										<td>GD</td>
										<td>GIA</td>
										<td>£278.11</td>
										<td> <a class="table-view-btn" href="#">View</a> </td>
										<td></td>
										<td><input type="radio"></td>
									</tr>
									<tr>
										<td>ROUND</td>
										<td>0.30</td>
										<td>K</td>
										<td>SI1</td>
										<td>GD</td>
										<td>GIA</td>
										<td>£278.11</td>
										<td> <a class="table-view-btn" href="#">View</a> </td>
										<td><a class="table-view-diamond" href="#">View Diamond</a></td>
										<td><input type="radio"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div data-pagination=""
				             data-num-pages="totalPages" 
				             data-current-page="currentPage"
				             data-max-size="maxSize" 
				             data-boundary-links="true" ng-click="pageChanged()">
				      </div>
					</div>
					<div class="table-bottom-content">
						<div class="diamond-total-subtotal">
							<p> <strong>Diamond Price:</strong> £ 278.11</p>
							<div class="total-diamond-price">£ 278.00 </div>
						</div>
						<div class="addbasket-req-btns">
							<a class="white-bg-btn" href="#">Add To Basket</a>
							<a class="btn-bg-small" href="#">Request an Appointment</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('js')
<script src="{{ asset('assets/js/nouislider.js?').env('VERSION') }}"></script>

<script type="text/javascript">
    jQuery(document).ready(function($){
		var stepsSlider = document.getElementById('range-slider');
		var input0 = document.getElementById('input-carat-min');
		var input1 = document.getElementById('input-carat-max');
		var inputs = [input0, input1];

		noUiSlider.create(stepsSlider, {
		    start: [0.3, 2.5],
		    connect: true,
		    tooltips: [true, wNumb({decimals: 0})],
		    range: {
		        'min': [0.3],
		        'max': [5]
		    },
		});

		stepsSlider.noUiSlider.on('update', function (values, handle) {
		    inputs[handle].value = values[handle];
			//jQuery(".search-button button").trigger('click');
		});

  });
</script>
@endsection

@endsection