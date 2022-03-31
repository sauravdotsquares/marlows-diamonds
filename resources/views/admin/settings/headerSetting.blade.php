@extends('layouts.admin.app')

@section('content')
@inject('settings1', 'App\Models\Settings') 
<div id="content-wrapper">
  <div class="container-fluid">
      
      @if(session()->has('alert-danger'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-danger') }}
        </div>
      @endif
      @if(session()->has('alert-success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-success') }}
        </div>
      @endif
     

      

      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i> Settings
        </div>
        <div class="card-body">
          <form action="{{ url('admin/settings-update') }}" enctype="multipart/form-data" method="post">
           @csrf 
            
			<div class="row">
               <div class="col-md-8">
                  <div class="card card-primary">
                     
                     <div class="card-body">
                        
                        
                       
						
						
						
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Google Tag Manager</label>
                             <textarea id="google" name="google" class="form-control">{{$settings1->get_options('google')}}</textarea> 
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Other Scripts</label>
                             <textarea id="other" name="other" class="form-control">{{$settings1->get_options('other')}}</textarea> 
                           </div>
                        </div>
						
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card card-header">
                     
                     <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </div>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
<!-- Sticky Footer -->
<script>
   $(function () {
     // Summernote
     $('#copyright').summernote()
   
   })
</script>  
@endsection