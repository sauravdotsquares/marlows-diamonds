@extends('layouts.admin.app')

@section('content')

<section class="content search-container ">
    <div class="container-fluid">
       <div class="row">
          <div class="col-md-12">
             <div class="card card-success">
                   <div class="card-header">
                      <h3 class="card-title">Price update</h3>
                   </div>
                   <form method="POST" action="{{ route('admin.update-base-price') }}">
                        @csrf
                      <input name="search_open" type="hidden" class="form-control" id="search_open" value="open">
                      <div class="card-body">
                         <div class="row">
                            
                            <div class="form-group col-6">
                              <input name="product_id" id="product_id" type="hidden" value="" />
                              <input name="product_name" id="product_name" type="hidden" value="" />
                              <select id="product" name="product" class="form-control select2"></select>
                              @error('product_id') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                            <div class="form-group col-6">
                              
                               <select name="category_id" id="category_id" class="form-control">
                                  <option value="">Update by category</option>
                                  {!! $categories !!}
                               </select>
                               @error('category_id') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>


                            <div class="form-group col-6">
                                <select name="type" id="type" class="form-control">
                                   <option {{ old('type') == 'increase' ? 'selected' : '' }} value="increase">Increase price</option>
                                   <option {{ old('type') == 'decrease' ? 'selected' : '' }} value="decrease">Decrease price</option>
                                </select>
                                @error('type') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                            <div class="form-group col-6">
                                <input name="percentage" type="text" class="form-control" id="percentage" value="{{ old('percentage')}}" placeholder="Percentage">
                                @error('percentage') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                         </div>

                      </div>

                      <div class="card-footer text-right">
                         <button type="submit" class="btn btn-success">Update</button>
                      </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </section>

@endsection

@section('css')
<link href="{{ asset('assets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendors/select2/dist/theme/bootstrap/dist/select2-bootstrap.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
<script src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
<script>

   $(document).ready(function() {

      const oldCategory = "{{ old('category_id') }}";
      document.getElementById("category_id").value = oldCategory;

      $("#product").select2({
         placeholder: "Update by product",
         theme: "bootstrap",
         tags: false,
         multiple: false,
         tokenSeparators: [',', ' '],
         minimumInputLength: 2,
         minimumResultsForSearch: 15,
         ajax: {
            url: "{{ route('admin.product-search') }}",
            dataType: "json",
            type: "GET",
            data: function (params) {
               var queryParameters = {
                  term: params.term
               }
               return queryParameters;
            },
            processResults: function (data) {
               return {
                  results: $.map(data, function (item) {
                     return {
                        text: item.title,
                        id: item.id
                     }
                  })
               };
            }
         }
      });
   }).on('select2:selecting', function(e) {
      $("#product_id").val(e.params.args.data.id);
      $("#product_name").val(e.params.args.data.text);
  });
</script>

@endsection