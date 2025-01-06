<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Settings;
use Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApplePayController extends Controller
{
    public function validateApplePay(Request $request)
    {
        $validationURL = $request->input('validationURL');

        // Use Stripe or custom logic to get the merchant session
        $merchantSession = []; // Example response

        return response()->json($merchantSession);
    }

    public function processApplePay(Request $request)
    {

        $paymentData = $request->input('payment');

        // Use Stripe or custom logic to process the payment
        $result = true; // Example response

        return response()->json(['success' => $result,'data' => $paymentData]);
    }

    public function updateGoogleStatus(Request $request)
    {
       

        // Get the raw content from the request body
        $rawData = $request->getContent();
        // Decode the JSON string into an array

        $getData = json_decode($rawData, true); // The second parameter 'true' converts it to an array

        $tokenOrdIdUp = $getData['tokenOrdIdUp'];
        $getDataToken = $getData['token']; // The second parameter 'true' converts it to an array
        
        

        // return response()->json(['success' => false, 'message' => $getData], 200);
        // return response()->json(['success' => false, 'message' =>  $request->input('billingAddress')], 200);

        // $getData = json_decode($request->all());
        // return response()->json(['success' => false, 'messageasdfaf' => $getData], 200);
        // Validate incoming data


        $request->validate([
            'paymentMethod' => 'required|string',
            'token' => 'required|string',
            'billingAddress' => 'required|array',
            'countryCode' => 'required|string',
        ]);

        // Example of finding the order by a specific order identifier (you can adjust this as needed)
        $order = Order::find($tokenOrdIdUp);
        
        //return response()->json(['success' => false, 'message' => $order], 200);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // Update the order status, payment method, etc.
        $order->status = 2; // You can set the status to "paid" or another value based on your logic
        $order->payment_method = $getData['paymentMethod'];
        $order->token = $getDataToken;
        $order->billingAddress = json_encode($request->input('billingAddress')); // You can save the address as a JSON string or map it to specific fields.
        
        // Save the updated order
        $order->save();

        $getResponses = $this->email_order_custom($tokenOrdIdUp);
        session()->forget('cart');
        // Return JSON response with redirect URL
        // Construct the URL directly instead of using route()
                $redirectUrl = url("/success-page/{$tokenOrdIdUp}");

                // Return JSON with the URL to redirect to
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl
                ]);
    }
    
     public function updateStatus(Request $request)
    {
       

        // Get the raw content from the request body
        $rawData = $request->getContent();
        // Decode the JSON string into an array

        $getData = json_decode($rawData, true); // The second parameter 'true' converts it to an array

        $tokenOrdIdUp = $getData['tokenOrdIdUp'];
        $getDataToken = $getData['token']; // The second parameter 'true' converts it to an array
        
        

        // return response()->json(['success' => false, 'message' => $getData], 200);
        // return response()->json(['success' => false, 'message' =>  $request->input('billingAddress')], 200);

        // $getData = json_decode($request->all());
        // return response()->json(['success' => false, 'messageasdfaf' => $getData], 200);
        // Validate incoming data


        $request->validate([
            'paymentMethod' => 'required|string',
            'token' => 'required|string',
            'billingAddress' => 'required|array',
            'countryCode' => 'required|string',
        ]);

        // Example of finding the order by a specific order identifier (you can adjust this as needed)
        $order = Order::find($tokenOrdIdUp);
        
        //return response()->json(['success' => false, 'message' => $order], 200);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // Update the order status, payment method, etc.
        $order->status = 2; // You can set the status to "paid" or another value based on your logic
        $order->payment_method = $getData['paymentMethod'];
        $order->token = $getDataToken;
        $order->billingAddress = json_encode($request->input('billingAddress')); // You can save the address as a JSON string or map it to specific fields.
        
        // Save the updated order
        $order->save();

        $getResponses = $this->email_order_custom($tokenOrdIdUp);
        session()->forget('cart');
        // Return JSON response with redirect URL
        // Construct the URL directly instead of using route()
                $redirectUrl = url("/success-page/{$tokenOrdIdUp}");

                // Return JSON with the URL to redirect to
                return response()->json([
                    'success' => true,
                    'redirect' => $redirectUrl
                ]);
    }


 // Function to show success page
    public function showSuccessPage(Request $request)
    {
       $order = Order::where('id', $request->id)->first();

        if (!$order->custom_order_id) {
            // Generate and update the custom_order_id only if it does not already exist
            $order->custom_order_id = rand(1000, 1000000) . '-' . $request->id;
            $order->save();  // Save the updated record
        }

        // Fetch the updated order details
        $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('id', $request->id)->first()->toArray();

        $result = [
            'pay' => $getOrderDetailsMail,
            'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been successfully paid',
        ];
        return view('front.pages.success-page',$result);
        // Retrieve the passed data from the query string (URL)
        $getResponses = $request->query('data');

        // Pass the data to the success page view
        return view('front.pages.success-page', compact('getResponses'));
    }




    public function email_order_custom($orderId){

       
        
        $getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('id',$orderId)->first()->toArray();
        
        if (isset($getOrderDetailsMail['email_status']) && $getOrderDetailsMail['email_status'] == 2) {
            return Redirect::route('home');
        }
        
        
        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');
        $transaction_emails = Settings::where("option_name",'transaction_emails')->value('option_value');
        
        $data = [
            'data' => $getOrderDetailsMail
        ];
        if (env('APP_ENV') == 'production') {
            $requestCustomerEmail = $getOrderDetailsMail['user_details']['email'];
                Mail::send('email.orderstatus', array(
                'data1' => $data,
            ), function($message) use ($requestCustomerEmail,$admin_email, $transaction_emails ){
                $message->from('dssmtp@marlows-diamonds.co.uk');
                $message->to($admin_email, 'Admin')->subject('Your Marlows Diamonds order has been received!');
        
                if(!empty($transaction_emails)){
                    $emails_to_cc = explode(',', $transaction_emails);
                    foreach ($emails_to_cc as $email_to_cc) {
                        $message->cc($emails_to_cc, 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                    }
                }
        
                $message->cc($requestCustomerEmail, 'Customer')->subject('Your Marlows Diamonds order has been received!');
                $message->bcc('sharma.gajendra@dotsquares.com', 'Customer')->subject('Your Marlows Diamonds order has been received pro!');
            });
        } else if (env('APP_ENV') == 'local') {
            $requestCustomerEmail = $getOrderDetailsMail['user_details']['email'];
                Mail::send('email.orderstatus', array(
                'data1' => $data,
            ), function($message) use ($requestCustomerEmail,$admin_email, $transaction_emails ){
                $message->from('dssmtp@marlows-diamonds.co.uk');
                $message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('Your Marlows Diamonds order has been received!');
        
                if(!empty($transaction_emails)){
                    $emails_to_cc = explode(',', $transaction_emails);
                    foreach ($emails_to_cc as $email_to_cc) {
                        $message->cc('sharma.gajendra@dotsquares.com', 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                    }
                }
                $message->cc($requestCustomerEmail, 'Customer')->subject('Your Marlows Diamonds order has been received!');
                $message->bcc('sharma.gajendra@dotsquares.com', 'Customer')->subject('Your Marlows Diamonds order has been received!');
            });
        }
        
        $result = [
            'pay' => $getOrderDetailsMail,
            'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been successfully paid',
        ];
        return $result;
    
    }
    
    public function validateMerchant(Request $request)
    {
        // Get the validation URL from the client request
        $validationUrl = $request->input('validationUrl');

        // Merchant info
        if (env('APP_ENV') == 'production') {
            $domainName = "marlows-diamonds.co.uk"; // Replace with your actual domain name
            $merchantIdentifier = env("PAYPAL_MERCHANTID_LIVE");
        }elseif (env('APP_ENV') == 'local') {
            $domainName = "devstaging.marlows-diamonds.co.uk"; // Replace with your actual domain name
            $merchantIdentifier = env("PAYPAL_MERCHANTID_STAG");
        }

        
        $displayName = "My Store"; // Replace with your actual display name

        // Make the HTTP request to Apple's startSession endpoint
        try {
            
            
            // cURL URL for Apple Pay session start
            $url = 'https://apple-pay-gateway-cert.apple.com/paymentservices/startSession';
            
            // Data to send to the Apple Pay API
            $data = [
                'merchantIdentifier' => $merchantIdentifier,
                'domainName' => $domainName,
                'displayName' => $displayName,
                'validationURL' => $validationUrl,
            ];
            
            // Initialize cURL session
            $ch = curl_init();
            
            // Set cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            
            // Attach the JSON-encoded data to the request
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            // Set content-type header to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            
            // Execute the cURL request
            $response = curl_exec($ch);
            var_dump($response);
            
            // Check for errors
            if ($response === false) {
                echo 'cURL error: ' . curl_error($ch);
            } else {
                // Success: Decode the response
                $responseData = json_decode($response, true);
                if ($responseData) {
                    echo 'Merchant session validated successfully: ';
                    print_r($responseData);  // Print the returned merchant session
                } else {
                    echo 'Invalid response: ' . $response;
                }
            }
            
            // Close the cURL session
            curl_close($ch);
            // Check if the response is successful
            if ($response->successful()) {
                // Send the merchant session to the client
                return response()->json([
                    'merchantSession' => $response->json(),
                ]);
            } else {
                // If the request fails, throw an exception
                throw new \Exception('Failed to validate merchant.');
            }
        } catch (\Exception $e) {
            // Return error if something went wrong
            return response()->json(['error' => 'Merchant validation failed: ' . $e->getMessage()], 500);
        }
    }

    // SUT
    public function generateAccessToken()
    {

        if (env('APP_ENV') == 'production') {
            $clientId = "AXc2YDyTWs6VKh-EdMFo1MV1zQ7vzYzLcPTvpmYg5rHMZxSgySqtLpT-5v13dRIxG6vxvrjb1X9QvBJR";
            $appSecret = "EITsZpoj19pYPdScdV6rIaJpFzND_qJDLFlhQBqHkYNhfYv__7fHwS2ESOSj7D_40_CSfJaf1rV7FD1V";
            $base = "https://api.paypal.com";
        }elseif (env('APP_ENV') == 'local') {
            $clientId = "AfLQcRuY8C2VcpdsSImup4E10vYi5Yi3w4gJ6d1WhqubKbHttdwpUe8RIW1pVkW0OsrXW4uNBl44RIqp";
            $appSecret = "EBzp7ErM5_MA5YOzBJxKpA4aZqtfchk5nFE8auNXEyp6UrxsCmWX-e6SlUbZOcOURs4_iuC_RSqNP3eO";
            $base = "https://api-m.sandbox.paypal.com";
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$base/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . base64_encode("$clientId:$appSecret")]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
    
        $json = json_decode($response, true);
        return $json['access_token'];
    }
    
    public function createOrder()
    {
        
        $userName = Session::get('userIddata'); // Default to 'Guest' if 'userName' is not set
        
        $getFinalAmount = Order::latest()->select('deposited_price')->first();
        
        // $totalDepositedPrice = array_reduce($data, function ($carry, $item) {
        //     return $carry + $item['deposited_price'];
        // }, 0);
        $totalDepositedPrice = $getFinalAmount->deposited_price;
        
        if (env('APP_ENV') == 'production') {
            $base = "https://api.paypal.com";
            $merchantId = env("PAYPAL_MERCHANTID_LIVE");
        }elseif (env('APP_ENV') == 'local') {
            $base = "https://api-m.sandbox.paypal.com";
            $merchantId = env("PAYPAL_MERCHANTID_STAG");
        }
        $accessToken = $this->generateAccessToken();
        $merchantId = env("PAYPAL_MERCHANTID");
        $purchaseAmount = $totalDepositedPrice; // Hardcoded for demonstration purposes
    
        $orderData = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "GBP",
                        "value" => $purchaseAmount
                    ],
                    "payee" => [
                        "merchant_id" => $merchantId
                    ]
                ]
            ]
        ];
        
        $ch = curl_init("$base/v2/checkout/orders");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $accessToken"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
        
        return json_decode($response, true);
    }
    
    public function capturePayment($orderId)
    {
        if (env('APP_ENV') == 'production') {
            $base = "https://api.paypal.com";
        }elseif (env('APP_ENV') == 'local') {
            $base = "https://api-m.sandbox.paypal.com";
        }
        $accessToken = $this->generateAccessToken();
    
        $ch = curl_init("$base/v2/checkout/orders/$orderId/capture");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $accessToken"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
    
        return json_decode($response, true);
    }
    
    public function generateClientToken()
    {
        if (env('APP_ENV') == 'production') {
            $base = "https://api.paypal.com";
        }elseif (env('APP_ENV') == 'local') {
            $base = "https://api-m.sandbox.paypal.com";
        }
        $accessToken = $this->generateAccessToken();
    
        $ch = curl_init("$base/v1/identity/generate-token");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $accessToken",
            "Accept-Language: en_US",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
    
        $json = json_decode($response, true);
        return $json['client_token'];
    }
    
    public function appleApiOrder(){
        try {
            $order = $this->createOrder();
            echo json_encode($order);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
        die;
        exit;
    }
    
    public function appleApiOrderCapture($orderId){
        try {
            $captureData = $this->capturePayment($orderId);
            echo json_encode($captureData);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
    
    
    // public function getOrderDetails($orderId) {
    //     try {
    //         // Step 1: Get the access token
    //         $accessToken = $this->generateAccessToken();
    
    //         // Step 2: Set up the cURL request to PayPal's GET endpoint
    //         $ch = curl_init("https://api.sandbox.paypal.com/v2/checkout/orders/$orderId");
    
    //         // Step 3: Set the necessary headers, including the access token
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //             "Authorization: Bearer $accessToken"
    //         ]);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    //         // Step 4: Execute the cURL request
    //         $response = curl_exec($ch);
            
    //         // Step 5: Check for cURL errors
    //         if (curl_errno($ch)) {
    //             throw new Exception(curl_error($ch));
    //         }
    
    //         // Step 6: Close the cURL session
    //         curl_close($ch);
    
    //         // Step 7: Decode the JSON response from PayPal
    //         $orderDetails = json_decode($response, true);
    
    //         // Step 8: Return or process the order details
    //         return $orderDetails;
    //     } catch (Exception $e) {
    //         // Handle errors
    //         return ['error' => $e->getMessage()];
    //     }
    // }


}








