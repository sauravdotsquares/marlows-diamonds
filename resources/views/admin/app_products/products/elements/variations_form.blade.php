<?php
use App\Models\AppProductAttributeVariationDescripiton;
?>

<input type="hidden" id="product_attribute_variations" name="variation_data[{{$index}}][product_attribute_variations]" class="form-control" value="{{ !empty($item) ? $item['id'] : '' }}">

<div class="data-information">
    <div class="form-group row">
        <?php if(!empty($attributeData) && count($attributeData)){ ?>
            <?php foreach ($attributeData as $attributeData_key => $attributeData_value) { ?>

                <?php
                    if(!empty($item)){
                        $attributeDescription = AppProductAttributeVariationDescripiton::where([
                            'is_deleted'=> 0, 
                            'product_id'=> $product->id, 
                            'attribute_variation_id' => $item->id,
                            'master_attribute_id' => $attributeData_value['id']
                        ])->select(['id','variation_id'])->first();
                        $selectedVariation = !empty($attributeDescription) ? $attributeDescription->variation_id : '';
                        $existingId = !empty($attributeDescription) ? $attributeDescription->id : '';
                    }else{
                        $selectedVariation = '';
                        $existingId = '';
                    }
                ?>
                

                <input type="hidden" class="value_carry" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][id]" value="{{ $existingId  }}" >
                <input type="hidden" class="value_carry" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][attribute_id]" value="{{ $attributeData_value['product_attribute']['id']  }}" >
                <input type="hidden" class="value_carry" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][master_attribute_id]" value="{{ $attributeData_value['id'] }}" >

                <div class="form-label-group col-sm-3">
                    <select class="form-control" id="attr-{{ $attributeData_value['id'] }}" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][variation_id]">
                        <option value="">{{ __('Select') .' '. $attributeData_value['name'] }}</option>
                        <?php if(!empty($attributeData_value['variations']) && count($attributeData_value['variations'])){ ?>
                            <?php foreach ($attributeData_value['variations'] as $variations_key => $variations_value) { ?>
                                <option {{  $selectedVariation==$variations_value['id'] ? 'selected' : '' }} value="{{ $variations_value['id'] }}">{{ $variations_value['name'] }}</option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

            <?php } ?>
        <?php } ?>
    </div>

    <div class="form-group row">
        <div class="form-label-group col-sm-12 col-md-6">
            <input type="text" id="price" name="variation_data[{{$index}}][price]" class="form-control" value="{{ !empty($item) ? $item['price'] : '' }}" placeholder="{{ __("Price")}}">
            @error('description') <span class="custom-error">{{ $message }}</span>  @enderror
        </div>
        <div class="form-label-group col-sm-12 col-md-6">
            <select id="in_stock" name="variation_data[{{$index}}][in_stock]" class="form-control">
                <option value="">Select stock status</option>
                <option value="0"  {{  !empty($item) && $item['in_stock'] ? '' : 'selected' }}  >Not in stock</option>
                <option value="1" {{ !empty($item) && $item['in_stock'] ? 'selected' : '' }}>In Stock</option>
            </select>
        </div>
    </div>


    <div class="form-group row">

        <div class="form-label-group col-sm-12 col-md-6">
            <input type="text" id="variation_image" name="variation_data[{{$index}}][image]" class="form-control" placeholder="Image id"
                value="{{ !empty($images) && !empty($images['variation_img_id']) ? implode(',', $images['variation_img_id']) : '' }}"
            >
            @if (!empty($images) && count($images['variation'])  )
                @include('admin.app_products.products.elements.product_img', ['image'=>$images['variation'][0], 'height'=> '100px', 'width'=> '100px'] )
            @else
                <img class="d-none" src="" height="120" width="120" alt="Waiting image"/>
                <video height="120" width="120" class="d-none">
                </video>
            @endif

            @error('image') <span class="custom-error">{{ $message }}</span>  @enderror
        </div>

        <div class="form-label-group col-sm-12 col-md-6">
            <button type="button" class="btn btn-info add-btn">Add More</button>
            <button type="button" class="btn btn-danger remove-btn d-none">Remove</button>
        </div>
    </div>
</div>