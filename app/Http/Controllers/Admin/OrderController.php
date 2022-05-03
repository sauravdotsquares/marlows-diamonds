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

}
