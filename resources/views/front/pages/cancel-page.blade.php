@extends('layouts.front.app')

@section('content')

    <div class="category-banner" style="background-image:url(../assets/images/cart-bg.jpg)">
        <div class="container">
            <div class="category-banner-text">
                <h1>Order Cancelled</h1>
            </div>

        </div>
    </div>
    <div class="orders-warp order-cancel-page">
        <div class="container">
            <div class="order-data">{{$response}}</div>
            <a href="{{ url('product-category/engagement-rings') }}" class="grey-btn-large"> Continue Shopping</a>
        </div>
    </div>

@endsection

@section('js')
@endsection
