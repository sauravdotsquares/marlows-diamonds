@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Add new record </h3>
                    </div>

                    <form method="POST">
                        <div class="card-body">
                            <input type="hidden" name="_token" value="{{csrf_token()}}" >

                            <h4>Basic information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Title </label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{ request()->old('title')  }}">
                                        @error('title') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="tags">Tags </label>
                                        <input type="text" class="form-control" id="tags" name="tags" data-role="tagsinput" placeholder="Enter tags" value="{{ request()->old('tags')  }}">
                                        @error('tags') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="categories">Categories </label>
                                        <select name="categories[]" id="categories" class="select2 select2-hidden-accessible"  multiple="" data-dropdown-css-class="select2-purple" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true"></select>
                                        @error('categories') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="short_description">Short description</label>
                                        <textarea type="text" class="form-control" id="short_description" name="short_description" placeholder="Enter Short description">{{ request()->old('short_description')  }}</textarea>
                                        @error('short_description') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Short description">{{ request()->old('description')  }}</textarea>
                                        @error('description') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="is_variation">Variable Product</label>
                                            <select name="is_variation" id="is_variation" class="form-control">
                                                <option value="0" {{ request()->old('is_variation')=='0' ? 'selected' : ''  }}> No</option>
                                                <option value="1" {{ request()->old('is_variation')=='1' ? 'selected' : ''  }}> Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="status">Product Status</label>
                                            <select id="status" name="status" class="form-control">
                                                <option value="">Select Status</option>
                                                <option value="1" {{ request()->old('status')=='1' ? 'selected' : ''  }}>Published</option>
                                                <option value="0" {{ request()->old('status')=='0' ? 'selected' : ''  }}>Not Published</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label>Enable Diamond Finder</label>
                                            <select id="dfinder_status" name="dfinder_status" class="form-control">
                                                <option value="">Select Diamond Finder Status</option>
                                                <option value="1" {{ request()->old('dfinder_status')=='1' ? 'selected' : ''  }}>Yes</option>
                                                <option value="0" {{ request()->old('dfinder_status')=='0' ? 'selected' : ''  }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label>Featured Status</label>
                                            <select id="is_featured" name="is_featured" class="form-control">
                                                <option value="">Select Featured</option>
                                                <option value="1" {{ request()->old('is_featured')=='1' ? 'selected' : ''  }}>Featured</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="diamond_shape_field">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label>Diamond Shape</label>
                                            <select id="diamond_shape" name="diamond_shape" class="form-control">
                                                <option value="">Select Diamond Shape</option>
                                                @foreach($diamondShapes as $diamondShape)
                                                    <option {{ request()->old('diamond_shape') == $diamondShape->value ? 'selected' : ''  }} value="{{$diamondShape->value}}">{{$diamondShape->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4>Meta information</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Meta Title" value="{{ request()->old('meta_title')  }}">
                                            @error('meta_title') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="meta_keyword">Meta Keywords</label>
                                            <input type="text" id="meta_keyword" name="meta_keyword" class="form-control" placeholder="Meta Keywords" value="{{ request()->old('meta_keyword')  }}">
                                            @error('meta_keyword') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea id="meta_description" name="meta_description" class="form-control ckeditor" placeholder="Meta Description">{{ request()->old('meta_description')  }}</textarea>
                                            @error('meta_description') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('css')
    <link rel="stylesheet" href="{{asset('')}}/admin/plugins/select2/css/select2.min.css" />
    <link rel="stylesheet" href="{{asset('')}}/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />

    <style>
    .bootstrap-tagsinput .tag {
        margin-right: 2px;
        color: black;
    }
    </style>

@endsection


@section('js')
    <script src="{{asset('')}}/admin/plugins/select2/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>

    <script>
        
        $( document ).ready(function() {
            $('#short_description').summernote({ height: 100 });
            $('#description').summernote({ height: 200, });
            $('.select2').select2();
            getParentCategory();
        });

        function getParentCategory() {
            $.ajax({
                type: 'POST',
                url: '{{asset("admin/get-categories")}}',
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': $(this).data('record'),
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
