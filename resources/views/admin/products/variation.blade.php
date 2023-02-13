<?php 
//prd($prod_varitn);
?>
<div id="{{$section}}" class="attr_section" data-attr-key="{{$index}}">
    <input type="hidden" class="vari_add_update" id="is_update_{{$index}}" name="data[{{$index}}][is_update]" value="{{$variation['id']}}">
    <input type="hidden" name="data[{{$index}}][vari_image_exist]" value="{{$variation['multi_vari_img']}}">
    <input type="hidden" name="data[{{$index}}][vari_video_exist]" value="{{$variation['multi_vari_video']}}">
    <div class="card-header" id="headingOne">
        <div id="dropdownVariation">
            @if(!empty($all_attrs))
            @foreach($all_attrs as $key=>$attr)
                <select data-field="{{$attr['key']}}" id="{{$attr['key']}}" name="data[{{$index}}][{{$attr['key']}}]" class="form-control">
                    
                    <option value="">Select Any {{$attr['name']}}</option>
                    @foreach($attr['value'] as $attr_val)
                    
                        <option value="{{trim($attr_val,' ')}}"  <?php echo (!empty($prod_varitn[$attr['key']])  && $prod_varitn[$attr['key']]==trim($attr_val,' '))  ? 'selected' : '---'; ?>  >{{trim($attr_val,' ')}}</option>
                        
                    @endforeach
                    
                </select>
            @endforeach
            @endif
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
                            <input data-field="vari_sale_price" type="text" id="vari_sale_price" name="data[{{$index}}][vari_sale_price]" class="form-control" placeholder="Sale Price" value="{{$variation['sale_price']}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="vari_regular_price">Regular Price</label>
                            <input data-field="vari_regular_price" type="text" id="vari_regular_price"
                                name="data[{{$index}}][vari_regular_price]" class="form-control"
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

                            <?php
                                $varImages = !empty($variation['multi_vari_img']) ? $variation['multi_vari_img'] : $variation['vari_image'];
                            ?>

                            @if(!empty($varImages))
                                <?php $varImagesAr = explode(',',$varImages); ?>
                                @foreach ($varImagesAr as $varImage)
                                <img class="variation_image" src="{{asset('/storage/'.$varImage)}}"/>
                                @endforeach
                            @else
                                <img class="variation_image" src="{{asset('assets/images/no-image.png')}}"/>
                            @endif
                            <input data-field="vari_image" type="file" id="vari_image" name="data[{{$index}}][vari_image][]"
                                class="form-control"  multiple>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="vari_video">Video</label>

                            <?php
                                $varVideos = !empty($variation['multi_vari_video']) ? $variation['multi_vari_video'] : $variation['vari_video'];
                            ?>

                            @if(!empty($varVideos))
                                <?php $varVideosAr = explode(',',$varVideos); ?>
                                @foreach ($varVideosAr as $varVideo)
                                <video class="variation_video" src="{{asset('/storage/'.$varVideo)}}"></video>
                                @endforeach
                            @else
                            <img class="variation_image" src="{{asset('assets/images/no-video.png')}}"/>
                            @endif
                            <input data-field="vari_video" type="file" id="vari_video" name="data[{{$index}}][vari_video][]"
                                class="form-control" multiple>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label for="vari_stock_status">Stock Status</label>
                            <select data-field="vari_stock_status" name="data[{{$index}}][vari_stock_status]" id="vari_stock_status"
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
                        <button type="button" name="remove_item" id="remove_item{{$index}}" class="btn btn-danger float-right removeVariation" data-var-id="{{$variation['id']}}" data-attr-key="{{$index}}">Remove</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>