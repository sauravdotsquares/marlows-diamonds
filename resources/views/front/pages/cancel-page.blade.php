@extends('layouts.front.app')

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

<?php if(!empty($response)){ ?>
    <div class="orders-warp order-cancel-page">
        <div class="container">
            <div class="order-data">{{$response}}</div>
            <a href="{{ url('/diamond-engagement-rings') }}" class="grey-btn-large"> Continue Shopping</a>
        </div>
    </div>
<?php } ?>

@endsection

@section('js')
@endsection
