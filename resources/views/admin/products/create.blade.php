@extends('layouts.admin.app')

@section('css')
<link rel="stylesheet" href="{{asset('')}}/admin/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{asset('')}}/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />

<style>
   .bootstrap-tagsinput .tag {
      margin-right: 2px;
      color: black;
   }
</style>

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
@if (\Session::has('success'))
<div class="alert alert-success">
   <ul>
      <li>{!! \Session::get('success') !!}</li>
   </ul>
</div>
@endif
@if (\Session::has('error'))
<div class="alert alert-error">
   <ul>
      <li>{!! \Session::get('error') !!}</li>
   </ul>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
   @foreach ($errors->all() as $error)
   {{$error}}
   @endforeach
</div>
@endif
<div class="content">
   <!-- DataTables Example -->
   <section class="content">
      <div class="container-fluid">
         <form id="addForm" action="{{route('admin.submit-product')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
               <div class="col-md-12">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Add Products</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="title">Title</label>
                              <input required type="text" id="title" name="title" class="form-control" placeholder="Title"
                                 value="{{isset($getData->title)?$getData->title:''}}">
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="slug">Slug</label>
                              <input type="text" id="slug" name="slug" class="form-control" placeholder="Slug"
                                 value="{{isset($getData->slug)?$getData->slug:''}}">
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="tags">Tags (Separate tags with commas)</label>
                              <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags"
                                 data-role="tagsinput" value="{{isset($getData->tags)?$getData->tags:''}}">
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="categories">Categories</label>
                              <select name="categories[]" id="categories" class="select2 select2-hidden-accessible"
                                 multiple="" data-dropdown-css-class="select2-purple" style="width: 100%;"
                                 data-select2-id="7" tabindex="-1" aria-hidden="true">

                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="is_variation">Variation</label>
                              <select name="is_variation" id="is_variation" class="form-control">
                                 <option value=""> Select Any</option>
                                 <option value="0" selected> No</option>
                                 <option value="1"> Yes</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group" style="display:none;">
                           <div class="form-label-group">
                              <label for="is_quantity">Manage Quantity</label>
                              <select name="is_quantity" id="is_quantity" class="form-control">
                                 <option value=""> Select Any</option>
                                 <option value="0"> Out Stock</option>
                                 <option value="1" selected> In Stock</option>
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="short_description">Short Description</label>
                              <textarea id="short_description" name="short_description"
                                 class="form-control ckeditor">{{isset($getData->short_description)?$getData->short_description:''}}</textarea>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="description">Description</label>
                              <textarea id="description" name="description"
                                 class="form-control ckeditor">{{isset($getData->description)?$getData->description:''}}</textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="card card-header">
                     <div class="form-group">
                        <label for="featured_image">Product Image</label>
                        @if(isset($getData->image_url) && !empty($getData->image_url))
                        <img src="{{asset('images').'/'.$getData->image_url}}" alt="" height="50px" width="50px">
                        @endif
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" id="featured_image" name="featured_image" class="custom-file-input"
                                 accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="gallery_image">Product Gallery</label>
                        @if(isset($getData->image_url) && !empty($getData->image_url))
                        <img src="{{ asset('storage/'.$getData->image_url) }}" alt="" height="50px" width="50px">
                        @endif
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" id="gallery_image" name="gallery_image[]" multiple
                                 class="custom-file-input" accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="status" name="status" class="form-control">
                              <option value="">Select Status</option>
                              @if(isset($getData->status) && $getData->status == 1)
                              <option value="1" selected>Published</option>
                              <option value="0">Not Published</option>
                              @elseif(isset($getData->status) && $getData->status == 0)
                              <option value="1">Published</option>
                              <option value="0" selected>Not Published</option>
                              @else
                              <option value="1" selected>Published</option>
                              <option value="0">Not Published</option>
                              @endif
                           </select>
                        </div>
                     </div>
					 <div class="form-group">
                        <div class="form-label-group">
						<label>Diamond Finder Status</label>
                           <select id="dfinder_status" name="dfinder_status" class="form-control">
                              <option value="">Select Diamond Finder Status</option>
                              @if(isset($getData->dfinder_status) && $getData->dfinder_status == 1)
                              <option value="1" selected>Yes</option>
                              <option value="0">No</option>
                              @elseif(isset($getData->dfinder_status) && $getData->dfinder_status == 0)
                              <option value="1">Yes</option>
                              <option value="0" selected>No</option>
                              @else
                              <option value="1" selected>Yes</option>
                              <option value="0">No</option>
                              @endif
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="is_featured" name="is_featured" class="form-control">
                              <option value="">Select Featured</option>
                              @if(isset($getData->is_featured) && $getData->is_featured == 1)
                              <option value="1" selected>Featured</option>
                              @else
                              <option value="1">Featured</option>
                              @endif
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_title">Meta Title</label>
                           <input type="text" id="meta_title" name="meta_title" class="form-control"
                              placeholder="Meta Title" value="{{isset($getData->meta_title)?$getData->meta_title:''}}">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_keyword">Meta Keywords</label>
                           <input type="text" id="meta_keyword" name="meta_keyword" class="form-control"
                              placeholder="Meta Keywords"
                              value="{{isset($getData->meta_keyword)?$getData->meta_keyword:''}}">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_description">Meta Description</label>
                           <textarea id="meta_description" name="meta_description" class="form-control ckeditor"
                              placeholder="Meta Description">{{isset($getData->meta_description)?$getData->meta_description:''}}</textarea>
                        </div>
                     </div>

                  </div>
               </div>
               <div class="col-md-12">
                  <div class="card-body">
                     <h4>Product Data</h4>
                     <div class="row">
                        <div class="col-5 col-sm-3">
                           <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                              aria-orientation="vertical">
                              <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill"
                                 href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home"
                                 aria-selected="true">General</a>
                              <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill"
                                 href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile"
                                 aria-selected="false">Attributes</a>
                              <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill"
                                 href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages"
                                 aria-selected="false">Variations</a>
                              <!-- <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill"
                                 href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings"
                                 aria-selected="false">Settings</a> -->
                           </div>
                        </div>
                        <div class="col-7 col-sm-9">
                           <div class="tab-content" id="vert-tabs-tabContent">
                              <div class="tab-pane text-left fade active show" id="vert-tabs-home" role="tabpanel"
                                 aria-labelledby="vert-tabs-home-tab">
                                 <div class="card-body">
                                    <div class="form-group">
                                       <div class="form-label-group">
                                          <label for="sale_price">Sale Price</label>
                                          <input type="text" id="sale_price" name="sale_price" class="form-control"
                                             placeholder="Sale Price" value="{{isset($getData->sale_price)?$getData->sale_price:''}}">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="form-label-group">
                                          <label for="regular_price">Regular Price</label>
                                          <input type="text" id="regular_price" name="regular_price" class="form-control"
                                             placeholder="Regular Price" value="{{isset($getData->regular_price)?$getData->regular_price:''}}">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <div class="form-label-group">
                                          <label for="is_taxable">Taxable</label>
                                          <select name="is_taxable" id="is_taxable" class="form-control">
                                             <option value=""> Select Any</option>
                                             <option value="0"> Non Taxable</option>
                                             <option value="1"> Taxable</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>


                              </div>
                              <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                                 aria-labelledby="vert-tabs-profile-tab">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-2">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="attribute_name">Name</label>
                                                <input type="text" id="attribute_name" name="attribute_name"
                                                   class="form-control" placeholder="Title"
                                                   value="{{isset($getData->title)?$getData->title:''}}">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="attribute_value">Value</label>
                                                <textarea name="attribute_value" id="attribute_value" cols="30"
                                                   rows="10"
                                                   placeholder="Enter some text, or some attributes by '|' separating values."></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-2">
                                          <div class="form-group">
                                             <button class="btn btn-primary" id="addAttributeAdd">Add</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-md-12">
                                       <div id="show_attributes">

                                       </div>
                                    </div>
                                 </div>

                              </div>
                              <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                 aria-labelledby="vert-tabs-messages-tab">

                                 <div id="show_variation">
                                    <p style="margin:0px 0px 0px 0px;"> <a href="javascript:void(0)" name="add_item" id="add_item" style="font-weight:bold;font-size:16px;">Add Variation</a>
                                    </p>

                                    <div class="accordion" id="accordionExample">
                                       <div id="item_details" class="card">
                                          <div class="card-header" id="headingOne">
                                             <div id="dropdownVariation">


                                             </div>
                                          </div>

                                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                             data-parent="#accordionExample">
                                             <div class="card-body">
                                                <div class="card-body">
                                                   <div class="row">
                                                      <div class="col-md-6">
                                                         <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_image">Image</label>
                                                               <input data-field="vari_image" type="file" id="vari_image" name="data[0][vari_image]"
                                                                  class="form-control">
                                                            </div>
                                                         </div>
                                                         <!-- <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_sku">SKU</label>
                                                               <input type="text" id="vari_sku" name="vari_sku[]"
                                                                  class="form-control" placeholder="SKU">
                                                            </div>
                                                         </div> -->
                                                         <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_sale_price">Sale Price</label>
                                                               <input data-field="vari_sale_price" type="text" id="vari_sale_price" name="data[0][vari_sale_price]"
                                                                  class="form-control" placeholder="Sale Price">
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                         <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_video">Video</label>
                                                               <input data-field="vari_video" type="file" id="vari_video" name="data[0][vari_video]"
                                                                  class="form-control">
                                                            </div>
                                                         </div>
                                                         <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_stock_status">Stock Status</label>
                                                               <select data-field="vari_stock_status" name="data[0][vari_stock_status]" id="vari_stock_status"
                                                                  class="form-control">
                                                                  <option value=""> Select Any</option>
                                                                  <option value="1"> In Stock</option>
                                                                  <option value="0"> Out Stock</option>
                                                               </select>
                                                            </div>
                                                         </div>
                                                         <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_regular_price">Regular Price</label>
                                                               <input data-field="vari_regular_price" type="text" id="vari_regular_price"
                                                                  name="data[0][vari_regular_price]" class="form-control"
                                                                  placeholder="Regular Price">
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>

                                          <p style="margin:-16px 0px 0px 600px;">
                                             <a href="javascript:void(0)" name="remove_item" class='remove' id="remove_item" style="font-weight:bold;color:red;font-size:16px;">Remove Variation</a></p>
                                       </div>
                                       <div id="new_item_details" class="new_item_details"></div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary">Submit</button>
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
<!-- Select2 -->
<script src="{{asset('')}}/admin/plugins/select2/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>

