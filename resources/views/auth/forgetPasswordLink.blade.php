@extends('layouts.front.app')
  
@section('content')
<div class="login-register-page login-form">
  <div class="cotainer">
	<div class="accounts-heading text-center">
                <h1>RESET PASSWORD</h1>
                
    </div>
      <div class="login-reg-wraper">
          <div class="row justify-content-center">
          <div class="col-lg-6">
              <div class="card">
                 
					<div class="card-body">
  
                      <form action="{{ route('reset.password.post') }}" method="POST">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
  
                          <div class="checkout-form-group row">
                              <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="checkout-form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required autofocus>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="checkout-form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="checkout-form-group row">
							  <div class="action-login">
								  <button type="submit" class="btn-bg-small">
									  Reset Password
								  </button>
							  </div>
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