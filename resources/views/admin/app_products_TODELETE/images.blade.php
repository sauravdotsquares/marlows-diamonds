@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Upload Images for product {{ $product->title }} </h3>
                    </div>

                    <form method="POST">
                        <div class="card-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="featured_image">Featured Image</label>
                                        <div class="file-field">
                                            <input type="file" id="gallery-photo-add">
                                            <input type="text" value="featured_image" id="image_type" name="image_type">
                                            <div class="image-container">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                            <div class="gallary">

                                                <?php foreach ($featured_image as $featured_image_key => $featured_image_value) { ?>
                                                    <div class="gallary_item">
                                                        <a href="javascript:;" class="remove-img"> <i class="fa fa-times"></i></a>
                                                        <input type="hidden" name="image_id[]" value="{{ $featured_image_value['id'] }}"> 
                                                        <img src="{{ asset( 'uploads/' . $featured_image_value['image']) }}" />
                                                    </div>
                                                <?php } ?>

                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="featured_image">Product Gallery</label>
                                        <div class="file-field">
                                            <input type="file" id="gallery-photo-add">
                                            <input type="text" value="product_gallery" id="image_type" name="image_type">
                                            <div class="image-container">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </div>
                                            <div class="gallary">
                                                <?php foreach ($product_gallery_images as $gallery_key => $gallery_value) { ?>
                                                    <div class="gallary_item"> 
                                                        <a href="javascript:;" class="remove-img"> <i class="fa fa-times"></i></a>
                                                        <input type="hidden" name="image_id[]" value="{{ $gallery_value['id'] }}"> 
                                                        <img src="{{ asset( 'uploads/' . $gallery_value['image']) }}" />
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-info">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('css')
<style>
.image-container{
    height: 150px;
    width: 150px;
    background: rgb(114, 75, 75);
    cursor: pointer;
    border-radius: 20px;
    position: relative;
}
.image-container i{
    position: absolute;
    top: 35px;
    bottom: 0;
    left: 46px;
    font-size: 64px;
    right: 0;
    color: #fff;
}

.file-field input{
    display: none;
}
.file-field .gallary{
    width: 90vh;
}
.gallary_item{
    display: inline-block !important;
    margin: 20px;
    border-radius: 20px;
    position: relative;
}
.gallary_item i{
    z-index: 9999;
    position: absolute;
    right: 0;
    color: #eb1717;
    font-size: 30px;
    top: -9px;
}

.gallary_item img{
    height: 150px;
    width: 150px;
    border-radius: 20px;
    /* object-fit: cover; */
}
</style>
@endsection


@section('js')
<script>

    function readURL(input, callback=()=>{}) {
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                callback(e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        else{
            callback('');
        }
    }

    $(".image-container").on("click", function(){
        $(this).parents('.file-field').find('input').trigger('click')
    });

    $(".file-field input").on('change', function(e) {
        var thisIs  = this;
        readURL(this,function(imageObj) {

            var fileToUpload = $(thisIs)[0].files[0];
            var imageType = $(thisIs).parents('.file-field').find('#image_type').val();


            var formData = new FormData();
            formData.append('file', fileToUpload);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('imageType', imageType);
            
            $.ajax({
                url : '{{ route("admin.app_products.add_images", ["slug"=> $product->slug ]) }}',
                type : 'POST',
                data : formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success : function(data) {

                    if(data.status == 'success'){
                        let imageToAppend = "<div class='gallary_item'> <input type='hidden' name='image_id[]' value='"+data.data+"' /> <img src='"+imageObj+"' /> </div>";
                        $(thisIs).parents('.file-field').find('.gallary').append(imageToAppend);
                    }
                }
            });
            

        })
    });


    $(".remove-img").on('click', function(){
        $(this).parents(".gallary_item").remove();
    })





</script>
@endsection