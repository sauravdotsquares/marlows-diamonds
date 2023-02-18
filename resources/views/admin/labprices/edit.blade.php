@extends('layouts.admin.app')

@section('content')

@if(Session::has('success'))
<div class="alert alert-success">
   {{ Session::get('success') }}
   @php
         Session::forget('success');
   @endphp
</div>
@endif


    <div class="content products_section">
        
        <section class="content">
            <div class="container-fluid">
                <form enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update engagement rings lab price details</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label for="product_name">Clarity</label>
                                                    <input type="text" id="clarity" name="clarity" class="form-control" placeholder="Clarity"
                                                    value="{{  !empty($data) ? $data->clarity : ''  }}"
                                                    >
                                                </div>
                                                @error('clarity') <span class="custom-error">{{ $message }}</span>  @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label for="product_name">Color</label>
                                                    <input type="text" id="color" name="color" class="form-control" placeholder="Color"
                                                    value="{{  !empty($data) ? $data->color : ''  }}"
                                                    >
                                                </div>
                                                @error('color') <span class="custom-error">{{ $message }}</span>  @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label for="product_name">Carat</label>
                                                    <input type="text" id="carat" name="carat" class="form-control" placeholder="Carat"
                                                    value="{{  !empty($data) ? $data->carat : ''  }}"
                                                    >
                                                </div>
                                                @error('carat') <span class="custom-error">{{ $message }}</span>  @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label for="product_name">Price</label>
                                                    <input type="text" id="price" name="price" class="form-control" placeholder="Price"
                                                    value="{{  !empty($data) ? $data->price : ''  }}"
                                                    >
                                                </div>
                                                @error('price') <span class="custom-error">{{ $message }}</span>  @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-8"></div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                  <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            </div>
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