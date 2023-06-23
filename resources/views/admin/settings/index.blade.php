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
        <div class="col-md-6">
        <div class="card card-primary">

        <div class="card-body">
          <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Site Title</label>
                <input type="text" id="site_title" name="site_title" value="{{$settings1->get_options('site_title')}}" class="form-control" placeholder="Site Title">
             </div>
          </div>
          <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Site Tagline</label>
                <input type="text" id="site_tagline" name="site_tagline" value="{{$settings1->get_options('site_tagline')}}" class="form-control" placeholder="Site Tagline">
             </div>
          </div>
          <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Site Address(URL)</label>
                <input type="text" id="site_url" name="site_url" value="{{$settings1->get_options('site_url')}}" class="form-control" placeholder="Site Address(URL)">
             </div>
          </div>

          <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Administration Email Address</label>
                <input type="text" id="admin_email" name="admin_email" value="{{$settings1->get_options('admin_email')}}" class="form-control" placeholder="Admin Email">
             </div>
          </div>

          <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Contact No.</label>
                <input type="text" id="contact_no" name="contact_no" value="{{$settings1->get_options('contact_no')}}" class="form-control" placeholder="Contact No.">
             </div>
          </div>
         
        
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Cookie bar message</label>
               <textarea id="cookie_message" name="cookie_message" class="form-control">{{$settings1->get_options('cookie_message')}}</textarea> 
             </div>
          </div>
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Google Analytics Script</label>
               <textarea id="google_analytics_code" name="google_analytics_code" class="form-control">{{$settings1->get_options('google_analytics_code')}}</textarea> 
             </div>
          </div>
          <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Google Tag Manager Script</label>
               <textarea id="google_tag_manager_code" name="google_tag_manager_code" class="form-control">{{$settings1->get_options('google_tag_manager_code')}}</textarea> 
             </div>
          </div>
        </div>
        </div>
        </div>

       <div class="col-md-6">
          <div class="card card-header">
             <div class="form-group">
                <label for="exampleInputFile">Logo</label>
                @if($settings1->get_options('logo')!='') 
                  <div class="input-group"><img src="{{url('/').'/images/logo/'.$settings1->get_options('logo')}}" width="150px;"></div>
                @endif
                <div class="input-group">
                   <div class="custom-file">
                      
                      <input type="file" id="logo" name="logo" value="{{ $settings1->get_options('logo') }}" class="custom-file-input" accept="image/*">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                   </div>
                </div>
             </div>
             <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Facebook</label>
                <input type="text" id="facebook" name="facebook" value="{{$settings1->get_options('facebook')}}" class="form-control" placeholder="Facebook">
             </div>
          </div>
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Twitter</label>
                <input type="text" id="twitter" name="twitter" value="{{$settings1->get_options('twitter')}}" class="form-control" placeholder="Twitter">
             </div>
          </div>
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Instagram</label>
                <input type="text" id="instagram" name="instagram" value="{{$settings1->get_options('instagram')}}" class="form-control" placeholder="Instagram">
             </div>
          </div>
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Pinterest</label>
                <input type="text" id="pinterest" name="pinterest" value="{{$settings1->get_options('pinterest')}}" class="form-control" placeholder="Pinterest">
             </div>
          </div>
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Youtube</label>
                <input type="text" id="youtube" name="youtube" value="{{$settings1->get_options('youtube')}}" class="form-control" placeholder="Youtube">
             </div>
          </div>
        <div class="form-group">
             <div class="form-label-group">
                <label for="product_name">Linkedin</label>
                <input type="text" id="linkedin" name="linkedin" value="{{$settings1->get_options('linkedin')}}" class="form-control" placeholder="Linkedin">
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