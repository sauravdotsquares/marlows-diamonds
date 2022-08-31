<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Products;
use App\Models\Posts;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
    	$breadcrumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcrumb($breadcrumb);

        

        // return response()->json($getOrder);

        /** Count */
        $totalProducts = Products::count();
        $totalPosts = Posts::count();
        $totalOrder = Order::count();
        $totalUser = User::count();

        /** Latest data */
        $latestUsers = User::orderBy('created_at','DESC')->limit(8)->get();
        $getOrderDetails = Order::with(['getOrderDetailsFunction'])->latest()->where('status','<',4)->limit(10)->get();
        $latestProducts = Products::with(['getProductImages'])->latest()->limit(5)->get();

        // echo '<pre>';
        // print_r($latestProducts->toArray());die;

        return view('admin.dashboard',compact([
            'getOrderDetails',
            'totalProducts',
            'totalPosts',
            'totalOrder',
            'totalUser',
            'latestProducts'
        ]));
    }
}
