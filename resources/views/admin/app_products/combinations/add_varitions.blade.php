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
                            <h3 class="card-title">{{ __("Add variations of") .' ' . $combinations->name }}</h3>
                        </div>

                        <?php $old = session()->getOldInput();
                            $oldData = $old && !empty($old['data']) ? $old['data'] : [0];
                            $arrayLastKey = array_key_last($oldData) + 1;
                        ?>

                        <div class="card-body">

                            <div class="append_data">


                                <?php foreach ($oldData as $old_key => $old_value) { ?>

                                    <div id="{{ $old_key ? 'record_'.$old_key : 'record_0' }}">
                                        <div class="row">

                                            {{-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label for="product_name">{{ __("Product type") }}</label>
                                                        <select class="form-control" name="data[{{$old_key}}][product_type]">
                                                            <?php foreach ($productTypes as $product_type_key => $product_type_value) { ?>
                                                                <option
                                                                {{  $old_value && !empty($old_value['product_type']) && $old_value['product_type'] == $product_type_value->id ? 'selected' : '' }}
                                                                 value="{{ $product_type_value->id }}">{{ $product_type_value->name }}</option>
                                                            <?php } ?>
                                                        </select>
                                                        @error('data.'. $old_key .'.product_type') <span class="custom-error">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <?php foreach ($attributes as $attributes_key => $attributes_value) { ?>

                                                <input type="hidden" name="data[{{$old_key}}][attribute_data][{{$attributes_key}}][attribute_id]" value="{{ $attributes_value->attribute_id }}" >
                                                <input type="hidden" name="data[{{$old_key}}][attribute_data][{{$attributes_key}}][combination_attribute_id]" value="{{ $attributes_value->id }}" >
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="form-label-group">
                                                            <label for="product_name">{{ $attributes_value->attributeData->name }}</label>
                                                            <select class="form-control" name="data[{{$old_key}}][attribute_data][{{$attributes_key}}][varition_id]">
                                                                <?php foreach ($attributes_value->variationsData as $variations_data_key => $variations_data_value) { ?>
                                                                    <option 
                                                                    {{  $old_value && !empty($old_value['attribute_data'][$attributes_key]['varition_id']) && $old_value['attribute_data'][$attributes_key]['varition_id'] == $variations_data_value->id ? 'selected' : '' }}
                                                                    value="{{ $variations_data_value->id }}">{{ $variations_data_value->name }}</option>
                                                                <?php } ?>
                                                            </select>
                                                            @error('data.'. $old_key .'.varition_id') <span class="custom-error">{{ $message }}</span>  @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label for="product_name">{{ __("Price percentage") }}</label>
                                                        <input type="text" name="data[{{$old_key}}][price]" placeholder="{{ __("Price percentage") }}" class="form-control remove-value" value="{{ $old_value ? $old_value['price'] : '' }}" />
                                                        @error('data.'. $old_key .'.price') <span class="custom-error">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label>&nbsp;</label>
                                                        <a href="javascript:;" class="btn btn-success form-control add_more_button" >Add more </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 {{ $old_key ? '' : 'd-none' }}">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label>&nbsp;</label>
                                                        <a href="javascript:;" data-removeId="{{ $old_key ? 'record_'.$old_key : '' }}" class="btn btn-danger form-control remove_button" >Remove</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>

                            </div>

                            <br>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="submit" name="submit" class="btn btn-success" placeholder="{{ __("Combination Name")}}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection


@section('js')
<script>

    appendRemove({
        appendClass: ".append_data",
        addButtonClass: ".add_more_button",
        firstElement: "#record_0",
        removeClass: ".remove_button",
        startElement: parseInt('{{ $arrayLastKey }}')
    });


    function appendRemove(options) {

        if(typeof options.addButtonClass!='undefined' && options.addButtonClass){}else{ return false; };
        if(typeof options.appendClass!='undefined' && options.appendClass){}else{ return false; };
        if(typeof options.firstElement!='undefined' && options.firstElement){}else{ return false; };
        if(typeof options.removeClass!='undefined' && options.removeClass){}else{ return false; };
        if(typeof options.startElement!='undefined' && options.startElement){}else{ return false; };

        var startVariation = options.startElement;
        /** on add new variations */
        $(document).on('click', options.addButtonClass , function(e) {
            const newId = `record_${startVariation}`;
            let $cloneItem = $(options.firstElement).clone().attr('id',newId);
            $(options.appendClass).append($cloneItem);
            setTimeout(() => {
                const $element = $(`#${newId}`);
                $element.find('select , input').each((index, element)=>{
                    const inputNames = $(element).attr('name');
                    const inputNamesAr = inputNames.split('[');
                    inputNamesAr[1] = startVariation + ']';
                    const inputNamesNew = inputNamesAr.join('[');
                    $(element).attr('name', inputNamesNew);

                    if( $(element).hasClass('remove-value') ){
                        $(element).val('')
                    }
                });
                $element.find(options.removeClass).attr('data-removeId', newId );
                if($element.find(options.removeClass).parents('.d-none:first').length){
                    $element.find(options.removeClass).parents('.d-none:first').removeClass('d-none');
                }

            }, 300);
            startVariation++;
        });
        $(document).on('click', options.removeClass, function(e) {
            const removeId = $(this).attr('data-removeId');
            $(`#${removeId}`).remove();
        });
    }



</script>

@endsection

