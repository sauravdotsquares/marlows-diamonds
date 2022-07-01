@extends('layouts.front.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                                // print_r($details['customArray']['final_price']);
                                // die;
                            ?>
                            @php
                                $total += $details['price'] * $details['quantity'];
                            @endphp
                            <tr data-id="{{ $id }}">
                                <td class="product-info-col" data-th="Product">
                                    <div class="cart-item-name">
                                        <div class="cart-image-item">
                                            @if(isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                                                <img src="{{$details['customArray']['ImageLink']}}" width="100" height="100"
                                                class="img-responsive" />
                                            @elseif(isset($details['image']) && !empty($details['image']))
                                                <img src="{{asset('storage/'.$details['image'])}}" width="100" height="100"
                                                class="img-responsive" />
                                            @else
                                                <img src="{{asset('assets/images/marlowsdiamonds-logo.png')}}" width="70" height="100" class="img-responsive" />
                                            @endif
                                        </div>
                                        <div class="cart-nameitem">
                                            @if(isset($details['customArray']['slug']) && !empty($details['customArray']['slug']))
                                                <div class="cartproduct-title"><a href="{{asset('product/'.$details['customArray']['slug'])}}"> {{ $details['name'] }}</a></div>
                                            @else
                                                <div class="cartproduct-title"><a href="javascript:void(0);"> {{ $details['name'] }}</a></div>
                                            @endif
                                            <dl class="variation">
                                                @if(isset($details['customArray']['choose_diamond']) && !empty($details['customArray']['choose_diamond']))
                                                    <dt class="variation-Colour">Choose Your Diamond: </dt>
                                                    <dd class="variation-Colour"><p> {{ ($details['customArray']['choose_diamond'] == 'lab_grown')?'Lab Grown':'Mined'}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['metalcolor']) && !empty($details['customArray']['metalcolor']))
                                                    <dt class="variation-Colour">Metal: </dt>
                                                    <dd class="variation-Colour"><p> {{$details['customArray']['metalcolor']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['fingersize']) && !empty($details['customArray']['fingersize']))
                                                    <dt class="variation-FingerSize">Finger Size: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['fingersize']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['width-mm']) && !empty($details['customArray']['width-mm']))
                                                    <dt class="variation-FingerSize">Width MM: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['width-mm']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['total-diamond-weight']) && !empty($details['customArray']['total-diamond-weight']))
                                                    <dt class="variation-FingerSize">Diamond Weight: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['total-diamond-weight']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['Shape']) && !empty($details['customArray']['Shape']))
                                                    <dt class="variation-FingerSize">Diamond Shape: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['Shape']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['Carat']) && !empty($details['customArray']['Carat']))
                                                    <dt class="variation-FingerSize">Diamond Carat: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['Carat']}}</p></dd>
                                                @elseif(isset($details['customArray']['carat']) && !empty($details['customArray']['carat']))
                                                    <dt class="variation-FingerSize">Diamond Carat: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['carat']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['Color']) && !empty($details['customArray']['Color']))
                                                    <dt class="variation-FingerSize">Diamond Color: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['Color']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['Clarity']) && !empty($details['customArray']['Clarity']))
                                                    <dt class="variation-FingerSize">Diamond Cut Grade: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['Clarity']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['Lab']) && !empty($details['customArray']['Lab']))
                                                    <dt class="variation-FingerSize">Certificate: </dt>
                                                    <dd class="variation-FingerSize"><p>{{$details['customArray']['Lab']}}</p></dd>
                                                @endif
                                                @if(isset($details['customArray']['CertificateLink']) && !empty($details['customArray']['CertificateLink']))
                                                    <dt class="variation-FingerSize">Certificate Link: </dt>
                                                    <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['CertificateLink']}}">View Certificate</a></dd>
                                                @endif
                                                @if(isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                                                    <dt class="variation-FingerSize">Image: </dt>
                                                    <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['ImageLink']}}">View Diamond</a></dd>
                                                @endif
                                                @if(isset($details['customArray']['CERT_NO']) && !empty($details['customArray']['CERT_NO']))
                                                    <dt class="variation-FingerSize">Certificate: </dt>
                                                    <dd class="variation-FingerSize"><p >{{$details['customArray']['CERT_NO']}}</p></dd>
                                                @endif
                                            </dl>
                                        </div>
                                    </div>
                                </td>
                                <td class="product-price-col" data-th="Price">
                                    @if(isset($details['customArray']['final_price']) && !empty($details['customArray']['final_price']) && $details['customArray']['final_price'] != $details['price'])
                                        <del>{{MY_CURRENCY_SYMBOL}}{{
                                            number_format($details['customArray']['final_price'],2) }}
                                        </del>
                                    @endif
                                    &nbsp; {{MY_CURRENCY_SYMBOL}}{{
                                    number_format($details['price'],2) }}</td>
                                <td class="product-quantity-col" data-th="Quantity">
                                    <input type="number" disabled="disabled" value="{{ $details['quantity'] }}"
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

{{-- <div class="category-banner" style="background-image:url(../assets/images/cart-bg.jpg)">
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
                                                    <div class="cartproduct-title"><a href="{{asset('product/'.$details['customArray']['slug'])}}"> {{ $details['name'] }}</a></div>
                                                    <dl class="variation">
                                                        @if(isset($details['customArray']['metalcolor']) && !empty($details['customArray']['metalcolor']))
                                                            <dt class="variation-Colour">Metal:</dt>
                                                            <dd class="variation-Colour"><p>{{$details['customArray']['metalcolor']}}</p></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['fingersize']) && !empty($details['customArray']['fingersize']))
                                                            <dt class="variation-FingerSize">Finger Size:</dt>
                                                            <dd class="variation-FingerSize"><p>{{$details['customArray']['fingersize']}}</p></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['Shape']) && !empty($details['customArray']['Shape']))
                                                            <dt class="variation-FingerSize">Diamond Shape:</dt>
                                                            <dd class="variation-FingerSize"><p>{{$details['customArray']['Shape']}}</p></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['Color']) && !empty($details['customArray']['Color']))
                                                            <dt class="variation-FingerSize">Diamond Color:</dt>
                                                            <dd class="variation-FingerSize"><p>{{$details['customArray']['Color']}}</p></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['Clarity']) && !empty($details['customArray']['Clarity']))
                                                            <dt class="variation-FingerSize">Diamond Cut Grade:</dt>
                                                            <dd class="variation-FingerSize"><p>{{$details['customArray']['Clarity']}}</p></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['Lab']) && !empty($details['customArray']['Lab']))
                                                            <dt class="variation-FingerSize">Certificate:</dt>
                                                            <dd class="variation-FingerSize"><p>{{$details['customArray']['Lab']}}</p></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['CertificateLink']) && !empty($details['customArray']['CertificateLink']))
                                                            <dt class="variation-FingerSize">Certificate Link:</dt>
                                                            <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['CertificateLink']}}">View Certificate</a></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['ImageLink']) && !empty($details['customArray']['ImageLink']))
                                                            <dt class="variation-FingerSize">Image:</dt>
                                                            <dd class="variation-FingerSize"><a target="_blank" href="{{$details['customArray']['ImageLink']}}">View Diamond</a></dd>
                                                        @endif
                                                        @if(isset($details['customArray']['CERT_NO']) && !empty($details['customArray']['CERT_NO']))
                                                            <dt class="variation-FingerSize">Certificate:</dt>
                                                            <dd class="variation-FingerSize"><p >{{$details['customArray']['CERT_NO']}}</p></dd>
                                                        @endif
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
                        <button class="btn-bg-large">Proceed To Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
