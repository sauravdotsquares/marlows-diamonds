<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;

class PayPalPaymentController extends Controller
{
    public function handlePayment($orderId)
    {
        $getOrderDetails = Order::with('getOrderDetailsFunction')->where('id',$orderId)->first();

        $getProdustItems = [];
        foreach($getOrderDetails->getOrderDetailsFunction as $key => $orderDetails){
            $getProdustItems[] = [
                'name' => isset($orderDetails->product_details->title)?$orderDetails->product_details->title:'No Name',
                'price' => isset($orderDetails->product_price)?$orderDetails->product_price:'1.00',
                'desc'  => isset($orderDetails->product_details->tags)?$orderDetails->product_details->tags:'No Desc',
                'qty' => isset($orderDetails->quantity)?$orderDetails->quantity:1,
            ];
        }


        $product = [];
        $product['items'] = $getProdustItems;

        $product['invoice_id'] = $orderId;
        $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
        $product['return_url'] = route('success.payment');
        $product['cancel_url'] = route('cancel.payment');
        $product['total'] = $getOrderDetails->final_price;


        $paypalModule = new ExpressCheckout;

        // $res = $paypalModule->setExpressCheckout($product);
        $res = $paypalModule->setExpressCheckout($product, true);

        $getOrderDetails = Order::where('id',$orderId)->update(['token'=>$res['TOKEN'],'pay_timestamp'=>date('Y-m-d h:i:s', strtotime($res['TIMESTAMP'])),'correlationid'=>$res['CORRELATIONID'],'acknowledge'=>$res['ACK'],'build'=>$res['BUILD'],'status'=>1]);
        // echo "<pre>";
        // print_r($res);
        // die;

        return redirect($res['paypal_link']);
    }

    public function paymentCancel(Request $request)
    {
        // echo "<pre>";
        // print_r($request->token);
        // die;
        session()->forget('cart');

        $getOrderDetails = Order::where('token',$request->token)->update(['status'=>3]);
        $result = [
            'response' => 'Your Order number('.$request->token.') has been cancelled',
            // 'getOrderDetails' => (isset($getOrderDetails)?$getOrderDetails:[]),
        ];

        return view('front.pages.cancel-page',$result);
        // dd('Your payment has been decliend. The payment cancelation page goes here!');
    }

    public function paymentSuccess(Request $request)
    {
        session()->forget('cart');
        // echo "<pre>";
        // print_r($request->all(''));
        // die;
        $paypalModule = new ExpressCheckout;
        $response = $paypalModule->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $getOrderDetails = Order::where('token',$request->token)->update(['status'=>2]);
            // echo "<pre>";
            // print_r($getOrderDetails);
            // die;
            $result = [
                'response' => 'Your Order number('.$request->token.') has been successfully paid',
                // 'getOrderDetails' => $getOrderDetails
            ];
            return view('front.pages.success-page',$result);

            // dd('Payment was successfull. The payment success page goes here!');
        }

        $getOrderDetails = Order::where('token',$request->token)->update(['status'=>3]);

        $result = [
            'response' => 'Your Order number('.$getOrderDetails->id.') has been cancelled',
            'getOrderDetails' => $getOrderDetails
        ];

        return view('front.pages.cancel-page',$result);

        dd('Error occured!');
    }
}
