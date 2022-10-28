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
                            <h3 class="card-title">{{ __("Variations")}}</h3>
                        </div>
                        <div class="card-body">

                            <div class="data-information">

                                <div class="form-group row">
                                    <?php if(!empty($attributeData) && count($attributeData)){ ?>
                                        <?php foreach ($attributeData as $attributeData_key => $attributeData_value) { ?>
                                            <div class="form-label-group col-sm-3">
                                                <select class="form-control" id="attr-{{ $attributeData_value['id'] }}" name="{{ $attributeData_value['id'] }}">
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
                                        <input type="text" id="sale_price" name="variation_data[0][sale_price]" class="form-control" value="{{ !empty($dataToFill['sale_price']) ? $dataToFill['sale_price'] : ''  }}" placeholder="{{ __("Sale price")}}">
                                        @error('sale_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                    <div class="form-label-group col-sm-12 col-md-6">
                                        <input type="text" id="regular_price" name="variation_data[0][regular_price]" class="form-control" value="{{ !empty($dataToFill['regular_price']) ? $dataToFill['regular_price'] : ''  }}" placeholder="{{ __("Regular Price")}}">
                                        @error('regular_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-label-group col-sm-12 col-md-6">
                                        <button type="button" class="btn btn-primary file-selector"> Select variation image </button>
                                        <input type="file" id="variation_image" name="variation_data[0][image]" class="form-control d-none variation_image file-field">
                                        <img class="d-none" src="" height="60" width="60"/>
                                        @error('image') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                    <div class="form-label-group col-sm-12 col-md-6">
                                        <button type="button" class="btn btn-primary file-selector"> Select variation video</button>
                                        <input type="file" id="variation_video" name="variation_data[0][video]" class="form-control d-none variation_video file-field">
                                        <video width="60" height="60" class="d-none">
                                            <source src="" type="video/mp4">
                                        </video>
                                        @error('video') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-label-group col-sm-12 col-md-6">
                                        <select id="in_stock" name="variation_data[0][in_stock]" class="form-control">
                                            <option value="0">Not in stock</option>
                                            <option value="1" selected>In Stock</option>
                                        </select>
                                    </div>
                                    <div class="form-label-group col-sm-12 col-md-6">
                                        <button type="button" class="btn btn-info">Add More</button>
                                        <button type="button" class="btn btn-danger">Remove</button>
                                    </div>
                                </div>

                            </div>

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
    $(document).on('click','.file-selector', function() {
        $(this).siblings('.file-field').trigger('click');
    });

    $(document).on('change','.variation_image', function(event) {
        const $item = $(this);
        var reader = new FileReader();
        reader.onload = function(){
            $item.siblings('img').attr('src',reader.result).removeClass('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    $(document).on('change','.variation_video', function(e) {
        const $item = $(this);
        var reader = new FileReader();
        reader.onload = function(){
            $item.siblings('video').append('<source src="'+reader.result+'" type="video/mp4">').removeClass('d-none');
            setTimeout(() => {
                $item.siblings('video')[0].play()
            }, 100);
        };
        reader.readAsDataURL(event.target.files[0]);
    });

</script>
@endsection