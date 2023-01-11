@extends('layouts.admin.app')

@section('content')

	    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              
              <!-- /.card-header -->
              <!-- form start -->
              
				@if(old('msg'))
				<p>msg:{{ old('msg') }}<p>
				@endif
            <form id="quickForm" method="POST" name="change_paswd" action="{{ url('admin/change-password') }}">
                @csrf
                @method('POST')
				<div class="card-header">
				<i class="fas fa-table"></i> Change Password
				</div>
				<div class="card-body">
                <div class="form-group row">
                    <label for="old_password" class="col-md-2 col-form-label">{{ __('Current Password') }} <span class="required-field-start">*</span></label>
                    <div class="col-md-6">
                        <input id="old_password" name="old_password" type="password" class="form-control" autocomplete="off" required1 autofocus>
                    </div>
                    <span class="help-block">
                        <strong>{{ $errors->first('old_password') }}</strong>
                    </span>
                </div>
                <div class="form-group row">
                    <label for="new_password" class="col-md-2 col-form-label">{{ __('New Password') }}  <span class="required-field-start">*</span></label>
                    <div class="col-md-6">
                        <input id="new_password" name="new_password" type="password" class="form-control" autocomplete="off" required1 autofocus>
                    </div>
                    <span class="help-block">
                        <strong>{{ $errors->first('new_password') }}</strong>
                    </span>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-md-2 col-form-label">{{ __('Confirm Password') }}  <span class="required-field-start">*</span></label>
                    <div class="col-md-6">
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="off" required1 autofocus>
                    </div>
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                </div>
				
				</div>  
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				
			</form>
			</div>
        
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection