@extends('layouts.admin.app')
@section('content')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
<!-- Main content -->
<section class="content">

    <div class="container-fluid order-details-dash">
        <div class="row">
            <div class="col-12">
                @if(session()->has('alert-success'))
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{
                    session()->get('alert-success') }}
                </div>
                @endif
                <div class="card">
                    <div class="woocommerce-MyAccount-content">
                        <div class="woocommerce-notices-wrapper"></div>
                        <p>
                            Order #<mark class="order-number">{{isset($getOrderDetails->token)?$getOrderDetails->token:''}}</mark> was placed on <mark class="order-date">{{isset($getOrderDetails->created_at)?$getOrderDetails->created_at->format('M d, Y'):''}}</mark> and is currently
                            <!-- <mark class="order-status">Cancelled</mark>  -->
                            <a href="javascript:void(0);" type="button" class="" data-bs-toggle="modal" id="orderSelectedStatus" data-status="{{isset($getOrderDetails->status)?$getOrderDetails->status:''}}" data-bs-target="#exampleModal">{!!isset($getOrderDetails->status_details_designs)?$getOrderDetails->status_details_designs:''!!}</a>.
                        </p>

                        <section class="woocommerce-order-details">
                            <h2 class="woocommerce-order-details__title">Order details</h2>
                            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                                <thead>
                                    <tr>
                                        <th style="width:65%;" class="woocommerce-table__product-name product-name">Product</th>
                                        <th class="woocommerce-table__product-table product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getOrderDetails->getOrderDetailsFunction as $key => $orderDetails)
                                        <?php
                                            if(isset($orderDetails->order_product_details) && !empty($orderDetails->order_product_details)){
                                                $orderProductDetails = json_decode($orderDetails->order_product_details);
                                            }else{
                                                $orderProductDetails = [];
                                            }
                                        ?>
                                        <tr class="woocommerce-table__line-item order_item">
                                            <td class="woocommerce-table__product-name product-name">
                                                <div class="pr-desc-text">
                                                    <div class="pr-desc-text-img">
                                                        <img src="images/Marlows-03.jpg" alt="ffimg">
                                                    </div>
                                                    <div class="pr-desc-text-content">
                                                        <a href="{{asset('product/'.$orderDetails->product_details->slug)}}" target="_blank">
                                                            {{isset($orderDetails->product_details->title)?$orderDetails->product_details->title:''}}</a> <strong
                                                            class="product-quantity">×&nbsp;{{$orderDetails->quantity}}</strong>
                                                        <ul class="wc-item-meta">
                                                            @foreach($orderProductDetails as $key1 => $orderProductDetails)
                                                                @if($key1 == 'certificatelink')
                                                                    <li><strong class="wc-item-meta-label">{{ucwords($key1)}}:</strong>
                                                                        <a href="{{$orderProductDetails}}" target="_blank">
                                                                        view </a>
                                                                    </li>
                                                                @else
                                                                    <li><strong class="wc-item-meta-label">{{ucwords($key1)}}:</strong>
                                                                        <p>{{$orderProductDetails}}</p>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="woocommerce-table__product-total product-total">
                                                <span class="woocommerce-Price-amount amount"><bdi><span
                                                            class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{$orderDetails->product_price * $orderDetails->quantity}}</bdi></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row">Subtotal:</th>
                                        <td><span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{$getOrderDetails->final_price}}</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Payment method:</th>
                                        <td>PayPal</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total:</th>
                                        <td><span class="woocommerce-Price-amount amount"><span
                                                    class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{$getOrderDetails->final_price}}</span>
                                            <small class="includes_tax">(includes <span
                                                    class="woocommerce-Price-amount amount"><span
                                                        class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>64.80</span>
                                                VAT)</small></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </section>

                        <section class="woocommerce-customer-details">


                            <h2 class="woocommerce-column__title">Billing address</h2>

                            <address>
                                {{isset($getOrderDetails->order_address->first_name)?$getOrderDetails->order_address->first_name:''}} {{isset($getOrderDetails->order_address->last_name)?$getOrderDetails->order_address->last_name:''}} {{isset($getOrderDetails->order_address->company_name)?$getOrderDetails->order_address->company_name:''}} {{isset($getOrderDetails->order_address->street_address_l1)?$getOrderDetails->order_address->street_address_l1:''}} {{isset($getOrderDetails->order_address->street_address_l2)?$getOrderDetails->order_address->street_address_l2:''}} {{isset($getOrderDetails->order_address->town_city)?$getOrderDetails->order_address->town_city:''}} {{isset($getOrderDetails->order_address->state)?$getOrderDetails->order_address->state:''}} {{isset($getOrderDetails->order_address->country_name)?$getOrderDetails->order_address->country_name:''}} {{isset($getOrderDetails->order_address->pin_code)?$getOrderDetails->order_address->pin_code:''}}

                                <p class="woocommerce-customer-details--phone">{{isset($getOrderDetails->order_address->mobile)?$getOrderDetails->order_address->mobile:''}}</p>

                                <p class="woocommerce-customer-details--email">{{isset($getOrderDetails->order_address->email)?$getOrderDetails->order_address->email:''}}</p>
                            </address>
                        </section>
                    </div>
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
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

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
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#orderSelectedStatus').on('click',function(){
                // console.log($(this).data('status'));
                $('#status_change').val($(this).data('status'));
            });


            $('#status_change').on('change',function(){
                if(confirm("Are you sure want to Change Status?")) {
                    $.ajax({
                        url: "{{ route('admin.order.change.order.status') }}",
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            order_token: '{{$getOrderDetails->token}}',
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

@endsection
