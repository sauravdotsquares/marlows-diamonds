@extends('layouts.front.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
<div class="category-banner" style="background-image:url(../assets/images/cart-bg.jpg)">
    <div class="container">
        <div class="category-banner-text">
            <h1>CART</h1>
        </div>
    </div>
</div>
<div class="cart-page-main">
    <div class="container">
        <div class="row">
            @if(session('cart'))
            <div class="col-lg-8">
                <div class="cart-table-wraper">

                    <table id="cart" class="cart-table">
                        <thead>
                            <tr>
                                <th class="product-th" style="width:45%">Product</th>
                                <th class="price-th">Price</th>
                                <th class="quantity-th">Quantity</th>
                                <th class="subtotal-th">Subtotal</th>
                                <th class="action-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp

                            @foreach(session('cart') as $id => $details)
                            <?php
                                // echo "<pre>";
                                // print_r(session('cart'));
                                // die;
                            ?>
                            @php
                                $total += $details['price'] * $details['quantity'];
                            @endphp
                            <tr data-id="{{ $id }}">
                                <td class="product-info-col" data-th="Product">
                                    <div class="cart-item-name">
                                        <div class="cart-image-item">
                                            @if(isset($details['selected_parameter']['imagelink']) && !empty($details['selected_parameter']['imagelink']))
                                                <img src="{{$details['selected_parameter']['imagelink']}}" width="100" height="100"
                                                class="img-responsive" />
                                            @elseif(isset($details['image']) && !empty($details['image']))
                                                <img src="{{asset('storage/'.$details['image'])}}" width="100" height="100"
                                                class="img-responsive" />
                                            @else
                                                <img src="{{asset('assets/images/marlowsdiamonds-logo.png')}}" width="70" height="100" class="img-responsive" />
                                            @endif
                                        </div>
                                        <div class="cart-nameitem">
                                            <div class="cartproduct-title">{!! $details['name'] !!}</div>
                                            <dl class="variation">
                                                <!-- <dt class="variation-Colour">Metal Colour:</dt>
                                                            <dd class="variation-Colour"><p>18ct White Gold</p></dd>
                                                            <dt class="variation-FingerSize">Finger Size:</dt>
                                                            <dd class="variation-FingerSize"><p>I</p></dd> -->
                                            </dl>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-price-col" data-th="Price">{{MY_CURRENCY_SYMBOL}}{{
                                    number_format($details['price'],2) }}</td>
                                <td class="product-quantity-col" data-th="Quantity">
                                    <input type="number" value="{{ $details['quantity'] }}"
                                        class="form-control quantity update-cart" />
                                </td>
                                <td class="product-subtotal-col" data-th="Subtotal">{{MY_CURRENCY_SYMBOL}}{{
                                    number_format($details['price'] * $details['quantity'],2) }}</td>
                                <td class="product-action-col" class="actions" data-th="">
                                    <button class="btn btn-danger btn-sm remove-from-cart"><i
                                            class="fa fa-trash-o"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-sidebar-box">
                    <div class="cart-sidebar-heading">Basket Totals</div>
                    <div class="cart-side-wrap">
                        <table border-collapse="collapse" style="width:100%">
                            <tbody>
                                <!-- <tr class="box-cart-subtotal">
                                        <th>Subtotal</th>
                                        <td>{{MY_CURRENCY_SYMBOL}}{{ $total }}</td>
                                    </tr> -->
                                <tr class="box-cart-total">
                                    <th>Total</th>
                                    <td> {{MY_CURRENCY_SYMBOL}}{{ number_format($total,2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-actions">
                            <a href="{{ url('product-category/engagement-rings') }}" class="grey-btn-large"> Continue Shopping</a>
                            @if(session('cart'))
                            <a href="{{route('product.checkout')}}"><button class="btn-bg-large">Proceed To
                                    Checkout</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="container">
                <div class="tinv-message ">
                    {{-- <div class="tinv-header">
                        <h2>Cart</h2>
                    </div> --}}
                    <p class="cart-empty woocommerce-info"> Your basket is currently empty. </p>
                    <div class="return-to-shop">
                        <a class="btn-bg-small" href="{{ url('/') }}">Return to shop</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>

    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if (confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route("remove.from.cart") }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    if(response.status == 200){
                        toastr.success(response.msg);
                        setTimeout(function () {
                            location.reload(true);
                        }, 1500);
                    }
                }
            });
        }
    });

</script>
@endsection
