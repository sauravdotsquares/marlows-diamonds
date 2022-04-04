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
   <!-- DataTables Example -->
   <section class="content">
      <div class="container-fluid">
         <form action="{{ url('admin/banners/edit/'.base64_encode($banners->id)) }}" enctype="multipart/form-data" method="post"  id="cmsForm">
            @csrf
            <div class="row">
               <div class="col-md-8">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Edit Banner</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Title</label>
                              <input type="text" id="title" name="title" value="{{ $banners->title }}" class="form-control" placeholder="Banner Name">
                           </div>
                        </div>
						<div class="form-group">
							<div class="form-label-group">
							<select id="page_id" name="page_id" class="form-control"  autofocus="autofocus">
                        <option value="">Select Page</option>
                        @foreach($pages as $page)
                          <option value = {{ $page->id }} {{ $page->id==$banners->page_id ? 'selected' : '' }} >{{ $page->title }}</option>
                        @endforeach
                      </select>                      
							</div>
						</div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <textarea id="description" name="description" class="form-control ckeditor" placeholder="Banner Description" >{{ $banners->description }}</textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card card-header">
                     <div class="form-group">
                        <label for="exampleInputFile">Banner</label>
                        <div class="input-group">
                           <div class="custom-file">
                              @if($banners->image!='') 
                              <img src="{{url('/').'/images/'.$banners->image}}" width="150px;">
                              @endif
                              <input type="file" id="image" name="image" value="{{ $banners->image }}" class="custom-file-input" accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="status" name="status" class="form-control">
                              <option value="">Select Status</option>
                              <option value="1" {{ $banners->status=='1' ? 'selected' : '' }} >Enable</option>
                              <option value="0" {{ $banners->status=='0' ? 'selected' : '' }} >Disable</option>
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

