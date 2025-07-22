<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"> --}}
</head>
<body style="padding: 0; margin: 0;">
<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:Arial; margin: auto; background-color: #fff;">
    <?php
        // echo "<pre>";
        // print_r($data1['data']);
        // die;

    ?>
	<tbody>
		<tr>
			<td>
				<table border="0" width="600px" cellspacing="0" cellpadding="0" align="center" bgcolor="#fff" style="border-collapse: collapse; max-width: 600px;">
					<tbody>
						<!-- Header part start here -->
						<tr>
							<td style="  border-bottom: 1px dashed #808080;padding: 20px 0 20px 0;">
								<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
									<tbody>
									<tr>
										<td align="center">
											<img src="{{ asset('') }}assets/images/logo.png" alt="Marlow's Diamond">
										</td>
									</tr>
									<tr>
										<td align="center" style="padding: 40px 0 20px 0;font-family:Arial;">
											<i style="font-size: 18px; color: #505050;font-family:Arial;">Hello from Marlows Diamonds!</i>
											<h3 style="margin: 0; font-weight: normal; line-height: 40px; font-size: 22px;font-family:Arial;"><b>New customer order!</b></h3>
										</td>
									</tr>
									<tr>
										<td>
											<p style="font-size: 16px; line-height: 25px; color: #505050;font-family:Arial;">Thank you for placing your order. It is now being processed and an update will be sent within 72hrs. The order is as follows: </p>
											{{-- <p style="font-size: 16px; line-height: 25px; color: #505050;font-family:Arial;">Paid with {{ isset($data1['data']['payment_type']) ? $data1['data']['payment_type'] : '' }}.</p> --}}
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<!-- Header part end here -->
						<!-- order details part -->
						<tr>
							<td>
								<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
									<thead>
										<tr>
											<th colspan="2" align="center" style="font-size: 26px;font-family:Arial;padding: 40px 0 20px 0;">
											Order Details
										</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="font-size: 16px;font-family:Arial; padding: 20px 0; font-style: italic;"> Order number: {{ isset($data1['data']['custom_order_id']) ? $data1['data']['custom_order_id'] : '' }} </td>
											<td align="right"  style="font-size: 16px;font-family:Arial; padding: 20px 0;font-style: italic;">  Order date: {!! isset($data1['data']['created_at']) ? date("M d, Y", strtotime($data1['data']['created_at'])) : '' !!}  </td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
									<thead>
										<tr>
											<th align="left" style="font-size: 16px; color: #606060;font-family:Arial; border: 1px dashed #808080; border-width:1px 0 1px 0; padding: 15px 0; ">Product</th>
											<th align="center" style="font-size: 16px; color: #606060;font-family:Arial; border: 1px dashed #808080; border-width:1px 0 1px 0; padding: 15px 0; ">Quantity</th>
											<th align="right" style="font-size: 16px; color: #606060;font-family:Arial; border: 1px dashed #808080; border-width:1px 0 1px 0; padding: 15px 0; "> Total Price</th>
											<th align="right" style="font-size: 16px; color: #606060;font-family:Arial; border: 1px dashed #808080; border-width:1px 0 1px 0; padding: 15px 0; "> Deposited Price</th>
										</tr>
									</thead>
									<tbody>
										@foreach($data1['data']['get_order_details_function'] as $key => $orderDetails)
                                            <?php
                                            $detailsDecode = (array)json_decode($orderDetails['order_product_details']);
                                            ?>
                                            <tr>
                                                <td width="270px" align="left" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
                                                color: #505050;line-height: 20px;">
                                                <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                    {{isset($orderDetails['product_details']['title'])?$orderDetails['product_details']['title']:''}}</p>
                                                    {{-- <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">	 </p> --}}

                                                    @if(isset($detailsDecode['choose_diamond']) && !empty($detailsDecode['choose_diamond']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Choose Your Diamond:
                                                            </strong>
                                                            {{ ($detailsDecode['choose_diamond'] == 'lab_grown')?'Lab Grown':'Mined'}}
                                                        </p>
                                                    @endif
                                                    @if(isset($detailsDecode['metal_type']) && !empty($detailsDecode['metal_type']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Metal:
                                                            </strong>
                                                            {{$detailsDecode['metal_type']}}
                                                        </p>
                                                    @endif
                                                    @if(isset($detailsDecode['fingersize']) && !empty($detailsDecode['fingersize']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Finger Size:
                                                            </strong>
                                                            {{$detailsDecode['fingersize']}}
                                                        </p>
                                                    @endif
                                                    @if(isset($detailsDecode['width-mm']) && !empty($detailsDecode['width-mm']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Width MM:
                                                            </strong>
                                                            {{$detailsDecode['width-mm']}}
                                                        </p>
                                                    @endif
                                                    @if(isset($detailsDecode['total-diamond-weight']) && !empty($detailsDecode['total-diamond-weight']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Weight:
                                                            </strong>
                                                            {{$detailsDecode['total-diamond-weight']}}
                                                        </p>
                                                    @endif

                                                    @if(isset($detailsDecode['Carat']) && !empty($detailsDecode['Carat']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Carat:
                                                            </strong>
                                                            {{$detailsDecode['Carat']}}
                                                        </p>
                                                    @elseif(isset($detailsDecode['carat']) && !empty($detailsDecode['carat']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Carat:
                                                            </strong>
                                                            {{$detailsDecode['carat']}}
                                                        </p>
                                                    @endif

                                                    @if(isset($detailsDecode['Color']) && !empty($detailsDecode['Color']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Color:
                                                            </strong>
                                                            {{$detailsDecode['Color']}}
                                                        </p>
                                                    @endif

                                                    @if(isset($detailsDecode['Clarity']) && !empty($detailsDecode['Clarity']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Clarity:
                                                            </strong>
                                                            {{$detailsDecode['Clarity']}}
                                                        </p>
                                                    @endif

                                                    @if(isset($detailsDecode['Lab']) && !empty($detailsDecode['Lab']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Certificate:
                                                            </strong>
                                                            {{$detailsDecode['Lab']}}
                                                        </p>
                                                    @endif

                                                    @if(isset($detailsDecode['shape']) && !empty($detailsDecode['shape']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond Shape:
                                                            </strong>
                                                            {{$detailsDecode['shape']}}
                                                        </p>
                                                    @endif
                                                    {{-- @if(isset($detailsDecode['Stock_NO']) && !empty($detailsDecode['Stock_NO']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond StockNo:
                                                            </strong>
                                                            {{$detailsDecode['Stock_NO']}}
                                                        </p>
                                                    @endif --}}






                                                    {{-- @if(isset($detailsDecode['CertificateLink']) && !empty($detailsDecode['CertificateLink']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Certificate Link:
                                                            </strong>
                                                            <a target="_blank" href="{{$detailsDecode['CertificateLink']}}">View Certificate</a>

                                                        </p>
                                                    @endif --}}
                                                    {{-- @if(isset($detailsDecode['ImageLink']) && !empty($detailsDecode['ImageLink']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Image:
                                                            </strong>
                                                            <a target="_blank" href="{{$detailsDecode['ImageLink']}}">View Diamond</a>
                                                        </p>
                                                    @endif --}}

                                                    @if(isset($detailsDecode['CERT_NO']) && !empty($detailsDecode['CERT_NO']))
                                                        <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">
                                                                Diamond CertificateNo:
                                                            </strong>
                                                            {{$detailsDecode['CERT_NO']}}
                                                        </p>
                                                    @endif


													@if(isset($orderDetails['yearly_support_status']) && $orderDetails['yearly_support_status'] == 1)
														<p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
															<strong style=" font-size: 14px;">
																Jewellery Care Plan:
															</strong>
															@if($orderDetails['yearly_support_price'] == 0)
																No applied
															@elseif($orderDetails['yearly_support_price'] == 89)
																1 year £89
															@elseif($orderDetails['yearly_support_price'] == 170)
																2 years £170
															@elseif($orderDetails['yearly_support_price'] == 220)
																3 years £220
															@elseif($orderDetails['yearly_support_price'] == 300)
																4 years £300
															@elseif($orderDetails['yearly_support_price'] == 400)
																5 years £400
															@endif
														</p>
													@endif
                                                    {{-- @foreach($detailsDecode as $key1 => $jsonData)
                                                        @if($key1 == 'certificatelink')

                                                        @else
                                                            <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                            <strong style=" font-size: 14px;">{{ucwords($key1)}}:</strong> {{$jsonData}}</p>
                                                        @endif
                                                    @endforeach --}}
                                                </td>

                                                {{-- <td width="270px" align="left" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
                                                color: #505050;line-height: 20px;">
                                                    <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                    WED023</p>
                                                    <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                    <strong style=" font-size: 14px;">Choose Your Diamond:</strong> Mined Diamond </p>
                                                    <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                    <strong style=" font-size: 14px;">Finger Size:</strong> l </p>
                                                    <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                    <strong style=" font-size: 14px;">Carat:</strong> 0.38 </p>
                                                    <p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
                                                    <strong style=" font-size: 14px;">Metal Colour:</strong> 9ct White Gold </p>
                                                </td> --}}

                                                <td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
                                                color: #505050;line-height: 20px; font-size: 14px;">
                                                        {{$orderDetails['quantity']}}
                                                </td>
                                                <td align="right" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
                                                color: #505050;line-height: 20px; font-size: 14px;">
                                                        {{MY_CURRENCY_SYMBOL}}{{$orderDetails['total_price']}}
                                                </td>
                                                <td align="right" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
                                                color: #505050;line-height: 20px; font-size: 14px;">
                                                        {{MY_CURRENCY_SYMBOL}}{{$orderDetails['deposited_product_price']}}
                                                </td>
                                            </tr>
										@endforeach
										<!-- <tr>
											<td width="270px" align="left" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px;">
												<p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
												<strong style=" font-size: 14px;">Subtotal:</strong></p>
											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="right" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">
												{{MY_CURRENCY_SYMBOL}}{{$data1['data']['deposited_price']}}
											</td>
										</tr> -->

										<tr>
											<td width="270px" align="left" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px;">
												<p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
												<strong style=" font-size: 14px;">Payment method:</strong></p>

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="right" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">
												{{$data1['data']['payment_type']}}
											</td>
										</tr>
										<tr>
											<td width="270px" align="left" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px;">
												<p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
												<strong style=" font-size: 14px;">Total:</strong></p>

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="right" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">
												{{MY_CURRENCY_SYMBOL}}{{$data1['data']['deposited_price']}}
											</td>
										</tr>
										<tr>
											<td width="270px" align="left" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px;">
												<p style="margin: 0;font-family:Arial; font-size: 14px; color: #505050; line-height: 25px;">
												<strong style=" font-size: 14px;">Deposited Total:</strong></p>

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="center" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">

											</td>
											<td align="right" style="font-family:Arial; border-bottom: 1px dashed #808080; padding: 15px 0;
											color: #505050;line-height: 20px; font-size: 14px;">
												{{MY_CURRENCY_SYMBOL}}{{$data1['data']['deposited_price']}}
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
									<thead>
										<tr>
											<th align="center" style="font-size: 26px;font-family:Arial;padding: 40px 0 20px 0; ">
												Billing address
											</th>
											@if(isset($data1['data']['order_address']['shipping_status']) && $data1['data']['order_address']['shipping_status'] == 0)
											<th align="center" style="font-size: 26px;font-family:Arial;padding: 40px 0 20px 0; ">
												Shipping address
											</th>
											@endif
										</tr>
									</thead>
									<tbody>
										<tr>
											<td align="center" style="border: 1px dashed #808080;font-family:Arial; font-size: 15px; color: #808080; padding: 30px 20px; line-height: 24px;">
												{{isset($data1['data']['order_address']['first_name'])?$data1['data']['order_address']['first_name']:''}} {!!isset($data1['data']['order_address']['last_name'])?$data1['data']['order_address']['last_name'].'<br>':''!!}
												{!!isset($data1['data']['order_address']['company_name'])?$data1['data']['order_address']['company_name'].'<br>':''!!}
												{!!isset($data1['data']['order_address']['street_address_l1'])?$data1['data']['order_address']['street_address_l1']:''!!} {!!isset($data1['data']['order_address']['street_address_l2'])?$data1['data']['order_address']['street_address_l2'].'<br>':''!!}
												{!!isset($data1['data']['order_address']['town_city'])?$data1['data']['order_address']['town_city'].'<br>':''!!}
												{!!isset($data1['data']['order_address']['state'])?$data1['data']['order_address']['state']:''!!} {!!isset($data1['data']['order_address']['pin_code'])?$data1['data']['order_address']['pin_code'].'<br>':''!!}
												{!!isset($data1['data']['order_address']['country_name'])?$data1['data']['order_address']['country_name'].'<br>':''!!}
												 <a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="tel:{{isset($data1['data']['order_address']['mobile'])?$data1['data']['order_address']['mobile']:''}}"> {{isset($data1['data']['order_address']['mobile'])?$data1['data']['order_address']['mobile']:''}}</a><br>
												 <a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="mailto:{{isset($data1['data']['order_address']['email'])?$data1['data']['order_address']['email']:''}}"> {{isset($data1['data']['order_address']['email'])?$data1['data']['order_address']['email']:''}}</a>
											</td>

											@if(isset($data1['data']['order_address']['shipping_status']) && $data1['data']['order_address']['shipping_status'] == 0)
											<?php 
												$colSpanMerge = 'colspan=2';
											?>
											<td align="center" style="border: 1px dashed #808080;font-family:Arial; font-size: 15px; color: #808080; padding: 30px 20px; line-height: 24px;">
												{{isset($data1['data']['order_shipping_address']['first_name'])?$data1['data']['order_shipping_address']['first_name']:''}} {!!isset($data1['data']['order_shipping_address']['last_name'])?$data1['data']['order_shipping_address']['last_name'].'<br>':''!!}
												{!!isset($data1['data']['order_shipping_address']['company_name'])?$data1['data']['order_shipping_address']['company_name'].'<br>':''!!}
												{!!isset($data1['data']['order_shipping_address']['street_address_l1'])?$data1['data']['order_shipping_address']['street_address_l1']:''!!} {!!isset($data1['data']['order_shipping_address']['street_address_l2'])?$data1['data']['order_shipping_address']['street_address_l2'].'<br>':''!!}
												{!!isset($data1['data']['order_shipping_address']['town_city'])?$data1['data']['order_shipping_address']['town_city'].'<br>':''!!}
												{!!isset($data1['data']['order_shipping_address']['state'])?$data1['data']['order_shipping_address']['state']:''!!} {!!isset($data1['data']['order_shipping_address']['pin_code'])?$data1['data']['order_shipping_address']['pin_code'].'<br>':''!!}
												{!!isset($data1['data']['order_shipping_address']['country_name'])?$data1['data']['order_shipping_address']['country_name'].'<br>':''!!}
												 <a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="tel:{{isset($data1['data']['order_shipping_address']['mobile'])?$data1['data']['order_shipping_address']['mobile']:''}}"> {{isset($data1['data']['order_shipping_address']['mobile'])?$data1['data']['order_shipping_address']['mobile']:''}}</a><br>
												 <a style="color: #8e2e65; font-style: 14px;font-family:Arial;" href="mailto:{{isset($data1['data']['order_shipping_address']['email'])?$data1['data']['order_shipping_address']['email']:''}}"> {{isset($data1['data']['order_shipping_address']['email'])?$data1['data']['order_shipping_address']['email']:''}}</a>
											</td>
											@endif
										</tr>
										<tr>
											<td align="center" style="border: 1px dashed #808080;font-family:Arial; font-size: 15px; color: #000; padding: 30px 20px; line-height: 24px;" {{isset($colSpanMerge)?$colSpanMerge:""}}>
												Thanks for using marlows-diamonds.co.uk!
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>

						<!-- order details part end-->

					</tbody>

				</table>
			</td>
		</tr>
		<tr>
			<td style="padding: 60px 0 0">
				<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#8e2e65" style="border-collapse: collapse;">
					<tbody>
						<tr>
							<td>
								<table border="0" width="600px" cellspacing="0" cellpadding="0" align="center" style="border-collapse: collapse; max-width: 600px;">
									<tr>
										<td align="center" style="padding: 20px 0; color: #fff;font-family:Arial;">
											<a style="color: #fff; text-decoration: none; padding:0 20px; font-style: 26px;" href="https://www.facebook.com/MarlowsDiamonds/">
												<i style="font-size: 26px;" class="fa fa-facebook-square" aria-hidden="true"></i>
											</a>
											<a style="color: #fff; text-decoration: none; padding:0 20px; font-style: 26px;" href="https://www.instagram.com/accounts/login/?next=/marlows_diamonds/">
												<i style="font-size: 26px;" class="fa fa-instagram" aria-hidden="true"></i>
											</a>
											<a style="color: #fff; text-decoration: none; padding:0 20px; font-style: 26px;" href="https://twitter.com/MarlowsDiamonds">
												<i style="font-size: 26px;" class="fa fa-twitter-square" aria-hidden="true"></i>
											</a>
											<a style="color: #fff; text-decoration: none; padding:0 20px; font-style: 26px;" href="http://marlows-diamonds.co.uk">
												<i style="font-size: 26px;" class="fa fa-link" aria-hidden="true"></i>
											</a>

										</td>
									</tr>
									<tr>
										<td align="center" style="font-size: 14px; color: #fff;font-family:Arial; padding: 30px 0; border-top: 1px dashed #fff;">
											Copyright © {{date('Y')}} Marlows Diamonds, All rights reserved.
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>
