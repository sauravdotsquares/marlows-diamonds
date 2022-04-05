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
          <i class="fas fa-table"></i> Footer Settings
        </div>
        <div class="card-body">
          <form action="{{ url('admin/settings-update') }}" enctype="multipart/form-data" method="post">
           @csrf 
            
			<div class="row">
               <div class="col-md-7">
                  <div class="card card-primary">
                     			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Section 1</h3>
              </div>
              <div class="card-body">
                <!-- Color Picker -->
                <div class="form-group">
                  <label>Section 1 Title</label>
                  <input type="text" id="sec1-title" name="sec1-title" value="{{$settings1->get_options('sec1-title')}}" class="form-control" placeholder="Section 1 Title" >
                </div>
                
				<div class="form-label-group">
                              <label for="product_name">About</label>
                              
							 <textarea id="about" name="about" class="form-control">{{$settings1->get_options('about')}}</textarea>   
                </div>
                
              </div>
              
            </div>
			
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Section 2</h3>
              </div>
              <div class="card-body">
                <!-- Color Picker -->
                <div class="form-group">
                  <label>Section 2 Title</label>
                  <input type="text" id="sec2-title" name="sec2-title" value="{{$settings1->get_options('sec2-title')}}" class="form-control" placeholder="Section 2 Title" >
                </div>
                
				<div class="form-label-group">
                              <label for="product_name">Catalogue</label>
                              
							 <textarea id="catalogue" name="catalogue" class="form-control">{{$settings1->get_options('catalogue')}}</textarea>   
                </div>
                
              </div>
              
            </div>
			
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Section 3</h3>
              </div>
              <div class="card-body">
                <!-- Color Picker -->
                <div class="form-group">
                  <label>Section 3 Title</label>
                  <input type="text" id="sec3-title" name="sec3-title" value="{{$settings1->get_options('sec3-title')}}" class="form-control" placeholder="Section 3 Title" >
                </div>
                
				<div class="form-label-group">
                              <label for="product_name">Resources</label>
                              
							 <textarea id="resources" name="resources" class="form-control">{{$settings1->get_options('resources')}}</textarea>   
                </div>
                
              </div>
              
            </div>
			
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Section 4</h3>
              </div>
              <div class="card-body">
                <!-- Color Picker -->
                <div class="form-group">
                  <label>Section 4 Title</label>
                  <input type="text" id="sec4-title" name="sec4-title" value="{{$settings1->get_options('sec4-title')}}" class="form-control" placeholder="Section 4 Title" >
                </div>
                
				<div class="form-label-group">
                              <label for="product_name">Resources</label>
                              
							 <textarea id="sec-resources" name="sec-resources" class="form-control">{{$settings1->get_options('sec-resources')}}</textarea>   
                </div>
                
              </div>
              
            </div>
			
			<div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Section 5</h3>
              </div>
              <div class="card-body">
                <!-- Color Picker -->
                <div class="form-group">
                  <label>Section 5 Title</label>
                  <input type="text" id="sec5-title" name="sec5-title" value="{{$settings1->get_options('sec5-title')}}" class="form-control" placeholder="Section 5 Title" >
                </div>
                
				<div class="form-label-group">
                              <label for="product_name">Policies</label>
                              
							 <textarea id="policies" name="policies" class="form-control">{{$settings1->get_options('policies')}}</textarea>   
                </div>
                
              </div>
              
            </div>
				  </div>
               </div>
               <div class="col-md-5">
                  <div class="card card-header">
                    <div class="card card-info">
						<div class="card-header">
						<h3 class="card-title">Footer Bottom</h3>
						</div>
					</div> 
					<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Footer Left</label>
                             <textarea id="footer-left" name="footer-left" class="form-control">{{$settings1->get_options('footer-left')}}</textarea> 
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Footer Center</label>
                             <textarea id="footer-center" name="footer-center" class="form-control">{{$settings1->get_options('footer-center')}}</textarea> 
                           </div>
                        </div>
						<div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Footer Right</label>
                             <textarea id="footer-right" name="footer-right" class="form-control">{{$settings1->get_options('footer-right')}}</textarea> 
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
     $('#about').summernote()
     $('#catalogue').summernote()
     $('#resources').summernote()
     $('#sec-resources').summernote()
     $('#policies').summernote()
     $('#footer-left').summernote()
     $('#footer-center').summernote()
     $('#footer-right').summernote()
     
   
   })
</script>  
@endsection