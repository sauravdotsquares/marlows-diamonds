@extends('layouts.front.app')

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
        <a href="{{ url('/') }}" class="grey-btn-large"> Continue Shopping</a>
    </div>
    </div>
    
@endsection
  