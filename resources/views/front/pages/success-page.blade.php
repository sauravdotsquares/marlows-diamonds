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

{{--criteo start --}}
@section('criteo-tracking')
@if (!empty($pay) && !empty($pay['get_order_details_function']))

<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    window.criteo_q.push(
        { event: "setAccount", account: 119681 },
        { event: "setEmail", email: "{{ hash('sha256', strtolower(trim($pay['user_details']['email']))) }}", hash_method: "sha256" },
        { event: "setEmail", email: "{{ md5(strtolower(trim($pay['user_details']['email']))) }}", hash_method: "md5" },
        @if (!empty($pay['order_address']['mobile']))
        { event: "setSha256HashedPhoneNumber", phone_number: "{{ hash('sha256', preg_replace('/[^0-9]/', '', $pay['order_address']['mobile'])) }}" },
        @endif
        { event: "setSiteType", type: "{{ request()->header('User-Agent') && preg_match('/iPad/', request()->header('User-Agent')) ? 't' : (preg_match('/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/', request()->header('User-Agent')) ? 'm' : 'd') }}" },
        { event: "setCustomerId", id: "{{ $pay['user_details']['id'] ?? 'guest' }}" },
        { event: "setRetailerVisitorId", id: "{{ session()->getId() }}" },
        @if (!empty($pay['order_address']['pin_code']))
        { event: "setZipcode", zipcode: "{{ $pay['order_address']['pin_code'] }}" },
        @endif
        {
            event: "trackTransaction",
            id: "{{ $pay['custom_order_id'] }}",
            new_customer: "{{ isset($pay['user_details']['is_new']) && $pay['user_details']['is_new'] ? '1' : '0' }}",
            deduplication: "",
            currency: "GBP",
            item: [
                @foreach($pay['get_order_details_function'] as $item)
                    {
                        id: "ig_{{ $item['product_id'] }}",
                        price: {{ $item['deposited_product_price'] }},
                        quantity: 1
                    }@if (!$loop->last),@endif
                @endforeach
            ]
        }
    );
</script>
@endif
@endsection
{{-- ends --}}

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
