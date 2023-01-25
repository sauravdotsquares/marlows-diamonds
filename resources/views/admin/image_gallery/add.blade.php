@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Add new media </h3>
                    </div>
                    

                    <?php $oldFormData = request()->old('form_data') ? request()->old('form_data') :  [0] ?>

                    <form method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" >
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name </label>
                                        <input type="file" class="form-control" id="image_gallary" name="name" placeholder="Enter name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <a href="{{ route('admin.image_gallery.index') }}" class="form-control btn btn-info">Done</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
<style>
    .filepond--credits{  display: none; }
    .file_uploader-container { display: inline-block; position: relative; margin: 20px; margin-left: 0px; }
    .file_uploader-container i { z-index: 10; position: absolute; font-size: 22px;  color: #973e71; right: 0; cursor: pointer; right: -7px; top: -9px;  }
    .file_uploader-img, .file_uploader-video { height:100px; width:100px; }
    .file_uploader-video{ vertical-align: middle; }
</style>
@endsection

@section('js')
<script src="{{asset('/admin/js/file_uploader.js')}}"></script>
    <script>

        imageUploader('#image_gallary', {
            limit : 10,
            inputName : 'product_gallery', 
            addImageUrl : "{{ route('admin.image_gallery.uploadImages') }}",
            csrf : '{{ csrf_token() }}',
            removeImageUrl : `{{ route("admin.image_gallery.removeImage") }}`,
            imgBasePath: "{{ asset('uploads') }}",
            allowedExtensions : ['jpeg','png','jpg','webp','mp4']
        });
        
    </script>
@endsection