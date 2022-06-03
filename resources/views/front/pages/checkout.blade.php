@extends('layouts.front.app')
@section('css')
<style>
    .error {
        color: #e74c3c;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')


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
            @if(!Auth::guard('customer')->check())
                <?php // echo "check"; die; ?>
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
            @endif

            <?php
                // echo "<pre>";
                // print_r($getUsersDetails->getCustomerAddressFunction->country_id);
                // die;
            ?>

            <!-- login form end-->
            <div class="checkout-main-wrap">
                <form id="finalPlaceOrderPage">
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
                                                        <input type="text" id="first_name" name="first_name" required="required" value="{{isset($getUsersDetails->getCustomerAddressFunction->first_name)?$getUsersDetails->getCustomerAddressFunction->first_name:''}}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Last Name <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="last_name" name="last_name" required="required" value="{{isset($getUsersDetails->getCustomerAddressFunction->last_name)?$getUsersDetails->getCustomerAddressFunction->last_name:''}}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Company Name <span
                                                                class="optional">(Optional)</span></label>
                                                        <input type="text" id="company_name" value="{{isset($getUserDetails->getCustomerAddressFunction->company_name)?$getUserDetails->getCustomerAddressFunction->company_name:''}}" name="company_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Country/Region <abbr
                                                                class="required">*</abbr></label>
                                                        <select id="country_id" name="country_id" required="required" class="form-control">
                                                            <option value="">Select Option</option>
                                                            @foreach($getCountries as $key => $country)
                                                                @if(isset($getUsersDetails->getCustomerAddressFunction->country_id) && $getUsersDetails->getCustomerAddressFunction->country_id == $country->shortname)
                                                                    <option value="{{$country->shortname}}" selected>{{$country->name}}</option>
                                                                @else
                                                                    <option value="{{$country->shortname}}">{{$country->name}}</option>
                                                                @endif
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
                                                        <input type="text" id="street_address_l1" name="street_address_l1" value="{{isset($getUsersDetails->getCustomerAddressFunction->street_address_l1)?$getUsersDetails->getCustomerAddressFunction->street_address_l1:''}}" required="required" class="form-control"
                                                            placeholder="House number and street name">
                                                    </div>
                                                    <div class="checkout-form-group">
                                                        <input type="text" value="{{isset($getUsersDetails->getCustomerAddressFunction->street_address_l2)?$getUsersDetails->getCustomerAddressFunction->street_address_l2:''}}" id="street_address_l2" name="street_address_l2" class="form-control"
                                                            placeholder="Apartment, suite, unit, etc. (optional)">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Town / City <abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" value="{{isset($getUsersDetails->getCustomerAddressFunction->town_city)?$getUsersDetails->getCustomerAddressFunction->town_city:''}}" id="town_city" name="town_city" required="required" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">State/Region<abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" value="{{isset($getUsersDetails->getCustomerAddressFunction->state)?$getUsersDetails->getCustomerAddressFunction->state:''}}" id="state" name="state" required="required" class="form-control">
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
                                                        <input type="text" value="{{isset($getUsersDetails->getCustomerAddressFunction->pin_code)?$getUsersDetails->getCustomerAddressFunction->pin_code:''}}" id="pin_code" name="pin_code" required="required" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkout-form-group">
                                                        <label class="input-label">Phone<abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" value="{{isset($getUsersDetails->getCustomerAddressFunction->mobile)?$getUsersDetails->getCustomerAddressFunction->mobile:''}}" id="mobile" name="mobile" required="required" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="emailCheck" class="checkout-form-group">
                                                        <label class="input-label">Email address<abbr
                                                                class="required">*</abbr></label>
                                                        <input type="text" id="cust_email" name="cust_email" required="required" value="{{isset(auth()->user()->email)?auth()->user()->email:''}}" @if(isset(auth()->user()->email)) readonly disable @endif class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @guest
                                    <div class="checkout-create-account">
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
                                                <textarea id="order_notes" name="order_notes" required="required" class="form-control" placeholder="Notes about your order, e.g. special notes for delivery."> {{isset($getUsersDetails->getCustomerAddressFunction->order_notes)?$getUsersDetails->getCustomerAddressFunction->order_notes:''}}
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
                                    @php $total = 0; $totalVat = 0; @endphp
                                    @if(session('cart'))
                                        @foreach(session('cart') as $id => $details)
                                            @php $total += $details['price'] * $details['quantity'] @endphp
                                            @php $totalVat += $details['vat'] * $details['quantity'] @endphp
                                        <tr class="checkcart-item">
                                            <td class="checkpr-name">
                                                @if(isset($details['customArray']['slug']) && !empty($details['customArray']['slug']))
                                                    <div class="cartproduct-title"><a href="{{asset('product/'.$details['customArray']['slug'])}}"> {{ $details['name'] }}</a></div>
                                                @else
                                                    <div class="cartproduct-title"><a href="javascript:void(0);"> {{ $details['name'] }}</a></div>
                                                @endif
                                                {{-- <div class="cartproduct-title"><a href="{{asset('product/'.$details['customArray']['slug'])}}"> {{ $details['name'] }}</a></div> --}}
                                                <dl class="variation">
                                                    @if(isset($details['customArray']['choose_diamond']) && !empty($details['customArray']['choose_diamond']))
                                                        <dt class="variation-Colour">Choose Your Diamond: </dt>
                                                        <dd class="variation-Colour"><p> {{ ($details['customArray']['choose_diamond'] == 'lab_grown')?'Lab Grown':'Mined'}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['metalcolor']) && !empty($details['customArray']['metalcolor']))
                                                        <dt class="variation-Colour">Metal: </dt>
                                                        <dd class="variation-Colour"><p> {{$details['customArray']['metalcolor']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['fingersize']) && !empty($details['customArray']['fingersize']))
                                                        <dt class="variation-FingerSize">Finger Size: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['fingersize']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['Shape']) && !empty($details['customArray']['Shape']))
                                                        <dt class="variation-FingerSize">Diamond Shape: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['Shape']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['Carat']) && !empty($details['customArray']['Carat']))
                                                        <dt class="variation-FingerSize">Diamond Carat: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['Carat']}}</p></dd>
                                                    @elseif(isset($details['customArray']['carat']) && !empty($details['customArray']['carat']))
                                                        <dt class="variation-FingerSize">Diamond Carat: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['carat']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['Color']) && !empty($details['customArray']['Color']))
                                                        <dt class="variation-FingerSize">Diamond Color: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['Color']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['Clarity']) && !empty($details['customArray']['Clarity']))
                                                        <dt class="variation-FingerSize">Diamond Cut Grade: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['Clarity']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['Lab']) && !empty($details['customArray']['Lab']))
                                                        <dt class="variation-FingerSize">Certificate: </dt>
                                                        <dd class="variation-FingerSize"><p>{{$details['customArray']['Lab']}}</p></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['CertificateLink']) && !empty($details['customArray']['CertificateLink']))
                                                        <dt class="variation-FingerSize">Certificate Link: </dt>
                                                        <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['CertificateLink']}}">View Certificate</a></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                                                        <dt class="variation-FingerSize">Image: </dt>
                                                        <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['ImageLink']}}">View Diamond</a></dd>
                                                    @endif
                                                    @if(isset($details['customArray']['CERT_NO']) && !empty($details['customArray']['CERT_NO']))
                                                        <dt class="variation-FingerSize">Certificate: </dt>
                                                        <dd class="variation-FingerSize"><p >{{$details['customArray']['CERT_NO']}}</p></dd>
                                                    @endif
                                                </dl>
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
                                            <small class="tax_label">(includes {{MY_CURRENCY_SYMBOL}}{{isset($totalVat)?$totalVat:0.00}} VAT)</small>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <input type="hidden" id="final_price" name="final_price" value="{{ $total }}">
                        <input type="hidden" id="selected_payment_type" name="selected_payment_type" value="paypal">
                        <div class="checkout-payment-options">
                            <ul class="cc_payment_methods_options">

                                @include('front.pages.payments.paypal',['totalAmount'=>$total])
                                @include('front.pages.payments.dekopay',['totalAmount'=>$total])
                            </ul>
                        </div>
                        <div class="checkout-place-order">
                            <div class="cc-terms-and-conditions-wrapper">
                                Your personal data will be used to process your order, support your experience
                                throughout this website, and for other purposes described in our
                                <a href="{{asset('privacy-policy')}}" target="_blank">Privacy Policy</a>
                            </div>
                            <div class="cc_place_order_btn">
                                @guest
                                    <!-- <a id="placeOrderDetails" href="javascript:void(0);" class="btn-bg-large">Place Order </a> -->
                                @endguest
                                @auth
                                @endauth
                                <button class="btn-bg-large" type="submit">Place Order</button>
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
<script src="{{$url}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        $('.showlogin').on('click', function () {
            $(".checkout-login-form").toggle(200);
        });

        $('#showRegisterDiv').on('change',function(){
            $('.showregisterform').toggle();
        });

        $('input[type=radio][name=payment_type]').on('change', function() {
            $('#selected_payment_type').val($(this).val());
            switch ($(this).val()) {
                case 'paypal':
                    $(".paypal-pay-box").show('slow');
                    $(".deko-pay-box").hide('slow');
                    break;
                case 'dekopay':
                    $(".paypal-pay-box").hide('slow');
                    $(".deko-pay-box").show('slow');
                    break;
            }
        });

        // $('#cust_email').on('blur',function(){
        //     var data = '{!! isset(auth()->user()->email)?auth()->user()->email:'' !!}';
        //     if(data){
        //         //console.log("if");
        //     }else{
        //         if($(this).val() != ''){
        //             getEmailCheck();
        //         }
        //     }
        // });

    });

    function getEmailCheck(){
        if($('#cust_email').val() != ''){
            console.log("if");
            var customeremail = $('#cust_email').val();
            $.ajax({
                url: "{{ route('check.email.id') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    email: $('#cust_email').val(),
                },
                success: function (response) {
                    $('#cust_email-error').remove();
                    // console.log(response);
                    if(response){
                        $('#emailCheck').append('<label id="cust_email-error" class="error" for="cust_email">Email('+customeremail+') is already exist Please Logged in </label>');
                        $('#cust_email').val(" ");
                        // $('#cust_email-error').css('display','block');
                        // toastr.success('Already exists please login');
                        // window.location.reload();
                        return response;
                    }
                    // else{
                    //     $('#cust_email-error').remove();
                    //     // toastr.info('not exist do continue');
                    //     return response;
                    // }
                }
            });
        }else{
            console.log("else");
        }
    }

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
        submitHandler: function () {
            $.ajax({
                url: "{{ route('login.customer.account') }}",
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                success: function (response) {
                    if(response.status == 200){
                        toastr.success(response.success);
                        window.location.reload();
                    }else{
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
                email:true,
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
            last_name:{
                required: "Last name is required",
            },
            company_name: {
                required: "Company name is required",
            },
            country_id:{
                required: "Country is required",
            },
            street_address_l1: {
                required: "Street Address is required",
            },
            street_address_l2:{
                required: "Street Address 2 is required",
            },
            town_city: {
                required: "Town/City is required",
            },
            state:{
                required: "State is required",
            },
            pin_code: {
                required: "Pin Code is required",
            },
            mobile:{
                required: "Mobile Number is required",
            },
            cust_email: {
                required: "Email is required",
                email:"Email id is valid format",
            },
            cust_username:{
                required: "Username is required",
            },
            cust_password: {
                required: "Password is required",
            },
            order_notes:{
                required: "Order Notes is required",
            },
            payment_type: {
                required: "Payment type is required",
            },
            paymentccdetails:{
                required: "Payment details is required",
            },
            depositepercentage: {
                required: "Deposit percentage is required",
            },
        },
        submitHandler: function (form) {
            $('.cc_place_order_btn button').text('Please Wait ...');
            $('.cc_place_order_btn button').prop('disabled', true);
            var form_data = new FormData(form);
            $.ajax({
                url: "{{ route('place.order') }}",
                method: "POST",
                cache:false,
                contentType:false,
                processData: false,
                data: form_data,
                success: function (response) {
                    $('.cc_place_order_btn button').text('Place Order');
                    $('.cc_place_order_btn button').prop('disabled', false);
                    if(response.status == 500){


                        $('#emailCheck').append('<label id="cust_email-error" class="error" for="cust_email">Email is already exist. Please try with another email.</label>');
                        toastr.info(response.msg);
                    }
                    if(response.status == 200){

                        // toastr.success(response.msg);
                        // window.location.reload();
                        if($('#selected_payment_type').val() == 'paypal'){
                            window.location.href = "{{route('make.payment')}}/"+response.order_dt;
                        }else{
                            window.location.href = "{{route('make.dekopay')}}/"+response.order_dt;
                        }

                    }else{
                        // toastr.info(response.error);
                    }
                }
            });
        }
    });




</script>

<script>
    var api = $("#myapi").val();

    var dekoFilters = null;
    if(undefined !== window.dekofilters){
        dekoFilters = window.dekofilters;
    }
        function alterMinOption(){
        var payedVal = $('select[name="percentage"]').val();
        var update = false;
        $('select[name="percentage"] option').each(function(){
            if($(this).val() == payedVal){
                if($(this).prop('disabled')){
                    update = true;
                }
            }
        });
        if(update || payedVal == null){
            $('select[name="percentage"]').val($('select[name="percentage"] option:not([disabled]):first'));
            $('select[name="percentage"] option:not([disabled]):first').prop('selected','selected');
        }
    }


    function alterFilters(){
            if(null != dekoFilters){
            var term = $('select[name="term"]').val();
            if(dekoFilters.hasOwnProperty(term)){
                termProp = parseInt(dekoFilters[term]);
                $('select[name="percentage"] option').attr('disabled', 'disabled');
                $('select[name="percentage"] option').each(function(){
                    var valInt = parseInt($(this).val());
                    if(valInt >= termProp){
                        $(this).removeAttr('disabled');
                    }
                });

            }else{
                $('select[name="percentage"] option').removeAttr('disabled');
            }
    }
    }

    var url="https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key=b884fefd2e03ec4c921c184fcc4273f0";

    function get_deko_data(){
        $.getScript( url, function() {
            alterFilters();
            alterMinOption();
            var values = $("#final_price").val();
            var code =$("#terms").val();
            var percentage = parseInt($("#payed").val());
            var deposit = parseFloat((percentage/100)*values);
            var my_fd_obj = new FinanceDetails(code,values,percentage,deposit);
            $("#perMonth").html(my_fd_obj.m_inst.toFixed(2)+" per month");
            $("#perMonths").html(my_fd_obj.m_inst.toFixed(2));
            $("#cashPrices").html(my_fd_obj.goods_val);
            $("#Deposited").html(my_fd_obj.d_amount);
            $("#loanAmt").html(my_fd_obj.l_amount);
            $("#loanRepay").html(my_fd_obj.l_repay);
            $("#costLoan").html(my_fd_obj.l_cost);
            $("#totalAmt").html(my_fd_obj.total);
            $("#noTerm").html(my_fd_obj.term);
            $("#totalP").html(my_fd_obj.goods_val);

            $("#payPro").val(code);
            $("#payPer").val(percentage);
        });
    }
    get_deko_data();

    $(document).ready(function(){
        $("#terms").on("change", function(){
            alterFilters();
            alterMinOption();
            $('select[name="percentage"]').val($('select[name="percentage"] option:not([disabled]):first'));
            $('select[name="percentage"] option:not([disabled]):first').prop('selected','selected');

            get_deko_data();
        });
        $("#payed").on("change", function(){
            alterFilters();
            alterMinOption();
            get_deko_data();
        });

    });
</script>

@endsection
