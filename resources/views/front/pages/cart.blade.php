@extends('layouts.front.app')



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
                                @if(session('cart'))
                                    @foreach(session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr data-id="{{ $id }}">
                                            <td class="product-info-col" data-th="Product">
                                                <div class="cart-item-name">
                                                    <div class="cart-image-item"><img src="{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                                                    <div class="cart-nameitem">
                                                        <div class="cartproduct-title"><a href="#"> {{ $details['name'] }}</a></div>
                                                        <dl class="variation">
                                                            <dt class="variation-Colour">Metal Colour:</dt>
                                                            <dd class="variation-Colour"><p>18ct White Gold</p></dd>
                                                            <dt class="variation-FingerSize">Finger Size:</dt>
                                                            <dd class="variation-FingerSize"><p>I</p></dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </td>
                                            <td  class="product-price-col" data-th="Price">${{ $details['price'] }}</td>
                                            <td  class="product-quantity-col" data-th="Quantity">
                                                <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                                            </td>
                                            <td  class="product-subtotal-col" data-th="Subtotal">${{ $details['price'] * $details['quantity'] }}</td>
                                            <td  class="product-action-col" class="actions" data-th="">
                                                <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div> 
                </div>   
                <div class="col-lg-4">
                    <div class="cart-sidebar-box">                            
                        <div class="cart-sidebar-heading">Basket totals</div>
                        <div class="cart-side-wrap">
                            <table border-collapse="collapse" style="width:100%">
                                <tbody>
                                    <tr class="box-cart-subtotal">
                                        <th>Subtotal</th>
                                        <td></td>
                                    </tr>
                                    <tr class="box-cart-total">
                                        <th>Total</th>
                                        <td> ${{ $total }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="cart-actions">
                            <a href="{{ url('/') }}" class="grey-btn-large"> Continue Shopping</a>
                            <a href="{{route('product.checkout')}}"><button class="btn-bg-large">Proceed To Checkout</button></a>
                            </div>                    
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
@endsection
  
@section('js')
    <script type="text/javascript">
    
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
    
            if(confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: '{{ route('remove.from.cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    
    </script>
@endsection