<script>
   $('.select2').select2();

   $("#tags").val();

   $("#tags").tagsinput('items');

   $(function () {
      // Summernote
      $('#short_description').summernote()
      $('#description').summernote()

   });

   //validation and form submission function here
   $('#addAttributeAdd').on('click', function (e) {
      if (!confirm('Are you sure you want to Insert/update this attribute ?')) {
         e.preventDefault();
         return false;
      } else {
         $.ajax({
            type: 'POST',
            url: '{{route("admin.add-attribute")}}',
            data: {
               '_token': "{{csrf_token()}}",
               'name': $('#attribute_name').val(),
               'value': $('#attribute_value').val(),
            },
            success: function (res) {
               console.log(res);
               getAttribute();
               return false;
            }
         });
      }
      return false;
   });
   getAttribute();
   function getAttribute() {
      $.ajax({
         type: 'POST',
         url: '{{route("admin.get-attribute")}}',
         data: {
            '_token': "{{csrf_token()}}",
         },
         success: function (res) {
            console.log(res);
            if (res) {
               $('#show_attributes').empty();
               $("#show_attributes").append(res.getAttributeDesign);
               $('#attribute_name').va("");
               $('#attribute_value').va("");
               getDropdownDesign(res.getData);
            }
            return false;
            // console.log(res);
            // if (res.length) {
            //    $('#show_attributes').empty();
            //    $.each(res, function (key, value) {
            //       $("#show_attributes").append('<div><input type="checkbox" id="attributevari' + value.id + '" name="selected_attribute_name[]" data-name="' + value.name + '" data-value="' + value.values + '" value="attri_' + value.slug + '">' + value.name + '</div>');
            //    });
            // }
            // return false;
         }
      });
   }

   function getDropdownDesign(res){
      $('.dropdownVariation').html("");
      $.each(res, function (key, value) {
         let changeText = $(document).find('#attributevari'+value.id).val();
         let changeTextArray = $(document).find('#attributevari'+value.id).data('value').split('|');
         let changeTextName = $(document).find('#attributevari'+value.id).data('name');
         if ($(document).find('#attributevari'+value.id).prop('checked') == true) {
            $(".dropdownVariation").append("<select data-field='" + changeText + "' id='" + changeText + "' name='data[0][" + changeText + "]' class'form-control'><option value=''>Select Any " + changeTextName + "</option></select> ");
            $.each(changeTextArray, function (key, value) {
               $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");
            });
         }else {
            $("#" + changeText).remove();
         }
      });
   }

   $(document).on('change', "[id^=attributevari]", function () {
      var index = parseInt($(this).attr("id").replace("attributevari", ''));
      // let changeText = $(this).data('name').replace(/ /g, "_");
      let changeText = $(this).val();
      // let changeTextName = $(this).data('name');

      let dataValue = $(this).val();


      if ($(this).prop('checked') == true) {
         $("#dropdownVariation").append("<select data-field='" + changeText + "' id='" + changeText + "' name='data[0][" + changeText + "]' class'form-control'><option value=''>Select Any " + $(this).data('name') + "</option></select> ");
         $.each($(this).data('value').split('|'), function (key, value) {
            console.log(value);
            $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");
         });
      }
      else {
         $("#" + changeText).remove();
      }
   });

   // $("#addVariationClone").on('click',function(){
      
   // });

   var selectedCategoryData = '{{$selectedParentId}}';

   getParentCategory(selectedCategoryData);

   function getParentCategory(selectedCategoryData) {
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


   var id = 0;
   $(document).ready(function () {
      var max = 10;

      $('#add_item').click(function () {
         var button = $('#item_details').clone(true);
         id++;
         button.find('input').val('');
         button.removeAttr('id');
         button.insertBefore('.new_item_details');
         button.attr('id', 'new_' + id);

         button.find('input').each(function() {
               const fieldname = $(this).attr('data-field');
               $(this).attr('name', 'data[' + id + '][' + fieldname + ']');
         });

         button.find('select').each(function() {
               const fieldname = $(this).attr('data-field');
               $(this).attr('name', 'data[' + id + '][' + fieldname + ']');
         });


      });

      $('.remove').click(function(e){
         $("#new_"+id).remove();
         id--;
         e.preventDefault();
      });
   });


</script>
@endsection