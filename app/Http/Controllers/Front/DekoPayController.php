<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDekopayFinance;
use App\Models\User;
use App\Models\Settings;
use Mail;
use Auth;

class DekoPayController extends Controller
{

	public function __construct(){
		$this->id = 'dekopay';
		$this->method_title = 'Dekopay';
		$this->has_fields = false;	
		$this->pay_url  = env('DEKOPAY_MODE');
		if($this->pay_url == 'live'){
			$this->purl = 'https://secure.dekopay.com/credit-application/form/';
		}else{
			$this->purl = 'https://test.dekopay.com/credit-application/form/';
		}
		$this->apikey = env('DEKOPAY_API_KEY');
		$this->api_install_id = env('DEKOPAY_API_INSTALL_ID');
	}
	/*
	** Dekopay payment receipt page
	*/
	public function receipt_page( $order )
	{
		
		echo $this->generate_dekopay_form( $order );
			
	}

	public function generate_dekopay_form( $order_id )
	{
		$api_key = $this->apikey;
		$api_install_id = $this->api_install_id;
		$orderDetails = OrderDetail::where('order_id',$order_id)->get();
		$orderDekopayFinance = OrderDekopayFinance::where('order_id',$order_id)->first();
		if($orderDekopayFinance){
			$totalAmts = (float)$orderDekopayFinance->totalAmts;
			$items = array();
			foreach ($orderDetails as $key => $orderDetail) {
				$orders = json_decode($orderDetail->order_product_details);
				$items[] = isset($orders->title)?$orders->title:'Custom Diamond';
				
			}
			$pname =implode(',',$items);
			$finCodes = $orderDekopayFinance->finCodes;
			$depositAmt = (float)$orderDekopayFinance->depositAmt;
			
			$result = $this->call_deko_curl($orderDekopayFinance, $totalAmts,  $pname, $finCodes, $depositAmt);
			$dekopay_args = $this->get_dekopay_args( $orderDekopayFinance );
			//echo '<pre>'; print_r($dekopay_args); die;
			return view('front.pages.payments.dekopay_receipt',compact('order_id','dekopay_args','orderDekopayFinance','api_key','api_install_id','pname','result'));
		}
		
		return view('front.pages.payments.dekopay_failed');
	}

	private function call_deko_curl($order, $bool, $desc, $finCode, $depositAmt ){
			
			
		$install_id = intval($this->api_install_id);

		$postFields = array(
			"action" => "credit_application_link",
			"Identification[api_key]"=> $this->apikey,
			"Identification[RetailerUniqueRef]"=> $order->order_id.'-'.$order->order_key,
			"Identification[InstallationID]"=> $install_id,
			"Goods[Price]"=> $bool * 100,
			"Goods[Description]"=> $desc,
			"Goods[Quantity]"=> 1,
			"Finance[Code]" => $finCode,
			//"Finance[Code]" => 'ONIB12-14.9',
			"Finance[Deposit]" => ($depositAmt/100) * $bool*100,
		);
		
		$pay_url =  $this->pay_url;
		$interface = ($pay_url != 'live') ? "https://test.dekopay.com:6686/" : "https://secure.dekopay.com:6686/";

	
			
		$curlSession = curl_init();
		curl_setopt($curlSession, CURLOPT_URL, $interface);
		curl_setopt($curlSession, CURLOPT_HEADER, 0);
		curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, 0);
		
		/*Upgrade start*/
		curl_setopt($curlSession,CURLOPT_POST,1);
		curl_setopt($curlSession,CURLOPT_POSTFIELDS,$postFields); 
		/*Upgrade end*/
		
		curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlSession, CURLOPT_USERAGENT, "Dekopay HTTP Post");
		curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, 1);
		$curl_response = curl_exec($curlSession);

		/*Check if curl option has error or not*/
		if(curl_errno($curlSession))
		{
			//echo '<br>Curl error: ' . curl_error($curlSession);
			return ""; 
		}
		
		if(curl_getinfo($curlSession))
		{
			$info = curl_getinfo($curlSession);
			//echo '<br>Curl Status: '.$info['http_code'];
			//echo $curl_response;
		}

		
		return $curl_response;
	}

	function get_dekopay_args( $order)
	{			
			$order_id = $order->order_id;
			$user_id = $order->user_id;
			
			$email = CustomerAddress::where('user_id',$user_id)->where('order_id',$order_id)->value('email');
			$data = array();
			$data['customerReference'] = $order_id.'-'.$order->order_key;
			$data['description'] = "Payment for order id ".$order_id;
			$data['email'] = $email;
			$data['INVNUM'] = $order_id;
			$data['amount'] = number_format($order->totalAmts, 2, '.', '');	
			
			$url = $this->pay_url;
			
            if($url == 'live'){
			  $form_url = 'https://secure.dekopay.com/credit-application/form/';
			}else{
			 $form_url = 'https://test.dekopay.com/credit-application/form/';
			}
			
			$data['gatewayurl'] = $form_url;			
			
			return $data;
			
	}
	
	public function dekopayVerified(Request $request){
	    $tokenData = (isset($request['token']) && !empty($request['token']))?$request['token']:0;
	    $retailerUniqueRef = (isset($request['retaileruniqueref']) && !empty($request['retaileruniqueref']))?$request['retaileruniqueref']:0;
	    
	    if($retailerUniqueRef != 0){
	         $result = $this->payment_complete($tokenData,$retailerUniqueRef,'verified');
	         return view('front.pages.success-page',$result);
	    }
	    return view('front.pages.cancel-page',[]);
	}
	
	public function dekopayDeclined(Request $request){
		$checkCustomOrderId = session()->get('custom_order_id');
		$result = $this->payment_cancelled($checkCustomOrderId,$checkCustomOrderId,'declined');
	    return view('front.pages.cancel-page',$result);
	}
	public function dekopayCancelled(Request $request){
		$checkCustomOrderId = session()->get('custom_order_id');
		$result = $this->payment_cancelled($checkCustomOrderId,$checkCustomOrderId,'cancelled');
		
		return view('front.pages.cancel-page',$result);
	}
	
	public function dekopayReferred(Request $request){
		$checkCustomOrderId = session()->get('custom_order_id');
		$result = $this->payment_cancelled($checkCustomOrderId,$checkCustomOrderId,'referred');
		
	    return view('front.pages.cancel-page',$result);
	}
	
	public function dekopayCsnUrl(Request $request){
		$checkCustomOrderId = session()->get('custom_order_id');
		$result = $this->payment_cancelled($checkCustomOrderId,$checkCustomOrderId,'csn_url');
	    return view('front.pages.cancel-page',$result);
	}

	public function check_response(Request $request)
	{ 
		$_PostVal=$request->all();
		$posted=$_PostVal;
		
		file_put_contents(__DIR__.'/'.time().'.txt', print_r($posted,true));

		if(empty($posted['retaileruniqueref'])){
			return view('front.pages.payments.dekopay_failed',['message'=>'Request Failure']);
		}
		//extract($posted);
			$msg = $posted['retaileruniqueref'];
			 if (isset($posted['retaileruniqueref']) ) :
				if (!empty($posted['retaileruniqueref']) ) :
					header('HTTP/1.1 200 OK');
					
            	    $result = $this->payment_complete(isset($posted['token'])?$posted['token']:0,$posted['retaileruniqueref']);
				    // 	$this->successful_request($posted);
					return view('front.pages.success-page',$result);
				else :
					return view('front.pages.payments.dekopay_failed',['message'=>'Request Failure']);
			   endif;
			else :
				$res_orderdata = $_GET['retaileruniqueref'];
				if(isset($_GET['retaileruniqueref']) && !empty($res_orderdata)) {
					$resorder = explode("-",$res_orderdata);
					$return_url = route('make.dekopay').'/'.$resorder[0]."?key=".$resorder[1];
					return redirect($return_url);
				} else {
					$return_url = route('product.cart');
					return redirect($return_url);
				}
			endif;

	}
	function payment_complete($token,$order_id,$dekoStatus){
		$resorder = explode("-",$order_id); 
		$order_id = $resorder[0];
		$dekoPayFinanceOrderId = $resorder[1];
		Order::where('id',$order_id)->update(['token'=>$token,'custom_order_id'=>$dekoPayFinanceOrderId,'deko_order_key'=> $dekoPayFinanceOrderId, 'pay_timestamp'=>date('Y-m-d h:i:s'),'status'=>2,'deko_status'=>$dekoStatus]);
		$getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('id',$order_id)->first()->toArray();
		
		$admin_email = Settings::where("option_name",'admin_email')->value('option_value');
        $transaction_emails = Settings::where("option_name",'transaction_emails')->value('option_value');
        $data = [
            'data' => $getOrderDetailsMail
        ];
        
        $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
        Mail::send('email.orderstatus', array(
            'data1' => $data,
        ), function($message) use ($request,$admin_email, $transaction_emails ){
            $message->from('sharma.gajendra@dotsquares.com');
            $message->to('sharma.gajendra@dotsquares.com', 'Admin')->subject('Your Marlows Diamonds order has been received!');

            if(!empty($transaction_emails)){
                $emails_to_cc = explode(',', $transaction_emails);
                foreach ($emails_to_cc as $email_to_cc) {
                    $message->cc('sharma.gajendra@dotsquares.com', 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                }
            }

            $message->cc($request['customer_email'], 'Customer')->subject('Your Marlows Diamonds order has been received!');
        });
		
		session()->forget('cart');
		
		$result = [
            'pay' => $getOrderDetailsMail,
            'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been successfully paid',
        ]; 
        return $result;
	}
	function payment_cancelled($token,$order_id,$dekoStatus){

		$resorder = explode("-",$order_id); 
		$order_id = $resorder[0];
		$dekoPayFinanceOrderId = $resorder[1];
		Order::where('id',$order_id)->update(['token'=>$token,'custom_order_id'=>$token,'deko_order_key'=> $dekoPayFinanceOrderId, 'pay_timestamp'=>date('Y-m-d h:i:s'),'status'=>3,'deko_status'=>$dekoStatus]);
		$getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('id',$order_id)->first()->toArray();

        $admin_email = Settings::where("option_name",'admin_email')->value('option_value');
        $transaction_emails = Settings::where("option_name",'transaction_emails')->value('option_value');

        $data = [
            'data' => $getOrderDetailsMail
        ];

        $request['customer_email'] = $getOrderDetailsMail['user_details']['email'];
		Mail::send('email.orderstatus-cancel', array('data1' => $data,), function($message) use ($request,$admin_email, $transaction_emails ){
			// $message->from('hello@marlows-diamonds.co.uk');
			$message->from('sharma.gajendra@dotsquares.com');

			$admin_email_london = "sharma.gajendra@dotsquares.com";
			$message->to($admin_email_london, 'Admin')->subject('Marlows Diamonds: Your transaction not completed.');
            
            /** add cc for more users */
            if(!empty($transaction_emails)){
                $emails_to_cc = explode(',', $transaction_emails);
                foreach ($emails_to_cc as $email_to_cc) {
                    $message->cc('sharma.gajendra@dotsquares.com', 'Third party')->subject('Marlows Diamonds: Your transaction not completed.');   
                }
            }
            
            $message->cc('sharma.gajendra@dotsquares.com', 'Customer')->subject('Marlows Diamonds: Your transaction not completed.');
        });

        $result = [
            'response' => 'Your Order number('.$getOrderDetailsMail['custom_order_id'].') has been cancelled',
        ];

        return $result;
	}
	function successful_request( $posted ) {

			$order_id_key=$posted['retaileruniqueref'];
			$resorder = explode("-",$order_id_key); 
			$order_id = $resorder[0];

			$price = 0;
			foreach ($posted['Goods'] as $prod) {
				$price = $price + $prod['Price'];
			}

			$status=strtolower($posted['Status']);
			$orderMessage = '';
			// if TXN is approved
			if($status=="accept" || $status=="complete" || $status=="verified" || $status=="refer")
			{
				
				$orderMessage .= 'dekopay payment  - CreditRequestID: ' . $posted['CreditRequestID'] . " - ResponseCode: " .$posted['Status'];
				
				$orderMessage .= 'dekopay payment Response: ' . json_encode($posted);
				
				// Payment completed
				$orderMessage .= 'payment completed';

				// Mark order complete
				//$order->payment_complete();
				$this->payment_complete($order_id);

				  // Empty cart and clear session
				// Redirect to thank you URL
				return view('front.pages.payments.dekopay_success',['response'=>'Payment Successful','orderMessage'=>$orderMessage]);
			}
			
			if ($status=="decline" || $status=="cancelled" || $status=="predecline")// TXN has declined
			{	   
				return view('front.pages.payments.dekopay_failed',['response'=>'Payment '.$status]);
				
			} 
			else // TXN has declined
			{	   
				// Change the status to pending / unpaid
				$orderMessage .= 'Payment declined';
			   
				// Add a note with the IPG details on it
				$orderMessage .= 'dekopay payment Failed - CreditRequestID: ' . $posted['CreditRequestID'] . " - ResponseStatus: " .$posted['Status']; // FAILURE NOTE
				
				$orderMessage .= 'dekopay payment Response: ' . json_encode($posted);
			   
				return view('front.pages.payments.dekopay_failed',['response'=>'Payment Successful','orderMessage'=>$orderMessage]);
			}

		}
}