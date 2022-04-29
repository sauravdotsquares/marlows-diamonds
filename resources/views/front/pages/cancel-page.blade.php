@extends('layouts.front.app')

@section('content')

    <div class="category-banner" style="background-image:url(../assets/images/cart-bg.jpg)">
        <div class="container">
            <div class="category-banner-text">
                <h1>Cancelled Page</h1>
            </div>
            
        </div>
    </div>
    <div>
        {{$response}}
    </div>
    <a href="{{ url('/') }}" class="grey-btn-large"> Continue Shopping</a>
@endsection
  
@section('js')
@endsection