@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <form id="variations_form" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __("Variations")}}</h3>
                        </div>

                        <?php
                            // prd($product_vari);
                            $request_data = [1];
                        ?>

                        <div class="card-body" id="append-data">

                            <?php foreach ($request_data as $data_key => $data_value) { ?>


                                <?php
                                    $price = !empty($data_value['price']) ? $data_value['price'] : '';
                                    $in_stock = !empty($data_value['in_stock']) ? $data_value['in_stock'] : '0';
                                    $index = $data_key;
                                ?>

                                <div class="data-information">

                                    <div class="form-group row">
                                        <?php if(!empty($attributeData) && count($attributeData)){ ?>
                                            <?php foreach ($attributeData as $attributeData_key => $attributeData_value) { ?>

                                                <?php //print_r($attributeData_value); ?>

                                                <input type="hidden" class="value_carry" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][attribute_id]" value="{{ $attributeData_value['product_attribute']['id']  }}" >
                                                <input type="hidden" class="value_carry" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][variations_attribute_id]" value="{{ $attributeData_value['id'] }}" >

                                                <div class="form-label-group col-sm-3">
                                                    <select class="form-control" id="attr-{{ $attributeData_value['id'] }}" name="variation_data[{{$index}}][variations][{{$attributeData_key}}][id]">
                                                        <option value="">{{ __('Select') .' '. $attributeData_value['name'] }}</option>
                                                        <?php if(!empty($attributeData_value['variations']) && count($attributeData_value['variations'])){ ?>
                                                            <?php foreach ($attributeData_value['variations'] as $variations_key => $variations_value) { ?>
                                                                <option value="{{ $variations_value['id'] }}">{{ $variations_value['name'] }}</option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
    
                                    <div class="form-group row">
                                        <div class="form-label-group col-sm-12 col-md-6">
                                            <input type="text" id="price" name="variation_data[{{$index}}][price]" class="form-control" value="{{ $price }}" placeholder="{{ __("Price")}}">
                                            @error('description') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                        <div class="form-label-group col-sm-12 col-md-6">
                                            <select id="in_stock" name="variation_data[{{$index}}][in_stock]" class="form-control">
                                                <option value="">Select stock status</option>
                                                <option value="0"  {{ $in_stock == '0' ? 'selected' : '' }}  >Not in stock</option>
                                                <option value="1" {{ $in_stock != '0' ? 'selected' : '' }}>In Stock</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
    
                                        <div class="form-label-group col-sm-12 col-md-6">

                                            <input type="text" id="variation_image" name="variation_data[{{$index}}][image]" class="form-control" placeholder="Image id">

                                            <?php if(!empty($data_value['image'])){ ?>
                                            <?php $images = [$data_value['image']]; ?>
                                                @include('admin.app_products.products.elements.product_img' )
                                            <?php }else{ ?>
                                                <img alt="variation image" class="d-none" src="" height="120" width="120"/>
                                            <?php } ?>
                                            <video height="120" width="120" class="d-none">
                                            </video>

                                            @error('image') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
    
                                        <div class="form-label-group col-sm-12 col-md-6">
                                            <button type="button" class="btn btn-info add-btn">Add More</button>
                                            <button type="button" class="btn btn-danger remove-btn d-none">Remove</button>
                                        </div>
                                    </div>
    
                                </div>
                            <?php } ?>

                        </div>
                        <div class="card-body">
                            <div class="form-label-group col-sm-12 col-md-4" style="float: right;">
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
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

    // $(document).on('click','.file-selector', function() {
    //     $(this).siblings('.file-field').trigger('click');
    // });
    
    $(document).on('click','.add-btn', function(event) {
        const uniqueId = new Date().getTime() +''+ Math.floor(Math.random() * 100000);
        const dataInformation = $(this).parents('.data-information').clone().attr('id', uniqueId);
        $("#append-data").append(dataInformation);

        /** Change names of every element of box */
        const newBox = $("#"+uniqueId);
        newBox.find(".remove-btn").removeClass('d-none');
        newBox.find('img').addClass('d-none');
        newBox.find("input,select").each(function(index, element) {

            const isValueCarry = $(element).hasClass('value_carry');

            const name = $(element).attr('name').split('[');
            name[1] =  uniqueId +']';
            $(element).attr('name', name.join('['));

            if(!isValueCarry){
                $(element).val('');
            }
        });
    });
    $(document).on('click','.remove-btn', function(event) {
        $(this).parents('.data-information').remove();
    });


    // $(document).on('change','.variation_image', function(event) {
    //     const $item = $(this);
    //     var reader = new FileReader();
    //     reader.readAsDataURL(event.target.files[0]);
    //     reader.onload = function(){
    //         /** extension check */
    //         const validFormats = ['jpg','jpeg','png','mp4','webp'];
    //         var extension = $item[0].files[0].name.split('.').pop().toLowerCase()
    //         if(!validFormats.includes(extension)){
    //             alert('Invalid file extension please choose ' + validFormats.join(', ') )
    //             return;
    //         }
    //         $item.siblings('video').addClass('d-none');
    //         $item.siblings('img').addClass('d-none');
    //         if(extension == 'mp4'){
    //             var video = $item.siblings('video');
    //             video.removeClass('d-none');
    //             video[0].src = reader.result;
    //             video[0].load();
    //             video[0].play();
    //         }else{
    //             $item.siblings('img').attr('src',reader.result).removeClass('d-none');
    //         }
    //         /** Set form data */
    //         var formData = new FormData();
    //         formData.append("file", $item[0].files[0]);
    //         /** Upload file */
    //         $.ajax({
    //             type: "POST",
    //             url: "{{ route('admin.app_products.upload_images') }}",
    //             headers: {
    //                 'IMAGE-TYPE' : 'variation',
    //                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //                 'IMAGE-FROM': 'md_app_product_attribute_variations',
    //             },
    //             success: function (data) {
    //                 console.log('data', data)
    //                 if(data){
    //                     $item.siblings('#variation_image_id').val(data);
    //                 }
    //                 $item.val('');
    //             },
    //             error: function (error) {
    //                 alert('Something went wrong');
    //             },
    //             async: true,
    //             data: formData,
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             timeout: 60000
    //         });
    //     }
    // });

    // $(document).on('submit','#variations_form_remoe', function(event) {

    //     const form = $(this);

    //     let clientInfo= form.serialize();
    //     const searchParams = new URLSearchParams(clientInfo);
    //     clientInfo = Object.fromEntries(searchParams);
    //     const form_data = new FormData();
    //     form_data.append('data', JSON.stringify(clientInfo) )

    //     // console.log('form', form.serialize());
    //     event.preventDefault();

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ route('admin.app_products.variations',  $product->slug ) }}",
    //         headers: {
    //             'X-CSRF-TOKEN': '{{ csrf_token() }}',
    //         },
    //         data: form_data,
    //         dataType: 'json',
    //         success: function (data) {
    //             console.log('data', data);
    //         },
    //         error: function (error) {
    //             console.log('error', error)
    //             // alert('Something went wrong');
    //         },
    //         async: true,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         timeout: 60000
    //     });

    // });
</script>
@endsection