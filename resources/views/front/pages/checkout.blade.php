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
                                                            <!-- <select id="state" name="state" required="required" class="form-control">
                                                                                                                                                                                                        <option>Select Option</option>
                                                                                                                                                                                                        <option>Rajasthan</option>
                                                                                                                                                                                                    </select> -->
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
                                                                                name="yearlySupport"
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




                                                {{-- google checkbox --}}
                                                <li class="cc_payment_methods googlepay_payment googlepaygateway_wrap">

                                                    <div class="google_pay_button">
                                                        <input type="radio" name="payment_type" id="googlepay_radio"
                                                            value="googlepay" autocomplete="off">
                                                        <label class="googlepay_label" for="googlepay_radio">
                                                            Google Pay
                                                            <a class="what-googlepay" href="https://pay.google.com/about/"
                                                                target="_blank">
                                                                What is Google Pay?
                                                            </a>
                                                        </label>
                                                    </div>

                                                    <i class="diamond-icon paypent-checkout"></i>
                                                    <div class="payment-box-main-drop googlepay-box"
                                                        style="display: none;">
                                                        Pay via Google Pay; a fast and secure way to pay using your saved
                                                        cards.
                                                    </div>
                                                    <div id="googlepay-button-container"
                                                        class="googlepay-button-container"></div>
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
        // This is to capture .env value
        const environmentCheckPhp = "{{ env('APP_ENV') }}";
        const PAYPAL_CLIENT_ID_PHP = "{{ env('PAYPAL_CLIENT_ID') }}";
        const PAYPAL_SECRET_PHP = "{{ env('PAYPAL_SECRET') }}";
        const PAYPAL_BASE_URL_PHP = "{{ env('PAYPAL_BASE_URL') }}";
        const PAYPAL_BASE_NEW_URL_PHP = "{{ env('PAYPAL_BASE_NEW_URL') }}";
    </script>
    @php
        // Request client token from the server-side PHP
        $clientToken = generateClientToken();

        if (env('APP_ENV') == 'production') {
            $merchantId = env('PAYPAL_MERCHANTID_LIVE');
        } elseif (env('APP_ENV') == 'local') {
            $merchantId = env('PAYPAL_MERCHANTID_STAG');
        }
        $clientId = env('PAYPAL_CLIENT_ID'); // Hardcode or set these manually
    @endphp
    <script src="https://applepay.cdn-apple.com/jsapi/v1/apple-pay-sdk.js"></script>
    <script src="{{ mix('js/googlepay_checkout_code.min.js') }}"></script>
    <script>
        function onPayPalScriptLoaded() {
            if (window.paypal && paypal.Googlepay) {
                // onGooglePayLoaded();
            } else {
                console.error('Google Pay not found in PayPal SDK');
            }
        }
    </script>
    <script
        src="https://www.paypal.com/sdk/js?components=applepay,googlepay&client-id={{ $clientId }}&currency=GBP&buyer-country=GB&merchant-id={{ $merchantId }}"
        data-client-token="{{ $clientToken }}" data-partner-attribution-id="APPLEPAY" onload="onPayPalScriptLoaded()">
    </script>
    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    <script src="{{ asset('/applepay_sdk/app.js') }}"></script>
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
                                    let payload = getGooglePayloadInfo(response.order_dt, response
                                        .get_order_detail,
                                        price, "GBP");
                                    onGooglePaymentButtonClicked(price, response.order_dt, payload,
                                        true);
                                } else if (selectedPaymentType == 'klarna') {
                                    console.log('selected option is klarna !!');
                                    handleKlarnaPayment(response.order_dt);
                                } else if (selectedPaymentType == 'applepay') {
                                    $('#already_inserted').val('order_inserted');
                                    $('.applepay-button-container').show();
                                    $('#place-order').hide();
                                }
                            }
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
                applepaybuttoncontainer.style.dispnone = "inline"; // Show the Place Order button
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
                            return;
                        }

                        Klarna.Payments.authorize({
                            payment_method_category: "pay_now"
                        }, function(res) {
                            if (res.error) {
                                console.error("Authorization error:", res);
                                alert("Authorization failed.");
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
                                        }
                                    })
                                    .catch(err => {
                                        alert("Order placement failed.");
                                        console.error(err);
                                    });
                            } else {
                                alert("Payment not approved.");
                            }
                        });
                    });
                })
                .catch(err => {
                    console.error("Error fetching client token:", err);
                    alert("Failed to generate Klarna client token.");
                });
        }

        // Google pay transaction payload code only
        function getGooglePayloadInfo(internal_order_id, get_order_detail, total, currencyCode = "USD") {
            let items = [];
            let itemsTotal = 0;
            total = parseFloat(total);
            total = total.toFixed(2);

            if (get_order_detail.get_order_details_function && get_order_detail.get_order_details_function.length > 0) {
                get_order_detail.get_order_details_function.forEach(item => {
                    let details = {};
                    try {
                        details = JSON.parse(item.order_product_details || "{}");
                    } catch (e) {
                        details = {};
                    }

                    const price = parseFloat(item.final_product_price) || 0;
                    const quantity = parseInt(item.quantity) || 1;

                    items.push({
                        name: details.slug || ("Product " + item.product_id),
                        description: details.metal_type ?
                            `${details.carat || ""} ${details.metal_type} ${details.shape || ""}`.trim() :
                            "Order Item",
                        unit_amount: {
                            currency_code: currencyCode,
                            value: price.toFixed(2)
                        },
                        quantity: quantity,
                        sku: item.product_id.toString()
                    });

                    itemsTotal += price * quantity;

                    // Yearly Care Plan for product
                    if (item.yearly_support_status == '1') {
                        const carePlanPrice = parseFloat(item.yearly_support_price) || 0;
                        const carePlanQuantity = parseInt(item.quantity) || 1;
                        switch (item.yearly_support_price) {
                            case '89.00':
                                $yearCarePlan = '1 year care plan for ';
                                break;

                            case '170.00':
                                $yearCarePlan = '2 years care plan for ';
                                break;

                            case '220.00':
                                $yearCarePlan = '3 years care plan for ';
                                break;

                            case '300.00':
                                $yearCarePlan = '4 years care plan for ';
                                break;

                            case '400.00':
                                $yearCarePlan = '5 years care plan for ';
                                break;

                            default:
                                $yearCarePlan = 'Care plan for ';
                                break;
                        }
                        const carePlanName = details.slug ? $yearCarePlan + details.slug : ("Product " + item
                            .product_id +
                            " care plan");
                        const carePlanDescription = details.metal_type ?
                            `${details.carat || ""} ${details.metal_type} ${details.shape || ""}`
                            .trim() : "Care Plan"
                        items.push({
                            name: carePlanName,
                            description: carePlanDescription,
                            unit_amount: {
                                currency_code: currencyCode,
                                value: carePlanPrice.toFixed(2)
                            },
                            quantity: carePlanQuantity,
                            sku: item.product_id.toString()
                        });
                        itemsTotal += carePlanPrice * carePlanQuantity;
                    }
                });
            }

            let payload = {
                intent: "CAPTURE",
                purchase_units: [{
                    reference_id: "ORDER_REF_" + internal_order_id,
                    amount: {
                        currency_code: currencyCode,
                        value: itemsTotal.toFixed(2), // must match sum
                        breakdown: {
                            item_total: {
                                currency_code: currencyCode,
                                value: itemsTotal.toFixed(2)
                            }
                        }
                    },
                    items: items
                }]
            };

            // ✅ Add shipping if available
            if (get_order_detail.customer_shipping_address) {
                const shipping = get_order_detail.customer_shipping_address;
                payload.purchase_units[0].shipping = {
                    name: {
                        full_name: shipping.first_name + " " + shipping.last_name
                    },
                    address: {
                        address_line_1: shipping.street_address_l1,
                        address_line_2: shipping.street_address_l2 || "",
                        admin_area_2: shipping.town_city,
                        admin_area_1: shipping.state,
                        postal_code: shipping.pin_code,
                        country_code: shipping.country_id
                    }
                };
            } else {
                payload.purchase_units[0].shipping = null;
            }

            return payload;
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
