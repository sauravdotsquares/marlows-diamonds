@extends('layouts.front.app')
  
@section('content')
<div class="login-register-page login-form">
  <div class="container">
			<div class="accounts-heading text-center">
                <h1>RESET PASSWORD</h1>
                <h2>CONTACT US FOR QUALITY DIAMOND ENGAGEMENT RINGS</h2>
            </div>
	<div class="login-reg-wraper">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                 
                  <div class="card-body">
  
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
  
                      <form id="" action="{{ route('forget.password.post') }}" method="POST">
                          @csrf
                          <div class="checkout-form-group row">
                              <label class="input-label">Email address <abbr class="required">*</abbr></label>
                              <div class="col-md-6">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
							  <div class="action-login">
                               <button class="btn-bg-small" type="submit">Send Password Reset Link</button>
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