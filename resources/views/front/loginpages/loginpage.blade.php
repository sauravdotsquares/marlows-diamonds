@extends('layouts.front.app')
@section('css')
<style>
    .error{
            color:red !important;
        }
</style>
@endsection
@section('content')

    @if(Session::has('error'))
    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
    @endif

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
                                <form id="loginCustomers" action="{{route('login-customers')}}" method="POST">
                                    @csrf
                                    <div class="checkout-form-group">
                                        <label class="input-label">Email address <abbr class="required">*</abbr></label>
                                        <input type="text" required="required" name="email" id="email" class="form-control">
                                    </div>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Password  <abbr class="required">*</abbr></label>
                                        <input type="password" required="required" name="password" id="password" class="form-control">
                                        <span class="password-show"><a href="javascript:void(0);"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
                                    </div>
                                    <div class="action-login">
                                        <button class="btn-bg-small" type="submit">Login</button>
                                            <label class="rememberme">
                                                <input type="checkbox">
                                                <span>Remember me</span>
                                            </label>
                                        </div>
                                    <div class="lostpassword">
                                        <a href="/users/forget-password">Lost your password</a>
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
                                <form id="registerCustomers" action="{{route('register-customers')}}" method="POST">
                                    @csrf
                                    <div class="checkout-form-group">
                                        <label class="input-label">Username <abbr class="required">*</abbr></label>
                                        <input type="text" name="username" id="username" required="required" class="form-control {{ $errors->has('username') ? 'error' : '' }}">
                                        @if ($errors->has('username'))
                                            <div class="error">
                                                {{ $errors->first('username') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Email address <abbr class="required">*</abbr></label>
                                        <input type="email" name="email" id="email" required="required" class="form-control {{ $errors->has('email') ? 'error' : '' }}">
                                        @if ($errors->has('email'))
                                        <div class="error">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="checkout-form-group">
                                        <label class="input-label">Password <abbr class="required">*</abbr></label>
                                        <input type="password" name="password" id="password" required="required" class="form-control {{ $errors->has('password') ? 'error' : '' }}">
                                        <span class="password-show"><a href="javascript:void(0);"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
                                        @if ($errors->has('password'))
                                            <div class="error">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="log-privacy-policy-text">
                                        <p>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our
                                            <a href="/privacy-policy" target="_blank">privacy policy</a>.</p>
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

    <script>
        $('.password-show').on('click',function(e){
            var target = e.currentTarget
            $(target).hasClass('show')?hidePassword($(target)):showPassword($(target))
        });

        function hidePassword(e){
            e.removeClass('show').addClass('hide')
            e.prev('input').attr('type','password')
        }
        function showPassword(e){
            e.removeClass('hide').addClass('show')
            e.prev('input').attr('type','text')
        }
    </script>

@endsection
