<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Settings;
use Stripe;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StripeController extends Controller
{
    public function stripe($id)
    {
        return view('front.pages.stripeform');
    }

    public function stripePost(Request $request)
    {
        $getOrderDetails = Order::where('id',base64_decode($request->tokenOrdId))->first();
        $maxOrderId = Order::max('custom_order_id');

        if (isset($maxOrderId) && !empty($maxOrderId)) {
            $generateCustomOrderId = '31002' . '' . $getOrderDetails->user_id . '' . $getOrderDetails->id;
        } else {
            $generateCustomOrderId = '31002';
        }

        $getOrderDetails->token = $request->stripeToken;
        $getOrderDetails->custom_order_id = $generateCustomOrderId;
        $getOrderDetails->save();
       

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // $session = \Stripe\Checkout\Session::create([
        //     'payment_method_types' => ['card'],
        //     'line_items' => [[
        //       'price' => 'price_1HKiSf2eZvKYlo2CxjF9qwbr',
        //       'quantity' => 1,
        //       ]],
        //     'mode' => 'subscription',
        //     'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
        //     'cancel_url' => 'https://example.com/cancel',
        //   ]);
        // die("Done");
        try {
            $getStripeData = Stripe\Charge::create ([
                "amount" => $getOrderDetails->deposited_price*100,
                "currency" => "GBP",
                "source" => $request->stripeToken,
                "description" => "This payment is testing purpose of techsolutionstuff",
            ]);
        } catch (\Exception $e) {
            // return view('layouts.errors.404');
            // Session::flash ('fail-message', "Error! Please Try again.");
            // return Redirect::back();
            Session::flash ('fail-message', $e->getMessage());
            return Redirect::back();
        }
     
        session()->forget('cart');
        $getOrderDetails = Order::where('token',$request->stripeToken)->update([
            'paymentccdetails' => $getStripeData->balance_transaction,
            'currency_symbol' => $getStripeData->currency,
            'status'=> 2,
            'seller_message'=> $getStripeData->outcome->seller_message,
            'payment_method'=> $getStripeData->payment_method,
            
        ]);

        $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('token', $request->stripeToken)->first()->toArray();
        
        if (isset($getOrderDetailsMail['email_status']) && $getOrderDetailsMail['email_status'] == 2) {
            return Redirect::route('home');
        }

        $admin_email = Settings::where("option_name", 'admin_email')->value('option_value');
        $transaction_emails = Settings::where("option_name", 'transaction_emails')->value('option_value');

        $data = [
            'data' => $getOrderDetailsMail
        ];

        $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];

        if (env('APP_ENV') == 'production') {
            Mail::send('email.orderstatus', array(
                'data1' => $data,
            ), function ($message) use ($request, $admin_email, $transaction_emails) {
                $message->from('hello@marlows-diamonds.co.uk');
                $message->to($admin_email, 'Admin')->subject('Your Marlows Diamonds order has been received!');

                if (!empty($transaction_emails)) {
                    $emails_to_cc = explode(',', $transaction_emails);
                    foreach ($emails_to_cc as $email_to_cc) {
                        $message->cc($emails_to_cc, 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');
                    }
                }

                $message->cc($request['customer_email'], 'Customer')->subject('Your Marlows Diamonds order has been received!');
            });
        } else if (env('APP_ENV') == 'local') {
            Mail::send('email.orderstatus', array(
                'data1' => $data,
            ), function ($message) use ($request, $admin_email, $transaction_emails) {
                $message->from("sharma.gajendra@dotsquares.com");
                $message->to("sharma.gajendra@dotsquares.com", 'Admin')->subject('Your Marlows Diamonds order has been received!');
                if (!empty($transaction_emails)) {
                    $emails_to_cc = explode(',', $transaction_emails);
                    foreach ($emails_to_cc as $email_to_cc) {
                        $message->cc("sharma.gajendra@dotsquares.com", 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');
                    }
                }
                $message->cc("sharma.gajendra@dotsquares.com", 'Customer')->subject('Your Marlows Diamonds order has been received!');
            });
        }
        Order::where('token',$request->token)->update(['email_status'=>2]);

        $result = [
            'pay' => $getOrderDetailsMail,
            'response' => 'Your Order number(' . $getOrderDetailsMail['custom_order_id'] . ') has been successfully paid',
        ];
        return view('front.pages.success-page', $result);

        // Session::flash('success', 'Payment Successfull!');
           
        // return back();
    }
}
