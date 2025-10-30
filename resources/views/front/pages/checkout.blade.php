@extends('layouts.front.app')


@section('css')
    <style>
        .error {
            color: #e74c3c;
        }

        .stripeValidationerror {
            color: #8f5154;
            background: #f3dede;
            text-align: center;
            padding: 10px 0px;
            font-weight: 600;
            border: 1px solid #e3d0d4;
            margin: 0px 14px 14px;
        }
        
        /* Payment Method Styling */
        .payment-method-content {
            padding: 20px;
        }
        
        .payment-button-container {
            margin: 15px auto;
            max-width: 400px;
            min-height: 40px;
        }
        
        .payment-features {
            margin: 15px 0;
            padding: 0;
            list-style: none;
        }
        
        .payment-features li {
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
        }
        
        .payment-features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #8e2e65;
        }
        
        /* PayPal and Google Pay Button Containers */
        #paypal-button-container,
        #googlepay-button-container {
            width: 100%;
            margin: 10px auto;
        }
    </style>
@endsection

@section('content')

    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    @if (\Session::has('fail-message'))
        <div class="alert alert-danger">
            {!! \Session::get('fail-message') !!}
        </div>
    @endif

    <div class="checkout-wraper">
        <div class="container">
            <div class="checkout-container">
                @if (!Auth::guard('customer')->check())
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
                            <p>If you have shopped with us before, please enter your details below. If you are a new
                                customer,
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
                                <a class="btn-bg-small" href="{{ asset('my-account') }}">
                                    Signup
                                </a>
                                <!-- <label class="rememberme">
                                                                                                                                                                                                <input type="checkbox">
                                                                                                                                                                                                <span>Remember me</span>
                                                                                                                                                                                            </label> -->
                            </div>
                            <!-- <div class="lostpassword">
                                                                                                                                                                                            <a href="javascript:void(0)">Lost your password</a>
                                                                                                                                                                                        </div> -->
                        </form>
                    </div>
                @endif


                <!-- login form end-->
                <div class="checkout-main-wrap">
                    <!--<div class="checkout-table">

                                                                                                                                                                                        <ul>
                                                                                                                                                                                            <li><span class="active">1</span>Shipping</li>
                                                                                                                                                                                            <li><span>2</span>Payment</li>
                                                                                                                                                                                        </ul>

                                                                                                                                                                                    </div> -->

                    <form id="finalPlaceOrderPage">
                        @csrf
                        <div class="customer-details-check">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout-left-fields">
                                        <div class="checkout-billing-fields">
                                            <div class="checkout-title-head">
                                                Billing Address
                                            </div>
                                            <div class="billin-fields-wrap">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">First Name <abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text" id="first_name" name="first_name"
                                                                required="required"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->first_name) ? $getUsersDetails->getCustomerAddressFunction->first_name : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Last Name <abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text" id="last_name" name="last_name"
                                                                required="required"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->last_name) ? $getUsersDetails->getCustomerAddressFunction->last_name : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Street address <abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text" id="street_address_l1"
                                                                name="street_address_l1"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->street_address_l1) ? $getUsersDetails->getCustomerAddressFunction->street_address_l1 : '' }}"
                                                                required="required" class="form-control"
                                                                placeholder="House number and street name">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Town / City <abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->town_city) ? $getUsersDetails->getCustomerAddressFunction->town_city : '' }}"
                                                                id="town_city" name="town_city" required="required"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">State/Region<abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->state) ? $getUsersDetails->getCustomerAddressFunction->state : '' }}"
                                                                id="state" name="state" required="required"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Country/Region <abbr
                                                                    class="required">*</abbr></label>
                                                            <select id="country_id" name="country_id" required="required"
                                                                class="form-control">
                                                                <option value="">Select Option</option>
                                                                @foreach ($getCountries as $key => $country)
                                                                    @if (isset($getUsersDetails->getCustomerAddressFunction->country_id) &&
                                                                            $getUsersDetails->getCustomerAddressFunction->country_id == $country->shortname)
                                                                        <option value="{{ $country->shortname }}" selected>
                                                                            {{ $country->name }}</option>
                                                                    @else
                                                                        <option value="{{ $country->shortname }}">
                                                                            {{ $country->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Postcode <abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->pin_code) ? $getUsersDetails->getCustomerAddressFunction->pin_code : '' }}"
                                                                id="pin_code" name="pin_code" required="required"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Phone<abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text"
                                                                value="{{ isset($getUsersDetails->getCustomerAddressFunction->mobile) ? $getUsersDetails->getCustomerAddressFunction->mobile : '' }}"
                                                                id="mobile" name="mobile" required="required"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="emailCheck" class="checkout-form-group">
                                                            <label class="input-label">Email address<abbr
                                                                    class="required">*</abbr></label>
                                                            <input type="text" id="cust_email" name="cust_email"
                                                                required="required"
                                                                value="{{ isset(auth()->user()->email) ? auth()->user()->email : '' }}"
                                                                @if (isset(auth()->user()->email)) readonly disable @endif
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @guest
                                            {{-- <div class="checkout-create-account">
                                            <div class="create-account-checkbox">
                                                <input type="checkbox" id="showRegisterDiv" name="showregistercheck">
                                                <label>Create an Account?</label>
                                            </div>
                                            <div class="create-account-fields showregisterform" style="display: none;">
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Account username<abbr
                                                            class="required">*</abbr></label>
                                                    <input type="text" id="cust_username" name="cust_username" required="required" class="form-control">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Create account password<abbr
                                                            class="required">*</abbr></label>
                                                    <input type="password" id="cust_password" name="cust_password" required="required" class="form-control">
                                                </div>
                                            </div>
                                        </div> --}}
                                        @endguest
                                    </div>



                                    <div class="billing-check">
                                        <input type="checkbox" checked class="checkshippingaddress" id="custom-checkBox2"
                                            name="checkshippingaddress" onchange="valueChanged()" />
                                        <h4>Shipping address same as billing </h4>
                                    </div>

                                    <div class="customer-details-check billing-detail-show">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkout-left-fields">
                                                    <div class="checkout-billing-fields">
                                                        <div class="checkout-title-head">
                                                            Shipping Address
                                                        </div>
                                                        <div class="billin-fields-wrap">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">First Name <abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text" id="first_shipping_name"
                                                                            name="first_shipping_name" required="required"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->first_name) ? $getUsersDetails->getCustomerShippingAddressFunction->first_name : '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">Last Name <abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text" id="last_shipping_name"
                                                                            name="last_shipping_name" required="required"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->last_name) ? $getUsersDetails->getCustomerShippingAddressFunction->last_name : '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">Street address <abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text"
                                                                            id="street_address_shipping_l1"
                                                                            name="street_address_shipping_l1"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->street_address_l1) ? $getUsersDetails->getCustomerShippingAddressFunction->street_address_l1 : '' }}"
                                                                            required="required" class="form-control"
                                                                            placeholder="House number and street name">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">Town / City <abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->town_city) ? $getUsersDetails->getCustomerShippingAddressFunction->town_city : '' }}"
                                                                            id="town_shipping_city"
                                                                            name="town_shipping_city" required="required"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">State/Region<abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->state) ? $getUsersDetails->getCustomerShippingAddressFunction->state : '' }}"
                                                                            id="shipping_state" name="shipping_state"
                                                                            required="required" class="form-control">
                                                                        {{-- <select id="state" name="state" required="required" class="form-control">
                                                                            <option>Select Option</option>
                                                                            <option>Rajasthan</option>
                                                                        </select> --}}
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">Country/Region <abbr
                                                                                class="required">*</abbr></label>
                                                                        <select id="country_shipping_id"
                                                                            name="country_shipping_id" required="required"
                                                                            class="form-control">
                                                                            <option value="">Select Option</option>
                                                                            @foreach ($getCountries as $key => $country)
                                                                                @if (isset($getUsersDetails->getCustomerShippingAddressFunction->country_id) &&
                                                                                        $getUsersDetails->getCustomerShippingAddressFunction->country_id == $country->shortname)
                                                                                    <option
                                                                                        value="{{ $country->shortname }}"
                                                                                        selected>{{ $country->name }}
                                                                                    </option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $country->shortname }}">
                                                                                        {{ $country->name }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">Postcode <abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->pin_code) ? $getUsersDetails->getCustomerShippingAddressFunction->pin_code : '' }}"
                                                                            id="pin_shipping_code"
                                                                            name="pin_shipping_code" required="required"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="checkout-form-group">
                                                                        <label class="input-label">Phone<abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text"
                                                                            value="{{ isset($getUsersDetails->getCustomerShippingAddressFunction->mobile) ? $getUsersDetails->getCustomerShippingAddressFunction->mobile : '' }}"
                                                                            id="shipping_mobile" name="shipping_mobile"
                                                                            required="required" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="emailCheck" class="checkout-form-group">
                                                                        <label class="input-label">Email address<abbr
                                                                                class="required">*</abbr></label>
                                                                        <input type="text" id="cust_shipping_email"
                                                                            name="cust_shipping_email" required="required"
                                                                            value="{{ isset(auth()->user()->email) ? auth()->user()->email : '' }}"
                                                                            @if (isset(auth()->user()->email)) readonly disable @endif
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @guest
                                                        {{-- <div class="checkout-create-account">
                                                        <div class="create-account-checkbox">
                                                            <input type="checkbox" id="showRegisterDiv" name="showregistercheck">
                                                            <label>Create an Account?</label>
                                                        </div>
                                                        <div class="create-account-fields showregisterform" style="display: none;">
                                                            <div class="checkout-form-group">
                                                                <label class="input-label">Account username<abbr class="required">*</abbr></label>
                                                                <input type="text" id="cust_username" name="cust_username" required="required" class="form-control">
                                                            </div>
                                                            <div class="checkout-form-group">
                                                                <label class="input-label">Create account password<abbr class="required">*</abbr></label>
                                                                <input type="password" id="cust_password" name="cust_password" required="required" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    @endguest
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="col-lg-6">
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
                                                        <th class="checkproduct-price">Price</th>
                                                        <th class="checkproduct-total">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $total = 0;
                                                        $totalPrice = 0;
                                                        $depositedPrice = 0;
                                                    @endphp
                                                    @if (session('cart'))
                                                        @foreach (session('cart') as $id => $details)
                                                            @php
                                                                $total +=
                                                                    $details['deposited_price'] * $details['quantity'];
                                                                $totalPrice += $details['price'] * $details['quantity'];
                                                                $depositedPrice +=
                                                                    $details['deposited_price'] * $details['quantity'];
                                                            @endphp
                                                            <tr class="checkcart-item">
                                                                <td class="checkpr-name">
                                                                    @if (isset($details['customArray']['slug']) && !empty($details['customArray']['slug']))
                                                                        <div class="cartproduct-title"><a
                                                                                href="{{ asset('product/' . $details['customArray']['slug']) }}">
                                                                                {{ $details['name'] }}</a></div>
                                                                    @else
                                                                        <div class="cartproduct-title"><a
                                                                                href="javascript:void(0);">
                                                                                {{ $details['name'] }}</a></div>
                                                                    @endif
                                                                    {{-- <div class="cartproduct-title"><a href="{{asset('product/'.$details['customArray']['slug'])}}"> {{ $details['name'] }}</a>
                                        </div> --}}
                                                                    <dl class="variation">
                                                                        @if (isset($details['customArray']['choose_diamond']) && !empty($details['customArray']['choose_diamond']))
                                                                            <dt class="variation-Colour">Choose Your
                                                                                Diamond:&nbsp; </dt>
                                                                            <dd class="variation-Colour">
                                                                                <p> {{ $details['customArray']['choose_diamond'] == 'lab_grown' ? 'Lab Grown' : 'Mined' }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['metal_type']) && !empty($details['customArray']['metal_type']))
                                                                            <dt class="variation-Colour">Metal:&nbsp; </dt>
                                                                            <dd class="variation-Colour">
                                                                                <p> {{ $details['customArray']['metal_type'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['fingersize']) && !empty($details['customArray']['fingersize']))
                                                                            <dt class="variation-FingerSize">Finger
                                                                                Size:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['fingersize'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['width-mm']) && !empty($details['customArray']['width-mm']))
                                                                            <dt class="variation-FingerSize">Width
                                                                                MM:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['width-mm'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['total-diamond-weight']) && !empty($details['customArray']['total-diamond-weight']))
                                                                            <dt class="variation-FingerSize">Diamond
                                                                                Weight:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['total-diamond-weight'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['Shape']) && !empty($details['customArray']['Shape']))
                                                                            <dt class="variation-FingerSize">Diamond
                                                                                Shape:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['Shape'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['Carat']) && !empty($details['customArray']['Carat']))
                                                                            <dt class="variation-FingerSize">Diamond
                                                                                Carat:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['Carat'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @elseif(isset($details['customArray']['carat']) && !empty($details['customArray']['carat']))
                                                                            <dt class="variation-FingerSize">Diamond
                                                                                Carat:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['carat'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['Color']) && !empty($details['customArray']['Color']))
                                                                            <dt class="variation-FingerSize">Diamond
                                                                                Color:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['Color'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['Clarity']) && !empty($details['customArray']['Clarity']))
                                                                            <dt class="variation-FingerSize">Diamond Cut
                                                                                Grade:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['Clarity'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['Lab']) && !empty($details['customArray']['Lab']))
                                                                            <dt class="variation-FingerSize">
                                                                                Certificate:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['Lab'] }}</p>
                                                                            </dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['CertificateLink']) && !empty($details['customArray']['CertificateLink']))
                                                                            <dt class="variation-FingerSize">Certificate
                                                                                Link:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize"><a
                                                                                    target="_blank"
                                                                                    href="{{ $details['customArray']['CertificateLink'] }}">View
                                                                                    Certificate</a></dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                                                                            <dt class="variation-FingerSize">Image:&nbsp;
                                                                            </dt>
                                                                            <dd class="variation-FingerSize"><a
                                                                                    target="_blank"
                                                                                    href="{{ $details['customArray']['ImageLink'] }}">View
                                                                                    Diamond</a></dd>
                                                                        @endif
                                                                        @if (isset($details['customArray']['CERT_NO']) && !empty($details['customArray']['CERT_NO']))
                                                                            <dt class="variation-FingerSize">
                                                                                Certificate:&nbsp; </dt>
                                                                            <dd class="variation-FingerSize">
                                                                                <p>{{ $details['customArray']['CERT_NO'] }}
                                                                                </p>
                                                                            </dd>
                                                                        @endif
                                                                        {{-- @if (isset($details['customArray']['metal_type']) && $details['customArray']['metal_type'] == 'Silver') --}}
                                                                        <div class="plancare-section">
                                                                            <h5>Jewellery Care Plan</h5>
                                                                            <select class="form-control"
                                                                                name="yearlySupport[]"
                                                                                id="yearlySupport{{ $id }}">
                                                                                <option value="0"
                                                                                    @if (isset($details['yearlySupport']) && $details['yearlySupport'] == 0) selected @endif>
                                                                                    No applied</option>
                                                                                <option value="89"
                                                                                    @if (isset($details['yearlySupport']) && $details['yearlySupport'] == 89) selected @endif>
                                                                                    1 year
                                                                                    {{ config('constants.MY_CURRENCY_SYMBOL') }}89
                                                                                </option>
                                                                                <option value="170"
                                                                                    @if (isset($details['yearlySupport']) && $details['yearlySupport'] == 170) selected @endif>
                                                                                    2 years
                                                                                    {{ config('constants.MY_CURRENCY_SYMBOL') }}170
                                                                                </option>
                                                                                <option value="220"
                                                                                    @if (isset($details['yearlySupport']) && $details['yearlySupport'] == 220) selected @endif>
                                                                                    3 years
                                                                                    {{ config('constants.MY_CURRENCY_SYMBOL') }}220
                                                                                </option>
                                                                                <option value="300"
                                                                                    @if (isset($details['yearlySupport']) && $details['yearlySupport'] == 300) selected @endif>
                                                                                    4 years
                                                                                    {{ config('constants.MY_CURRENCY_SYMBOL') }}300
                                                                                </option>
                                                                                <option value="400"
                                                                                    @if (isset($details['yearlySupport']) && $details['yearlySupport'] == 400) selected @endif>
                                                                                    5 years
                                                                                    {{ config('constants.MY_CURRENCY_SYMBOL') }}400
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        {{-- @endif --}}
                                                                    </dl>
                                                                    <strong class="checkpr-quantity">x
                                                                        {{ $details['quantity'] }}</strong>
                                                                </td>
                                                                <td>
                                                                    @if (isset($details['rrp_price']) && !empty($details['rrp_price']))
                                                                        {{-- <p>
                                                <span> RRP: </span>
                                                <del>{{config('constants.MY_CURRENCY_SYMBOL')}} {{$details['rrp_price']}}</del>
                                            </p> --}}
                                                                    @endif
                                                                    <!-- <p> <span> Save Price: </span> {{ config('constants.MY_CURRENCY_SYMBOL') }} {{ isset($details['savePrice']) ? $details['savePrice'] : '' }}</p> -->
                                                                    @if (isset($details['shop_price']) && !empty($details['shop_price']))
                                                                        @if ($details['price'] != $details['shop_price'])
                                                                            {{-- <p>
                                                    <span> Our Price: </span>
                                                    <del> {{config('constants.MY_CURRENCY_SYMBOL')}}{{ isset($details['shop_price'])?$details['shop_price']:'' }}</del>
                                                </p> --}}
                                                                        @endif
                                                                    @endif
                                                                    <span id="productPrice{{ $id }}">
                                                                        @if (isset($details['customArray']['final_price']) &&
                                                                                !empty($details['customArray']['final_price']) &&
                                                                                $details['customArray']['final_price'] != $details['price']
                                                                        )
                                                                            <span> Our Price: </span>
                                                                            <del>{{ config('constants.MY_CURRENCY_SYMBOL') }}{{ $details['customArray']['final_price'] }}
                                                                            </del>
                                                                        @endif <br>
                                                                        @if (isset($details['customArray']['choose_diamond']) && $details['customArray']['choose_diamond'] == 'lab_grown')
                                                                            {{ config('constants.MY_CURRENCY_SYMBOL') }}{{ $details['price'] }}
                                                                        @else
                                                                            {{ config('constants.MY_CURRENCY_SYMBOL') }}{{ $details['price'] }}
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                                <td class="check-product-total">
                                                                    <span
                                                                        id="subtotalPrice{{ $id }}">{{ config('constants.MY_CURRENCY_SYMBOL') }}{{ round($details['deposited_price'], 2) }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr class="checkout-cart-subtotal">
                                                        <th>Subtotal</th>
                                                        <td id="subTotalPrices">
                                                            <strong>{{ config('constants.MY_CURRENCY_SYMBOL') }}{{ round($total, 2) }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr class="checkout-cart-total">
                                                        <th>Total</th>
                                                        <td id="totalFinalPrices">
                                                            <strong>{{ config('constants.MY_CURRENCY_SYMBOL') }}{{ round($total, 2) }}</strong>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        @if (isset($details['customArray']['choose_diamond']) && $details['customArray']['choose_diamond'] == 'lab_grown')
                                            {{-- <div class="checkout-coupan-code">
                                                <label for="coupon_code">Coupon Code</label>
                                                <input type="text" name="coupon_code" value="{{isset($details['couponCodeText'])?$details['couponCodeText']:''}}" id="coupon_code{{$id}}" class="form-control">
                                                @if (isset($details['couponCodeText']) && !empty($details['couponCodeText']))
                                                    <span id="couponCodeMessage{{$id}}"></span>
                                                    <a id="applyCouponCode{{$id}}" href="javascript:void(0)">
                                                        Applied
                                                    </a>
                                                @else
                                                    <span id="couponCodeMessage{{$id}}"></span>
                                                    <a id="applyCouponCode{{$id}}" href="javascript:void(0)">
                                                        Apply
                                                    </a>
                                                @endif
                                            </div> --}}
                                        @endif
                                        <input type="hidden" id="final_price" name="final_price"
                                            value="{{ $total }}">
                                        <input type="hidden" id="total_price" name="total_price"
                                            value="{{ $totalPrice }}">
                                        <input type="hidden" id="deposited_price" name="deposited_price"
                                            value="{{ $depositedPrice }}">
                                        <input type="hidden" id="selected_payment_type" name="selected_payment_type"
                                            value="paypal">
                                        <input type="hidden" id="already_inserted" name="already_inserted"
                                            value="">

                                        <div
                                            style="color: #000; font-size: 18px; font-weight: bold; margin: 15px 0; text-align: center;">
                                            <span style="color: #8e2e65;">Apple Pay</span> accepted (through Apple devices)
                                        </div>
                                        <div class="checkout-payment-options">
                                            <ul class="cc_payment_methods_options">

                                                {{-- previous paypal --}}
                                                @include('front.pages.payments.paypal', [
                                                    'totalAmount' => $total,
                                                ])

                                                {{-- new payapl integration --}}
                                                {{-- <div id="paypal-button-container"></div>
                                                     <div id="paypal-marks-container"></div> --}}
                                                {{-- <div id="container"></div> --}}




                                                <!-- Google Pay with PayPal Integration -->
                                                <li class="cc_payment_methods googlepay_payment googlepaygateway_wrap">
                                                    <div class="google_pay_button">
                                                        <input type="radio" name="payment_type" id="googlepay_radio"
                                                            value="googlepay" autocomplete="off">
                                                        <label class="googlepay_label" for="googlepay_radio">
                                                            Google Pay
                                                            <a class="what-googlepay" href="https://pay.google.com/about/"
                                                                target="_blank">What is Google Pay?</a>
                                                        </label>
                                                    </div>
                                                    <i class="diamond-icon payment-checkout"></i>
                                                    <div class="payment-box-main-drop googlepay-box">
                                                        <div class="payment-method-content">
                                                            <p>Pay securely with Google Pay:</p>
                                                            <!-- PayPal's Google Pay Button Container -->
                                                            <div id="googlepay-button-container" class="payment-button-container"></div>
                                                            <ul class="payment-features">
                                                                <li>Fast and secure checkout</li>
                                                                <li>Your payment details are protected</li>
                                                                <li>No need to enter card details manually</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>


                                                {{-- <div class="container">
                                                        <h3>Apple Pay with PayPal Integration</h3>
                                                        <h6>Test Transaction (Live)</h6>
                                                        <div id="applepay-container"></div>
                                                        <div><i>Use Apple Pay test cards for the sandbox environment.</i></div>
                                                    </div> --}}

                                                {{-- <ul> --}}
                                                <li class="cc_payment_methods applepay_payment applepaygateway_wrap"
                                                    style="display: none;">
                                                    <input type="radio" name="payment_type" id="applepay_radio"
                                                        value="applepay" autocomplete="off">
                                                    <label class="applepay_label" for="applepay_radio">
                                                        Apple Pay
                                                        <a class="what-applepay" href="https://www.apple.com/apple-pay/"
                                                            target="_blank">
                                                            What is Apple Pay?
                                                        </a>
                                                    </label>
                                                    <i class="diamond-icon payment-checkout"></i>
                                                    <div class="payment-box-main-drop applepay-box"
                                                        style="display: none;">
                                                        Pay securely via Apple Pay using your iPhone, iPad, or Mac.
                                                    </div>
                                                    <div id="applepay-button-container" class="applepay-button-container"
                                                        style="display:none"></div>
                                                </li>



                                                <!-- Klarna Payment Option -->
                                                <li class="cc_payment_methods klarna_payment klarnagateway_wrap">
                                                    <input type="radio" name="payment_type" id="klarna_radio"
                                                        value="klarna" autocomplete="off">
                                                    <label class="klarna_label" for="klarna_radio">
                                                        Klarna
                                                        <a class="what-klarna" href="https://www.klarna.com/"
                                                            target="_blank">
                                                            What is Klarna?
                                                        </a>
                                                    </label>
                                                    <i class="diamond-icon payment-checkout"></i>
                                                    <div class="payment-box-main-drop klarna-box" style="display: none;">
                                                        Pay securely via Klarna. Flexible payment options available.
                                                    </div>
                                                    <div id="klarna_container" class="klarna-button-container"
                                                        style="display: none;"></div>
                                                </li>
                                                {{-- </ul> --}}
                                                {{-- <div id="container"></div> --}}
                                                {{-- @include('front.pages.payments.dekopay',['totalAmount'=>$total])
                                            @include('front.pages.payments.stripepay',['totalAmount'=>$total]) --}}
                                            </ul>
                                        </div>

                                        <div class="checkout-place-order">
                                            <div class="cc-terms-and-conditions-wrapper">
                                                Your personal data will be used to process your order, support your
                                                experience
                                                throughout this website, and for other purposes described in our
                                                <a href="{{ asset('privacy-policy') }}" target="_blank">Privacy
                                                    Policy</a>
                                            </div>
                                            <div class="cc_place_order_btn">
                                                @guest
                                                    <!-- <a id="placeOrderDetails" href="javascript:void(0);" class="btn-bg-large">Place Order </a> -->
                                                @endguest
                                                @auth
                                                @endauth
                                                <button id="place-order" class="btn-bg-large" type="submit">Place
                                                    Order</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Checkout order section END -->

                                </div>


                                {{-- <div class="col-lg-6">
                                    <div class="checkout-right-fields">
                                        <div class="checkout-addition-fields">
                                            <div class="checkout-title-head">
                                                Additional information
                                            </div>
                                            <div class="additional-fields-wrap">
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Order notes<span
                                                            class="optional">(Optional)</span></label>
                                                    <textarea id="order_shipping_notes" name="order_shipping_notes" required="required" class="form-control" placeholder="Notes about your order, e.g. special notes for delivery."> {{isset($getUsersDetails->getCustomerShippingAddressFunction->order_notes)?$getUsersDetails->getCustomerShippingAddressFunction->order_notes:''}}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div> --}}
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('front.pages.stripeform', ['totalAmount' => $total])
@endsection

@section('js')
    <script src="https://x.klarnacdn.net/kp/lib/v1/api.js" async></script>
    <script>
    // Pull values from config instead of calling env() in views
    const environmentCheckPhp = "{{ config('app.env') }}";
    const PAYPAL_CLIENT_ID_PHP = "{{ config('paypal.client_id') }}";
    const PAYPAL_SECRET_PHP = "{{ config('paypal.secret') }}";
    const PAYPAL_BASE_URL_PHP = "{{ config('paypal.base_url') }}";
    const PAYPAL_BASE_NEW_URL_PHP = "{{ config('paypal.base_new_url') }}";
    </script>
    @php
        if (config('app.env') == 'production') {
            $paypalClientId = config('paypal.client_id');
            $paypalEnvironment = 'production';
        } else {
            $paypalClientId = config('paypal.client_id');
            $paypalEnvironment = 'sandbox';
        }
    @endphp
    
    <!-- PayPal SDK with Google Pay Component -->
    <script src="https://www.paypal.com/sdk/js?components=buttons,googlepay&client-id={{ $paypalClientId }}&currency=GBP&buyer-country=GB"></script>
    
    <!-- PayPal + Google Pay Integration -->
    <script>
    // Verify PayPal SDK loaded correctly
    window.addEventListener('load', function() {
        if (!window.paypal) {
            console.error('PayPal SDK failed to load');
            // Hide payment methods that require PayPal SDK
            document.querySelectorAll('.googlepay_payment, .paypal_payment').forEach(el => {
                el.style.display = 'none';
            });
            return;
        }
        // PayPal button configuration
        const paypalButtonsConfig = {
            // Create order on PayPal servers
            createOrder: async (data, actions) => {
                // Get order details from form
                const orderData = {
                    amount: parseFloat(document.getElementById('final_price').value),
                    currency: 'GBP'
                };

                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: orderData.amount.toFixed(2),
                            currency_code: orderData.currency
                        }
                    }]
                });
            },
            // Handle PayPal approval
            onApprove: async (data, actions) => {
                document.getElementById("loader-overlay").style.display = "flex";
                try {
                    const captureResult = await actions.order.capture();
                    // Send capture result to your server
                    await fetch('/api/paypal/capture-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            captureResult: captureResult
                        })
                    });
                    
                    // Show success message and redirect
                    window.location.href = '/order/success';
                } catch (error) {
                    console.error('Payment capture failed:', error);
                    document.getElementById("loader-overlay").style.display = "none";
                    alert('Payment failed. Please try again.');
                }
            }
        };

        // Google Pay configuration
        const googlePayConfig = {
            buttonColor: 'black', // or 'white'
            buttonType: 'pay',    // or 'plain'
            // Create order when Google Pay is clicked
            createOrder: paypalButtonsConfig.createOrder,
            // Handle successful payment
            onApprove: paypalButtonsConfig.onApprove
        };

        // Initialize buttons when PayPal SDK is loaded
        window.paypal.Buttons(paypalButtonsConfig)
            .render('#paypal-button-container')
            .catch(err => {
                console.error('PayPal Buttons failed to render:', err);
            });

        // Initialize Google Pay button when available
        window.paypal.Googlepay(googlePayConfig)
            .render('#googlepay-button-container')
            .catch(err => {
                console.error('Google Pay failed to render:', err);
                // Hide Google Pay container if not available
                document.getElementById('googlepay-button-container').style.display = 'none';
            });
    </script>
    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    <script src="https://applepay.cdn-apple.com/jsapi/1/latest/apple-pay-sdk.js"></script>
    {{-- <script src="{{ asset('/applepay_sdk/app.js') }}"></script> --}}
    <script src="{{ mix('js/applepay_checkout_code.min.js') }}"></script>
    {{-- <script src="{{$url}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script>
        $(document).ready(function() {
            // Hide all payment boxes initially
            $(".payment-box-main-drop").hide();
            // Show the checked one (on page load)
            $("input[name='payment_type']:checked").closest("li").find(".payment-box-main-drop").slideDown();

            $(document).on('change', "[id^=yearlySupport]", function() {
                  document.getElementById("loader-overlay").style.display = "flex";   
                var index = parseInt($(this).attr("id").replace("yearlySupport", ''));
                $.ajax({
                    url: "{{ route('update.cart.coupon') }}",
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        cartid: index,
                        price: $(this).val(),
                        priceStatus: 1,
                    },
                    success: function(response) {
                        if (response.result.status == 501) {
                            toastr.info(response.result.msg);
                            return false;

                        }
                        $.each(response.result.sessionCartValues, function(keyIndex, value) {
                            $('#subtotalPrice' + keyIndex).text(
                                '{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                                value.deposited_price.toFixed(2));
                            $('#totalFinalPrices' + keyIndex).text(
                                '{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                                response.finalPrice);
                        });
                        $('#subTotalPrices').html(
                            '<strong>{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                            response.result.finalPrice + '</strong>');
                        $('#totalFinalPrices').html(
                            '<strong>{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                            response.result.finalPrice + '</strong>');
                        $('#deposited_price').val(response.result.finalPrice);
                        $('#final_price').val(response.result.finalPrice);
                        /** For dekopay */
                        $("#totalOrder").val(response.result.finalPrice);
                        $(".totalP-dekopay").text(response.result.finalPrice);
                        // get_deko_data();
                        /** End of dekopay */
                        $('#totalP').val(response.result.finalPrice);
                        $('#loader-overlay').hide(); 
                        toastr.success(response.result.errormsg);
                    }
                });
            });
            $(document).on('click', "[id^=applyCouponCode]", function() {
                var index = parseInt($(this).attr("id").replace("applyCouponCode", ''));
                $.ajax({
                    url: "{{ route('update.cart.coupon') }}",
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        cartid: index,
                        coupon_code: $('#coupon_code' + index).val(),
                        coupon_status: 1
                    },
                    success: function(response) {
                        $.each(response.sessionCartValues, function(keyIndex, value) {
                            $('#subtotalPrice' + keyIndex).text(
                                '{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                                value.deposited_price.toFixed(2));
                            $('#totalFinalPrices' + keyIndex).text(
                                '{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                                response.finalPrice);
                            // console.log(keyIndex + ": " + value.deposited_price.toFixed(2));
                            // console.log("checking again ");
                            $('#applyCouponCode' + keyIndex).text(response.statustext);
                            $('#couponCodeMessage' + keyIndex).html(response.errormsg);
                            $('#coupon_code' + keyIndex).val(value.couponCodeText);
                            // alert( index + ": " + value );
                        });
                        $('#subTotalPrices').html(
                            '<strong>{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                            response.finalPrice + '</strong>');
                        $('#totalFinalPrices').html(
                            '<strong>{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                            response.finalPrice + '</strong>');
                        $('#deposited_price').val(response.finalPrice);

                        // console.log(response);
                        // return false;
                        // // window.location.reload();
                        // if(response.status == 200){

                        //     $('#totalFinalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        //     $('#applyCouponCode'+index).text(response.statustext);
                        //     $('#subtotalPrice'+index).html('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.deposited_price);
                        //     $('#deposited_price').val(response.finalPrice);
                        //     $('#couponCodeMessage'+index).html(response.errormsg);
                        // }else if(response.status == 500){
                        //     $('#applyCouponCode'+index).text(response.statustext);
                        //     $('#subtotalPrice'+index).html('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.deposited_price);
                        //     $('#couponCodeMessage'+index).html(response.errormsg);
                        //     $('#subTotalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        //     $('#deposited_price').val(response.finalPrice);
                        //     $('#totalFinalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        // }
                    }
                });
            });

            $(document).on('click', "[id^=applyCouponCodeCancel]", function() {
                var index = parseInt($(this).attr("id").replace("applyCouponCodeCancel", ''));
                $.ajax({
                    url: "{{ route('update.cart.coupon') }}",
                    method: "patch",
                    data: {
                        _token: '{{ csrf_token() }}',
                        cartid: index,
                        coupon_code: $('#coupon_code' + index).val(),
                        coupon_status: 2
                    },
                    success: function(response) {
                        $.each(response.sessionCartValues, function(keyIndex, value) {
                            $('#subtotalPrice' + keyIndex).text(
                                '{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                                value.deposited_price.toFixed(2));
                            $('#totalFinalPrices' + keyIndex).text(
                                '{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                                response.finalPrice);
                            // console.log(keyIndex + ": " + value.deposited_price.toFixed(2));
                            // console.log("checking again ");
                            $('#applyCouponCode' + keyIndex).text(response.statustext);
                            $('#couponCodeMessage' + keyIndex).html(response.errormsg);
                            $('#coupon_code' + keyIndex).val(value.couponCodeText);
                            // alert( index + ": " + value );
                        });
                        $('#subTotalPrices').html(
                            '<strong>{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                            response.finalPrice + '</strong>');
                        $('#totalFinalPrices').html(
                            '<strong>{{ config('constants.MY_CURRENCY_SYMBOL') }} ' +
                            response.finalPrice + '</strong>');
                        $('#deposited_price').val(response.finalPrice);
                        // console.log(response);

                        // $('#subtotalPrice'+index).html('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.deposited_price);
                        // window.location.reload();
                        // if(response.status == 200){
                        //     $('#subTotalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        //     $('#totalFinalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        //     $('#applyCouponCode'+index).text(response.statustext);
                        //     $('#subtotalPrice'+index).html('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.deposited_price);
                        //     $('#deposited_price').val(response.finalPrice);
                        //     $('#couponCodeMessage'+index).html(response.errormsg);
                        // }else if(response.status == 500){
                        //     $('#applyCouponCode'+index).text(response.statustext);
                        //     $('#subtotalPrice'+index).html('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.deposited_price);
                        //     $('#couponCodeMessage'+index).html(response.errormsg);
                        //     $('#subTotalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        //     $('#deposited_price').val(response.finalPrice);
                        //     $('#totalFinalPrices').text('{{ config('constants.MY_CURRENCY_SYMBOL') }} '+response.finalPrice);
                        // }
                    }
                });
            });

            $('#card_number').mask('0000 0000 0000 0000');
            $('#cvv_number').mask('000');
            $('#expiry_month').mask('00');
            $('#expiry_year').mask('0000');

            $('#stripePayModal').on('click', 'button.close', function(eventObject) {
                $('#stripePayModal').modal('hide');
            });

            $('.showlogin').on('click', function() {
                $(".checkout-login-form").toggle(200);
            });

            $('#showRegisterDiv').on('change', function() {
                $('.showregisterform').toggle();
            });

            $('input[type=radio][name=payment_type]').on('change', function() {
                $('#selected_payment_type').val($(this).val());
                $('#already_inserted').val('');
                $(".payment-box-main-drop").slideUp(); // hide all
                $(this).closest("li").find(".payment-box-main-drop").slideDown(); // show selected
                switch ($(this).val()) {
                    case 'paypal':
                        $(".via_deko_payment").removeClass('dekopaymentgateway_wrap');
                        $(".stripe_payment").removeClass('stripepaymentgateway_wrap');
                        $(".paypal_payment").addClass('paypalpaymentgateway_wrap');
                        $(".paypal-pay-box").show('slow');
                        $(".deko-pay-box").hide('slow');
                        $(".stripe-pay-box").hide('slow');
                        break;
                    case 'dekopay':
                        $(".stripe_payment").removeClass('stripepaymentgateway_wrap');
                        $(".paypal_payment").removeClass('paypalpaymentgateway_wrap');
                        $(".via_deko_payment").addClass('dekopaymentgateway_wrap');
                        $(".paypal-pay-box").hide('slow');
                        $(".deko-pay-box").show('slow');
                        $(".stripe-pay-box").hide('slow');
                        break;
                    case 'stripe':
                        $(".via_deko_payment").removeClass('dekopaymentgateway_wrap');
                        $(".paypal_payment").removeClass('paypalpaymentgateway_wrap');
                        $(".stripe_payment").addClass('stripepaymentgateway_wrap');
                        $(".paypal-pay-box").hide('slow');
                        $(".deko-pay-box").hide('slow');
                        $(".stripe-pay-box").show('slow');
                        break;
                }
            });

        });

        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s]+$/i.test(value);
        }, "Letters only please");

        $('form#payment-form').validate({
            rules: {
                name_of_card: {
                    required: true,
                    lettersonly: true,
                },
                card_number: {
                    required: true,
                },
                cvv_number: {
                    required: true,
                },
                expiry_month: {
                    required: true,
                    number: true
                },
                expiry_year: {
                    required: true,
                    number: true
                }
            },
            messages: {
                name_of_card: {
                    required: "Name of card is required",
                },
                card_number: "Card number is required",
                cvv_number: "CVV/CVC is required",
                expiry_month: {
                    required: "Please Enter valid month",
                    number: "Please Enter valid min month",
                },
                expiry_year: {
                    required: "Please Enter valid year",
                    number: "Please Enter valid min year",
                },
            },
            submitHandler: function() {
                return true;
            }
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
                email: "Please Enter valid email address",
                password: "Please enter password"
            },
            submitHandler: function() {
                $.ajax({
                    // url: "{{ route('login-customers') }}",
                    url: "{{ route('login.customer.account') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        // login_email: $('#email').val(),
                        // login_password: $('#password').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success(response.success);
                            window.location.reload();
                        } else {
                            toastr.info(response.error);
                        }
                    }
                });
            }
        });

        $('form#finalPlaceOrderPage').validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                // company_name: {
                // required: true,
                // },
                country_id: {
                    required: true,
                },
                street_address_l1: {
                    required: true,
                },
                street_address_l2: {
                    required: false,
                },
                town_city: {
                    required: true,
                },
                state: {
                    required: true,
                },
                pin_code: {
                    required: true,
                },
                mobile: {
                    required: true,
                },
                cust_email: {
                    required: true,
                    email: true,
                },
                cust_username: {
                    required: true,
                },
                cust_password: {
                    required: true,
                },
                order_notes: {
                    required: true,
                },
                payment_type: {
                    required: true,
                },
                paymentccdetails: {
                    required: true,
                },
                depositepercentage: {
                    required: true,
                },
            },
            messages: {
                first_name: {
                    required: "First name is required",
                },
                last_name: {
                    required: "Last name is required",
                },
                company_name: {
                    required: "Company name is required",
                },
                country_id: {
                    required: "Country is required",
                },
                street_address_l1: {
                    required: "Street Address is required",
                },
                street_address_l2: {
                    required: "Street Address 2 is required",
                },
                town_city: {
                    required: "Town/City is required",
                },
                state: {
                    required: "State is required",
                },
                pin_code: {
                    required: "Pin Code is required",
                },
                mobile: {
                    required: "Mobile Number is required",
                },
                cust_email: {
                    required: "Email is required",
                    email: "Email id is valid format",
                },
                cust_username: {
                    required: "Username is required",
                },
                cust_password: {
                    required: "Password is required",
                },
                order_notes: {
                    required: "Order Notes is required",
                },
                payment_type: {
                    required: "Payment type is required",
                },
                paymentccdetails: {
                    required: "Payment details is required",
                },
                depositepercentage: {
                    required: "Deposit percentage is required",
                },
            },

            submitHandler: function(form) {
                document.getElementById("loader-overlay").style.display = "flex";
             
                const getValue = $('#already_inserted').val();
                if (getValue != "order_inserted") {
                    $('.cc_place_order_btn button').text('Please Wait ...');
                    $('.cc_place_order_btn button').prop('disabled', true);
                    var form_data = new FormData(form);
                    $.ajax({
                        url: "{{ route('place.order') }}",
                        method: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(response) {

                            $('.cc_place_order_btn button').text('Place Order');
                            $('.cc_place_order_btn button').prop('disabled', false);
                            if (response.status == 500) {
                                $('#emailCheck').append(
                                    '<label id="cust_email-error" class="error" for="cust_email">Email is already exist. Please try with another email.</label>'
                                );
                                toastr.info(response.msg);
                            }
                            if (response.orderf_status == "emailf_generated") {
                                window.location.href = "{{ route('successf.payment') }}";
                                return false;
                            }

                            const totalFinalPricesElement = document.getElementById(
                                "totalFinalPrices");

                            if (!totalFinalPricesElement) {
                                console.error(
                                    "Error: #totalFinalPrices element not found in the DOM.");
                                return 0;
                            }

                            const strongTag = totalFinalPricesElement.querySelector("strong");

                            if (!strongTag) {
                                console.error(
                                    "Error: <strong> tag not found inside #totalFinalPrices.");
                                return 0; // Default price if <strong> is missing
                            }

                            const strongValue = strongTag.textContent.trim();

                            // Remove currency symbols or extra characters, if any
                            const numericValue = strongValue.replace(/[^0-9.]/g, "");

                            const price = parseFloat(numericValue);


                            if (response.status == 200) {
                                const selectedPaymentType = $('#selected_payment_type').val();

                                $('#tokenOrdId').val(response.order_dt);

                                if (selectedPaymentType == 'paypal') {
                                    window.location.href = "{{ route('make.payment') }}/" +
                                        response.order_dt;
                                } else if (selectedPaymentType == 'googlepay') {
                                    // Payment will be handled by PayPal's Google Pay integration
                                    // Just store the order ID and show the Google Pay button
                                    $('#already_inserted').val('order_inserted');
                                    // Update order ID for PayPal's Google Pay integration
                                    window.marlowsOrderId = response.order_dt;
                                    // Show the Google Pay button
                                    $('#googlepay-button-container').show();
                                    // Hide loader since payment will be handled by PayPal SDK
                                    $('#loader-overlay').hide();
                                    $('body').removeClass('loading');
                                } else if (selectedPaymentType == 'klarna') {
                                    console.log('selected option is klarna !!');
                                    handleKlarnaPayment(response.order_dt);
                                } else if (selectedPaymentType == 'applepay') {
                                    $('#loader-overlay').hide();
                                    // let applepayPayload = getApplePayPayloadInfo(response.order_dt,
                                    //     response
                                    //     .get_order_detail,
                                    //     price, "GBP");
                                    // const applepayPriceSet = parseFloat(String(price).replace(/,/g,
                                    //     "").trim());

                                    // triggerApplePayViaPayPal(applepayPriceSet, response.order_dt,
                                    //     "GBP");
                                    // $('#already_inserted').val('order_inserted');
                                    // $('.applepay-button-container').show();
                                    // $('#place-order').hide();

                                    // New Flow for Apple Pay
                                    applepayAfterOrderCreated(response.order_dt, price);
                                }
                                  
                            }
                        },
                        error: function(xhr) {
                            $('.cc_place_order_btn button').text('PLACE ORDER');
                            $('.cc_place_order_btn button').prop('disabled', false);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                console.log(errors);

                                // Remove any previous error messages
                                $('.backend-error').remove();

                                $.each(errors, function(key, value) {
                                    // Find the input with name matching the key
                                    var input = $('[name="' + key + '"]');

                                    if (input.length) {
                                        // Create a new span element for the error
                                        var errorEl = $(
                                            '<span class="backend-error" style="color:red;"></span>'
                                        ).text(value[0]);

                                        // Insert the error **after the input element**
                                        input.after(errorEl);
                                    }
                                });
                                 $('#loader-overlay').hide(); 
                            } else {
                                alert('Something went wrong!');
                                 $('#loader-overlay').hide(); 
                            }
                               $('#loader-overlay').hide();
                        }
                    });
                }
            }
        });
    </script>
    {{--
    <script>
        // var url = "https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key=b884fefd2e03ec4c921c184fcc4273f0";

        // function get_deko_data() {
        //     $.getScript(url, function() {
        //         alterFilters();
        //         alterMinOption();
        //         var values = $("#final_price").val();
        //         var code = $("#terms").val();
        //         var percentage = parseInt($("#payed").val());
        //         var deposit = parseFloat((percentage / 100) * values);
        //         var my_fd_obj = new FinanceDetails(code, values, percentage, deposit);
        //         $("#perMonth").html(my_fd_obj.m_inst.toFixed(2) + " per month");
        //         $("#perMonths").html(my_fd_obj.m_inst.toFixed(2));
        //         $("#cashPrices").html(my_fd_obj.goods_val);
        //         $("#Deposited").html(my_fd_obj.d_amount);
        //         $("#loanAmt").html(my_fd_obj.l_amount);
        //         $("#loanRepay").html(my_fd_obj.l_repay);
        //         $("#costLoan").html(my_fd_obj.l_cost);
        //         $("#totalAmt").html(my_fd_obj.total);
        //         $("#noTerm").html(my_fd_obj.term);
        //         $("#totalP").html(my_fd_obj.goods_val);

        //         $("#payPro").val(code);
        //         $("#payPer").val(percentage);
        //     });
        // }
        // get_deko_data();
    </script>
    --}}




    {{-- Issue resolve script --}}
    <script>
        var api = $("#myapi").val();

        var dekoFilters = null;
        if (undefined !== window.dekofilters) {
            dekoFilters = window.dekofilters;
        }


        function alterMinOption() {
            var payedVal = $('select[name="percentage"]').val();
            var update = false;
            $('select[name="percentage"] option').each(function() {
                if ($(this).val() == payedVal) {
                    if ($(this).prop('disabled')) {
                        update = true;
                    }
                }
            });
            if (update || payedVal == null) {
                $('select[name="percentage"]').val($('select[name="percentage"] option:not([disabled]):first'));
                $('select[name="percentage"] option:not([disabled]):first').prop('selected', 'selected');
            }
        }



        function alterFilters() {
            if (null != dekoFilters) {
                var term = $('select[name="term"]').val();
                if (dekoFilters.hasOwnProperty(term)) {
                    termProp = parseInt(dekoFilters[term]);
                    $('select[name="percentage"] option').attr('disabled', 'disabled');
                    $('select[name="percentage"] option').each(function() {
                        var valInt = parseInt($(this).val());
                        if (valInt >= termProp) {
                            $(this).removeAttr('disabled');
                        }
                    });

                } else {
                    $('select[name="percentage"] option').removeAttr('disabled');
                }
            }
        }

        $(document).ready(function() {
            $("#terms").on("change", function() {
                alterFilters();
                alterMinOption();
                $('select[name="percentage"]').val($(
                    'select[name="percentage"] option:not([disabled]):first'));
                $('select[name="percentage"] option:not([disabled]):first').prop('selected', 'selected');

                // get_deko_data();
            });
            $("#payed").on("change", function() {
                alterFilters();
                alterMinOption();
                // get_deko_data();
            });

        });

        function shippingBillingAddress() {
            if ($('.checkshippingaddress').is(":checked")) {
                $('first_name').val($('#first_shipping_name').val());
                $('last_name').val($('#last_shipping_name').val());
                $('street_address_l1').val($('#street_address_shipping_l1').val());
                $('town_city').val($('#town_shipping_city').val());
                $('state').val($('#shipping_state').val());
                $('country_id').val($('#country_shipping_id').val());
                $('pin_code').val($('#pin_shipping_code').val());
                $('mobile').val($('#shipping_mobile').val());
                $('email').val($('#cust_shipping_email').val());
            } else {
                $('first_name').val("");
                $('last_name').val("");
                $('street_address_l1').val("");
                $('town_city').val("");
                $('state').val("");
                $('country_id').val("");
                $('pin_code').val("");
                $('mobile').val("");
                $('email').val("");
            }
        }

        function valueChanged() {
            if ($('.checkshippingaddress').is(":checked"))
                $(".billing-detail-show").hide();
            else
                $(".billing-detail-show").show();
        }

        document.addEventListener("DOMContentLoaded", () => {
            // Get the Apple Pay payment method element
            const applePayElement = document.querySelector('.applepay_payment');

            // Check if the user is on an Apple device
            const isAppleDevice = /iPhone|iPad|Macintosh/i.test(navigator.userAgent) ||
                (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);

            if (isAppleDevice) {
                // Show the Apple Pay payment method
                applePayElement.style.display = "block";
            } else {
                // Hide the Apple Pay payment method
                applePayElement.style.display = "none";
            }
        });


        // Function to handle radio button selection and toggle the Place Order button
        function togglePlaceOrderButton() {

            const placeOrderButton = document.getElementById("place-order");
            const applepaybuttoncontainer = document.getElementById("applepay-button-container");
            const applePayRadio = document.getElementById("applepay_radio"); // ID of the Apple Pay radio button

            // Check if the Apple Pay radio button is selected
            if (applePayRadio && applePayRadio.checked) {
                // placeOrderButton.style.display = "none"; // Hide the Place Order button
                applepaybuttoncontainer.style.display = "inline"; // Show the Place Order button
            } else {
                placeOrderButton.style.display = "inline"; // Show the Place Order button
                applepaybuttoncontainer.style.display = "none"; // Show the Place Order button
            }
        }

        // Attach the event listener to all radio buttons
        document.addEventListener("DOMContentLoaded", () => {
            const radioButtons = document.querySelectorAll(
                'input[name="payment_type"]'); // Replace with your payment method radio name
            radioButtons.forEach((radio) => {
                radio.addEventListener("change", togglePlaceOrderButton);
            });
            // Initial check on page load
            // togglePlaceOrderButton();
        });

        // Klarna Payment Flow
        function handleKlarnaPayment(orderId) {

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


            fetch(`/klarna/generate-client-token/${orderId}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    const clientToken = data.client_token;
                    console.log('clientToken', clientToken);

                    if (!clientToken) {
                        alert("Client token is missing.");
                        $('#loader-overlay').hide();
                        return;
                    }

                    Klarna.Payments.init({
                        client_token: clientToken
                    });

                    Klarna.Payments.load({
                        container: "#klarna_container",
                        payment_method_category: "pay_now"
                    }, function(res) {
                        if (res.error) {
                            console.error("Klarna load error:", res);
                            alert("Failed to load Klarna payment method.");
                            $('#loader-overlay').hide();
                            return;
                        }

                        Klarna.Payments.authorize({
                            payment_method_category: "pay_now"
                        }, function(res) {
                            if (res.error) {
                                console.error("Authorization error:", res);
                                alert("Authorization failed.");
                                $('#loader-overlay').hide();
                                return;
                            }

                            if (res.approved) {
                                fetch('/klarna/place-order', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            authorization_token: res.authorization_token,
                                            order_Id: orderId
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert("Order placed successfully!");
                                            window.location.href =
                                                "{{ route('order.success') }}/" + orderId;
                                        } else {
                                            alert("Order placement failed: " + (data.error ||
                                                "Unknown error"));
                                                $('#loader-overlay').hide();
                                        }
                                    })
                                    .catch(err => {
                                        alert("Order placement failed.");
                                        console.error(err);
                                        $('#loader-overlay').hide();
                                    });
                            } else {
                                alert("Payment not approved.");
                                $('#loader-overlay').hide();
                            }
                        });
                    });
                })
                .catch(err => {
                    console.error("Error fetching client token:", err);
                    alert("Failed to generate Klarna client token.");
                    $('#loader-overlay').hide();
                });
        }

        // Modern PayPal + Google Pay Integration
        // No custom payload needed - handled by PayPal SDK

        // Apple pay transaction payload code only
        function getApplePayPayloadInfo(internal_order_id, get_order_detail, totalAmt, currencyCode = "GBP") {
            // --- Apple Pay Request ---
            let applepayPayload = {
                countryCode: "GB",
                currencyCode: currencyCode,
                merchantCapabilities: ["supports3DS", "supportsCredit", "supportsDebit"],
                supportedNetworks: ["visa", "masterCard", "amex", "discover"],
                total: {
                    label: "Marlows Diamond",
                    amount: totalAmt.toFixed(2),
                    type: "final"
                }
            };
        }
    </script>
@endsection

{{-- criteo start --}}
@section('criteo-tracking')
    @if (session()->has('cart') && !empty(session('cart')))
        <script type="text/javascript">
            setTimeout(function() {
                window.criteo_q = window.criteo_q || [];
                window.criteo_q.push({
                        event: "setAccount",
                        account: 119681
                    },
                    @if (Auth::check())
                        {
                            event: "setEmail",
                            email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}",
                            hash_method: "sha256}}"
                        }, {
                            event: "setEmail",
                            email: "{{ hash('sha256', strtolower(trim(Auth::user()->email))) }}",
                            hash_method: "md5"
                        },
                    @endif {
                        event: "setSiteType",
                        type: "{{ request()->header('User-Agent') && preg_match('/iPad/', request()->header('User-Agent')) ? 't' : (preg_match('/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/', request()->header('User-Agent')) ? 'm' : 'd') }}"
                    },
                    @if (Auth::check())
                        {
                            event: "setCustomerId",
                            id: {{ Auth::user()->id }}
                        },
                    @endif {
                        event: "viewBasket",
                        item: [
                            @foreach (session('cart') as $id => $details)
                                {
                                    id: "ig_{{ $id }}",
                                    price: {{ $details['deposited_price'] }},
                                    quantity: {{ $details['quantity'] }}
                                }
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        ]
                    }
                );
            }, 4000); // ⏳ load after 4 seconds
        </script>
    @endif
@endsection
{{-- ends --}}
