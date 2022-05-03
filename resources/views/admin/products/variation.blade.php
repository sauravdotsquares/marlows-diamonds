
<div class="card-header" id="headingOne">
         <div id="dropdownVariation">


         </div>
      </div>

      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
         data-parent="#accordionExample">
         <div class="card-body">
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <div class="form-label-group">
                        <label for="vari_sale_price">Sale Price</label>
                        <input data-field="vari_sale_price" type="text" id="vari_sale_price" name="data[0][vari_sale_price]" class="form-control" placeholder="Sale Price" value="{{$variation['sale_price']}}">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <div class="form-label-group">
                        <label for="vari_regular_price">Regular Price</label>
                        <input data-field="vari_regular_price" type="text" id="vari_regular_price"
                           name="data[0][vari_regular_price]" class="form-control"
                           placeholder="Regular Price" value="{{$variation['regular_price']}}">
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <div class="form-label-group">
                        <label for="vari_image">Image</label>
                        @if($variation['vari_image']!=null || $variation['vari_image']!='')
                        	<img class="variation_image" src="{{asset('/storage/'.$variation['vari_image'])}}"/>
                        @else
                        	<img class="variation_image" src="{{asset('assets/images/no-image.png')}}"/>
                        @endif
                        <input data-field="vari_image" type="file" id="vari_image" name="data[0][vari_image]"
                           class="form-control">
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <div class="form-label-group">
                        <label for="vari_video">Video</label>
                        @if($variation['vari_video']!=null || $variation['vari_video']!='')
                        	<video class="variation_video" src="{{asset('/storage/'.$variation['vari_video'])}}"></video>
                    	@else
                    	<img class="variation_image" src="{{asset('assets/images/no-video.png')}}"/>
                        
                        @endif
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
                              <option value="1" @if($variation["stock_status"]==1) selected @endif> In Stock</option>
                              <option value="0" @if($variation["stock_status"]==0) selected @endif> Out Stock</option>
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