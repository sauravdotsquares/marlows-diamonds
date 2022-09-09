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
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label for="featured_image">Featured Image</label>


                                        <div class="file-field">
                                            <input type="file" id="gallery-photo-add">
                                            <div class="image-container"></div>
                                            <div class="gallary"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Add</button>
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
    height: 200px;
    width: 200px;
    background: #030303;
    cursor: pointer;
}
.file-field input{
    display: none;
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

            let imageToAppend = "<div class='gallary_item'><img src='"+imageObj+"' /> </div>";
            $(thisIs).parents('.file-field').find('.gallary').append(imageToAppend);
            // console.log('params',  );
        })
    });


</script>
@endsection