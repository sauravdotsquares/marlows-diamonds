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
                           <div class="form-group">
                              <input name="title" type="text" class="form-control" id="title" value="{{ request()->title }}" placeholder="Search by title">
                           </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">Search</button>
                            <a href="{{ route('admin.products-list') }}" class="btn btn-primary">Reset</a>
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
                  <div class="card-header text-right">
                     <a href="{{route('admin.products-createform')}}"><button type="button" class="btn btn-primary">Add New Product</button></a>
                     <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                  </div>

                  <div class="card-body">
                     <table id="" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>Sr No</th>
                              <th><span class="wc-image tips">Image</span></th>
                              <th>Title</th>
                              <th>Stock</th>
                              <th>Category</th>
                           
                              <th>Created</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(isset($getProducts) && !$getProducts->isEmpty())
                              @foreach($getProducts as $key => $value)
                                 <tr>
                                    <td>{{$getProducts->firstItem() + $key}}</td>
                                    <td>
                                       @if(isset($value->getProductImages) && !empty($value->getProductImages->image_url))
                                          <img src="{{ asset('storage/'.$value->getProductImages->image_url) }}" alt="" height="50px" width="50px">
                                       @endif
                                    </td>
                                    <td>{{isset($value->title)?$value->title:''}}</td>
                                    <td>In Stock</td>
                                    <td>{{isset($value->cat_details)?$value->cat_details:''}}</td>
                                    
                                    <td>{{date('d M Y H:i:s', strtotime($value->created_at))}}</td>
                                    <td>
                                       @if($value->status == 1)
                                          <a title="Change Status"
                                          href="javascript:void(0);" class="statusSwitch" data-record="{{$value->id}}" data-value="0"><i
                                             class="fa fa-check" aria-hidden="true"></i></a>
                                       @else
                                          <a title="Change Status"
                                          href="javascript:void(0);" class="statusSwitch" data-record="{{$value->id}}" data-value="1"><i
                                             class="fa fa-edit" aria-hidden="true"></i></a>
                                       @endif
                                       
                                       <a title="Pricing" href="{{route('admin.product-pricing',[$value->slug])}}" class="btn btn-success btn-sm"><i class="fa fa-solid fa-dollar-sign" aria-hidden="true"></i></a>
                                       <a title="Images" href="{{route('admin.update_product_images',[$value->slug])}}" class="btn btn-info btn-sm"><i class="fa fa-image" aria-hidden="true"></i></a>
                                       <a title="Edit" href="{{route('admin.products-updateform',[$value->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit " aria-hidden="true"></i></a>
                                       <a title="Delete" href="javascript:void(0);" class="delete-modal btn btn-danger btn-sm" data-value="{{$value}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                 </tr>
                              @endforeach
                           @else
                              No record found
                           @endif
                        </tbody>
                        <tfoot>
                           <tr>
                              <th>Sr No</th>
                              <th><span class="wc-image tips">Image</span></th>
                              <th>Title</th>
                              <th>Stock</th>
                              <th>Category</th>
                              <th>Created</th>
                              <th>Action</th>
                           </tr>
                        </tfoot>
                     </table>
                     <div class="pagination-container float-right">
                        {{ $getProducts->appends($_GET)->links('layouts.pagination') }}
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

<div id="myModal" class="modal fade" role="dialod">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">
            </h4>
            <button class="close" type="button" data-bs-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="deleteContent">
               Are you sure want to delete <span class="title"></span>?
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal">
               <span id="footer_action_button"></span>
            </button>
            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
               <span class="glyphicon glyphicon"></span> Close
            </button>
            <input type="hidden" name="themeId" value="" />
         </div>
      </div>
   </div>
</div>

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){
       
         $('.statusSwitch').on('click',function(){
               $.ajax({
                  type:'POST',
                  url:'{{route("admin.change-product-status")}}',
                  data:{
                  '_token':"{{csrf_token()}}",
                  'id':$(this).data('record'),
                  'status':$(this).data('value')
                  },
                  success:function(responseText){
                  Swal.fire({
                     position: 'top-end',
                     icon: 'success',
                     title: "Changed",
                     showConfirmButton: false,
                     timer: 1500
                  });
                  location.reload();
                  }
               })
         });

         $(document).on('click','.delete-modal',function(){
               roe=$(this).parent('id').parent('tr');
               $('#footer_action_button').text('Delete');
               $('#footer_action_button').removeClass('glyphicon-check');
               $('#footer_action_button').addClass('glyphicon-trash');
               $('.actionBtn').removeClass('btn-success');
               $('.actionBtn').removeClass('btn-danger');
               $('.actionBtn').addClass('delete');
               $('.modal-title').text('Delete ?');
               $('.modal-footer').find('input[name=themeId]').val($(this).data('value').id);
               $('.deleteContent').show();
               $('.form-horizontal').hide();
               $('.title').html($(this).data('value').title);
               $('#myModal').modal('show');
         });


         $('.modal-footer').on('click','.delete',function(){
            let themeId = $('input[name=themeId]').val();
            $.ajax({
               type:"POST",
               url:'{{route("admin.delete-product-records")}}',
               data:{
                  "_token": "{{ csrf_token() }}",
                  'id':themeId,
               },
               success:function(res){
                  Swal.fire({
                     position: 'top-end',
                     icon: 'success',
                     title: "Deleted",
                     showConfirmButton: false,
                     timer: 1500
                  });
                  location.reload();
               }
            });
         });

   })
</script>
@endsection