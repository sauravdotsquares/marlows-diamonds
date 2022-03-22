@extends('layouts.admin.app')

@section('content')
<div class="content">
    <!-- Breadcrumbs-->
    @if(session()->has('alert-danger'))
      <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-danger') }}
      </div>
    @endif
    @if ($errors->has('title'))
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('title') }}
        </div>
    @endif
    @if ($errors->has('description'))
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('description') }}
        </div>
    @endif
    @if ($errors->has('status'))
        <div class="alert alert-danger">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('status') }}
        </div>
    @endif
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{url('/home')}}">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Add Page</li>
    </ol>
    <!-- DataTables Example -->
    <section class="content">
        <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
		<div class="card card-primary">
		<div class="card-header">
                <h3 class="card-title">Add Page</h3>
        </div>
        <form id="cmsForm" action="{{ url('admin/pages/add') }}" enctype="multipart/form-data" method="post" >
		      @csrf          
          <div class="card-body">
                  <div class="form-group">
                    <div class="form-label-group">
					<label for="product_name">Page Name</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Page Name" >
                
              </div>
            </div>
	 
	          <div class="form-group">
              <div class="form-label-group">
                <textarea id="cms_description" name="description" class="form-control ckeditor" placeholder="Page Description" ></textarea>                    
              </div>
            </div>
          
          <div class="form-group">
				   <label for="exampleInputFile">File input</label>
                    <div class="input-group">
					 <div class="custom-file">
                <input type="file" id="image" name="image" class="custom-file-input" accept="image/*">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
            <div class="form-group">
              <div class="form-label-group">
                <select id="status" name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="1">Enable</option>
                    <option value="0">Disable</option>
                </select>
              </div>
            </div>
               <div class="form-group">
                    <div class="form-label-group">
					<label for="product_name">Meta Title</label>
                <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Meta Title" >
                
              </div>
				</div>  
					<div class="form-group">
              <div class="form-label-group">
                <textarea id="meta_description" name="meta_description" class="form-control ckeditor" placeholder="Meta Description" ></textarea>                    
              </div>
            </div>
           <div class="form-group">
             <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>

          </form>
        </div>
        </div>
        </div>
        </div>
		</section>
      </div> 	
<!-- Sticky Footer -->

<script type="text/javascript">
    CKEDITOR.replace( 'cms_description',
    {
      customConfig : 'config.js',
      toolbar : 'simple',
      maxlength : 75
    });
</script>  
@endsection  