<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Mail;
use App\Models\Settings;

class OrderController extends Controller
{
    public function index()
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Orders", "url" => route("admin.order.details.page"), "icon" => "fa fa-dashboard"],

        ];
        populate_breadcrumb($breadcrumb);

        $getOrderDetails = Order::with(['getOrderDetailsFunction'])->latest()->where('status','<',4)->paginate(10);
        // return response()->json($getOrderDetails);

        return view('admin.orders.order-list',compact('getOrderDetails'));
    }

    public function orderProductDetails($orderId)
    {
        $breadcrumb = [
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],
            ["name" => "Orders", "url" => route("admin.order.details.page"), "icon" => "fa fa-dashboard"],

        ];
        populate_breadcrumb($breadcrumb);

        $getOrderDetails = Order::with(['getOrderDetailsFunction'])->where('id',$orderId)->first();
        // return response()->json($getOrderDetails);

        return view('admin.orders.order-details',compact('getOrderDetails'));

        // echo "<pre>";
        // print_r("Checking");
        // print_r($orderId);
        // die;
    }

    public function changeOrderStatus(Request $request)
    {
        $getOrderDetails = Order::where('token',$request->order_token)->update(['status'=>$request->order_status]);
		$getOrderDetailsMail = Order::with('getOrderDetailsFunction')->where('token',$request->order_token)->first()->toArray();
		
		$admin_email = Settings::where("option_name",'admin_email')->value('option_value');
		
		$data = [
		   'data' => $getOrderDetailsMail
		];
		
		$request['customer_email'] = $getOrderDetailsMail['user_details']['email']; 
		// echo "<pre>";
		// print_r($getOrderDetailsMail['user_details']['email']);
		// die;
		//Mail::send('email.orderstatus',["data1"=>$data], function($message) use ($request,$admin_email ){
		Mail::send('email.orderstatus', array(
            'data1' => $data,
			
            
        ), function($message) use ($request,$admin_email ){	
			$message->from('hello@marlows-diamonds.co.uk');
			$message->to($admin_email, 'Admin')->subject('Order Status');
			$message->cc($request['customer_email'], 'Customer')->subject('Order Status');
			
        });
		
        return response()->json(['status'=>200,'msg'=>'Successfully Updated...']);
    }

}
