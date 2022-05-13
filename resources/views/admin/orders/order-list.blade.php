@extends('layouts.admin.app')
@section('content')
@section('css')
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
<!-- Main content -->
<section class="content">
   <div class="container-fluid orderlist-dash">
      <div class="row">
         <div class="col-12">
		 @if(session()->has('alert-success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-success') }}
            </div>
          @endif
            <div class="card">
               <div class="card-header">
                  
               </div>
               <!-- /.card-header -->
               <div class="card-body">
               <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>User Email</th>
                      <th>Total Payment</th>
                      <th>Payment Method</th>
                      <th>Status</th>
                      <th>Order Date</th>
                      <th>View Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($getOrderDetails as $key => $order)
                    <tr>
                      <td><a href="pages/examples/invoice.html">{{isset($order->token)?$order->token:''}}</a></td>
                      <td>{{isset($order->user_details->email)?$order->user_details->email:''}}</td>
                      <td>{{isset($order->final_price)?$order->final_price:''}}</td>
                      <td>{{isset($order->payment_type)?$order->payment_type:''}}</td>
                      <td>
                        <a href="javascript:void(0);" type="button" class="orderSelectedStatus" data-bs-toggle="modal" data-token="{{$order->token}}" data-status="{{isset($order->status)?$order->status:''}}" data-bs-target="#exampleModal">{!!isset($order->status_details_designs)?$order->status_details_designs:''!!}</a>

                         <!-- <a href="javascript:void(0);" id="orderDetailsPage{{$order->id}}">{!!isset($order->status_details_designs)?$order->status_details_designs:'' !!}</a></td> -->
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">{{$order->created_at->format('M d,Y')}}</div>
                      </td>
                      <td><a href="{{route('admin.order.product.details',[$order->id])}}">View Product Details</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                {!! $getOrderDetails->render() !!}
               </div>
               <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="financeAvailableModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Request an appointment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            
         </div>
      </div>
   </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <select name="status_change" class="form-control" id="status_change">
            <option value="">Choose Any</option>
            <option value="0">Payment Pending</option>
            <option value="1">Payment Processing</option>
            <option value="2">Payment Success</option>
            <option value="3">Payment Cancelled</option>
            <option value="4">Order Shipped</option>
            <option value="5">Order Delivered</option>
            <option value="6">Order Return</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
   $(document).ready(function(){
      $(document).on('change', "[id^=orderDetailsPage]", function () {
         var index = parseInt($(this).attr("id").replace("orderDetailsPage", ''));
         console.log(index);
      });

      $('.orderSelectedStatus').on('click',function(){
         // console.log($(this).data('status'));
         $('#status_change').val($(this).data('status'));
         $('#status_change').attr('data-token',$(this).data('token'));
      });
      

      $('#status_change').on('change',function(){
         if(confirm("Are you sure want to Change Status?")) {
            $.ajax({
               url: "{{ route('admin.order.change.order.status') }}",
               method: "POST",
               data: {
                     _token: '{{ csrf_token() }}', 
                     order_token: $(this).data('token'),
                     order_status: $(this).val()
               },
               success: function (response) {
                     // 
                     if(response.status == 200){
                        toastr.success(response.msg);
                     }else{
                        toastr.info("Not Updated...");
                     }
                     window.location.reload();
               }
            });
         }
         // console.log($(this).val());
      });

   });
</script>
@endsection
