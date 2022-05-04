<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        $getOrderDetails = Order::with(['getOrderDetailsFunction'])->latest()->where('status','<',4)->limit(10)->get();

        // return response()->json($getOrder);

        return view('admin.dashboard',compact('getOrderDetails'));
    }
}
