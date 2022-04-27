@extends('layouts.front.app')
@section('css')
<style>
    .error {
        color: #e74c3c;
    }
</style>
@endsection

@section('content')

@if (\Session::has('success'))
    <!-- <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div> -->
@endif

@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif

<div class="checkout-wraper">
    <div class="container">
        <div class="checkout-container">
            @guest
                <?php //echo "check"; die; ?>
                <div class="not-logedin-block alert alert-dismissible fade show" role="alert">
                    <div class="alert_icon">
                        <i class="fa fa-question" aria-hidden="true"></i>
                    </div>

                    <div class="alert_wraper">
                        Returning customer?
                        <a class="showlogin" href="javascript:void(0);">Click here to login</a>
                    </div>
                    <div class="alert_close">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <!-- login form start-->
                <div class="checkout-login-form">
                    <form id="loginRegisterForm">
                        <p>If you have shopped with us before, please enter your details below. If you are a new customer,
                            please proceed to the Billing section.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkout-form-group">
                                    <label class="input-label">Email <abbr class="required">*</abbr></label>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-group">
                                    <label class="input-label">Password <abbr class="required">*</abbr></label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="action-login">
                            <button class="btn-bg-small" type="submit">Login</button>
                            <label class="rememberme">
                                <input type="checkbox">
                                <span>Remember me</span>
                            </label>
                        </div>
                        <div class="lostpassword">
                            <a href="javascript:void(0)">Lost your password</a>
                        </div>
                    </form>
                </div>
            @endguest
            <!-- login form end-->
            <div class="checkout-main-wrap">
                <form id="finalPlaceOrderPage" action="{{route('place.order')}}" method="POST">
                    @csrf
                    <div class="customer-details-check">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout-left-fields">
                                    <div class="checkout-billing-fields">
                                        <div class="checkout-title-head">
                                            Billing details
                                        </div>
                                        <div class="billin-fields-wrap">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">First Name <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="first_name" name="first_name" required="required" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Last Name <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="last_name" name="last_name" required="required" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Company Name <span
                                                                class="optional">(Optional)</span></label>
                                                        <input type="text" id="company_name" name="company_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Country/Region <abbr
                                                                class="required">*</abbr></label>
                                                        <select id="country_id" name="country_id" required="required" class="form-control">
                                                            <option>Select Option</option>
                                                            @foreach($getContries as $key => $country)
                                                                <option value="{{$country->shortname}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Street address <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="street_address_l1" name="street_address_l1" required="required" class="form-control"
                                                            placeholder="House number and street name">
                                                    </div>
                                                    <div class="checkout-form-group">
                                                        <input type="text" id="street_address_l2" name="street_address_l2" class="form-control"
                                                            placeholder="Apartment, suite, unit, etc. (optional)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Town / City <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="town_city" name="town_city" required="required" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">State/Region<abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="state" name="state" required="required" class="form-control">
                                                        <!-- <select id="state" name="state" required="required" class="form-control">
                                                            <option>Select Option</option>
                                                            <option>Rajasthan</option>
                                                        </select> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">PIN <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="pin_code" name="pin_code" required="required" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Phone<abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="mobile" name="mobile" required="required" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Email address<abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="email" name="email" required="required" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @guest
                                    <div class="checkout-create-account">
                                        <div class="create-account-checkbox">
                                            <input type="checkbox" checked>
                                            <label>Create an Account?</label>
                                        </div>
                                        <div class="create-account-fields">
                                            <div class="checkout-form-group">
                                                <label class="input-label">Account username<abbr
                                                        class="required">*</abbr></label>
                                                <input type="text" id="username" name="username" required="required" class="form-control">
                                            </div>
                                            <div class="checkout-form-group">
                                                <label class="input-label">Create account password<abbr
                                                        class="required">*</abbr></label>
                                                <input type="password" id="password" name="password" required="required" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    @endguest
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout-right-fields">
                                    <div class="checkout-addition-fields">
                                        <div class="checkout-title-head">
                                            Additional information
                                        </div>
                                        <div class="additional-fields-wrap">
                                            <div class="checkout-form-group">
                                                <label class="input-label">Order notes<span
                                                        class="optional">(Optional)</span></label>
                                                <textarea id="order_notes" name="order_notes" required="required" class="form-control" placeholder="Notes about your order, e.g. special notes for delivery.">
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Checkout order section START -->
                    <div class="checkout-order-review">
                        <div class="checkout-title-head">
                            Your Order
                        </div>
                        <div class="checkout-order-table">
                            <table style="width:100%" border-collapse="collapse">
                                <thead>
                                    <tr>
                                        <th class="checkproduct-name">Product</th>
                                        <th class="checkproduct-total">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0 @endphp
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr class="checkcart-item">
                                            <td class="checkpr-name">
                                                {!! $details['name'] !!}
                                                <strong class="checkpr-quantity">x {{$details['quantity']}}</strong>
                                            </td>
                                            <td class="check-product-total">
                                                <span>{{MY_CURRENCY_SYMBOL}}{{ $details['price'] * $details['quantity'] }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="checkout-cart-subtotal">
                                        <th>Subtotal</th>
                                        <td>
                                            <strong>{{MY_CURRENCY_SYMBOL}}{{ $total }}</strong>
                                            <small class="tax_label"> (incl. VAT)</small>
                                        </td>
                                    </tr>
                                    <tr class="checkout-cart-total">
                                        <th>Total</th>
                                        <td>
                                            <strong>{{MY_CURRENCY_SYMBOL}}{{ $total }}</strong>
                                            <small class="tax_label">(includes £144.00 VAT)</small>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <input type="hidden" id="final_price" name="final_price" value="{{ $total }}">
                        <div class="checkout-payment-options">
                            <ul class="cc_payment_methods_options">
                                <li class="cc_payment_methods paypal_payment">
                                    <input type="radio" name="payment_type" checked required="required" value="paypal">
                                    <label class="paypal_label">
                                        Paypal
                                        <img src="{{asset('')}}assets/images/paypal-icon.png" alt="paypal">
                                        <a class="what-paypal" href="https://www.paypal.com/gb/webapps/mpp/paypal-popup" onclick="javascript:window.open('https://www.paypal.com/gb/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;">What is PayPal?</a>
                                    </label>
                                    <div class="payment-box-main-drop paypal-pay-box">
                                        Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                        account.
                                    </div>
                                </li>
                                <li class="cc_payment_methods via_deko_payment">
                                    <input type="radio" name="payment_type" required="required" value="dekopay">
                                    <label class="deko_label">
                                        Dekopay
                                        <img src="{{asset('')}}assets/images/dek_one.png" alt="deko">
                                    </label>
                                    <div class="payment-box-main-drop deko-pay-box" style="display:none;">
                                        <p>Pay securely by Credit or Debit card or internet banking through Dekopay
                                            Secure Servers.</p>
                                        <div class="deko_finance">
                                            <img src="../assets/images/Deko_square_colour_whiteBG200px_wide.png"
                                                alt="deko">
                                            <span> Finance Options </span>
                                        </div>
                                        <div class="payment-cc-details-box">
                                            <div class="payment-cc-details-inner">
                                                <div class="payment-cc-details-label">
                                                    Price :
                                                </div>
                                                <div class="payment-cc-details-values">
                                                    {{MY_CURRENCY_SYMBOL}}{{ $total }}
                                                </div>
                                            </div>
                                            <div class="payment-cc-details-inner">
                                                <div class="payment-cc-details-label">
                                                    Term :
                                                </div>
                                                <div class="payment-cc-details-values">
                                                    <select id="paymentccdetails" name="paymentccdetails">
                                                        <option value="12"> 12 Months Credit 16.9%</option>
                                                        <option value="18"> 18 Months Credit 16.9%</option>
                                                        <option value="24"> 24 Months Credit 16.9%</option>
                                                        <option value="36"> 36 Months Credit 16.9%</option>
                                                        <option value="48"> 48 Months Credit 16.9%</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="payment-cc-details-inner">
                                                <div class="payment-cc-details-label">
                                                    Deposit :
                                                </div>
                                                <div class="payment-cc-details-values">
                                                    <select id="depositepercentage" name="depositepercentage">
                                                        <option value="10">10%</option>
                                                        <option value="20">20%</option>
                                                        <option value="30">30%</option>
                                                        <option value="40">40%</option>
                                                        <option value="50">50%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cc_pay_details">
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Monthly Payment
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 70.45
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Cash Price
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 864.00
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Deposit to Pay
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 86.40
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Loan Amount
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 777.60
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Loan Repayment
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 845.39
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Cost of Loan
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 67.79
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Total Amount Payable
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    £ 931.79
                                                </div>
                                            </div>
                                            <div class="cc_pay_details_inner">
                                                <div class="cc_pay_details_label">
                                                    Number of Monthly Payments
                                                </div>
                                                <div class="cc_pay_details_values">
                                                    12
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cc_how_apply">
                                            <strong>HOW TO APPLY</strong>
                                            <span>Choose Dekopay as your payment method and place your order.</span>
                                            <span>Finance is only available to permanent UK residents aged between 18
                                                and 80, subject to status, terms and conditions apply. For more details
                                                about Dekopay please see <a href="#">Terms of Service</a> | <a
                                                    href="#">Privacy Policy</a> | <a href="#">FAQ.</a></span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="checkout-place-order">
                            <div class="cc-terms-and-conditions-wrapper">
                                Your personal data will be used to process your order, support your experience
                                throughout this website, and for other purposes described in our
                                <a href="#" target="_blank">Privacy Policy</a>
                            </div>
                            <div class="cc_place_order_btn">
                                @guest
                                    <a id="placeOrderDetails" href="javascript:void(0);" class="btn-bg-large">Place Order </a>
                                @endguest
                                @auth
                                    <button class="btn-bg-large" type="submit">Place Order</button>
                                @endauth
                            </div>
                        </div>
                    </div>
                    <!-- Checkout order section END -->
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $('.showlogin').on('click', function () {
            $(".checkout-login-form").toggle(200);
        });

        $('input[type=radio][name=payment_type]').on('change', function() {
            switch ($(this).val()) {
                case 'paypal':
                    // alert("paypal Thai Gayo Bhai");
                    $(".paypal-pay-box").show();
                    $(".deko-pay-box").hide();
                    break;
                case 'dekopay':
                    $(".paypal-pay-box").hide();
                    $(".deko-pay-box").show();
                    break;
            }
        });

    });

    $('form#loginRegisterForm').validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
            }
        },
        messages: {
            email: "Please specify a valid email address",
            password: "Please enter password"
        },
        submitHandler: function () {
            // return true;
            $.ajax({
                url: "{{ route('login.customer.account') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                success: function (response) {
                    console.log(response);
                    return false;
                    window.location.reload();
                }
            });
        }
    });

</script>

@endsection