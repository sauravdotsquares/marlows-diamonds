

<div class="vieworderd-list ">
    <p> Order <strong>#{{$getOrderDetails->custom_order_id}}</strong> was placed on <strong>{{$getOrderDetails->created_at->format('M d, Y')}}</strong> and is currently
        <strong>{{$getOrderDetails->status_details}}.</strong></p>
    <div class="view-order-details">
        <h4>Order details</h4>
        <div class="vieworderd-table">
            <table border-collapse="collapse">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Total</th>
                        <th>Deposited</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getOrderDetails->getOrderDetailsFunction as $key => $value)
                        <?php
                            $detailsDecode = (array)json_decode($value->order_product_details);
                            // $new_value = $getDataProduct['title'];
                            // unset($getDataProduct['title']);
                            // array_unshift($getDataProduct, $new_value);
                        ?>
                        <tr>
                            <td>
                                @if(isset($value->product_details) && !empty($value->product_details))
                                    <a class="order-pr-name" href="{{asset('product/')}}/{{isset($value->product_details)?$value->product_details->slug:''}}">
                                        <strong class="product-quantity">{{isset($value->product_details->title)?$value->product_details->title:'Custom Diamond'}}×{{$value->quantity}}</strong>
                                    </a>
                                @elseif(isset($getDataProduct['0']) && $getDataProduct['0'] == 'Custom Diamond')
                                    <a class="order-pr-name" href="javascript:void(0);">
                                        <strong class="product-quantity">{{isset($getDataProduct['0'])?$getDataProduct['0']:'Custom Diamond'}}×{{$value->quantity}}</strong>
                                    </a>
                                @endif
                                <ul class="wc-item-meta">
                                    @if(isset($detailsDecode['choose_diamond']) && !empty($detailsDecode['choose_diamond']))
                                        <li><strong class="wc-item-meta-label">Choose Your Diamond :</strong>
                                            <p> {{ ($detailsDecode['choose_diamond'] == 'lab_grown')?'Lab Grown':'Mined'}}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['metal_type']) && !empty($detailsDecode['metal_type']))
                                        <li><strong class="wc-item-meta-label">Metal:</strong>
                                            <p> {{ $detailsDecode['metal_type'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['fingersize']) && !empty($detailsDecode['fingersize']))
                                        <li><strong class="wc-item-meta-label">Finger Size:</strong>
                                            <p> {{ $detailsDecode['fingersize'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['width-mm']) && !empty($detailsDecode['width-mm']))
                                        <li><strong class="wc-item-meta-label">Width MM:</strong>
                                            <p> {{ $detailsDecode['width-mm'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['total-diamond-weight']) && !empty($detailsDecode['total-diamond-weight']))
                                        <li><strong class="wc-item-meta-label">Diamond Weight:</strong>
                                            <p> {{ $detailsDecode['total-diamond-weight'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['Carat']) && !empty($detailsDecode['Carat']))
                                        <li><strong class="wc-item-meta-label">Diamond Carat:</strong>
                                            <p> {{ $detailsDecode['Carat'] }}</p>
                                        </li>
                                    @elseif(isset($detailsDecode['carat']) && !empty($detailsDecode['carat']))
                                        <li><strong class="wc-item-meta-label">Diamond Carat:</strong>
                                            <p> {{ $detailsDecode['carat'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['Color']) && !empty($detailsDecode['Color']))
                                        <li><strong class="wc-item-meta-label">Diamond Color:</strong>
                                            <p> {{ $detailsDecode['Color'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['Clarity']) && !empty($detailsDecode['Clarity']))
                                        <li><strong class="wc-item-meta-label">Diamond Clarity:</strong>
                                            <p> {{ $detailsDecode['Clarity'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['Lab']) && !empty($detailsDecode['Lab']))
                                        <li><strong class="wc-item-meta-label">Diamond Certificate:</strong>
                                            <p> {{ $detailsDecode['Lab'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['shape']) && !empty($detailsDecode['shape']))
                                        <li><strong class="wc-item-meta-label">Diamond Shape:</strong>
                                            <p> {{ $detailsDecode['shape'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['Stock_NO']) && !empty($detailsDecode['Stock_NO']))
                                        <li><strong class="wc-item-meta-label"> Diamond StockNo:</strong>
                                            <p> {{ $detailsDecode['Stock_NO'] }}</p>
                                        </li>
                                    @endif
                                    @if(isset($detailsDecode['CERT_NO']) && !empty($detailsDecode['CERT_NO']))
                                        <li><strong class="wc-item-meta-label">Diamond CertificateNo:</strong>
                                            <p> {{ $detailsDecode['CERT_NO'] }}</p>
                                        </li>
                                    @endif

                                    {{-- @foreach($getDataProduct as $keyR => $valnew)

                                        @if($keyR != 0)
                                            @if($keyR == "certificatelink")
                                                <li><strong class="wc-item-meta-label">{{ucfirst($keyR)}}:</strong><a href="{{$valnew}}" target="_blank">View</a>
                                                </li>
                                            @elseif($keyR == "imagelink")
                                                <li><strong class="wc-item-meta-label">{{ucfirst($keyR)}}:</strong><a href="{{$valnew}}" target="_blank">View</a>
                                                </li>
                                            @else
                                                <li><strong class="wc-item-meta-label">{{ucfirst($keyR)}}:</strong>
                                                    <p>{{ucfirst($valnew)}}</p>
                                                </li>
                                            @endif
                                        @endif
                                    @endforeach --}}
                                </ul>
                            </td>
                            <td> {{MY_CURRENCY_SYMBOL}} {{ $value->product_price * $value->quantity}}</td>
                            <td> {{MY_CURRENCY_SYMBOL}} {{ isset($value->deposited_product_price)?$value->deposited_product_price:$value->total_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="row">Subtotal:</th>
                        <td><span class="woocommerce-Price-amount amount"><span
                                    class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{isset($getOrderDetails->total_price)?$getOrderDetails->total_price:$getOrderDetails->final_price}}</span></td>
                    </tr>
                    <tr>
                        <th scope="row">Payment method:</th>
                        <td>{{$getOrderDetails->payment_type}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Deposited Total:</th>
                        <td><span class="woocommerce-Price-amount amount"><span
                                    class="woocommerce-Price-currencySymbol">{{MY_CURRENCY_SYMBOL}}</span>{{isset($getOrderDetails->deposited_price)?$getOrderDetails->deposited_price:$getOrderDetails->final_price}}</span> <small
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
                {!!isset($getOrderDetails->order_address->first_name)?$getOrderDetails->order_address->first_name."<br>":''!!}
                {!!isset($getOrderDetails->order_address->company_name)?$getOrderDetails->order_address->company_name.'<br>':'' !!}  
                {!!isset($getOrderDetails->order_address->street_address_l1)?$getOrderDetails->order_address->street_address_l1.'<br>':''!!}{!!isset($getOrderDetails->order_address->street_address_l2)?$getOrderDetails->order_address->street_address_l2.'<br>':''!!}{!!isset($getOrderDetails->order_address->town_city)?$getOrderDetails->order_address->town_city:''!!} {!!isset($getOrderDetails->order_address->state)?$getOrderDetails->order_address->state.'<br>':''!!}{!!isset($getOrderDetails->order_address->pin_code)?$getOrderDetails->order_address->pin_code:''!!}
                <p class="woocommerce-customer-details--phone"> {{isset($getOrderDetails->order_address->mobile)?$getOrderDetails->order_address->mobile:''}} </p>

                <p class="woocommerce-customer-details--email">{{isset($getOrderDetails->order_address->email)?$getOrderDetails->order_address->email:''}}</p>
            </address>
        </div>
    </div>
</div>
