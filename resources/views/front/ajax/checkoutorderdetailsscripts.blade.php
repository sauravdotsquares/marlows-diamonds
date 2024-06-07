<div class="checkout-title-head">
    Your Order
</div>
<div class="checkout-order-table">
    <table style="width:100%" border-collapse="collapse">
        <thead>
            <tr>
                <th class="checkproduct-name">Product</th>
                <th class="checkproduct-price">Price</th>
                <th class="checkproduct-total">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $totalPrice = 0; $depositedPrice = 0; @endphp
            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
            @php
            $total += $details['deposited_price'] * $details['quantity'];
            $totalPrice += $details['price'] * $details['quantity'];
            $depositedPrice += $details['deposited_price'] * $details['quantity'];
            @endphp
            <tr class="checkcart-item">
                <td class="checkpr-name">
                    @if(isset($details['customArray']['slug']) && !empty($details['customArray']['slug']))
                    <div class="cartproduct-title"><a href="{{asset('product/'.$details['customArray']['slug'])}}"> {{ $details['name'] }}</a></div>
                    @else
                    <div class="cartproduct-title"><a href="javascript:void(0);"> {{ $details['name'] }}</a></div>
                    @endif
                    <dl class="variation">
                        @if(isset($details['customArray']['choose_diamond']) && !empty($details['customArray']['choose_diamond']))
                        <dt class="variation-Colour">Choose Your Diamond:&nbsp; </dt>
                        <dd class="variation-Colour">
                            <p> {{ ($details['customArray']['choose_diamond'] == 'lab_grown')?'Lab Grown':'Mined'}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['metal_type']) && !empty($details['customArray']['metal_type']))
                        <dt class="variation-Colour">Metal:&nbsp; </dt>
                        <dd class="variation-Colour">
                            <p> {{$details['customArray']['metal_type']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['fingersize']) && !empty($details['customArray']['fingersize']))
                        <dt class="variation-FingerSize">Finger Size:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['fingersize']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['width-mm']) && !empty($details['customArray']['width-mm']))
                        <dt class="variation-FingerSize">Width MM:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['width-mm']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['total-diamond-weight']) && !empty($details['customArray']['total-diamond-weight']))
                        <dt class="variation-FingerSize">Diamond Weight:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['total-diamond-weight']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['Shape']) && !empty($details['customArray']['Shape']))
                        <dt class="variation-FingerSize">Diamond Shape:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['Shape']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['Carat']) && !empty($details['customArray']['Carat']))
                        <dt class="variation-FingerSize">Diamond Carat:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['Carat']}}</p>
                        </dd>
                        @elseif(isset($details['customArray']['carat']) && !empty($details['customArray']['carat']))
                        <dt class="variation-FingerSize">Diamond Carat:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['carat']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['Color']) && !empty($details['customArray']['Color']))
                        <dt class="variation-FingerSize">Diamond Color:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['Color']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['Clarity']) && !empty($details['customArray']['Clarity']))
                        <dt class="variation-FingerSize">Diamond Cut Grade:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['Clarity']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['Lab']) && !empty($details['customArray']['Lab']))
                        <dt class="variation-FingerSize">Certificate:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['Lab']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['customArray']['CertificateLink']) && !empty($details['customArray']['CertificateLink']))
                        <dt class="variation-FingerSize">Certificate Link:&nbsp; </dt>
                        <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['CertificateLink']}}">View Certificate</a></dd>
                        @endif
                        @if(isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                        <dt class="variation-FingerSize">Image:&nbsp; </dt>
                        <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['ImageLink']}}">View Diamond</a></dd>
                        @endif
                        @if(isset($details['customArray']['CERT_NO']) && !empty($details['customArray']['CERT_NO']))
                        <dt class="variation-FingerSize">Certificate:&nbsp; </dt>
                        <dd class="variation-FingerSize">
                            <p>{{$details['customArray']['CERT_NO']}}</p>
                        </dd>
                        @endif
                        @if(isset($details['name']) && $details['name'] != 'Custom Diamond')
                        <div class="plancare-section">
                            <h5>Jewellery Care Plan</h5>
                            <select class="form-control" name="yearlySupport" id="yearlySupport{{$id}}">
                                <option value="0" @if(isset($details['yearlySupport']) && $details['yearlySupport']==0) selected @endif>No applied</option>
                                <option value="89" @if(isset($details['yearlySupport']) && $details['yearlySupport']==89) selected @endif>1 year {{MY_CURRENCY_SYMBOL}}89</option>
                                <option value="170" @if(isset($details['yearlySupport']) && $details['yearlySupport']==170) selected @endif>2 years {{MY_CURRENCY_SYMBOL}}170</option>
                                <option value="220" @if(isset($details['yearlySupport']) && $details['yearlySupport']==220) selected @endif>3 years {{MY_CURRENCY_SYMBOL}}220</option>
                                <option value="300" @if(isset($details['yearlySupport']) && $details['yearlySupport']==300) selected @endif>4 years {{MY_CURRENCY_SYMBOL}}300</option>
                                <option value="400" @if(isset($details['yearlySupport']) && $details['yearlySupport']==400) selected @endif>5 years {{MY_CURRENCY_SYMBOL}}400</option>
                            </select>
                        </div>
                        @endif
                    </dl>
                    <strong class="checkpr-quantity">x {{$details['quantity']}}</strong>
                </td>
                <td>
                    <span id="productPrice{{$id}}">
                        @if(isset($details['customArray']['final_price']) && !empty($details['customArray']['final_price']) && $details['customArray']['final_price'] != $details['price'])
                        <span> Our Price: </span>
                        <del>{{MY_CURRENCY_SYMBOL}}{{ $details['customArray']['final_price'] }}</del>
                        @endif <br>
                        @if(isset($details['customArray']['choose_diamond']) && $details['customArray']['choose_diamond'] == 'lab_grown')
                        {{MY_CURRENCY_SYMBOL}}{{ $details['price'] }}
                        @else
                        {{MY_CURRENCY_SYMBOL}}{{ $details['price'] }}
                        @endif
                    </span>
                </td>
                <td class="check-product-total">
                    <span id="subtotalPrice{{$id}}">{{MY_CURRENCY_SYMBOL}}{{ round($details['deposited_price'],2) }}</span>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr class="checkout-cart-subtotal">
                <th>Subtotal</th>
                <td id="subTotalPrices">
                    <strong>{{MY_CURRENCY_SYMBOL}}{{ round($total,2) }}</strong>
                </td>
            </tr>
            <tr class="checkout-cart-total">
                <th>Total</th>
                <td id="totalFinalPrices">
                    <strong>{{MY_CURRENCY_SYMBOL}}{{ round($total,2) }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<input type="hidden" id="final_price" name="final_price" value="{{ $total }}">
<input type="hidden" id="total_price" name="total_price" value="{{ $totalPrice }}">
<input type="hidden" id="deposited_price" name="deposited_price" value="{{ $depositedPrice }}">
<input type="hidden" id="selected_payment_type" name="selected_payment_type" value="paypal">
<div class="checkout-payment-options">
    <ul class="cc_payment_methods_options">
        @include('front.pages.payments.paypal',['totalAmount'=>$total])
        @include('front.pages.payments.dekopay',['totalAmount'=>$total])
        @include('front.pages.payments.stripepay',['totalAmount'=>$total])
    </ul>
</div>
<div class="checkout-place-order">
    <div class="cc-terms-and-conditions-wrapper">
        Your personal data will be used to process your order, support your experience
        throughout this website, and for other purposes described in our
        <a href="{{asset('privacy-policy')}}" target="_blank">Privacy Policy</a>
    </div>
    <div class="cc_place_order_btn">
        <button class="btn-bg-large" type="submit">Place Order</button>
    </div>
</div>