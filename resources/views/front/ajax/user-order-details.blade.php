

<div class="vieworderd-list ">
    <p> Order <strong>#{{$getOrderDetails->token}}</strong> was placed on <strong>{{$getOrderDetails->created_at->format('M d, Y')}}</strong> and is currently
        <strong>{{$getOrderDetails->status_details}}.</strong></p>
    <div class="view-order-details">
        <h4>Order details</h4>
        <div class="vieworderd-table">
            <table border-collapse="collapse">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getOrderDetails->getOrderDetailsFunction as $key => $value)
                        <?php
                            $getDataProduct = (array)json_decode($value->order_product_details);
                            $new_value = $getDataProduct['title'];
                            unset($getDataProduct['title']);
                            array_unshift($getDataProduct, $new_value);
                        ?>
                        <tr>
                            <td>
                                @if(isset($value->product_details) && !empty($value->product_details))
                                    <a class="order-pr-name" href="{{asset('product/')}}/{{isset($value->product_details)?$value->product_details->slug:''}}">
                                        <strong class="product-quantity">{{isset($getDataProduct['0'])?$getDataProduct['0']:''}}×{{$value->quantity}}</strong>
                                    </a>
                                @elseif(isset($getDataProduct['0']) && $getDataProduct['0'] == 'Custom Diamond')
                                    <a class="order-pr-name" href="javascript:void(0);">
                                        <strong class="product-quantity">{{isset($getDataProduct['0'])?$getDataProduct['0']:''}}×{{$value->quantity}}</strong>
                                    </a>
                                @endif
                                <ul class="wc-item-meta">
                                    @foreach($getDataProduct as $keyR => $valnew)
                                        @if($keyR != 0)
                                            @if($keyR == "certificatelink")
                                                <li><strong class="wc-item-meta-label">{{ucfirst($keyR)}}:</strong><a href="{{$valnew}}" target="_blank">View</a>
                                                    {{-- <p>{{ucfirst($valnew)}}</p> --}}
                                                </li>
                                            @elseif($keyR == "imagelink")
                                                <li><strong class="wc-item-meta-label">{{ucfirst($keyR)}}:</strong><a href="{{$valnew}}" target="_blank">View</a>
                                                    {{-- <p>{{ucfirst($valnew)}}</p> --}}
                                                </li>
                                            @else
                                                <li><strong class="wc-item-meta-label">{{ucfirst($keyR)}}:</strong>
                                                    <p>{{ucfirst($valnew)}}</p>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </td>
                            <td> {{MY_CURRENCY_SYMBOL}} {{ $value->product_price * $value->quantity}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="row">Subtotal:</th>
                        <td><span class="woocommerce-Price-amount amount"><span
                                    class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{$getOrderDetails->final_price}}</span></td>
                    </tr>
                    <tr>
                        <th scope="row">Payment method:</th>
                        <td>{{$getOrderDetails->payment_type}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Total:</th>
                        <td><span class="woocommerce-Price-amount amount"><span
                                    class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{$getOrderDetails->final_price}}</span> <small
                                class="includes_tax">(includes <span class="woocommerce-Price-amount amount"><span
                                        class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>64.80</span> VAT)</small></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="view-order-billing-details">
        <h4>Billing address</h4>
        <div class="woocommerce-customer-details">
            <address>
                {{isset($getOrderDetails->order_address->first_name)?$getOrderDetails->order_address->first_name." ":''}}{{isset($getOrderDetails->order_address->last_name)?$getOrderDetails->order_address->last_name:''}} <br> {{isset($getOrderDetails->order_address->company_name)?$getOrderDetails->order_address->company_name:''}}  <br>
                {{isset($getOrderDetails->order_address->street_address_l1)?$getOrderDetails->order_address->street_address_l1:''}}<br>{{isset($getOrderDetails->order_address->street_address_l2)?$getOrderDetails->order_address->street_address_l2:''}}<br>{{isset($getOrderDetails->order_address->town_city)?$getOrderDetails->order_address->town_city:''}} {{isset($getOrderDetails->order_address->state)?$getOrderDetails->order_address->state:''}}<br><br>{{isset($getOrderDetails->order_address->pin_code)?$getOrderDetails->order_address->pin_code:''}}
                <p class="woocommerce-customer-details--phone"> {{isset($getOrderDetails->order_address->mobile)?$getOrderDetails->order_address->mobile:''}} </p>

                <p class="woocommerce-customer-details--email">{{isset($getOrderDetails->order_address->email)?$getOrderDetails->order_address->email:''}}</p>
            </address>
        </div>
    </div>
</div>
