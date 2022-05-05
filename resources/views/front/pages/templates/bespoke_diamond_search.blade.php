@extends('layouts.front.app')
@section('content')
@section('css')
<link href="{{ asset('assets/css/nouislider.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/loading-placeholder.css') }}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
<div class="perfect-certified-wrap" id="diamondMainController" ng-controller="DiamondSearchController"  ng-init="getDiamondResults()"  ng-cloak>
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
												<input checked="checked" value="ROUND" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/pear-1.png" alt="pearl">
												<span>Pear</span>
												<input value="PEAR" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/marquee-1.png" alt="marquise">
												<span>Marquise </span>
												<input value="MARQUISE" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/heart-1.png" alt="heart">
												<span>Heart</span>
												<input value="HEART" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/asscher.png" alt="Asscher">
												<span>Asscher</span>
												<input value="ASSCHER" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/priceless-1.png" alt="priceless">
												<span>Princess</span>
												<input value="PRINCESS" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/radiant.png" alt="radiant">
												<span>Radiant</span>
												<input value="RADIANT" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/emerald-1.png" alt="Emerald">
												<span>Emerald</span>
												<input value="EMERALD" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/oval-1.png" alt="Oval">
												<span>Oval</span>
												<input value="OVAL" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
										<li>
											<button type="button" class="btn  shape_btn">
												<img src="assets/images/cushion.png" alt="cushion">
												<span>Cushion</span>
												<input value="CUSHION" class="" type="radio" name="shape" ng-model="shape"  ng-change="getDiamondResults()">
											</button>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row diamond-carat">
							<div class="diamond-field-labels col-lg-3">
								Carat
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="range_carat_wap">
										<div id="range-slider"></div>
										<input type="hidden" id="input-carat-min" name="carat">
										<input type="hidden" id="input-carat-max" name="carat-max">
									 </div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{CARAT_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row diamond-colour">
							<div class="diamond-field-labels col-lg-3">
								Colour
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												@foreach (range('D', 'K') as $alphabet)
												<li class="selected-this">
													<button type="button" class="btn">
									                    {{$alphabet}}
									                    <input value="{{$alphabet}}" class="diamond-colour" name="colour[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												@endforeach

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{COLOUR_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="choose-diaond-fields row diamond-clarity">
							<div class="diamond-field-labels col-lg-3">
								Clarity
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<button type="button" class="btn">
									                    IF
									                    <input value="IF" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>

													<button type="button" class="btn">
									                    VVS1
									                    <input value="VVS1" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>

													<button type="button" class="btn">
									                    VVS2
									                    <input value="VVS2" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>

													<button type="button" class="btn">
									                    VS1
									                    <input value="VS1" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>

													<button type="button" class="btn">
									                    VS2
									                    <input value="VS2" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>

													<button type="button" class="btn">
									                    SI1
									                    <input value="SI1" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>

													<button type="button" class="btn">
									                    SI2
									                    <input value="SI2" class="diamond-clarity" name="clarity[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{CLARITY_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="choose-diaond-fields row diamond-cut-grade">
							<div class="diamond-field-labels col-lg-3">
								 Cut Grade
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<button type="button" class="btn">
									                    Excellent
									                    <input value="EX" class="diamond-grade" name="grade[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Very Good
									                    <input value="VG" class="diamond-grade" name="grade[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Good
									                    <input value="GD" class="diamond-grade" name="grade[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{CUT_GRADE_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row diamond-polish">
							<div class="diamond-field-labels col-lg-3">
								 Polish
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<button type="button" class="btn">
									                    Excellent
									                    <input value="EX" class="diamond-polish" name="polish[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Very Good
									                    <input value="VG" class="diamond-polish" name="polish[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Good
									                    <input value="GD" class="diamond-polish" name="polish[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{POLISH_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="choose-diaond-fields row diamond-symmetry">
							<div class="diamond-field-labels col-lg-3">
								 Symmetry
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<button type="button" class="btn">
									                    Excellent
									                    <input value="EX" class="diamond-symmetry" name="symmetry[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Very Good
									                    <input value="VG" class="diamond-symmetry" name="symmetry[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Good
									                    <input value="GD" class="diamond-symmetry" name="symmetry[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{SYMMETRY_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


						<div class="choose-diaond-fields row diamond-fluorescence">
							<div class="diamond-field-labels col-lg-3">
								 Fluorescence
							</div>
							<div class="diamond-field-contens col-lg-9">
								<div class="diamond-field-inner-bar">
									<div class="diamond-fil-cols">
										<div class="diamond-values-in">
											<ul>
												<li>
													<button type="button" class="btn">
									                    None
									                    <input value="N" class="diamond-fluorescence" name="fluorescence[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Faint
									                    <input value="F" class="diamond-fluorescence" name="fluorescence[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Medium
									                    <input value="M" class="diamond-fluorescence" name="fluorescence[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    Strong
									                    <input value="ST" class="diamond-fluorescence" name="fluorescence[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    V Strong
									                    <input value="VS" class="diamond-fluorescence" name="fluorescence[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>

											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{FLUORESCENCE_TOOLTIP}}
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
													<button type="button" class="btn">
									                    GIA
									                    <input value="GIA" class="diamond-certificate" name="certificate[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
												<li>
													<button type="button" class="btn">
									                    IGI
									                    <input value="IGI" class="diamond-certificate" name="certificate[]" type="checkbox" ng-click="getDiamondResults()">
									                </button>
												</li>
											</ul>
										</div>
									</div>
									<div class="diamond-filter-quote">
										<div class="quote-icon-pop">
											<a class="ma-info-icon" href="javascript:void(0)"><img src="assets/images/marlows-info-icon.png" alt="marlows-info-icon"></a>
											<div class="m-quote-pop">
												{{CERTIFICATE_TOOLTIP}}
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- <div class="chooseshop-btn text-center">
							<a class="btn-bg-small" href="#">Search</a>
						</div> -->
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
										<th ng-if="shape=='ROUND'">Cut</th>
										<th>Cert</th>
										<th>Diamond Price inc VAT</th>
										<th>Certificate</th>
										<th>Image</th>
										<th>Select</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-if="data.length>0 && loader==false" ng-repeat="records in data" class="<%$index%>" id="selectedDiamondRow<%$index%>">
										<td id="tdShape<%$index%>"><%records.Shape%></td>
										<td id="tdCarat<%$index%>"><%records.Carat%></td>
										<td id="tdColor<%$index%>"><%records.Color%></td>
										<td id="tdClarity<%$index%>"><%records.Clarity%></td>
										<td id="tdCut<%$index%>" ng-if="shape=='ROUND'"><%records.Cut%></td>
										<td id="tdLab<%$index%>"><%records.Lab%></td>
										<td id="tdAmount<%$index%>"><%records.Amount*VAT | number : 2 %></td>

										<td id="tdCertiLink<%$index%>"> <a target="_block" class="table-view-btn" href="<%records.CertificateLink%>">View</a> </td>

										<td id="tdImgLink<%$index%>"><img ng-if="records.ImageLink" src="<%records.ImageLink%>" class="diamond_image" alt="<%records.Shape%>"></td>

										<td><input id="selectedDiamondCheckBox<%$index%>" data-certno="<%records.CERT_NO%>" data-stockno="<%records.Stock_NO%>" type="radio" name="selectedDiamond" value="<%records.Amount%>" ng-checked="$index==0" ng-click="updateDiamondPrice(records.Amount)" ng-model="selectedDiamond"></td>
									</tr>

									<tr ng-if="data.length==0">
										<td colspan="10">No Record Found.</td>
									</tr>

								</tbody>
							</table>
						<div class="timeline-wrapper" ng-if="loader">
						    <div class="timeline-item">
						    	@for($i=1;$i<=5;$i++)
						        <div class="animated-background">
						            <div class="background-masker content-first-end"></div>
						        </div>
						        @endfor
						    </div>
						</div>
						<div data-pagination=""
				             data-num-pages="totalPages"
				             data-current-page="currentPage"
				             data-max-size="maxSize"
				             data-boundary-links="true" ng-click="pageChanged()">
				      </div>
					</div>
                    <input type="hidden" id="addtobasketselectedrowid" value="0">
                    <input type="hidden" id="addCertificateNo" value="0">
                    <input type="hidden" id="addStockNumber" value="0">
					<div class="table-bottom-content">
						<div class="diamond-total-subtotal">
							<p ng-if="firstDiamondAmount"> <strong>Diamond Price:</strong> £ <%firstDiamondAmount*VAT | number : 2 %></p>
							<div class="total-diamond-price" ng-if="firstDiamondAmount">£ <%firstDiamondAmount*VAT | number : 0 %> </div>
						</div>
						<div class="addbasket-req-btns">
							{{-- <a class="white-bg-btn" href="#">Add To Basket</a> --}}
                            <a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to basket</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
		stepsSlider.noUiSlider.on('change', function (values, handle) {
		    angular.element(document.getElementById('diamondMainController')).scope().getDiamondResults();
		});

        $(document).on('change', "[id^=selectedDiamondCheckBox]", function () {
            var index = parseInt($(this).attr("id").replace("selectedDiamondCheckBox",''));
            $('#addtobasketselectedrowid').val(index);
        });

        $('#addtobasket').on('click',function(){
            // alert($('#addtobasketselectedrowid').val());
            addtobasketFunction($('#addtobasketselectedrowid').val());
        });
    });

    function getNumberFromCurrency(currency) {
        return Number(currency.replace(/[$,]/g,''))
    }

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function isNullAndUndef(variable) {
        return (variable !== null && variable !== undefined);
    }

    function addtobasketFunction(index){
        var cert_number = $('#tdCertiLink'+index).find('a').attr('href');
        console.log(cert_number);
        // var filename = cert_number.replace( /^.*?([^\/]+)\..+?$/, '$1' );
        // var fileName_new = cert_number.replace(/[\#\?].*$/,'');
        // var src= $('#tdCertiLink'+index).find('a').attr('href');

        // var name = src.match(/static\/images\/banner\/(.*)\.jpg/);

        var reportno = getParameterByName('reportno',cert_number);
        var certNumber;
        if(reportno !== null && reportno !== undefined){
            // console.log("Not Null");
            certNumber = reportno;

        }else{
            var reportno = getParameterByName('r',cert_number);
            if(reportno !== null && reportno !== undefined){
                // console.log("Not Null");
                certNumber = reportno;
            }else{
                // console.log("Null");
                var tarr = cert_number.replace(/^.*\/\/[^\/]+/, '').split('/');
                certNumber = tarr[2].replace(/\.[^/.]+$/, "");
            }
        }


        var certificatenumber = $('#selectedDiamondCheckBox'+index).data('certno');
        var stockno = $('#selectedDiamondCheckBox'+index).data('stockno');

        // console.log(certificatenumber);
        // console.log(stockno);

        if(certificatenumber != '' && certificatenumber !== null && certificatenumber !== undefined){
            // console.log("certificatenumber");
            certNumber = certificatenumber;
        }else if(stockno != '' && stockno !== null && stockno !== undefined){
            // console.log("stockno");
            certNumber = stockno;
        }else{
            // console.log("else");
            certNumber = 0;
        }



        console.log(certNumber);
        // return false;

        // console.log(cert_number.replace(/^.*\/\/[^\/]+/, ''));



        // console.log(fileName_new);
        // console.log(name);
        // console.log(cert_number);
        // console.log(filename);
        // return false;

        $.ajax({
            type: 'POST',
            url: '{{route("add.to.cart.diamond")}}',
            data: {
                '_token': "{{csrf_token()}}",
                'carat' : $('#tdCarat'+index).text(),
                'color' : $('#tdColor'+index).text(),
                'clarity' : $('#tdClarity'+index).text(),
                'grade' : $('#tdCut'+index).text(),
                'certificate' : $('#tdLab'+index).text(),
                'certificate_number' : certNumber,
                'price': getNumberFromCurrency($('#tdAmount'+index).text()) || 0, //parseFloat($('#price').val()) || 0;
                'certificatelink': $('#tdCertiLink'+index).find('a').attr('href') || '',
                'shape': $('#tdShape'+index).text() || '',
                'imagelink': $('#tdImgLink'+index).find('img').attr('src') || '',
            },
            success: function (res) {
                // console.log(res);
                if(res.success != '' && typeof res.success !== "undefined"){
                    if(res.cartcount){
                        $(".cartcount").text(res.cartcount);
                    }
                    if(res.wishcount){
                        $(".wishcount").removeClass('fa-heart-o');
                        $(".wishcount").addClass('fa-heart');
                    }
                    toastr.success(res.success);
                }else{
                    toastr.info(res.error);
                }
            }
        });
    }


</script>
@endsection

@endsection
