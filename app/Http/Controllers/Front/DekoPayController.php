<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDekopayFinance;
use App\Models\User;
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
				$items[] = $orders->title;
				
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
			$email = CustomerAddress::where('user_id',Auth::user()->id)->where('order_id',$order_id)->value('email');
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

	public function check_response(Request $request)
	{ 
		$_PostVal=$request->all();
		$posted=$_PostVal;
		
		
		file_put_contents(__DIR__.'/'.time().'.txt', print_r($posted,true));

		if(empty($posted['Identification']['RetailerUniqueRef'])){
			return view('front.pages.payments.dekopay_failed',['message'=>'Request Failure']);
		}
		//extract($posted);
			$msg = $posted['Identification']['RetailerUniqueRef'];
			 if (isset($posted['Identification']['RetailerUniqueRef']) && isset($posted['Status'])) :		
				if (!empty($posted['Identification']['RetailerUniqueRef']) && !empty($posted['Status'])) :
					header('HTTP/1.1 200 OK');
					$this->successful_request($posted);
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
	function payment_complete($order_id){
		Order::where('id',$order_id)->update(['pay_timestamp'=>date('Y-m-d h:i:s'),'status'=>2]);

		session()->forget('cart');
	}
	function successful_request( $posted ) {
			$order_id_key=$posted['Identification']['RetailerUniqueRef'];
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