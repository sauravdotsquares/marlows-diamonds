@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <form id="cmsForm" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __("Basic information")}}</h3>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label for="title">{{ __("Name")}}</label>
                                    <input type="text" id="title" name="title" class="form-control" value="{{ $product->title  }}" placeholder="{{ __("Name")}}">
                                    @error('title') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>

                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label for="tags">{{ __("Tags")}}</label>
                                    <input type="text" id="tags" name="tags" class="form-control" value="{{ $product->tags }}" placeholder="{{ __("Tags")}}">
                                    @error('tags') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>


                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label for="categories">{{ __("Categories")}}</label>
                                    <select name="categories[]" id="categories" class="form-control select2 select2-hidden-accessible" multiple="" data-dropdown-css-class="select2-purple" style="width: 100%;" aria-hidden="true">
                                        {!!  $category_data !!}
                                    </select>
                                    @error('categories') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-12">
                                    <div class="form-label-group">
                                        <label for="short_description">{{ __("Short Description")}}</label>
                                        <textarea id="short_description" name="short_description" class="form-control ckeditor">{{ $product->short_description }}</textarea>
                                        @error('short_description') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group col-sm-12 col-md-12">
                                    <div class="form-label-group">
                                       <label for="description">{{ __("Description")}}</label>
                                       <textarea id="description" name="description" class="form-control ckeditor">{{ $product->description }}</textarea>
                                       @error('description') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title">{{ __("Meta information")}}</h3>
                        </div>

                        <div class="card-body">

                            <input type="hidden" id="metaId" name="meta_id" value="{{ $product->productMeta->id }}" >

                            <div class="form-group col-sm-12 col-md-12">
                                <div class="form-label-group">
                                    <label for="meta_title">{{ __("Meta title")}}</label>
                                    <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ $product->productMeta->meta_title }}" placeholder="{{ __("Meta title")}}">
                                    @error('meta_title') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                            </div>

                            <div class="form-group col-md-12 col-sm-12">
                                <div class="form-label-group">
                                    <label for="meta_keyword">{{ __("Meta keywords")}}</label>
                                    <input type="text" id="meta_keyword" name="meta_keyword" class="form-control" value="{{ $product->productMeta->meta_keywords }}" placeholder="{{ __("Meta keywords")}}">
                                    @error('meta_keyword') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                            </div>

                            <div class="form-group col-sm-12 col-md-12">
                                <div class="form-label-group">
                                   <label for="meta_description">{{ __("Meta Description")}}</label>
                                   <textarea id="meta_description" name="meta_description" class="form-control">{{ $product->productMeta->meta_description }}</textarea>
                                   @error('meta_description') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title">{{ __("Variable information")}}</h3>
                        </div>

                        <div class="card-body">
                            
                            <div class="form-group row">
                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label for="is_variation">{{ __("Variable Product")}}</label>
                                    <select name="is_variation" id="is_variation" class="form-control">
                                      <option value="0" {{ $product->is_variable ? '' : 'selected' }}> {{ __("No")}}</option>
                                      <option value="1" {{ $product->is_variable ? 'selected' : '' }}> {{ __("Yes")}}</option>
                                    </select>
                                    @error('is_variation') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label for="status">{{ __("Product Status")}}</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="1" {{ $product->status ? 'selected' : '' }}>{{ __("Published")}}</option>
                                        <option value="0" {{ $product->status ? '' : 'selected' }}>{{ __("Not Published")}}</option>
                                    </select>
                                    @error('status') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                                
                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label>{{ __("Enable Diamond Finder")}}</label>
                                    <select id="dfinder_status" name="dfinder_status" class="form-control">
                                        <option value="">{{ __("Select Diamond Finder Status")}}</option>
                                        <option value="1" {{ $product->dfinder_status ? 'selected' : '' }}>{{ __("Yes")}}</option>
                                        <option value="0" {{ $product->dfinder_status ? '' : 'selected' }}>{{ __("No")}}</option> 
                                    </select>
                                    @error('dfinder_status') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>

                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label>{{ __("Diamond Shape")}}</label>
                                    <select id="diamond_shape" name="diamond_shape" class="form-control">
                                        <option value="">{{ __("Select Diamond Shape")}}</option>
                                        @foreach($diamondShapes as $diamondShape)
                                            <option  {{ $product->diamond_shape == $diamondShape->value ? 'selected' : ''  }} value="{{$diamondShape->value}}">{{$diamondShape->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('diamond_shape') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>

                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label>{{ __("Featured Status")}}</label>
                                    <select id="is_featured" name="is_featured" class="form-control">
                                       <option value="">{{ __("Select Featured")}}</option>
                                       <option value="1"  {{ $product->is_featured ? 'selected' : '' }}>{{ __("Featured")}}</option>
                                    </select>
                                    @error('is_featured') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>

                                <div class="form-label-group col-sm-12 col-md-6">
                                    <label>{{ __("Price combinations")}}</label>
                                    <select id="combinations" name="combination_id" class="form-control">
                                        <option value="">{{ __("Select global price Combinations")}}</option>
                                        @foreach($combinations as $combinations_value)
                                            <option {{ $product->combination_id ==$combinations_value['id'] ? 'selected' : ''  }} value="{{$combinations_value['id'] }}">{{ $combinations_value['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('combination_id') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                            </div>

                        </div>

                        <div class="card-header">
                            <h3 class="card-title">{{ __("Image gallary")}}</h3>
                        </div>
                        <div class="card-body">


                            <div class="form-label-group col-sm-12 col-md-12">
                                <label>{{ __("Thumbnail image")}}</label>
                                <input type="text" id="thumb_image" name="media[thumb_image]" class="form-control file_uploader"
                                    value="{{ 
                                        !empty($product->productImages) && !empty($product->productImages['thumb_image_img_id'])
                                        ? implode(',', $product->productImages['thumb_image_img_id']) : ''
                                    }}"
                                >
                            </div>

                            <div class="form-label-group col-sm-12 col-md-12">
                                <label>{{ __("Thumbnail hover image/video")}}</label>
                                <input type="text" id="thumb_video" name="media[thumb_video]" class="form-control" 
                                    value="{{ 
                                        !empty($product->productImages) && !empty($product->productImages['thumb_video_img_id'])
                                        ? implode(',', $product->productImages['thumb_video_img_id']) : ''
                                    }}"
                                >
                            </div>

                            <div class="form-label-group col-sm-12 col-md-12">
                                <label>{{ __("Featured image")}}</label>
                                <input type="text" id="featured_image" name="media[featured_image]" class="form-control" 
                                    value="{{ 
                                        !empty($product->productImages) && !empty($product->productImages['featured_image_img_id'])
                                        ? implode(',', $product->productImages['featured_image_img_id']) : ''
                                    }}"
                                >
                            </div>

                            <div class="form-label-group col-sm-12 col-md-12">
                                <label>{{ __("Image gallary")}}</label>
                                <input type="text" id="product_gallery" name="media[product_gallery]" class="form-control" 
                                    value="{{ 
                                        !empty($product->productImages) && !empty($product->productImages['product_gallery_img_id'])
                                        ? implode(',', $product->productImages['product_gallery_img_id']) : ''
                                    }}"
                                >
                            </div>
                            
                        </div>

                        <div class="card-header">
                            <h3 class="card-title">{{ __("Attributes")}}</h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($attributes as $attributes_key => $attributes_value) { ?>
                                    <div class="form-group col-sm-4">
                                        <div class="form-check">
                                            <input id="attr-{{$attributes_value['id']}}" {{ in_array($attributes_value['id'], $product->product_attributes_ids) ? 'checked' : '' }} class="form-check-input" type="checkbox" name="attributes[]" value="{{ $attributes_value['id'] }}">
                                            <label for="attr-{{$attributes_value['id']}}" class="form-check-label">{{ $attributes_value['name'] }}</label>
                                        </div>
                                    </div>
                                <?php } ?>
                                @error('attributes') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="form-label-group col-sm-12 col-md-4" style="float: right;">
                                <button type="submit" class="btn btn-success btn-block">Next</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


