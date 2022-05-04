<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

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
        return response()->json(['status'=>200,'msg'=>'Successfully Updated...']);
    }

}
