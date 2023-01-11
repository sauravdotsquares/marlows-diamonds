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
   <!-- DataTables Example -->
   <section class="content">
      <div class="container-fluid">
         <form action="{{ url('admin/users/edit/'.base64_encode($users->id)) }}" enctype="multipart/form-data" method="post"  id="cmsForm">
            @csrf
            <div class="row">
               <div class="col-md-8">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Edit User</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Name</label>
                              <input type="text" id="name" name="name" value="{{ $users->name }}" class="form-control" placeholder="Name">
                           </div>
                        </div>
                         <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Email</label>
                              <input type="text" id="email" name="email" value="{{ $users->email }}" class="form-control" placeholder="Email">
                           </div>
                        </div>
						 <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Username</label>
                              <input type="text" id="nicename" name="nicename" value="{{ $users->nicename }}" class="form-control" placeholder="Name">
                           </div>
                        </div>
						 <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Password</label>
                              <input type="password" id="password" name="password" value="{{ $users->password }}" class="form-control" placeholder="Name">
                           </div>
                        </div>
						 <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Confirm Password</label>
                              <input type="password" id="confirm_password" name="confirm_password" value="{{ $users->confirm_password }}" class="form-control" placeholder="Name">
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                               <label for="product_name">Description</label>
							  <textarea id="description" name="description" class="form-control ckeditor" placeholder="User Description" >{{ $users->description }}</textarea>
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
                              <option value="1" {{ $users->is_active=='1' ? 'selected' : '' }} >Enable</option>
                              <option value="0" {{ $users->is_active=='0' ? 'selected' : '' }} >Disable</option>
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
     $('#description').summernote()
   
   })
</script>
@endsection

