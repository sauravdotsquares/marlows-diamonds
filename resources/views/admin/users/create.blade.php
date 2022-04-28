@extends('layouts.admin.app')
@section('content')

<div class="content">
   <!-- Breadcrumbs-->
   @if(session()->has('alert-danger'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-danger') }}
   </div>
   @endif
   @if ($errors->has('name'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('name') }}
   </div>
   @endif
   @if ($errors->has('username'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('username') }}
   </div>
   @endif
   @if ($errors->has('is_active'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('is_active') }}
   </div>
   @endif
   @if ($errors->has('password'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('password') }}
   </div>
   @endif
   @if ($errors->has('confirm_password'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('confirm_password') }}
   </div>
   @endif
   <!-- DataTables Example -->
   <section class="content">
      <div class="container-fluid">
         <form id="cmsForm" action="{{ url('admin/users/add') }}" enctype="multipart/form-data" method="post" >
            @csrf
            <div class="row">
               <div class="col-md-8">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Add User</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Name</label>
                              <input type="text" id="name" name="name" class="form-control" placeholder="Name" >
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Email</label>
                              <input type="text" id="email" name="email" class="form-control" placeholder="Email" >
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Username</label>
                              <input type="text" id="username" name="username" class="form-control" placeholder="Username" >
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Nice Name</label>
                              <input type="text" id="nicename" name="nicename" class="form-control" placeholder="Nicename" >
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Password</label>
                              <input type="password" id="password" name="password" class="form-control" placeholder="Password" >
                           </div>
                        </div>
						<div class="form-group">
							<div class="form-label-group">
								<label for="confirm_password">Confirm Password</label>
								<input type="password" class="form-control" id="confirm_password" placeholder="Confirm Password" name="confirm_password">
							</div>
						</div>
						<div class="form-group">
						   <div class="form-label-group">
							  <label for="description">Description</label>
								<textarea name="description" id="description" class="form-control" cols="20" rows="5">
								</textarea>
						   </div>
						</div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card card-header">
                     
                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="is_active" name="is_active" class="form-control">
                              <option value="">Select Status</option>
                              <option value="1">Enable</option>
                              <option value="0">Disable</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </section>
</div>
<!-- Sticky Footer -->
<script>
   $(function () {
     // Summernote
     $('#description').summernote({
	 height:250
	})
   
   })
</script>
@endsection