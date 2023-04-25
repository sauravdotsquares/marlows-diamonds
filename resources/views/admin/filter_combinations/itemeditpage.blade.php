@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Add new record </h3>
                    </div>


                    <?php $oldFormData = request()->old('form_data') ? request()->old('form_data') :  [0] ?>

                    <?php
                        // prd($masterData);
                    ?>
                    <form method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" >
                        <input type="hidden" name="item_id" value="{{$dataToPass->id}}" >
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="item_name">Name </label>
                                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter item name" value="{{ isset($dataToPass->item_name)?$dataToPass->item_name:'' }}">
                                        @error('item_name') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="top_text">Top Text </label>
                                        <input type="text" class="form-control" id="top_text" name="top_text" placeholder="Enter item name" value="{{ isset($dataToPass->top_text)?$dataToPass->top_text:'' }}">
                                        @error('top_text') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bottom_text">Bottom Text </label>
                                        <input type="text" class="form-control" id="bottom_text" name="bottom_text" placeholder="Enter item name" value="{{ isset($dataToPass->bottom_text)?$dataToPass->bottom_text:'' }}">
                                        @error('bottom_text') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                               
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="form-control btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
    <script>

      
    </script>
@endsection