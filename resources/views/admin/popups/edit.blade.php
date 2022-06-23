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
         <form action="{{ url('admin/popups/edit/'.base64_encode($popups->id)) }}" enctype="multipart/form-data" method="post"  id="cmsForm">
            @csrf
            <div class="row">
               <div class="col-md-8">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Edit Popup</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Name</label>
                              <input type="text" id="title" name="title" value="{{ $popups->title }}" class="form-control" placeholder="Name">
                           </div>
                        </div>

                        <div class="form-group">
                           <div class="form-label-group">
                               <label for="product_name">Popup</label>
							  <textarea id="description" name="description" class="form-control ckeditor" placeholder="Popup Description" >{{ $popups->description }}</textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card card-header">

                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="status" name="status" class="form-control">
                              <option value="">Select Status</option>
                              <option value="1" {{ $popups->status=='1' ? 'selected' : '' }} >Enable</option>
                              <option value="0" {{ $popups->status=='0' ? 'selected' : '' }} >Disable</option>
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
    $(document).ready(function() {
        $('#description').summernote({
            height:250,
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
        var form_data = new FormData();
		var SITEURL = '/admin/uploadEditorImage';
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
</script>
@endsection

