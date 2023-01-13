@extends('layouts.admin.app')

@section('content')

   <section class="content search-container  {{ request()->search_open == 'open' ? '' : 'd-none' }}">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card card-success">
                     <div class="card-header">
                        <h3 class="card-title">Search here</h3>
                     </div>
                     <form method="GET">
                        <input name="search_open" type="hidden" class="form-control" id="search_open" value="open">
                        <div class="card-body">
                           <div class="row">
                              
                              @if ($search)
                                 <div class="form-group col-4">
                                    <input name="title" type="text" class="form-control" id="title" value="{{ request()->title }}" placeholder="Search by product name">
                                 </div>

                                 <div class="form-group col-4">
                                    <select name="category" id="category" class="form-control">
                                       <option value="">Filter by category</option>
                                       {!! $categories !!}
                                    </select>
                                 </div>

                                 <div class="form-group col-4">
                                    <select name="pricing-id" id="pricing-id" class="form-control">
                                       <option value="">Filter by pricing</option>
                                       @foreach ($product_pricing_ids as $item)
                                          <option {{ request('pricing-id')== $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->percentage .' % '. ucfirst($item->type) }} </option>
                                       @endforeach
                                    </select>
                                 </div>

                              @else
                              <div class="form-group col-6">
                                 <select name="pricing-id" id="pricing-id" class="form-control">
                                    <option value="">Filter by pricing</option>
                                    @foreach ($product_pricing_ids as $item)
                                       <option {{ request('pricing-id')== $item->id ? 'selected' : '' }} value="{{$item->id}}">{{$item->percentage .' % '. ucfirst($item->type) }} </option>
                                    @endforeach
                                 </select>
                              </div>
                              @endif
                           </div>

                        </div>

                        <div class="card-footer text-right">
                           <button type="submit" class="btn btn-success">Search</button>
                           <a href="{{ route('admin.base-price-list') }}" class="btn btn-primary">Reset</a>
                        </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>

	<section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                     <div class="card-title">
                        <strong>Total records:- </strong> {{ $product_variations->total() }}, 
                        <strong>Total products:- </strong> {{ $productsCount }}
                     </div>
                     <div class="card-tools">
                        <a href="{{route('admin.update-base-price')}}"><button type="button" class="btn btn-info">Add/Remove price</button></a>
                        <a href="{{ request()->fullUrlWithQuery(['export'=>'true']) }}"><button type="button" class="btn btn-primary">Export</button></a>
                        <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                     </div>
                     
                  </div>

                  <div class="card-body">
                     <table id="" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th>Sr No</th>
                              <th>Product</th>
                              <th>Variations</th>
                              <th>Base Price</th>
                              <th>Mined Price</th>
                              <th>Lab grown Price</th>
                              <th>Discounted</th>
                              <th>New Price</th>
                              <th>New Mined</th>
                              <th>New Lab grown</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(isset($product_variations) && !$product_variations->isEmpty())
                             @foreach($product_variations as $key => $value)
                             <?php 
                              if(!empty($pricingData)){
                                 $percentageValue = getPercentageValue($value->regular_price, $pricingData->percentage); 
                              }else{$percentageValue=0;}
                             ?>
                                 <tr>
                                    <td>{{$product_variations->firstItem() + $key}}  ({{ $value->id }}) </td>
                                    <td>
                                       {{ $value['product']->title }}
                                    </td>
                                    <td>
                                       @foreach($value['get_vari_details_id'] as $key => $attribute)
                                          <b> {{str_replace("attri_","",$attribute->key)}}:- </b> {{$attribute->value ? $attribute->value : "All"}}, 
										         @endforeach
                                    </td>
                                    <td> {{ show_percentage($value->regular_price, $pricingData) }} </td>
                                    <td> {{ !empty($value['mined']['regular_price']) ?  show_percentage($value['mined']['regular_price'], $pricingData)  : 'N/A' }} </td>
                                    <td> {{  !empty($value['lab_grown']['regular_price']) ? show_percentage($value['lab_grown']['regular_price'], $pricingData) : 'N/A'  }} </td>
                                    <td>N/A</td>
                                    <td> {{ show_percentage($value->regular_price,$pricingData,'action' ) }} </td>
                                    <td> {{ !empty($value['mined']['regular_price']) ?  show_percentage($value['mined']['regular_price'],$pricingData,'action' ) : 'N/A'  }} </td>
                                    <td> {{  !empty($value['lab_grown']['regular_price']) ? show_percentage($value['lab_grown']['regular_price'],$pricingData,'action' ) : 'N/A'  }} </td>
                                  
                                 </tr>
                              @endforeach
                           @else
                              No record found
                           @endif
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>Sr No</th>
                              <th>Product</th>
                              <th>Variations</th>
                              <th>Base Price</th>
                              <th>Mined Price</th>
                              <th>Lab grown Price</th>
                              <th>Discounted</th>
                              <th>New Price</th>
                              <th>New Mined</th>
                              <th>New Lab grown</th>
                           </tr>
                        </tfoot>
                     </table>
                     <div class="pagination-container float-right">
                        {{ $product_variations->appends($_GET)->links('layouts.pagination') }}
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection


@section('js')
<script>
   const selectedCategory = "{{ request()->category }}";
   document.getElementById("category").value = selectedCategory;
   // alert(selectedCategory );
</script>
@endsection