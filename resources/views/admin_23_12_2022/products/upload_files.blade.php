@extends('layouts.admin.app')

@section('content')


<div class="content products_section">
    <!-- DataTables Example -->
    <section class="content">
       <div class="container-fluid">
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="slug" value="{{$product->slug}}" >
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Product Details of {{$product->title}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <label for="image">Upload thumbnail Hover file</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                        </div>
                                    </div>
                                    <?php $thumbnailImage = getThumbnailGif($product->id); ?>
                                    <?php if(!empty($thumbnailImage)){ ?>
                                        <?php if($thumbnailImage->extension == "mp4"){ ?>
                                            <video class="product-hover-video" muted="muted" autoplay style="height: 200px; width:200px;">
                                                <source src="{{ asset('storage/'.  $thumbnailImage->image_url)}}" type="video/mp4">
                                            </video>
                                        <?php }else if($thumbnailImage->extension == "mp4"){ ?>
                                            <img src="{{ asset('storage/' . $thumbnailImage->image_url )}}" class="product-hover-video" style="height: 200px; width:200px;" >
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <h1>Not uploaded</h1>
                                    <?php } ?>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
       </div>
    </section>
</div>


@endsection