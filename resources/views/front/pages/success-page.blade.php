@extends('layouts.front.app')
@section('google-ecommerce')
    <?php
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
                'name' => $value2['product_details']['title'],
                'list_name' => 'Search Results',
                'brand' => 'Marlows',
                'category' => $value2['product_details']['cat_details'],
                'variant'=> 'Black',
                'list_position' => 1,
                'quantity'=> $value2['quantity'],
                'price' => $value2['total_price'],
            );
        }
        $getJsonOrderData = json_encode($getCustomOrderData);
    ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-988710676"></script>
    <script>
        gtag('event', 'purchase', {{$getJsonOrderData}});
    </script>
@endsection
@section('content')

    <div class="category-banner" style="background-image:url(../assets/images/cart-bg.jpg)">
        <div class="container">
            <div class="category-banner-text">
                <h1>Success Page</h1>
            </div>

        </div>
    </div>
    <div class="orders-warp order-success-page">
        <div class="container">
        <!-- Your Order number(22545875412) has been cancelled  -->
        <div class="order-data">{{$response}}</div>
        <a href="{{ url('product-category/engagement-rings') }}" class="grey-btn-large"> Continue Shopping</a>
    </div>
    </div>

@endsection

@section('js')
@endsection
