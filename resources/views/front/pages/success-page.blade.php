@extends('layouts.front.app')
@section('google-ecommerce')
    <?php
    if(!empty($pay)){
            $getCustomOrderData = array();
            $getCustomOrderData['transaction_id'] = $pay['custom_order_id'];
            $getCustomOrderData['affiliation'] = 'Marlows online store';
            $getCustomOrderData['value'] = $pay['final_price'];
            $getCustomOrderData['currency'] = "GBP";
            $getCustomOrderData['tax'] = getVATPriceFunction($pay['final_price']);
            $getCustomOrderData['shipping'] = 0;
            $getCustomOrderData['items'] = array();
            foreach($pay['get_order_details_function'] as $value2){
                $getCustomOrderData['items'][] = array(
                    'id' => $value2['id'],
                    'name' => isset($value2['product_details']['title'])?$value2['product_details']['title']:'custom_diamond',
                    'list_name' => 'Search Results',
                    'brand' => 'Marlows',
                    'category' => isset($value2['product_details']['cat_details'])?$value2['product_details']['cat_details']:'custom_diamond',
                    'variant'=> 'Black',
                    'list_position' => 1,
                    'quantity'=> $value2['quantity'],
                    'price' => $value2['total_price'],
                    'deposited_price' => isset($value2['deposited_product_price'])?$value2['deposited_product_price']:$value2['total_price'],
                );
            }
        }
    ?>
    
<?php if(!empty($getCustomOrderData)){ ?>
    <script> gtag('event', 'purchase', {!!  json_encode($getCustomOrderData) !!});</script>
<?php } ?>

@endsection
@section('content')

    <div class="category-banner" style="background-image:url(../assets/images/cart-bg.jpg)">
        <div class="container">
            <div class="category-banner-text">
                <h1>
                    Thank you for visiting. Check out more products <a href="{{ url('/') }}"> here</a>.
                </h1>
            </div>
        </div>
    </div>
    <?php if(!empty($getCustomOrderData)){ ?>
    <div class="orders-warp order-success-page">
        <div class="container">
            <div class="order-data">{{$response}}</div>
            <a href="{{ url('product-category/engagement-rings') }}" class="grey-btn-large"> Continue Shopping</a>
        </div>
    </div>
    <?php } ?>

@endsection

@section('js')
@endsection
