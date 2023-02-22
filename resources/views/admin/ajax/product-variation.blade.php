@foreach($getVariationData as $key => $data)
    <?php // echo $key; 
        // echo "<pre>";
        // print_r($getAttrId_arr);
        // print_r($data->get_vari_details_id);
        // die;
    ?>
    <div id="item_details{{$key}}" class="card">
        <div class="card-header" id="headingOne">
            <div id="dropdownVariation" class="dropdownVariation">
                <?php 
                    if(count($getData)>0){
                        $getAttributeDesign = '';
                        $getHtml = '';
                        $i = 0;
                        foreach ($getData as $keyData => $parent) {
                            if(in_array('attri_'.$keyData,$getAttrId_arr)){
                                $getValues = explode('|',$parent);
            
                                $getHtml .= '<select data-field="attri_'.$keyData.'" id="attri_'.$keyData.$key.'"
                                name="data['.$key.'][attri_'.$keyData.']" clas="form-control"> <option value="">Select Any'.ucfirst(str_replace('-',' ',$keyData)).'</option>';
            
                                foreach($getValues as $newKey => $valAnother){
                                    if($getAttrId_arr[$i] == $data->get_vari_details_id[$i]->key){
                                        // echo "Key 1 ".$getAttrId_arr[$i];
                                        // echo "Key 2 ".$data->get_vari_details_id[$i]->key;
                                        $getHtml .= '<option selected value="'.$valAnother.'">'.$valAnother.'</option>';
                                    }else{
                                        $getHtml .= '<option value="'.$valAnother.'">'.$valAnother.'</option>';
                                    }
                                }
                                $getHtml .= '</select>';
                                
                                // print_r($getValues);
                            }
                            $i = $i+1;
                        }
                    }

                    echo $getHtml;
                ?>
            </div>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                @if(isset($data->vari_image))
                                    <img src="{{ asset('storage/'.$data->vari_image) }}" alt="Variation image" height="50px" width="50px">
                                @endif
                                <div class="form-label-group">
                                    <label for="vari_image">Image</label>
                                    <input data-field="vari_image" type="file" id="vari_image" name="data[{{$key}}][vari_image]" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="vari_sale_price">Sale Price</label>
                                    <input data-field="vari_sale_price" type="text" id="vari_sale_price"
                                        name="data[{{$key}}][vari_sale_price]" value="{{isset($data->sale_price)?$data->sale_price:''}}" class="form-control" placeholder="Sale Price">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label-group">
                                    @if(isset($data->vari_video))
                                        <img src="{{ asset('storage/'.$data->vari_video) }}" alt="Variation image">
                                    @endif

                                    <label for="vari_video">Video</label>
                                    <input data-field="vari_video" type="file" id="vari_video" name="data[{{$key}}][vari_video]"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="vari_stock_status">Stock Status</label>
                                    <select data-field="vari_stock_status" name="data[{{$key}}][vari_stock_status]"
                                        id="vari_stock_status" class="form-control">
                                        <option value=""> Select Any</option>
                                        @if($data->stock_status == 1)
                                        <option value="1" selected> In Stock</option>
                                        <option value="0"> Out Stock</option>
                                        @elseif($data->stock_status == 0)
                                        <option value="1"> In Stock</option>
                                        <option value="0" selected> Out Stock</option>
                                        @else
                                        <option value="1"> In Stock</option>
                                        <option value="0"> Out Stock</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="vari_regular_price">Regular Price</label>
                                    <input data-field="vari_regular_price" value="{{isset($data->regular_price)?$data->regular_price:''}}" type="text" id="vari_regular_price"
                                        name="data[{{$key}}][vari_regular_price]" class="form-control" placeholder="regular_price">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p style="margin:-16px 0px 0px 600px;">
            <a href="javascript:void(0)" name="remove_item" class='remove' id="remove_item{{$key}}"
                style="font-weight:bold;color:red;font-size:16px;">Remove Variation</a>
        </p>
    </div>
   
@endforeach

