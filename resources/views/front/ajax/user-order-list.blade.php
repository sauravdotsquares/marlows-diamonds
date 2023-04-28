@foreach($getOrderDetails as $key => $order)
    <tr>
        <td class="orderid-accoount"><a href="#">#{{isset($order->custom_order_id)?$order->custom_order_id:''}}</a></td>
        <td><span>{{$order->created_at->format('M d, Y')}}</span></td>
        <td>{{isset($order->status_details)?$order->status_details:''}}</td>
        <td><span>{{MY_CURRENCY_SYMBOL}}{{number_format(isset($order->total_price)?$order->total_price:$order->final_price,2)}}</span> for {{isset($order->total_quantity)?$order->total_quantity:''}} item</td>
        <td><span>{{MY_CURRENCY_SYMBOL}}{{number_format(isset($order->deposited_price)?$order->deposited_price:$order->total_price,2)}}</span> for {{isset($order->total_quantity)?$order->total_quantity:''}} item</td>
        <td><a class="btn-bg-small" href="javascript:void(0);" id="viewOrderDetails{{$key}}" data-token="{{$order->token}}">View</a></td>
    </tr>
@endforeach
