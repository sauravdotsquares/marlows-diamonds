@extends('layouts.front.app')
@section('css')
<style>
    .error {
        color: #e74c3c;
    }
</style>
@endsection

@section('content')
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
                            <p>If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="checkout-form-group">
                                        <label class="input-label">Email <abbr class="required">*</abbr></label>
                                        <input type="text" name="email" id="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkout-form-group">
                                        <label class="input-label">Password  <abbr class="required">*</abbr></label>
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
                    <form>
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
                                                            <label class="input-label">First Name <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Last Name <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Company Name <span class="optional">(Optional)</span></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Country/Region  <abbr class="required">*</abbr></label>
                                                            <select class="form-control">
                                                                <option>Select Option</option>
                                                                <option>India</option>
                                                                <option>India</option>
                                                                <option>India</option>
                                                                <option>India</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Street address <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control" placeholder="House number and street name">
                                                        </div>
                                                        <div class="checkout-form-group">
                                                            <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Town / City <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">State<abbr class="required">*</abbr></label>
                                                            <select class="form-control">
                                                                <option>Select Option</option>
                                                                <option>Rajasthan</option>
                                                                
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">PIN <abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Phone<abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="checkout-form-group">
                                                            <label class="input-label">Email address<abbr class="required">*</abbr></label>
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <div class="checkout-create-account">
                                            <div class="create-account-checkbox">
                                                <input type="checkbox" checked>
                                                <label>Create an Account?</label>
                                            </div>
                                            <div class="create-account-fields">
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Account username<abbr class="required">*</abbr></label>
                                                    <input type="text" class="form-control">
                                                </div>
                                                <div class="checkout-form-group">
                                                    <label class="input-label">Create account password<abbr class="required">*</abbr></label>
                                                    <input type="password" class="form-control">
                                                </div>
                                            </div>
                                    </div>
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
                                                    <label class="input-label">Order notes<span class="optional">(Optional)</span></label>
                                                    
                                                    <textarea class="form-control" placeholder="Notes about your order, e.g. special notes for delivery.">

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
                                        <tr class="checkcart-item">
                                            <td class="checkpr-name">
                                                <div class="name-pr-cart">AALIYAH | Four Claw split shoulder Solitaire Diamond Ring
                                                    <strong class="checkpr-quantity">x 1</strong>
                                                </div>  
                                                <dl class="variation">
                                                    <dl class="variation">
                                                    <dt class="variation-Colour">Metal Colour:</dt>
                                                    <dd class="variation-Colour"><p>18ct White Gold</p></dd>
                                                    <dt class="variation-FingerSize">Finger Size:</dt>
                                                    <dd class="variation-FingerSize"><p>I</p></dd>
                                                </dl>
                                            </td>
                                            <td class="check-product-total">
                                                <span>£475.00</span>
                                            </td>
                                        </tr>
                                        <tr class="checkcart-item">
                                            <td class="checkpr-name">
                                                <div class="name-pr-cart">ABBIE | Marquise shape solitaire Diamond Engagement Ring
                                                    <strong class="checkpr-quantity">x 1</strong>
                                                </div>  
                                                <dl class="variation">
                                                    <dl class="variation">
                                                    <dt class="variation-Colour">Metal Colour:</dt>
                                                    <dd class="variation-Colour"><p>18ct White Gold</p></dd>
                                                    <dt class="variation-FingerSize">Finger Size:</dt>
                                                    <dd class="variation-FingerSize"><p>I</p></dd>
                                                </dl>
                                            </td>
                                            <td class="check-product-total">
                                                <span>£389.00</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="checkout-cart-subtotal">
                                            <th>Subtotal</th>
                                            <td>
                                                <strong>£864.00</strong>
                                                <small class="tax_label"> (incl. VAT)</small>
                                            </td>
                                        </tr>   
                                        <tr class="checkout-cart-total">
                                            <th>Total</th>
                                            <td>
                                                <strong>£864.00</strong>
                                                <small class="tax_label">(includes £144.00 VAT)</small>
                                            </td>
                                        </tr>   
                                    
                                    </tfoot>
                                </table>
                            </div> 
                            <div class="checkout-payment-options">
                                <ul class="cc_payment_methods_options">
                                    <li class="cc_payment_methods paypal_payment">
                                        <input type="radio">
                                        <label class="paypal_label">
                                            Paypal
                                            <img src="../assets/images/paypal-icon.png" alt="paypal">
                                            <a class="what-paypal" href="#">What is PayPal?</a>
                                        </label>
                                        <div class="payment-box-main-drop paypal-pay-box">
                                            Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.
                                        </div>
                                    </li>
                                    <li class="cc_payment_methods via_deko_payment">
                                        <input type="radio">
                                        <label class="deko_label">
                                            Dekopay
                                            <img src="../assets/images/dek_one.png" alt="deko">
                                        </label>
                                        <div class="payment-box-main-drop deko-pay-box">
                                            <p>Pay securely by Credit or Debit card or internet banking through Dekopay Secure Servers.</p>
                                            <div class="deko_finance">
                                                <img src="../assets/images/Deko_square_colour_whiteBG200px_wide.png" alt="deko">                                                        
                                                <span> Finance Options </span>
                                            </div>
                                            <div class="payment-cc-details-box">
                                                <div class="payment-cc-details-inner">
                                                    <div class="payment-cc-details-label">
                                                        Price : 
                                                    </div>
                                                    <div class="payment-cc-details-values">
                                                        £ 864.00 
                                                    </div>
                                                </div>
                                                <div class="payment-cc-details-inner">
                                                    <div class="payment-cc-details-label">
                                                        Term : 
                                                    </div>
                                                    <div class="payment-cc-details-values">
                                                        <select>
                                                            <option> 12  Months Credit 16.9%</option>
                                                            <option> 18  Months Credit 16.9%</option>
                                                            <option> 24 Months Credit 16.9%</option>
                                                            <option> 36 Months Credit 16.9%</option>
                                                            <option> 48 Months Credit 16.9%</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="payment-cc-details-inner">
                                                    <div class="payment-cc-details-label">
                                                        Deposit : 
                                                    </div>
                                                    <div class="payment-cc-details-values">
                                                        <select>
                                                            <option>10%</option>
                                                            <option>20%</option>
                                                            <option>30%</option>
                                                            <option>40%</option>
                                                            <option>50%</option>
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
                                                <span>Finance is only available to permanent UK residents aged between 18 and 80, subject to status, terms and conditions apply. For more details about Dekopay please see <a href="#">Terms of Service</a> | <a href="#">Privacy Policy</a> | <a href="#">FAQ.</a></span>
                                            </div>
                                            
                                        </div>
                                    </li>
                                </ul>

                            </div>

                            <div class="checkout-place-order">
                                <div class="cc-terms-and-conditions-wrapper">
                                    Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our
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
        $(document).ready(function(){
            $('.showlogin').on('click',function(){
                $(".checkout-login-form").toggle(200);
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
            submitHandler: function() {
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