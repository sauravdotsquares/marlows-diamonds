<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Session, Redirect, Config;
use App\Models\Settings;
use Mail;


class KlarnaController extends Controller
{
    
    private $klarnaUsername;
    private $klarnaPassword;
    private $klarnaBaseUrl;

    public function __construct()
    {
        $this->klarnaUsername = env('KLARNA_USERNAME'); // Store in .env
        $this->klarnaPassword = env('KLARNA_PASSWORD'); // Store in .env
        $this->klarnaBaseUrl = 'https://api.klarna.com/';
    }


    public function showKlarnaPage()
    {
        $payload = $this->getOrderPayload();
            $response = Http::withBasicAuth($this->klarnaUsername, $this->klarnaPassword)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->klarnaBaseUrl}/payments/v1/sessions", $payload);
            if (!$response->successful()) {
                return abort(500, 'Failed to create Klarna session');
            }
            return view('klarna', [
                'client_token' => $response->json('client_token'),
            ]);
    }


public function placeOrder(Request $request)
{
   $data = $request->all();
   $orderId = isset($data['order_Id']) ? $data['order_Id'] : null;
   $authorizationToken = $request->input('authorization_token');


   $getOrderDetails = Order::with('getOrderDetailsFunction')->where('id', $orderId)->first();
    if (!$authorizationToken) {
        return response()->json([
            'success' => false,
            'error' => 'Missing authorization token',
        ], 400);
    }

    $payload = $this->getOrderPayload($getOrderDetails);



    $response = Http::withBasicAuth($this->klarnaUsername, $this->klarnaPassword)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post("{$this->klarnaBaseUrl}/payments/v1/authorizations/{$authorizationToken}/order", $payload);

    if (!$response->successful()) {
        return response()->json([
            'success' => false,
            'error' => 'Failed to place order with Klarna',
            'klarna_response' => $response->json(),
        ], $response->status());
    }

    return response()->json([
        'success' => true,
        'order_id' => $response->json('order_id'),
        'klarna_response' => $response->json(),
    ]);
}




//checkout page
private function getOrderPayload(Order $order): array
{

    $priceInMinorUnits = intval($order->final_price * 100);

    return [
        'purchase_country' => 'GB',
        'purchase_currency' => 'GBP',
        'locale' => 'en-GB',
        'order_amount' => $priceInMinorUnits,
        'order_tax_amount' => 0,
        'order_lines' => [
            [
                'name' => 'Sample Product',
                'type' => 'physical',
                'quantity' => 1,
                'unit_price' => $priceInMinorUnits,
                'total_amount' => $priceInMinorUnits,
            ],
        ],
        'merchant_reference' => 'PK2539718',
    ];
}




public function paymentSuccess($orderId)
{
    session()->forget('cart');

             $getOrderDetails = Order::where('id',$orderId)->update(['status'=>2]);

            $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('id',$orderId)->first()->toArray();

            $admin_email = Settings::where("option_name",'admin_email')->value('option_value');
            $transaction_emails = Settings::where("option_name",'transaction_emails')->value('option_value');
            
            $data = [
                'data' => $getOrderDetailsMail
            ];
            if (env('APP_ENV') == 'production') {
                // $getOrderDetails['customer_email'] = $getOrderDetails['user_details']['email'];
                    Mail::send('email.orderstatus', array(
                    'data1' => $data,
                ), function($message) use ($getOrderDetailsMail,$admin_email, $transaction_emails ){
                    $message->from('order@marlows-diamonds.co.uk');
                    $message->to('hello@marlows-diamonds.co.uk', 'Admin')->subject('Your Marlows Diamonds order has been received!');
                    if(!empty($transaction_emails)){
                        $emails_to_cc = explode(',', $transaction_emails);
                        foreach ($emails_to_cc as $email_to_cc) {
                            $message->cc($email_to_cc, 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                        }
                    }
                    $message->cc($getOrderDetailsMail['customer_email'], 'Customer')->subject('Your Marlows Diamonds order has been received!');
                    $message->bcc('kartik.tanwar@dotsquares.com', 'Customer')->subject('Your Marlows Diamonds order has been received!');
                });
            }else if (env('APP_ENV') == 'local') {
                Mail::send('email.orderstatus', array(
                    'data1' => $data,
                ), function($message) use ($getOrderDetailsMail,$admin_email, $transaction_emails ){
                    $message->from('dssmtp@marlows-diamonds.co.uk');
                    $message->to('kartik.tanwar@dotsquares.com', 'Admin')->subject('Your Marlows Diamonds order has been received!');

                    if(!empty($transaction_emails)){
                        $emails_to_cc = explode(',', $transaction_emails);
                        foreach ($emails_to_cc as $email_to_cc) {
                            $message->cc('kartik.tanwar@dotsquares.com', 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                        }
                    }
                    $message->cc($getOrderDetailsMail['user_details']['email'], 'Customer')->subject('Your Marlows Diamonds order has been received!');
                    $message->bcc('kartik.tanwar@dotsquares.com', 'Customer')->subject('Your Marlows Diamonds order has been received!');
                });
            }
            $result = [
                'pay' => $getOrderDetailsMail,
                'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been successfully paid',
            ];
            return view('front.pages.success-page',$result);
    dd('Error occured!');
}





public function checkOrderStatus($orderId)
{
    $username = env('KLARNA_USERNAME');
    $password = env('KLARNA_PASSWORD');
    $auth = base64_encode("{$username}:{$password}");

    // Make a GET request to Klarna's Order Status endpoint
    $response = Http::withHeaders([
        'Authorization' => "Basic {$auth}",
        'Content-Type' => 'application/json',
    ])->get("$this->klarnaBaseUrl/ordermanagement/v1/orders/{$orderId}");

    return response()->json($response->json());
}
}