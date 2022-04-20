@extends('layouts.front.app')
@section('content')

    <div class="login-register-page">
        <div class="container">
            <div class="accounts-heading text-center">
                <h1>LOGIN - REGISTER</h1>
                <h2>CONTACT US FOR QUALITY DIAMOND ENGAGEMENT RINGS</h2>
            </div>
            <div class="login-reg-wraper">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="login-block-wrap login-reg-block">
                            <div class="heading-div-lock">
                                Login
                            </div>
                            <div class="login-reg-box">
                                <form>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Username or email address <abbr class="required">*</abbr></label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Password  <abbr class="required">*</abbr></label>
                                        <input type="password" class="form-control">
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
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6">
                        <div class="login-block-wrap login-reg-block">
                            <div class="heading-div-lock">
                                Register
                            </div>
                            <div class="login-reg-box">
                                <form>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Username <abbr class="required">*</abbr></label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Email address <abbr class="required">*</abbr></label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Password <abbr class="required">*</abbr></label>
                                        <input type="password" class="form-control">
                                    </div>
                                    <div class="log-privacy-policy-text">
                                        <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our 
                                            <a href="#" target="_blank">privacy policy</a>.</p>
                                    </div>
                                    <div class="action-login">
                                        <button class="btn-bg-small" type="submit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
  
@section('js')
@endsection