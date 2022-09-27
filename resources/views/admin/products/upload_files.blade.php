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
                                            <label for="image">Upload thumbnail gif</label>
                                            <input type="file" id="image" name="image" class="form-control">
                                        </div>
                                    </div>
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