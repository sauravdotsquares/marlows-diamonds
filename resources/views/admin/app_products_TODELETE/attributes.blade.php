@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Add attribute of  {{ $product->title }} </h3>
                    </div>
                    <div class="card-body">

                        <form method="POST">
                            @csrf

                            <h4>Attribute </h4>
                            <div class="form-group row">
                                <?php foreach ($attribute as $attribute_key => $attribute_value) { ?>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input {{ in_array($attribute_value['id'], $selected_attributes) ? 'checked' : '' }} type="checkbox" name="attributes[]" value="{{ $attribute_value['id'] }}" class="form-check-input">
                                            <label class="form-check-label" for="exampleCheck2">{{ $attribute_value['name'] }}</label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            @error('attributes') <span class="custom-error">{{ $message }}</span>  @enderror

                            <h4>Combinations </h4>
                            <div class="form-group row">
                                <?php foreach ($combinations as $combinations_key => $combinations_value) { ?>
                                    <div class="col-sm-4">
                                        <div class="form-check">
                                            <input type="checkbox" {{ in_array($combinations_value['id'], $selected_combinations) ? 'checked' : '' }} name="combinations[]" value="{{ $combinations_value['id'] }}" class="form-check-input">
                                            <label class="form-check-label" for="exampleCheck2">{{ $combinations_value['name'] }}</label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            @error('combinations') <span class="custom-error">{{ $message }}</span>  @enderror


                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-info">Next</button>
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
@endsection



@section('js')
@endsection