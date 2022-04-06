<?php 
    // echo "sdfsd<pre>";
    // print_r($getVariationData);
    // // print_r($getVariationDetails);
    // // print_r($getData);
    // // print_r($getAttrId_arr);
    // die;

?>

@foreach($getVariationData as $key => $data)
<?php 
    // print($data->get_vari_details_id);
    // die;
?>

<div id="item_details" class="card">
    <div class="card-header" id="headingOne">
        <div id="dropdownVariation" class="dropdownVariation">
            <!-- <select data-field="attri_new-title-again-to-store" id="attri_new-title-again-to-store"
                name="data[0][attri_new-title-again-to-store]" clas='form-control'>
                <option value="">Select Any New Title again to store</option>
                <option value="Testing">Testing</option>
                <option value="chsdecking">chsdecking</option>
                <option value="finadfsdal">finadfsdal</option>
            </select> -->
            <?php 
                if(count($getData)>0){
                    $getAttributeDesign = '';
                    $getHtml = '';
                    $i = 0;
                    foreach ($getData as $key => $parent) {
                        // echo "<pre>";
                        // print_r($key);
                        // print_r($getAttrId_arr);
                        // print_r($parent);
                        // die;
                        if(in_array('attri_'.$key,$getAttrId_arr)){
                            $getValues = explode('|',$parent);
        
                            $getHtml .= '<select data-field="attri_'.$key.'" id="attri_'.$key.'"
                            name="data['.$i.'][attri_'.$key.']" clas="form-control"> <option value="">Select Any'.ucfirst(str_replace('-',' ',$key)).'</option>';
        
                            foreach($getValues as $newKey => $valAnother){
                                // echo 'attri_'.$key;
                                if(in_array_r('attri_'.$key, (array)$data->get_vari_details_id)){
                                    // echo 'value is in multidim array found';
                                    $getHtml .= '<option selected value="'.$valAnother.'">'.$valAnother.'</option>';
                                }else{
                                    $getHtml .= '<option value="'.$valAnother.'">'.$valAnother.'</option>';

                                }
                                // die;
                                // if(array_search('attri_'.$key, array_column((array)$data->get_vari_details_id, 'key')) !== false) {

                                //     echo 'value is in multidim array';
                                // }
                                // else {
                                //     echo 'value is not in multidim array';
                                // }
                                // die;

                                // $getHtml .= '<option value="'.$valAnother.'">'.$valAnother.'</option>';
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
                            <div class="form-label-group">
                                @if(isset($data->vari_image))
                                    <img src="{{asset('images/'.$data->vari_image)}}" alt="">
                                @endif
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
                                <input data-field="vari_sale_price" type="text" id="vari_sale_price"
                                    name="data[0][vari_sale_price]" value="{{isset($data->sale_price)?$data->sale_price:''}}" class="form-control" placeholder="Sale Price">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-label-group">
                                @if(isset($data->vari_video))
                                    <img src="{{asset('images/'.$data->vari_video)}}" alt="">
                                @endif

                                <label for="vari_video">Video</label>
                                <input data-field="vari_video" type="file" id="vari_video" name="data[0][vari_video]"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label for="vari_stock_status">Stock Status</label>
                                <select data-field="vari_stock_status" name="data[0][vari_stock_status]"
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
                                    name="data[0][vari_regular_price]" class="form-control" placeholder="regular_price">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p style="margin:-16px 0px 0px 600px;">
        <a href="javascript:void(0)" name="remove_item" class='remove' id="remove_item"
            style="font-weight:bold;color:red;font-size:16px;">Remove Variation</a>
    </p>
</div>

@endforeach