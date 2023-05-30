@extends('layouts.admin.app')
@section('css')
<link rel="stylesheet" href="{{asset('')}}/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('')}}/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
<?php 
   if(isset($getData->categories) && $getData->categories != 0){
      $selectedParentId = $getData->categories;
	  
   }elseif(isset($getData->categories) && $getData->categories == 0){
      $selectedParentId = $getData->id;
   }else{
      $selectedParentId = null;
   }
?>
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
         <form action="{{ url('admin/posts/edit/'.base64_encode($posts->id)) }}" enctype="multipart/form-data" method="post"  id="cmsForm">
            @csrf
            <div class="row">
               <div class="col-md-8">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Edit Post</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Title</label>
                              <input type="text" id="title" name="title" value="{{ $posts->title }}" class="form-control" placeholder="Post Name">
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Sub title</label>
                              <input type="text" id="subtitle" name="subtitle" value="{{ $posts->subtitle }}" class="form-control" placeholder="Subtitle" >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Slug</label>
                              <input type="text" id="slug" name="slug" value="{{ $posts->slug }}" class="form-control" placeholder="Slug" >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Short Description</label>
                              <textarea id="short_description" name="short_description" class="form-control">{{ $posts->short_description }}</textarea>                    
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <textarea id="description" name="description" class="form-control ckeditor description" placeholder="Post Description" >{{ $posts->description }}</textarea>
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
						@if(isset($posts->image) && !empty($posts->image))
                              <img src="{{asset('storage').'/'.$posts->image}}" width="50px;">
                        @endif
                           <div class="custom-file">
                              <input type="file" id="image" name="image" value="{{ $posts->image }}" class="custom-file-input" accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="status" name="status" class="form-control">
                              <option value="">Select Status</option>
                              <option value="1" {{ $posts->status=='1' ? 'selected' : '' }} >Enable</option>
                              <option value="0" {{ $posts->status=='0' ? 'selected' : '' }} >Disable</option>
                           </select>
                        </div>
                     </div>
					 <div class="form-group">
						   <div class="form-label-group">
							  <label for="product_name">Categories</label>
							  <select name="categories[]" id="categories" class="select2 select2-hidden-accessible"
								 multiple="" data-dropdown-css-class="select2-purple" style="width: 100%;"
								 data-select2-id="7" tabindex="-1" aria-hidden="true">

							  </select>
						   </div>
					  </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="product_name">Meta Title</label>
                           <input type="text" id="meta_title" name="meta_title" value="{{ $posts->meta_title }}" class="form-control" placeholder="Meta Title">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_keyword">Meta Keywords</label>
                           <input type="text" id="meta_keyword" name="meta_keyword" class="form-control" placeholder="Meta Keywords" value="{{ $posts->meta_keyword }}">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <textarea id="meta_description" name="meta_description" class="form-control ckeditor" placeholder="Meta Description" >{{ $posts->meta_description }}</textarea>
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
@endsection
@section('js')
<script src="{{asset('')}}/admin/plugins/select2/js/select2.full.min.js"></script>
<script>
	$(document).on('change', '.custom-file-input', function (event) {
		$(this).next('.custom-file-label').html(event.target.files[0].name);
	})
	$('.select2').select2();
   
   
   $(document).ready(function() {

		$('.description').summernote({
			height:500,
			codeviewFilter: true,
			codeviewIframeFilter: true,
			focus: false,
			callbacks: {
				onImageUpload: function(files, editor, welEditable) {
					for (var i = files.length - 1; i >= 0; i--) {
						sendEditorFile(files[i], this);
					}
				}
			},
			dialogsFade: true,
			fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
			toolbar: [
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['font', ['style','bold', 'italic', 'underline', 'clear']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['height', ['height']],
				['table', ['table']],
				['insert', ['picture','link']],
				['view', ['fullscreen', 'codeview']],
				['misc', ['undo','redo']]
			]
		});

	});

	function sendEditorFile(file, el) {
		console.log("checking");
        var form_data = new FormData();
		   //var uploadUrl = $('#uploadUrl').attr('url');
         var SITEURL = '{{ route("admin.uploadEditorImage") }}';
		//  var SITEURL = '/admin/uploadEditorImage';
        form_data.append('file', file);
		form_data.append('_token', '{{csrf_token()}}');
        $.ajax({
            type: "POST",
            url: SITEURL,
			data: form_data,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function(url) {
				// return false;
				console.log(url);
               $(el).summernote('editor.insertImage', url);
            }
        });
    }
   
   
   var selectedCategoryData = '{{$selectedParentId}}';

   getParentCategory(selectedCategoryData);

   function getParentCategory(selectedCategoryData) {
      $.ajax({
         type: 'POST',
         url: '{{asset("admin/get-postcategories")}}',
         data: {
            '_token': "{{csrf_token()}}",
            'id': '{{$posts->id}}',
            'status': $(this).data('value')
         },
         success: function (res) {
            if (res) {
               $("#categories").append('<option value="">Select Category</option>' + res);
            }
         }
      })
   }
   
</script> 
@endsection