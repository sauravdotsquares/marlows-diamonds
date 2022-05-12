@extends('layouts.front.app')
@section('content')
<div class="container">
	<div class="container-payment-receipt">
		<div class="dekopay-message">Thank you for your order. We are now redirecting you to your Dekopay application.</div>
		<form action="{{$dekopay_args['gatewayurl']}}" method="post" id="dekopay_payment_form" target="_top">
			{{csrf_field()}}
			<table border-collapse="collapse">
	            <thead>
	                <tr>
	                    <th class="">Order Number</th>
	                    <th class="">Date</th>
	                    <th class="">Total</th>
	                    <th class="">Payment Method</th>
	                </tr>
	            </thead>
	            <tbody>
	            	<tr>
	                    <td class="">#{{$order_id}}</td>
	                    <td class="">{{date('M d, Y')}}</td>
	                    <td class="">{{$orderDekopayFinance->totalAmts}}</td>
	                    <td class="">Dekopay</td>
	                </tr>
	            </tbody>
	        </table>

	        <input type="hidden" name="Identification[RetailerUniqueRef]" value="{{$order_id}}-{{$orderDekopayFinance->order_key}}">
			<input type="hidden" name="Identification[api_key]" value="{{$api_key}}">
			<input type="hidden" name="Identification[InstallationID]" value="{{$api_install_id}}">
								
			<input type="hidden" name="Goods[0][Description]" value="{{$pname}}">
			<input type="hidden" name="Goods[0][Quantity]" value="1">
			<input type="hidden" name="Goods[0][Price]" value="{{$orderDekopayFinance->totalAmts}}">
		   
			<input type="hidden" name="Finance[Code]" value="{{$orderDekopayFinance->finCodes}}" id="submit_finance_code">
			<input type="hidden" name="Finance[Deposit]" value="{{$orderDekopayFinance->depositAmt}}" id="submit_finance_deposit">

			<a href="{{$result}}" id="submit_dekopay_payment_form" class="btn btn-primary" disabled="disabled">Click here to complete your finance application</a>
			
		</form>
	</div>
</div>
@endsection

@section('js')

<script>
	var timer2 = "0:15";
	var interval = setInterval(function() {
		var timer = timer2.split(':');
		//by parsing integer, I avoid all extra string processing
		var minutes = parseInt(timer[0], 10);
		var seconds = parseInt(timer[1], 10);
		--seconds;
		minutes = (seconds < 0) ? --minutes : minutes;
		if (minutes < 0) clearInterval(interval);
		seconds = (seconds < 0) ? 59 : seconds;
		seconds = (seconds < 10) ? '0' + seconds : seconds;
		//minutes = (minutes < 10) ?  minutes : minutes;
		$('#submit_dekopay_payment_form').text('Redirecting in '+minutes + ':' + seconds);
		timer2 = minutes + ':' + seconds;
		if(timer2=='-1:59'){
			$('#submit_dekopay_payment_form').text('Click here to complete your finance application');
			$('#submit_dekopay_payment_form').removeAttr('disabled');
		}

	}, 1000);

	setTimeout(function(){
		 window.location.href = '{{$result}}';
	 },1500);
</script>

@endsection