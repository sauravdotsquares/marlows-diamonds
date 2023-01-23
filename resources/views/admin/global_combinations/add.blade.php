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

                    <form method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" >
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name </label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ request()->old('name') }}">
                                        @error('name') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="append-data">

                                <?php foreach ($oldFormData as $old_key => $old_value) { ?>
                                    <div class="combinations" id="data-id">
                                        <div class="row">
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="product_type">Product type </label>
                                                    <select class="form-control" id="product_type" name="form_data[{{$old_key}}][product_type]">
                                                        <?php foreach ($dataToPass['product_type'] as $product_type_key => $product_type_value) { ?>
                                                            <option {{ $old_value && $old_value['product_type'] == $product_type_value['id'] ? 'selected' : '' }} value="{{ $product_type_value['id'] }}">{{ $product_type_value['name'] }}</option>
                                                        <?php } ?>
                                                    </select>
                                                    @error('form_data.'.$old_key.'.product_type') <span class="custom-error">{{ $message }}</span>  @enderror
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="metal_types">Metal type </label>
                                                    <select class="form-control" id="metal_types" name="form_data[{{$old_key}}][metal_types]">
                                                        <?php foreach ($dataToPass['metal_types'] as $metal_types_key => $metal_types_value) { ?>
                                                            <option {{ $old_value && $old_value['metal_types'] == $metal_types_value['id'] ? 'selected' : '' }} value="{{ $metal_types_value['id'] }}">{{ $metal_types_value['name'] }}</option>
                                                        <?php } ?>
                                                    </select>
                                                    @error('form_data.'.$old_key.'.metal_types') <span class="custom-error">{{ $message }}</span>  @enderror
                                                </div>
                                            </div>
    
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="value">Value  </label>
                                                    <input type="text" class="form-control" id="price" name="form_data[{{$old_key}}][price]" placeholder="Enter value" value="{{ $old_value ? $old_value['price'] : '' }}">
                                                    @error('form_data.'.$old_key.'.price') <span class="custom-error">{{ $message }}</span>  @enderror
                                                </div>
                                            </div>
    
                                            <div class="col-md-12">
                                                <div class="form-group text-right">
                                                    <a class="btn btn-app bg-success add-record">
                                                        <i class="fas fa-plus"></i> Add
                                                    </a>
                                                    <a class="btn btn-app bg-danger remove-record-container remove-record" style="display: none" >
                                                        <i class="fas fa-times"></i> remove
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            {{-- <div class="col-md-2 remove-record-container" style="display: none;" >
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" class="form-control btn btn-info remove-record">Remove</button>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
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

        var dataId = parseInt("{{ count($oldFormData) }}");
        $(document).on('click','.add-record', function(e){
            dataId++;
            const idData = 'data-id-' + dataId;
            const combinations = $("#data-id").clone().attr('id',idData);
            $(".append-data").append(combinations);

            setTimeout(() => {
                $('#'+ idData).find('.remove-record').attr('data-remove', idData);
                $('#'+ idData).find('.remove-record-container').css('display','inline-block');

                $('#'+ idData).find("input").each(function(i) {
                    $(this).find('input').attr('name', 'song' + i);
                });
                $('#'+ idData).find('[name^="form_data"]').each(function(i, el) {
                    var inputName = $(this).attr('name').split('[');
                    inputName[1] = dataId + ']';
                    const newName = inputName.join('[');
                    $(this).attr('name',newName);
                });
            }, 100);
        });

        $(document).on('click','.remove-record', function(e){
            const removeId = $(this).attr('data-remove');
            $("#"+ removeId).remove();
        })
    </script>
@endsection