<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body style="padding: 0; margin: 0;">
	<div style="margin-top: 30px;text-align: center;">
		<img src="https://admin.marlowsdiamonds.com/images/logo/logo_201517063_07_07_2023_12_41_48.png" alt="Marlow's Diamond">
	</div>
	<div style="width: 975px; margin: 0 auto; margin-top:20px;">
		<h3>Dear <strong>{{ isset($data1['data']['order_address']['first_name']) ? $data1['data']['order_address']['first_name'] : '' }}</strong></h3>
		<p>Thank you for visiting <a href="https://marlows-diamonds.co.uk/" target="_blank" style="color:#8e2e65">www.marlows-diamonds.co.uk</a>. We value your time and see that you tried to place an order but could not complete the transaction for the following item:</p>
	</div>
	<h2 colspan="2" style="font-size: 26px;font-family:Arial;padding: 10px 0 10px 0;text-align: center;">
		Order Details
	</h2>
	<table width="100%" cellspacing="0" cellpadding="3" style="font-family:Arial; margin: auto; background-color: #fff;">
		<tbody>
			<tr>
				<td>
					<table align="center" width="600px" cellspacing="0" cellpadding="0" bgcolor="#fff" style="border-collapse: collapse; max-width: 600px;">
						<tbody>
							<!-- Header part start here -->
							<!-- Header part end here -->
							<!-- order details part -->

							<tr>
								<td>
									<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;padding: 20px 0 20px 0;border: 1px solid #808080;border-bottom: none;">
										<thead>
											<tr>

											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="font-size: 16px;font-family:Arial; padding: 20px 20px; "> Order number: {{ isset($data1['data']['custom_order_id']) ? $data1['data']['custom_order_id'] : '' }} </td>
												<td style="font-size: 16px;font-family:Arial; padding: 20px 10px;"> Order date: {!! isset($data1['data']['created_at']) ? date("M d, Y", strtotime($data1['data']['created_at'])) : '' !!} </td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td>
									<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;border: 1px solid #808080;">
										<thead>
											<tr>
												<th style="font-size: 15px; font-family:Arial; border-width:1px 0 1px 0;border: 1px solid #808080; padding: 15px 10px; ">Product</th>
												<th style="font-size: 15px; font-family:Arial; border-width:1px 0 1px 0; border: 1px solid #808080; padding: 15px 10px; ">Quantity</th>
												<th style="font-size: 15px; font-family:Arial; border-width:1px 0 1px 0; border: 1px solid #808080; padding: 15px 8px; "> Total Price</th>
												<th style="font-size: 15px; font-family:Arial; border-width:1px 0 1px 0; border: 1px solid #808080; padding: 15px 8px; "> Deposited Price</th>
											</tr>
										</thead>
										<tbody>
											@foreach($data1['data']['get_order_details_function'] as $key => $orderDetails)
											<?php
											$detailsDecode = (array)json_decode($orderDetails['order_product_details']);

											if ($key == 0) {
												$firstProductOrderURL = $orderDetails['product_details']['slug'];
											}

											?>
											<tr>
												<td width="270px" style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 10px;
                                                line-height: 20px;border: 1px solid #808080;">
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<a href="{{asset('/product/'.$orderDetails['product_details']['slug'])}}">
															@if(isset($orderDetails['product_details']['AdditionalPriceMetalType']) && !empty($orderDetails['product_details']['AdditionalPriceMetalType']['image_url']))														<img src="{{ env('APP_IMAGE_URL').'/storage/'.$orderDetails['product_details']['AdditionalPriceMetalType']['image_url'] }}" alt="{{$orderDetails['product_details']['title']}}" style="height: 100px;">														@endif														<br>
															{{isset($orderDetails['product_details']['title'])?$orderDetails['product_details']['title']:''}}
														</a>
													</p>
													@if(isset($detailsDecode['choose_diamond']) && !empty($detailsDecode['choose_diamond']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Choose Your Diamond:
														</strong>
														{{ ($detailsDecode['choose_diamond'] == 'lab_grown')?'Lab Grown':'Mined'}}
													</p>
													@endif
													@if(isset($detailsDecode['metal_type']) && !empty($detailsDecode['metal_type']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Metal:
														</strong>
														{{$detailsDecode['metal_type']}}
													</p>
													@endif
													@if(isset($detailsDecode['fingersize']) && !empty($detailsDecode['fingersize']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Finger Size:
														</strong>
														{{$detailsDecode['fingersize']}}
													</p>
													@endif
													@if(isset($detailsDecode['width-mm']) && !empty($detailsDecode['width-mm']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Width MM:
														</strong>
														{{$detailsDecode['width-mm']}}
													</p>
													@endif
													@if(isset($detailsDecode['total-diamond-weight']) && !empty($detailsDecode['total-diamond-weight']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Weight:
														</strong>
														{{$detailsDecode['total-diamond-weight']}}
													</p>
													@endif
													@if(isset($detailsDecode['Carat']) && !empty($detailsDecode['Carat']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Carat:
														</strong>
														{{$detailsDecode['Carat']}}
													</p>
													@elseif(isset($detailsDecode['carat']) && !empty($detailsDecode['carat']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Carat:
														</strong>
														{{$detailsDecode['carat']}}
													</p>
													@endif
													@if(isset($detailsDecode['Color']) && !empty($detailsDecode['Color']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Color:
														</strong>
														{{$detailsDecode['Color']}}
													</p>
													@endif
													@if(isset($detailsDecode['Clarity']) && !empty($detailsDecode['Clarity']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Clarity:
														</strong>
														{{$detailsDecode['Clarity']}}
													</p>
													@endif
													@if(isset($detailsDecode['Lab']) && !empty($detailsDecode['Lab']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Certificate:
														</strong>
														{{$detailsDecode['Lab']}}
													</p>
													@endif
													@if(isset($detailsDecode['shape']) && !empty($detailsDecode['shape']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond Shape:
														</strong>
														{{$detailsDecode['shape']}}
													</p>
													@endif
													@if(isset($detailsDecode['CERT_NO']) && !empty($detailsDecode['CERT_NO']))
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">
															Diamond CertificateNo:
														</strong>
														{{$detailsDecode['CERT_NO']}}
													</p>
													@endif
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; text-align: center;
                                                line-height: 20px; font-size: 14px;border: 1px solid #808080;">
													{{$orderDetails['quantity']}}
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0;
                                                line-height: 20px; font-size: 14px;border: 1px solid #808080; text-align:center;">
													{{config('constants.MY_CURRENCY_SYMBOL')}}{{$orderDetails['total_price']}}
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0;
                                                line-height: 20px; font-size: 14px;border: 1px solid #808080;text-align:center;">
													{{config('constants.MY_CURRENCY_SYMBOL')}}{{$orderDetails['deposited_product_price']}}
												</td>
											</tr>
											@endforeach
											<tr>
												<td width="270px" style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 10px;
											line-height: 20px;border: 1px solid #808080;">
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">Subtotal:</strong>
													</p>

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0;line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;text-align:center;">
													{{config('constants.MY_CURRENCY_SYMBOL')}}{{$data1['data']['total_price']}}
												</td>
											</tr>
											<tr>
												<td width="270px" style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 10px; line-height: 20px;border: 1px solid #808080;">
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style="font-size: 14px;">Payment method:</strong>
													</p>
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;text-align:center;">
													{{$data1['data']['payment_type']}}
												</td>
											</tr>
											<tr>
												<td width="270px" style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 10px; line-height: 20px;border: 1px solid #808080;">
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style="font-size: 14px;">Status:</strong>
													</p>
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 20px;border: 1px solid #808080;text-align:center;font-weight: bold;">
													{{$data1['data']['status_details']}}
												</td>
											</tr>
											<tr>
												<td width="270px" style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 10px; line-height: 20px;border: 1px solid #808080;">
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">Total:</strong>
													</p>
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0;line-height: 20px; font-size: 14px;border: 1px solid #808080;">
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;text-align:center;">
													{{config('constants.MY_CURRENCY_SYMBOL')}}{{$data1['data']['total_price']}}
												</td>
											</tr>
											<tr>
												<td width="270px" style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 10px; line-height: 20px;border: 1px solid #808080;">
													<p style="margin: 0;font-family:Arial; font-size: 14px;  line-height: 25px;">
														<strong style=" font-size: 14px;">Deposited Total:</strong>
													</p>
												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;">

												</td>
												<td style="font-family:Arial; border-bottom: 1px solid #808080; padding: 15px 0; line-height: 20px; font-size: 14px;border: 1px solid #808080;text-align:center;">
													{{config('constants.MY_CURRENCY_SYMBOL')}}{{$data1['data']['deposited_price']}}
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<!-- order details part end-->
						</tbody>

						<table align="center" width="600px" cellspacing="0" cellpadding="0" bgcolor="#fff" style="border-collapse: collapse; max-width: 600px;">

<tbody>

<tr>
								<td style="width: 48.7%; font-family:Arial; padding: 15px 10px;line-height: 20px;border: 1px solid #808080;border-top:none;text-align:center;font-weight: bold;font-size: 26px;">
									Billing Address
								</td>
								<td style="font-family:Arial; padding: 15px 10px;line-height: 20px;border: 1px solid #808080;border-top:none;text-align:center;font-weight: bold;font-size: 26px;">
									Shipping Address
								</td>
							</tr>
							<tr>
								<td  style="font-family:Arial; padding: 15px 10px; line-height: 20px;border: 1px solid #808080;text-align:center">
									{{isset($data1['data']['order_address']['first_name'])?$data1['data']['order_address']['first_name']:''}} {!!isset($data1['data']['order_address']['last_name'])?$data1['data']['order_address']['last_name'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['company_name'])?$data1['data']['order_address']['company_name'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['street_address_l1'])?$data1['data']['order_address']['street_address_l1']:''!!} {!!isset($data1['data']['order_address']['street_address_l2'])?$data1['data']['order_address']['street_address_l2'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['town_city'])?$data1['data']['order_address']['town_city'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['state'])?$data1['data']['order_address']['state']:''!!} {!!isset($data1['data']['order_address']['pin_code'])?$data1['data']['order_address']['pin_code'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['country_name'])?$data1['data']['order_address']['country_name'].'<br>':''!!}
									<a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="tel:{{isset($data1['data']['order_address']['mobile'])?$data1['data']['order_address']['mobile']:''}}"> {{isset($data1['data']['order_address']['mobile'])?$data1['data']['order_address']['mobile']:''}}</a><br>
									<a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="mailto:{{isset($data1['data']['order_address']['email'])?$data1['data']['order_address']['email']:''}}"> {{isset($data1['data']['order_address']['email'])?$data1['data']['order_address']['email']:''}}</a>
								</td>
								<td style="font-family:Arial; padding: 15px 10px; line-height: 20px;border: 1px solid #808080;text-align:center">
									{{isset($data1['data']['order_address']['first_name'])?$data1['data']['order_address']['first_name']:''}} {!!isset($data1['data']['order_address']['last_name'])?$data1['data']['order_address']['last_name'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['company_name'])?$data1['data']['order_address']['company_name'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['street_address_l1'])?$data1['data']['order_address']['street_address_l1']:''!!} {!!isset($data1['data']['order_address']['street_address_l2'])?$data1['data']['order_address']['street_address_l2'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['town_city'])?$data1['data']['order_address']['town_city'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['state'])?$data1['data']['order_address']['state']:''!!} {!!isset($data1['data']['order_address']['pin_code'])?$data1['data']['order_address']['pin_code'].'<br>':''!!}
									{!!isset($data1['data']['order_address']['country_name'])?$data1['data']['order_address']['country_name'].'<br>':''!!}
									<a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="tel:{{isset($data1['data']['order_address']['mobile'])?$data1['data']['order_address']['mobile']:''}}"> {{isset($data1['data']['order_address']['mobile'])?$data1['data']['order_address']['mobile']:''}}</a><br>
									<a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="mailto:{{isset($data1['data']['order_address']['email'])?$data1['data']['order_address']['email']:''}}"> {{isset($data1['data']['order_address']['email'])?$data1['data']['order_address']['email']:''}}</a>
								</td>
							</tr>
</tbody>
</table>
					</table>
				</td>
			</tr>

			<table style="width: 975px;margin: 0 auto;">
				<tr>
					<td style="padding: 10px 0 0">
						<p style="text-align: center;">To complete your order right now, just click on the button below:</p>
						<div class="clearfix" style="clear: both;"></div>
						<p style="text-align: center;"><a href="{{asset('product').'/'.$firstProductOrderURL}}" target="_blank" style="font-size: 14px;text-decoration: none;background: #8e2e65;color: #fff;display: inline-block;padding: 11px 25px;font-family: arial;text-transform: capitalize;">Complete order </a></p>
						<p style="text-align: center;"><i>  "Loved this product! Highly recommend." - Happy Customer</i></p>
					</td>
				</tr>
			</table>
		</tbody>
	</table>

<table style="width: 975px;margin: 0 auto; text-align:center;">
<tbody>
<tr>
				<td>
					<p>
						If you have any questions, please <a href="https://marlows-diamonds.co.uk/visit-us"> contact us</a> or visit our store
					</p>
				</td>
			</tr>

</tbody>
</table>
	<table style="width: 598px;margin: 0 auto;">
		<tbody>
			<tr>
				<h2 style="text-align:center;">Contact Details </h2>
			</tr>
			<tr>
				<td style="padding: 0 10px;">
					<div>
						<h4>Birmingham Store:</h4>
						<address>
							46-47 Warstone Lane Hockley, Birmingham B18 6JJ.
						</address>
						<p> <strong>Email:</strong> hello@marlows-diamonds.co.uk </p>
						<p> <strong>Phone no:</strong> 0121 236 4415</p>
					</div>
				</td>
				<td style="border-left: solid #8e2e65 1px;padding: 0 10px;">
					<div>
						<h4>London Store:</h4>
						<address>
							20 Beauchamp Pl, Knightsbridge, London SW3 1NQ.
						</address>
						<p> <strong>Email:</strong> london@marlows-diamonds.co.uk </p>
						<p> <strong>Phone no:</strong> 020 7405 1477</p>
					</div>
				</td>
			</tr>
		</tbody>
	</table>

	<table style="width: 598px;margin: 0 auto;">
		<tbody>
			<tr>
				<td style="text-align:center;">

					<p style="padding:20px 0; text-align:center;"><strong>Note -</strong>If you wish to create your own design, we can quote you to manufacture a bespoke piece at a competitive price. </p>
					<h3>Happy To Help You!</h3>
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
