<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use Session, Redirect, Config;
use Mail;
use App\Models\Settings;

class PayPalPaymentController extends Controller
{
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function handlePayment($orderId)
    {
        $getOrderDetails = Order::with('getOrderDetailsFunction')->where('id',$orderId)->first();
        $maxOrderId = Order::max('custom_order_id');


        if(isset($maxOrderId) && !empty($maxOrderId)){
            $generateCustomOrderId = $maxOrderId +1;
        }else{
            $generateCustomOrderId = '31002';
        }

        $getProdustItems = [];
        foreach($getOrderDetails->getOrderDetailsFunction as $key => $orderDetails){
            // $getProdustItems[] = [
            //     'name' => isset($orderDetails->product_details->title)?$orderDetails->product_details->title:'No Name',
            //     'price' => isset($orderDetails->product_price)?$orderDetails->product_price:'1.00',
            //     'desc'  => isset($orderDetails->product_details->tags)?$orderDetails->product_details->tags:'No Desc',
            //     'qty' => isset($orderDetails->quantity)?$orderDetails->quantity:1,
            // ];
            $item = new Item();
            $item->setName(isset($orderDetails->product_details->title)?$orderDetails->product_details->title:'No Name') /** item name **/
                        ->setCurrency(Config::get('paypal.currency','GBP'))
                        ->setQuantity(isset($orderDetails->quantity)?$orderDetails->quantity:1)
                        ->setPrice(isset($orderDetails->product_price)?$orderDetails->product_price:'1.00'); /** unit price **/
            $getProdustItems[] = $item;
        }


        // $product = [];
        // $product['items'] = $getProdustItems;

        // $product['invoice_id'] = $orderId;
        // $product['invoice_description'] = "Order #{$product['invoice_id']} Bill";
        // $product['return_url'] = route('success.payment');
        // $product['cancel_url'] = route('cancel.payment');
        // $product['total'] = $getOrderDetails->final_price;


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_list = new ItemList();
        $item_list->setItems($getProdustItems);

        $amount = new Amount();
        $amount->setCurrency(Config::get('paypal.currency','GBP'))
            ->setTotal($getOrderDetails->final_price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('success.payment')) /** Specify return URL **/
            ->setCancelUrl(route('cancel.payment'));


        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
            \Session::put('error', 'Connection timeout');
                            return Redirect::route('paywithpaypal');
            } else {
            \Session::put('error', 'Some error occur, sorry for inconvenient');
                            return Redirect::route('paywithpaypal');
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
            $redirect_url = $link->getHref();
                            break;
            }
        }

        if (isset($redirect_url)) {
            $getOrderDetails = Order::where('id',$orderId)->update(['token'=>$payment->getToken(),'custom_order_id'=>$generateCustomOrderId,'pay_timestamp'=>date('Y-m-d h:i:s', strtotime($payment->getCreateTime())),'acknowledge'=>$payment->getState(),'status'=>1]);
            return Redirect::away($redirect_url);
        }

        $getOrderDetails = Order::where('id',$orderId)->update(['token'=>$payment->getToken(),'custom_order_id'=>$generateCustomOrderId,'pay_timestamp'=>date('Y-m-d h:i:s', strtotime($payment->getCreateTime())),'acknowledge'=>$payment->getState(),'status'=>0]);

        return redirect()->back()->with('error','Payment gateway initiliazation failed.');
    }

    public function paymentCancel(Request $request)
    {
        session()->forget('cart');

        $getOrderDetails = Order::where('token',$request->token)->update(['status'=>3]);

        $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('token',$request->token)->first()->toArray();

        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');

        $data = [
            'data' => $getOrderDetailsMail
        ];

        $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
            Mail::send('email.orderstatus', array(
            'data1' => $data,
        ), function($message) use ($request,$admin_email ){
            $message->from('hello@marlows-diamonds.co.uk');
            $message->to($admin_email, 'Admin')->subject('Order Received');
            $message->cc($request['customer_email'], 'Customer')->subject('Order Received');
        });

        $result = [
            'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been cancelled',
            // 'getOrderDetails' => (isset($getOrderDetails)?$getOrderDetails:[]),
        ];

        return view('front.pages.cancel-page',$result);
        // dd('Your payment has been decliend. The payment cancelation page goes here!');
    }

    public function paymentSuccess(Request $request)
    {
        session()->forget('cart');
        $requestData = $request->all();
        if(isset($request->paymentId) && isset($request->PayerID) && isset($request->token)){
            $payment = Payment::get($requestData['paymentId'], $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($requestData['PayerID']);
            $result = $payment->execute($execution, $this->_api_context);

            if ($result->getState() == 'approved') {
                $getOrderDetails = Order::where('token',$request->token)->update(['status'=>2]);

                $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('token',$request->token)->first()->toArray();

                $admin_email = Settings::where("option_name",'admin_email')->value('option_value');

                $data = [
                    'data' => $getOrderDetailsMail
                ];

                $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
                    Mail::send('email.orderstatus', array(
                    'data1' => $data,
                ), function($message) use ($request,$admin_email ){
                    $message->from('hello@marlows-diamonds.co.uk');
                    $message->to($admin_email, 'Admin')->subject(env('APP_NAME').'  ('.$getOrderDetailsMail['custom_order_id'].') -Order Received');
                    $message->cc($request['customer_email'], 'Customer')->subject(env('APP_NAME').'  ('.$getOrderDetailsMail['custom_order_id'].') -Order Received');
                });
                
                $result = [
                    'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been successfully paid',
                ];
                return view('front.pages.success-page',$result);
            }
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
