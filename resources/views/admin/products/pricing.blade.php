@extends('layouts.admin.app')

@section('content')


<div class="content products_section">
    <!-- DataTables Example -->
    <section class="content">
       <div class="container-fluid">
            <form method="POST" action="">
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
                                            <a target="_blank" href="{{ route('admin.masters.add',['carat']) }}" type="submit" class="btn btn-primary">Add more carat</a>
                                        </div>
                                    </div>
                                    <?php foreach ($caratData as $carat_key => $carat_value) { ?>

                                        <?php 
                                            $selectedValue = [];
                                            if(!empty($variationData) && !empty($variationData[$carat_value->id])){
                                                $selectedValue = $variationData[$carat_value->id];
                                                $old = (array)session()->getOldInput();
                                                $old = !empty($old['data']) ? $old['data'] : [];
                                                if(!empty($old)){
                                                    foreach ( $old as $k=>$v ){
                                                        $old[ $old[$k]['master_id'] ] = $v;
                                                        unset($old[$k]);
                                                    }
                                                }
                                                $selectedValue = !empty($old[$carat_value->id]) ? $old[$carat_value->id] : $selectedValue;
                                            }
                                        ?>
                                        
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <div class="form-check">
                                                    <input 
                                                        name="data[{{$carat_key}}][master_id]" 
                                                        value="{{ $carat_value->id }}" 
                                                        type="checkbox" 
                                                        class="form-check-input variation_check" 
                                                        data-index="{{$carat_key}}" 
                                                        id="variation_{{$carat_value->slug}}"
                                                        {{  !empty($selectedValue['master_id']) && $selectedValue['master_id'] ==$carat_value->id  ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="exampleCheck2">{{ $carat_value->name .' '. ucwords($carat_value->type) }} </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 {{  !empty($selectedValue['master_id']) ? '' : 'visibility_hidden'  }}" id="total_amount_variation_{{$carat_value->slug}}">
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <input type="text" id="total_price" name="{{  !empty($selectedValue['master_id']) ? "data[$carat_key][total_price]" : ''  }}" class="form-control total_price_{{$carat_value->slug}}" placeholder="Total Amount of {{ $carat_value->name .' '. ucwords($carat_value->type) }}" value="{{  !empty($selectedValue['total_price']) ? $selectedValue['total_price'] : '' }}">
                                                    </div>
                                                    @error('data.'.$carat_key.'.total_price') <span class="custom-error">{{ $message }}</span>  @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-3 {{  !empty($selectedValue['master_id']) ? '' : 'visibility_hidden'  }}" id="amount_variation_{{$carat_value->slug}}">
                                                <input name="{{  !empty($selectedValue['master_id']) ? "data[$carat_key][id]" : ''  }}" id="dataId" type="hidden" value="{{  !empty($selectedValue['id'])  ? $selectedValue['id'] : '' }}" >
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <input type="text" id="price" name="{{  !empty($selectedValue['master_id']) ? "data[$carat_key][price]" : ''  }}" class="form-control price_{{$carat_value->slug}}" placeholder="Amount of {{ $carat_value->name .' '. ucwords($carat_value->type) }}" value="{{  !empty($selectedValue['price']) ? $selectedValue['price'] : '' }}">
                                                    </div>
                                                    @error('data.'.$carat_key.'.price') <span class="custom-error">{{ $message }}</span>  @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-3 {{  !empty($selectedValue['master_id']) ? '' : 'visibility_hidden'  }}" id="amount_information_variation_{{$carat_value->slug}}">
                                                <a href="javascript:;" class="information-tooltip" id="{{$carat_value->slug}}">
                                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="prod-button">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        
    </section>
</div>


<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="priceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="priceModalLabel">Pricing calculation</h5>
                <button type="button" class="close close_modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="data_to_append"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .visibility_hidden{
        visibility: hidden;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $(document).on('change', '.variation_check', function(e) {
            $checkId = $(this).attr('id');
            $dataIndex = $(this).data('index');
            $isChecked = $('#' + $checkId).is(":checked");
            if($isChecked){
                $("#amount_information_" + $checkId).removeClass('visibility_hidden');
                $("#amount_" + $checkId).removeClass('visibility_hidden');
                $("#amount_" + $checkId).find('#dataId').attr('name',`data[${$dataIndex}][id]`);
                $("#amount_" + $checkId).find('#price').attr('name',`data[${$dataIndex}][price]`);

                $("#total_amount_" + $checkId).removeClass('visibility_hidden');
                $("#total_amount_" + $checkId).find('#total_price').attr('name',`data[${$dataIndex}][total_price]`);

            }else{
                $("#amount_information_" + $checkId).addClass('visibility_hidden');
                $("#amount_" + $checkId).addClass('visibility_hidden');
                $("#amount_" + $checkId).find('#price').attr('name',``);
                $("#amount_" + $checkId).find('#dataId').attr('name',``);

                $("#total_amount_" + $checkId).addClass('visibility_hidden');
                $("#total_amount_" + $checkId).find('#total_price').attr('name',``);
            }
        });
    });


    $(document).on('click','.information-tooltip', function(e) {
        const dataId = $(this).attr('id');
        console.log('dataId', dataId);
        const $price = $(".price_"+dataId).val();

        var fd = new FormData();    
        fd.append( 'price', $price );
        fd.append( '_token', '{{ csrf_token() }}' );

        $.ajax({
            url: "{{ route('admin.get-product-price') }}",
            cache: false,
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(response){
                if(response.status == 'success'){ 
                    let appendHtml = "<ul>";
                    for (let index = 0; index < response.data.length; index++) {
                        const element = response.data[index];
                        appendHtml += `<li> ${element}  </li>`;
                    }
                    appendHtml += "</ul>";
                    $(".data_to_append").empty();
                    $(".data_to_append").append(appendHtml);
                    $("#priceModal").modal('show');
                }else{
                    alert('Invalid amount')
                }
            }
        });
    });

    $(document).on('click','.close_modal', function(e) {
        $("#priceModal").modal('hide');
    });

</script>
@endsection