@endsection


@section('css')
<link rel="stylesheet" href="{{asset('/admin/custom_plugins/jquery-tags/dist/jquery.tagsinput.min.css')}}">
<link rel="stylesheet" href="{{asset('/admin/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<style>
   div.tagsinput{ padding: 0px; }
   /* .filepond--credits{  display: none; }
   .file_uploader-container { display: inline-block; position: relative; margin: 20px; margin-left: 0px; }
   .file_uploader-container i { z-index: 10; position: absolute; font-size: 22px;  color: #973e71; right: 0; cursor: pointer; right: -7px; top: -9px;  }
   .file_uploader-img, .file_uploader-video { height:100px; width:100px; } */
</style>
@endsection

@section('js')
<script src="{{asset('/admin/custom_plugins/jquery-tags/dist/jquery.tagsinput.min.js')}}"></script>
<script src="{{asset('/admin/plugins/select2/js/select2.full.min.js')}}"></script>
{{-- <script src="{{asset('/admin/js/file_uploader.js')}}"></script> --}}
<script>

    var summernote_options = {
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    };

    $(document).ready(function() {
        
        $('#tags').tagsInput({
            height: "auto",
            width: "auto"
        });
        $('#categories').select2();
        $('#short_description').summernote({height:50, ...summernote_options});
        $('#description').summernote({height:100, ...summernote_options});
    });

      

</script>
@endsection