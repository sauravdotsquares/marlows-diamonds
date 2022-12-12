<?php if(!empty($product_attr_value)  && !empty($product_attr_value['info']) ){ ?>
    <?php if($product_attr_value['info']['display_type'] == 'radio'){ ?>
        <div class="diamond-type">
            <label>{{ $product_attr_value['info']['name'] }}</label>
            <?php foreach ($product_attr_value['variations'] as $attr_key => $attr_value) { ?>
                <div class="d-type-input">
                    <input type="radio" name="attribute_choose-your-diamond" value="{{ $attr_value['info']['id'] }}" class="attr-selection"  {{ !$attr_key ? 'checked' : '' }}  >
                    <span> {{ $attr_value['info']['name'] }} </span>
                </div>
            <?php } ?>
        </div>
    <?php }else if($product_attr_value['info']['display_type'] == 'select'){ ?>
        <div class="product-type-variations" id="filterDataDesign">
            <div class="type-variations-row">
                <div class="type-variations-col">
                    <label for="{{ $product_attr_value['info']['slug'] }}">{{ $product_attr_value['info']['name'] }}</label>
                    <select name="metal-type" id="{{ $product_attr_value['info']['slug'] }}" class="form-control  {{ $product_attr_value['isPriceAffected'] ? 'attr-selection' : '' }}  ">
                        <?php foreach ($product_attr_value['variations'] as $attr_key => $attr_value) { ?>
                            <option value="{{ $attr_value['info']['id'] }}"> {{ $attr_value['info']['name'] }} </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>