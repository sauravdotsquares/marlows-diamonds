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

   .img_wrp {
        display: inline-block;
        position: relative;
    }
    .close {
        position: absolute;
        top: 0;
        right: 0;
    }
</style>

@endsection

@section('content')


<?php

    $cateArray = explode(",",$getProductData->categories);

   //   echo "<pre>";
   //   print_r($getProductData);
   //   die;

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
<div class="content products_section">
   <!-- DataTables Example -->
   <section class="content">
      <div class="container-fluid">
         <form id="addForm" action="{{route('admin.submit-product')}}" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" name="table_id" id="table_id" value="{{isset($getProductData->id)?$getProductData->id:''}}">
            <input type="hidden" name="slug_bk" id="slug_bk" value="{{isset($getProductData->slug)?$getProductData->slug:''}}">
            <input type="hidden" name="featured_image_bk" id="featured_image_bk" value="{{isset($getProductData->featured_image)?$getProductData->featured_image:''}}">
            <div class="row">
               <div class="col-md-12">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Product Details</h3>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-label-group">
                                    <label for="product_name">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Title"
                                       value="{{isset($getProductData->title)?$getProductData->title:''}}">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-label-group">
                                    <label for="product_name">Slug</label>
                                    <input type="text" id="slug" name="slug" class="form-control" placeholder="Slug"
                                       value="{{isset($getProductData->slug)?$getProductData->slug:''}}">
                                       <a href="{{url('/product/')}}/{{isset($getProductData->slug)?$getProductData->slug:''}}" target="_blank">{{url('/product/')}}/{{isset($getProductData->slug)?$getProductData->slug:''}}</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-label-group">
                                    <label for="product_name">Tags (Separate tags with commas)</label>
                                    <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags"
                                       data-role="tagsinput" value="{{isset($getProductData->tags)?$getProductData->tags:''}}">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-label-group">
                                    <label for="product_name">Categories</label>
                                    <select name="categories[]" id="categories" class="select2 select2-hidden-accessible"
                                       multiple="" data-dropdown-css-class="select2-purple" style="width: 100%;"
                                       data-select2-id="7" tabindex="-1" aria-hidden="true">

                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>



						      <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Short Description</label>
                              <textarea id="short_description" name="short_description"
                                 class="form-control ckeditor">{{isset($getProductData->short_description)?$getProductData->short_description:''}}</textarea>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Description</label>
                              <textarea id="description" name="description"
                                 class="form-control ckeditor">{{isset($getProductData->description)?$getProductData->description:''}}</textarea>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="card card-header">
                     <div class="row">
                        <div class="col-md-6">
                     <div class="form-group">
                        <label for="exampleInputFile">Featured Image</label>
                        @if(isset($getProductData->getProductImages) && !empty($getProductData->getProductImages))
                            <div class="img_wrp">
                                <img src="{{ asset('storage/'.$getProductData->getProductImages->image_url) }}" alt="" id="imgeremovenew{{$getProductData->getProductImages->id}}" class="featured_image imgResponsiveMax">
                                <a href="javascript:void(0);" id="imgeremove{{$getProductData->getProductImages->id}}" data-productdt="{{$getProductData->getProductImages->product_id}}">
                                    <img class="close" src="{{asset('admin\dist\img\cross.png')}}" id="imgeremovenewClose{{$getProductData->getProductImages->id}}" height="10" width="10" />
                                </a>
                            </div>
                        @endif
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" id="featured_image" name="featured_image" class="custom-file-input"
                                 accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="exampleInputFile">Product Gallery</label>
                        @if(isset($getProductData->getProductGallery) && !empty($getProductData->getProductGallery))
                            @foreach($getProductData->getProductGallery as $key => $gallery)
                                <div class="img_wrp">
                                    <img src="{{ asset('storage/'.$gallery->image_url) }}" id="imgeremovenew{{$gallery->id}}"  alt=""  class="gallery_image">
                                    <a href="javascript:void(0);" id="imgeremove{{$gallery->id}}" data-productdt="{{$gallery->product_id}}">
                                        <img class="close" id="imgeremovenewClose{{$gallery->id}}"  src="{{asset('admin\dist\img\cross.png')}}" height="10" width="10" />
                                    </a>
                                </div>
                            @endforeach
                        @endif
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" id="gallery_image" name="gallery_image[]" multiple
                                 class="custom-file-input" accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                                 <div class="form-label-group">
                                    <label for="product_name">Variable Product</label>
                                    <select name="is_variation" id="is_variation" class="form-control">
                                       <option value=""> Select Any</option>
                                       <option value="0" @if($getProductData->is_variable==0) selected @endif> No</option>
                                       <option value="1"  @if($getProductData->is_variable==1) selected @endif> Yes</option>
                                    </select>
                                 </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <div class="form-label-group">
                                 <label for="status">Product Status</label>
                                 <select id="status" name="status" class="form-control">
                                    <option value="">Select Status</option>

                                    <option value="1" @if(isset($getProductData->status) && $getProductData->status == 1) selected @endif>Published</option>

                                    <option value="0" @if(isset($getProductData->status) && $getProductData->status == 0) selected @endif>Not Published</option>

                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                 <div class="form-label-group">
                                    <label>Enable Diamond Finder</label>
                                    <select id="dfinder_status" name="dfinder_status" class="form-control">
                                       <option value="">Select Diamond Finder Status</option>
                                       <option value="1" @if(isset($getProductData->dfinder_status) && $getProductData->dfinder_status == 1) selected @endif>Yes</option>
                                       <option value="0" @if(isset($getProductData->dfinder_status) && $getProductData->dfinder_status == 0) selected @endif>No</option>

                                    </select>
                                 </div>
                              </div>
                           </div>

                           <div class="col-md-6" id="diamond_shape_field"  style="@if(isset($getProductData->dfinder_status) && $getProductData->dfinder_status == 1) display:block @else display:none @endif">
                            <div class="form-group">
                                 <div class="form-label-group">
                                    <label>Diamond Shape</label>
                                    <select id="diamond_shape" name="diamond_shape" class="form-control">
                                       <option value="">Select Diamond Shape</option>
                                       @foreach($diamondShapes as $diamondShape)
                                          <option value="{{$diamondShape->value}}" @if(isset($getProductData->diamond_shape) && $getProductData->diamond_shape == $diamondShape->value) selected @endif>{{$diamondShape->name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                           </div>

                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <div class="form-label-group">
                                    <select id="is_featured" name="is_featured" class="form-control">
                                       <option value="">Select Featured</option>

                                       <option value="1"  @if(isset($getProductData->is_featured) && $getProductData->is_featured == 1) selected @endif>Featured</option>

                                    </select>
                                 </div>
                              </div>
                           </div>
                        </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_title">Meta Title</label>
                           <input type="text" id="meta_title" name="meta_title" class="form-control"
                              placeholder="Meta Title" value="{{isset($getProductData->meta_title)?$getProductData->meta_title:''}}">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_keyword">Meta Keywords</label>
                           <input type="text" id="meta_keyword" name="meta_keyword" class="form-control"
                              placeholder="Meta Keywords"
                              value="{{isset($getProductData->meta_keyword)?$getProductData->meta_keyword:''}}">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="meta_keyword">Meta Description</label>
                           <textarea id="meta_description" name="meta_description" class="form-control ckeditor"
                              placeholder="Meta Description">{{isset($getProductData->meta_description)?$getProductData->meta_description:''}}</textarea>
                        </div>
                     </div>

                  </div>
               </div>
               <div class="col-md-12">
                  <div class="card card-primary">
                  <div class="card-header">
                     <h3 class="card-title">Product Data</h3>
                  </div>
                  <div class="card-body">

                     <div class="row">
                        <div class="col-5 col-sm-3 prod-data-left-section">
                           <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                              aria-orientation="vertical">
                              <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill"
                                 href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home"
                                 aria-selected="true">General</a>
                              <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill"
                                 href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile"
                                 aria-selected="false">Attributes</a>
                              <a class="nav-link" id="variationData" data-toggle="pill"
                                 href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages"
                                 aria-selected="false">Variations</a>
                           </div>
                        </div>
                        <div class="col-7 col-sm-9 prod-data-right-section">
                           <div class="tab-content" id="vert-tabs-tabContent">
                              <div class="tab-pane text-left fade active show" id="vert-tabs-home" role="tabpanel"
                                 aria-labelledby="vert-tabs-home-tab">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="product_name">Sale Price</label>
                                                <input type="text" id="sale_price" name="sale_price" class="form-control"
                                                   placeholder="Sale Price" value="{{isset($getProductData->sale_price)?$getProductData->sale_price:''}}">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="product_name">Regular Price</label>
                                                <input type="text" id="regular_price" name="regular_price" class="form-control"
                                                   placeholder="Regular Price" value="{{isset($getProductData->regular_price)?$getProductData->regular_price:''}}">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="product_name">Taxable</label>
                                                <select name="is_taxable" id="is_taxable" class="form-control">
                                                   <option value=""> Select Any</option>

                                                      <option value="0" @if($getProductData->is_taxable == 0) selected @endif> Non Taxable</option>
                                                      <option value="1"  @if($getProductData->is_taxable == 1) selected @endif> Taxable</option>

                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="in_stock">Stock Status</label>
                                                <select name="in_stock" id="in_stock" class="form-control">
                                                   <option value=""> Select Any</option>
                                                   <option value="0"  @if($getProductData->stock_status == 0) selected @endif> Out Stock</option>
                                                   <option value="1" @if($getProductData->stock_status == 1) selected @endif> In Stock</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>


                              </div>
                              <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel"
                                 aria-labelledby="vert-tabs-profile-tab">
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="product_name">Name</label>
                                                <input type="text" id="attribute_name" name="attribute_name"
                                                   class="form-control" placeholder="Title"
                                                   value="{{isset($getData->title)?$getData->title:''}}">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="product_name">Value</label>
                                                <textarea name="attribute_value" id="attribute_value" cols="30"
                                                   rows="10"
                                                   placeholder="Enter some text, or some attributes by '|' separating values."></textarea>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-2">
                                          <div class="form-group">
                                             <div class="form-label-group">
                                                <label for="addAttributeAdd">&nbsp;</label>
                                                <button class="btn btn-primary" id="addAttributeAdd">Add</button>
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
                                 </div>



                              </div>
                              <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel"
                                 aria-labelledby="vert-tabs-messages-tab">

                                 <div id="show_variation">


                                    <div class="accordion variation_section" id="accordionExample">
                                       <div id="item_details" class="attr_section" data-attr-key="0">
                                          <input type="hidden" class="vari_add_update" id="is_update_0" name="data[0][is_update]" value="">

                                          <div class="card-header" id="headingOne">
                                             <div id="dropdownVariation" class="dropdownVariation"></div>
                                          </div>

                                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                             data-parent="#accordionExample">
                                             <div class="card-body">
                                                <div class="row">
                                                   <div class="col-md-6">
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
                                                            <label for="vari_regular_price">Regular Price</label>
                                                            <input data-field="vari_regular_price" type="text" id="vari_regular_price"
                                                               name="data[0][vari_regular_price]" class="form-control"
                                                               placeholder="Regular Price">
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <div class="form-group">
                                                         <div class="form-label-group">
                                                            <label for="vari_image">Image</label>
                                                            <input data-field="vari_image" type="file" id="vari_image" name="data[0][vari_image]"
                                                               class="form-control">
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
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-6">
                                                         <div class="form-group">
                                                            <div class="form-label-group">
                                                               <label for="vari_stock_status">Stock Status</label>
                                                               <select data-field="vari_stock_status" name="data[0][vari_stock_status]" id="vari_stock_status"
                                                                  class="form-control">
                                                                  <option value=""> Select Any</option>
                                                                  <option value="1" selected="selected"> In Stock</option>
                                                                  <option value="0"> Out Stock</option>
                                                               </select>
                                                            </div>
                                                         </div>
                                                      </div>
                                                </div>
                                                <div class="row variation-btn-row">
                                                   <div class="col-md-12">
                                                      <div class="form-group">
                                                         <button type="button" name="add_item" id="add_item" class="btn btn-success float-right">Add More</button>
                                                         <button type="button" name="remove_item" id="remove_item" class="btn btn-danger float-right remove">Remove</button>
                                                      </div>
                                                   </div>
                                                </div>
                                       </div>

                                    </div>
                                 </div>

                              </div>
                              <div id="new_item_details" class="new_item_details"></div>
                           </div>
                        </div>
                           </div>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
            </div>
            <div class=" prod-button">
               <div class="col-md-12">
               <div class="form-group">
                     <button type="submit" class="btn btn-primary float-right">Update</button>
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

    $(document).on('click', "[id^=imgeremove]", function () {
        var index = parseInt($(this).attr("id").replace("imgeremove", ''));
        $.ajax({
            type: 'POST',
            url: '{{route("admin.remove-product-images")}}',
            data: {
                '_token': "{{csrf_token()}}",
                'productimage': index,
                'productdt': $(this).data('productdt'),
            },
            success: function (res) {
                if(res.status == 200){
                    // removed msg
                    $('#imgeremovenew'+index).remove();
                    $('#imgeremovenewClose'+index).remove();
                }
                // getAttribute();
                return false;
            }
        });
    });

   $('.select2').select2();

   $("#tags").val();

   $("#tags").tagsinput('items');



   $(function () {
      // Summernote
      $('#short_description').summernote({
         height: 100,
      })
      $('#description').summernote({
         height: 200,
      })

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
               //console.log(res);
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
            'id': '{{$getProductData->id}}',
         },
         success: function (res) {
           // console.log(res);
            if (res) {
               $('#show_attributes').empty();
               $("#show_attributes").append(res.getAttributeDesign);
               getDropdownDesign(res.getData);
            }
            return false;
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
         $(".dropdownVariation").append("<select data-field='" + changeText + "' id='" + changeText + "' name='data[0][" + changeText + "]' class'form-control'><option value=''>Select Any " + $(this).data('name') + "</option></select> ");
         $.each($(this).data('value').split('|'), function (key, value) {
            //console.log(value);
            $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");
         });
      }
      else {
         $("#" + changeText).remove();
      }
   });

   function getDropdownDesign(res){
      $('.dropdownVariation').html("");
      $.each(res, function (key, value) {
         //console.log('key 1 ');
         //console.log(key);
         let changeText = $(document).find('#attributevari'+value.id).val();
         let changeTextArray = $(document).find('#attributevari'+value.id).data('value').split('|');
         let changeTextName = $(document).find('#attributevari'+value.id).data('name');
         // $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");

         if ($(document).find('#attributevari'+value.id).prop('checked') == true) {
            $(".dropdownVariation").append("<select data-field='" + changeText + "' id='" + changeText + "' name='data[0][" + changeText + "]' class'form-control'><option value=''>Select Any " + changeTextName + "</option></select> ");
            $.each(changeTextArray, function (key, value) {
               //console.log('key 1 ');
               //console.log(key);
               // console.log(value);
               $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");
            });
         }else {
            $("#" + changeText).remove();
         }
      });
   }

   function getDropdownDesign(res){
      $('.dropdownVariation').html("");
      $.each(res, function (key, value) {
        // console.log('key 1 ');
        // console.log(key);
         let changeText = $(document).find('#attributevari'+value.id).val();
         let changeTextArray = $(document).find('#attributevari'+value.id).data('value').split('|');
         let changeTextName = $(document).find('#attributevari'+value.id).data('name');
         // $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");

         if ($(document).find('#attributevari'+value.id).prop('checked') == true) {
            $(".dropdownVariation").append("<select data-field='" + changeText + "' id='" + changeText + "' name='data[0][" + changeText + "]' class'form-control'><option value=''>Select Any " + changeTextName + "</option></select> ");
            $.each(changeTextArray, function (key, value) {
              // console.log('key 1 ');
              // console.log(key);
               // console.log(value);
               $("#" + changeText).append("<option value='" + value + "'>" + value + "</option>");
            });
         }else {
            $("#" + changeText).remove();
         }
      });
   }

   // $("#addVariationClone").on('click',function(){

   // });


   getParentCategory();

   function getParentCategory() {
      $.ajax({
         type: 'POST',
         url: '{{asset("admin/get-categories")}}',
         data: {
            '_token': "{{csrf_token()}}",
            'id': '{{$getProductData->id}}',
         },
         success: function (res) {
            if (res) {
               $("#categories").append('<option value="">Select Category</option>' + res);
            }
         }
      })
   }


   $('#variationData').on('click',function(){

      $.ajax({
         type: 'POST',
         url: '{{asset("admin/get-product-details-variation")}}',
         data: {
            '_token': "{{csrf_token()}}",
            'id': '{{$getProductData->id}}',
         },
         success: function (res) {

            if(res.length>0){
               $( ".variation_section").html("");
               $.each( res, function( i ,val) {
                 $( ".variation_section").append(val);
               });
            }


         }
      })
   });

   $(document).on('click','.removeVariation',function () {
      var checkstr =  confirm('Are you sure you want to delete this?');
      if(checkstr == true){
         var var_id = $(this).data('var-id');
         if(var_id==''){
            $("#item_details"+key).remove();
            return false;
         }
         var key = $(this).data('attr-key');
         $.ajax({
            type: 'POST',
            url: '{{asset("admin/delete-product-variation")}}',
            data: {
               '_token': "{{csrf_token()}}",
               'var_id': var_id,
            },
            success: function (res) {

              $("#item_details"+key).remove();
            }
         })
      }else{
         return false;
      }
   });



   $(document).ready(function () {
      var max = 10;

      $(document).on('click','#add_item',function () {
         var button = $('#item_details').clone(true);
         var is_update = 'is_update';
         var attr_key = $( ".attr_section:last-child" ).data( "attr-key" );
         attr_key++;
         button.find('input').val('');
         button.find('select').val('');
         button.find('.variation_image').remove();
         button.find('.variation_video').remove();
         button.find('.vari_add_update').removeAttr('name');
         button.appendTo('.variation_section');
         button.attr('id', 'item_details' + attr_key);
         button.attr('data-attr-key', attr_key);

         button.find('.vari_add_update').attr('id','is_update_'+attr_key);
         button.find('input').each(function() {
               const fieldname = $(this).attr('data-field');
               $(this).attr('name', 'data[' + attr_key + '][' + fieldname + ']');
         });
         button.find('.vari_add_update').attr('name','data[' + attr_key + '][' + is_update + ']');

         button.find('.removeVariation').attr('data-var-id','');
         button.find('.removeVariation').attr('data-attr-key',attr_key);
         button.find('.removeVariation').attr('id','remove_item'+attr_key);
         button.find('select').each(function() {
               const fieldname = $(this).attr('data-field');
               $(this).attr('name', 'data[' + attr_key + '][' + fieldname + ']');
         });
      });

      $(document).on('click', "[id^=remove_item]", function (e) {
         var index = parseInt($(this).attr("id").replace("remove_item", ''));
         if(index > 0){
            $('#item_details'+index).remove();
         }
         e.preventDefault();
      });
      $(document).on('click','.remove',function(e){
         $(this).remove();

         e.preventDefault();
      });
      $("#dfinder_status").on('change',function(){
         if($(this).find(":selected").val()==1){
            $("#diamond_shape_field").show();
         }else{
            $("#diamond_shape_field").hide();
         }
      })
   });


</script>
@endsection
