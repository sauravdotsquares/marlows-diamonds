@foreach($getOrderDetails as $key => $order)
    <tr>
        <td class="orderid-accoount"><a href="#">#{{isset($order->token)?$order->token:''}}</a></td>
        <td><span>{{$order->created_at->format('M d, Y')}}</span></td>
        <td>{{isset($order->status_details)?$order->status_details:''}}</td>
        <td><span>{{MY_CURRENCY_SYMBOL}}{{number_format(isset($order->final_price)?$order->final_price:'',2)}}</span> for {{isset($order->total_quantity)?$order->total_quantity:''}} item</td>
        <td><a class="btn-bg-small" href="#">View</a></td>
    </tr>
@endforeach