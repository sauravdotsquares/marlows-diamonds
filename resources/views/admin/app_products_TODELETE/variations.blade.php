@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Add variations of  {{ $product->title }} </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" >
                            @csrf

                            <div class="append_data">


                                <?php $oldFormData = request()->old('form_data') ? request()->old('form_data') :  [0] ?>
                                <?php //echo '<pre>'; print_r($oldFormData);die; ?>

                                <?php foreach ($oldFormData as $old_key => $old_value) { ?>
                                    <div class="data-row" id="data-{{$old_key}}">

                                        <input type="hidden" value="{{ $old_value ? $old_value['id'] : '' }}" name="form_data[{{$old_key}}][dataId]" />

                                        <div class="row">
                                            <?php foreach ($attr_variations as $attr_variations_key => $attr_variations_value) { ?>
                                                <div class="form-group col-md-4">
                                                    <label>Select {{ $attr_variations_value['name'] }} </label>
                                                    <select class="form-control" name="form_data[{{$old_key}}][variations][{{$attr_variations_value['slug']}}]" >
                                                        <?php foreach ($attr_variations_value['variations'] as $variations_key => $variations_value) { ?>
                                                            <option 
                                                                {{  $old_value && !empty($old_value['variations']) && !empty( $old_value['variations'][$attr_variations_value["slug"]] ) && $old_value['variations'][$attr_variations_value["slug"]] == $variations_value['id']  ? 'selected' : '' }} 
                                                                value="{{$variations_value['id']}}"> {{$variations_value['name']}}  </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label for="vari_sale_price">Sale Price</label>
                                                        <input value="{{ $old_value ? $old_value['sale_price'] : '' }}" data-field="vari_sale_price" type="text" id="vari_sale_price" name="form_data[{{$old_key}}][sale_price]" class="form-control" placeholder="Sale Price">
                                                    </div>
                                                    @error('form_data.'.$old_key.'.sale_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label for="vari_regular_price">Regular Price</label>
                                                        <input value="{{ $old_value ? $old_value['regular_price'] : '' }}" type="text" id="vari_regular_price" name="form_data[{{$old_key}}][regular_price]" class="form-control" placeholder="Regular Price">
                                                        @error('form_data.'.$old_key.'.regular_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label for="vari_stock_status">Stock Status</label>
                                                        <select data-field="vari_stock_status" name="form_data[{{$old_key}}][stock_status]" id="vari_stock_status" class="form-control">
                                                            <option value=""> Select Any</option>
                                                            <option value="1" {{ $old_value && $old_value['stock_status'] ? 'selected' : '' }}> In Stock</option>
                                                            <option value="0" {{ $old_value && empty($old_value['stock_status']) ? 'selected' : '' }}> Out Stock</option>
                                                        </select>
                                                        @error('form_data.'.$old_key.'.stock_status') <span class="custom-error">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label for="vari_image">Image</label>
                                                        <input type="file" id="vari_image" name="form_data[{{$old_key}}][image]" class="form-control">
                                                        @error('form_data.'.$old_key.'.image') <span class="custom-error">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                    <label for="vari_video">Video</label>
                                                    <input type="file" id="vari_video" name="form_data[{{$old_key}}][video]" class="form-control">
                                                    @error('form_data.'.$old_key.'.video') <span class="custom-error">{{ $message }}</span>  @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row variation-btn-row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button type="button" data-remove="{{ $old_key ? 'data-'.$old_key : '' }}" class="btn btn-danger float-right remove_item ml-1 {{ $old_key ? '' : 'd-none' }} ">Remove</button>
                                                    <button type="button" class="btn btn-success float-right add_item ml-1">Add More</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                

                                

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group text-right pt-3">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection


@section('css')
<style>
    .data-row{
        border-bottom: 2px solid black;
        padding-bottom: 20px;
        border-radius: 10px;
    }
</style>
@endsection



@section('js')

    <script>

        var dataId = parseInt("{{ count($oldFormData) }}");
        $(document).on('click',".add_item", function(){
            dataId++;
            const idData = 'data-' + dataId;
            const combinations = $("#data-0").clone().attr('id',idData);
            $(".append_data").append(combinations);

            $('#'+ idData).find('[name^="form_data"]').each(function(i, el) {
                var inputName = $(this).attr('name').split('[');
                inputName[1] = dataId + ']';
                const newName = inputName.join('[');
                $(this).attr('name',newName);
            });
            $('#'+ idData).find('.remove_item').removeClass('d-none');
            $('#'+ idData).find('.remove_item').attr('data-remove', idData);
            $('#'+ idData).find('input[type=hidden]').remove();
        });

        $(document).on('click',".remove_item", function(){
            const removeId = $(this).attr('data-remove');
            $("#"+ removeId).remove();
        });
        
    </script>

@endsection