@extends('layouts.admin.app')
@section('content')

<section class="content">
    <?php
        // echo "<pre>afsd";
        // print_r($slugData);
        // die;
    ?>
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
                        <div class="card-body">

                            <div class="row">
                                {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="item_name">Name </label>
                                        <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Enter item name" value="{{ request()->old('item_name') }}">
                                        @error('item_name') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                </div> --}}
                                <input type="hidden" name="product_filter_id" value="{{$getFilterData['id']}}">
                                <input type="hidden" name="item_type" value="{{$getFilterData['slug']}}">
                                @if($slugData == 'filter-by-price')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_price">Min Price </label>
                                            <input type="text" class="form-control" id="min_price" name="min_price" placeholder="Enter min price" value="{{ isset($masterData['MinPrice'])?(int)$masterData['MinPrice']:1 }}">
                                            @error('min_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="max_price">Max Price </label>
                                            <input type="text" class="form-control" id="max_price" name="max_price" placeholder="Enter max price" value="{{ isset($masterData['MaxPrice'])?(int)$masterData['MaxPrice']:1 }}">
                                            @error('max_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'filter-by-shape')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="item_value">Shape </label>
                                            <select name="item_value" id="shape" class="form-control">
                                                @foreach($masterData as $key =>$shape)
                                                    <option value="{{$shape['value'].'-'.$shape['name']}}">{{$shape['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'style-categories')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="min_price">Style </label>
                                            <select name="item_value" id="style" class="form-control">
                                                @foreach($masterData as $key =>$style)
                                                    <option value="{{$style['value'].'-'.$style['name']}}">{{$style['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'colour')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="colour">Colour </label>
                                            <select name="item_value" id="colour" class="form-control">
                                                @foreach($masterData as $key =>$colour)
                                                    <option value="{{$colour['value'].'-'.$colour['name']}}">{{$colour['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'diamond-clarity')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="clarity">Clarity </label>
                                            <select name="item_value" id="clarity" class="form-control">
                                                @foreach($masterData as $key =>$clarity)
                                                    <option value="{{$clarity['value'].'-'.$clarity['name']}}">{{$clarity['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'carat')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="carat">Carat </label>
                                            <select name="item_value" id="carat" class="form-control">
                                                @foreach($masterData as $key =>$carat)
                                                    <option value="{{$carat['value'].'-'.$carat['name']}}">{{$carat['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'metal_type')
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="metal_type">Metal Type</label>
                                            <select name="item_value" id="metal_type" class="form-control">
                                                @foreach($masterData as $key =>$metal)
                                                    <option value="{{$metal['value'].'-'.$metal['name']}}">{{$metal['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                @elseif($slugData == 'category')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="category">Category</label>
                                                <select name="item_value" id="category" class="form-control">
                                                    @foreach($masterData as $key =>$category)
                                                        <option value="{{$category['value'].'-'.$category['name']}}">{{$category['name']}}</option>
                                                    @endforeach
                                                </select>
                                                @error('item_value') <span class="custom-error">{{ $message }}</span>  @enderror
                                            </div>
                                        </div>
                                @endif
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
