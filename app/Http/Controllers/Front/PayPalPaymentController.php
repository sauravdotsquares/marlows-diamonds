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
            $generateCustomOrderId = '31002'.''.$getOrderDetails->user_id.''.$getOrderDetails->id;
        }else{
            $generateCustomOrderId = '31002';
        }

        $getProdustItems = [];
        foreach($getOrderDetails->getOrderDetailsFunction as $key => $orderDetails){
            $item = new Item();
            $item->setName(isset($orderDetails->product_details->title)?$orderDetails->product_details->title:'No Name') /** item name **/
                        ->setCurrency(Config::get('paypal.currency','GBP'))
                        ->setQuantity(isset($orderDetails->quantity)?$orderDetails->quantity:1)
                        ->setPrice(isset($orderDetails->deposited_product_price)?$orderDetails->deposited_product_price:'1.00'); /** unit price **/
            $getProdustItems[] = $item;
        }

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_list = new ItemList();
        $item_list->setItems($getProdustItems);

        $amount = new Amount();
        $amount->setCurrency(Config::get('paypal.currency','GBP'))
            ->setTotal($getOrderDetails->deposited_price);

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

        if (isset($getOrderDetailsMail['email_status']) && $getOrderDetailsMail['email_status'] == 2) {
            return Redirect::route('home');
        }

        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');
        $transaction_emails = Settings::where("option_name",'transaction_emails')->value('option_value');

        $data = [
            'data' => $getOrderDetailsMail
        ];
        if (env('APP_ENV') == 'production') {
            $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
                Mail::send('email.orderstatus-cancel', array('data1' => $data,), function($message) use ($request,$admin_email, $transaction_emails ){
                $message->from('hello@marlows-diamonds.co.uk');

                $admin_email_london = "london@marlows-diamonds.co.uk";
                $message->to($admin_email_london, 'Admin')->subject('Marlows Diamonds: Your transaction not completed.');
                
                /** add cc for more users */
                if(!empty($transaction_emails)){
                    $emails_to_cc = explode(',', $transaction_emails);
                    foreach ($emails_to_cc as $email_to_cc) {
                        $message->cc($emails_to_cc, 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                    }
                }
                
                $message->cc($request['customer_email'], 'Customer')->subject('Marlows Diamonds: Your transaction not completed.');
            });
        } else if (env('APP_ENV') == 'local') {
            $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
            Mail::send('email.orderstatus-cancel', array('data1' => $data,), function($message) use ($request, $transaction_emails ){
                $message->from('hello@marlows-diamonds.co.uk');

                $admin_email_london = 'sharma.gajendra@dotsquares.com';
                $message->to($admin_email_london, 'Admin')->subject('Marlows Diamonds: Your transaction not completed.');
                
                /** add cc for more users */
                if(!empty($transaction_emails)){
                    $emails_to_cc = explode(',', $transaction_emails);
                    foreach ($emails_to_cc as $email_to_cc) {
                        $message->cc('raubi.gaur@dotsquares.com', 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                    }
                }
                
                $message->cc('sanyukta.chauhan@dotsquares.com', 'Customer')->subject('Marlows Diamonds: Your transaction not completed.');
            });
        }
        Order::where('token',$request->token)->update(['email_status'=>2]);

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
        if(isset($requestData['paymentid']) && isset($requestData['payerid']) && isset($requestData['token'])){
            $payment = Payment::get($requestData['paymentid'], $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId($requestData['payerid']);
            $result = $payment->execute($execution, $this->_api_context);

            if ($result->getState() == 'approved') {
                $getOrderDetails = Order::where('token',$requestData['token'])->update(['status'=>2]);

                $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('token',$requestData['token'])->first()->toArray();

                if (isset($getOrderDetailsMail['email_status']) && $getOrderDetailsMail['email_status'] == 2) {
                    return Redirect::route('home');
                }

                $admin_email = Settings::where("option_name",'admin_email')->value('option_value');
                $transaction_emails = Settings::where("option_name",'transaction_emails')->value('option_value');

                $data = [
                    'data' => $getOrderDetailsMail
                ];
                if (env('APP_ENV') == 'production') {
                    $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
                        Mail::send('email.orderstatus', array(
                        'data1' => $data,
                    ), function($message) use ($request,$admin_email, $transaction_emails ){
                        $message->from('hello@marlows-diamonds.co.uk');
                        $message->to($admin_email, 'Admin')->subject('Your Marlows Diamonds order has been received!');

                        if(!empty($transaction_emails)){
                            $emails_to_cc = explode(',', $transaction_emails);
                            foreach ($emails_to_cc as $email_to_cc) {
                                $message->cc($email_to_cc, 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');
                            }
                        }

                        $message->cc($request['customer_email'], 'Customer')->subject('Your Marlows Diamonds order has been received!');
                        $message->bcc('sharma.gajendra@dotsquares.com', 'Customer')->subject('Your Marlows Diamonds order has been received pro!');
                    });
                } else if (env('APP_ENV') == 'local') {
                    $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];

                    // $adminEmail = 'sharma.gajendra@dotsquares.com';

                    // $when = now()->addMinutes(1);

                    // Mail::to($adminEmail)->cc('jhandu.saini@dotsquares.com')->bcc('sanyukta.chauhan@dotsquares.com')->later($when, new OrderMailProcess($data));

                    // Mail::to($adminEmail)->cc('jhandu.saini@dotsquares.com')->queue(new OrderMailProcess($data));

                    // echo "adfadfsdfsdfdsffdfdsf checking again<pre>";
                    // print_r($getOrderDetailsMail['user_details']['email']);
                    // echo "<br>";
                    // print_r($data);
                    // die;

                   
                    
                    Mail::send('email.orderstatus', array(
                        'data1' => $data,
                    ), function($message) use ($request,$admin_email, $transaction_emails ){
                        $message->from('hello@marlows-diamonds.co.uk');
                        $message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('Your Marlows Diamonds order has been received!');

                        if(!empty($transaction_emails)){
                            $emails_to_cc = explode(',', $transaction_emails);
                            foreach ($emails_to_cc as $email_to_cc) {
                                $message->cc('anamika.verma@dotssquares.com', 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                            }
                        }
                        $message->cc($request['customer_email'], 'Customer')->subject('Your Marlows Diamonds order has been received!');
                        $message->bcc('sharma.gajendra@dotsquares.com', 'Customer')->subject('Your staging Marlows Diamonds order has been received!');
                    });
                }

                Order::where('token',$requestData['token'])->update(['email_status'=>2]);
                
                $result = [
                    'pay' => $getOrderDetailsMail,
                    'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been successfully paid',
                ];
                return view('front.pages.success-page',$result);
            }
        }else{
            return view('front.pages.cancel-page',[]);
        }

        // $getOrderDetails = Order::where('token',$request->token)->update(['status'=>3]);
        // // prd($getOrderDetails);
        // if(!empty($getOrderDetails)){
        //     $result = [
        //         'response' => 'Your Order number('.$getOrderDetails->id.') has been cancelled',
        //         'getOrderDetails' => $getOrderDetails
        //     ];
    
        //     return view('front.pages.cancel-page',$result);
        // }else{
        //     return view('front.pages.cancel-page',[]);
        // }

        

        dd('Error occured!');
    }
}
