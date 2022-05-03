@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
    
    <div class="container-fluid">
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
                            {!!isset($getOrderDetails->status_details_designs)?$getOrderDetails->status_details_designs:''!!}.
                        </p>

                        <section class="woocommerce-order-details">
                            <h2 class="woocommerce-order-details__title">Order details</h2>
                            <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                                <thead>
                                    <tr>
                                        <th class="woocommerce-table__product-name product-name">Product</th>
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
@endsection