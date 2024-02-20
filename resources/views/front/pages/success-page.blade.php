@extends('layouts.front.app')
@section('successtrackingscript')
    <script>
        window.uetq = window.uetq || [];window.uetq.push('event', 'purchase', {"revenue_value":"{{isset($pay['final_price'])?$pay['final_price']:0.00}}","currency":"GBP"});
    </script>
@endsection


@section('google-ecommerce')
    <?php
        if(!empty($pay)){
            
            $getCustomOrderData = array();
            $getCustomOrderData['transaction_id'] = $pay['custom_order_id'];
            $getCustomOrderData['affiliation'] = 'Marlows online store';
            $getCustomOrderData['value'] = $pay['deposited_price'];
            $getCustomOrderData['currency'] = "GBP";
            $getCustomOrderData['items'] = array();
            foreach($pay['get_order_details_function'] as $value2){
                $getCustomOrderData['items'][] = array(
                    'id' => $value2['id'],
                    'name' => isset($value2['product_details']['title'])?$value2['product_details']['title']:'custom_diamond',
                    'brand' => 'Marlows',
                    'category' => isset($value2['product_details']['cat_details'])?$value2['product_details']['cat_details']:'custom_diamond',
                    'variant'=> 'Black',
                    'quantity'=> 1,
                    'price' => $value2['deposited_product_price'],
                );
            }
        }
    ?>
    <?php if(isset($getCustomOrderData) && !empty($getCustomOrderData)){ ?>
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
    <?php if(isset($getCustomOrderData) && !empty($getCustomOrderData)){ ?>
    <div class="orders-warp order-success-page">
        <div class="container">
            <div class="order-data">{{$response}}</div>
            <a href="{{ url('/diamond-engagement-rings') }}" class="grey-btn-large"> Continue Shopping</a>
        </div>
    </div>
    <?php } ?>

@endsection

@section('js')
<?php if(isset($getCustomOrderData) && !empty($getCustomOrderData)){ ?>
    <script>
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({
        'event':'order_complete',
        'order_id': '{{$pay['custom_order_id']}}',
        'order_value': '{{$pay['deposited_price']}}',
        'order_currency': 'GBP',
        'enhanced_conversion_data': {
          "email": "{{$pay['user_details']['email']}}",
          }
      });
    </script>
<?php } ?>
@endsection
