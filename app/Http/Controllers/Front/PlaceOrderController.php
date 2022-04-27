<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use Redirect;

class PlaceOrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        if(auth()->guard('customer')->check()){
            $getCustomerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
            if($getCustomerAddress){
                $getCustomerAddress->user_id = Auth::user()->id;
                $getCustomerAddress->order_id = 1;
                $getCustomerAddress->first_name = $request->first_name;
                $getCustomerAddress->last_name = $request->last_name;
                $getCustomerAddress->country_id = $request->country_id;
                $getCustomerAddress->street_address_l1 = $request->street_address_l1;
                $getCustomerAddress->street_address_l2 = $request->street_address_l2;
                $getCustomerAddress->town_city = $request->town_city;
                $getCustomerAddress->state = $request->state;
                $getCustomerAddress->pin_code = $request->pin_code;
                $getCustomerAddress->mobile = $request->mobile;
                $getCustomerAddress->email = $request->email;
                $getCustomerAddress->order_notes = $request->order_notes;
                $getCustomerAddress->save();
            }else{
                $getCustomerAddress = new CustomerAddress;
                $getCustomerAddress->user_id = Auth::user()->id;
                $getCustomerAddress->order_id = 1;
                $getCustomerAddress->first_name = $request->first_name;
                $getCustomerAddress->last_name = $request->last_name;
                $getCustomerAddress->country_id = $request->country_id;
                $getCustomerAddress->street_address_l1 = $request->street_address_l1;
                $getCustomerAddress->street_address_l2 = $request->street_address_l2;
                $getCustomerAddress->town_city = $request->town_city;
                $getCustomerAddress->state = $request->state;
                $getCustomerAddress->pin_code = $request->pin_code;
                $getCustomerAddress->mobile = $request->mobile;
                $getCustomerAddress->email = $request->email;
                $getCustomerAddress->order_notes = $request->order_notes;
                $getCustomerAddress->save();
            }
            if($getCustomerAddress){
                $getOrders = new Order;
                $getOrders->user_id = Auth::user()->id;
                $getOrders->final_price = $request->final_price;
                $getOrders->payment_type = $request->payment_type;
                $getOrders->paymentccdetails = $request->paymentccdetails;
                $getOrders->depositpercentage = $request->depositepercentage;
                $getOrders->save();

                if($getOrders){
                    $getSessionProductData = session('cart');
                    if(isset($getSessionProductData) && !empty($getSessionProductData)){
                        foreach($getSessionProductData as $key => $getProduct){
                            $getOrderDetails = new OrderDetail;
                            $getOrderDetails->order_id = $getOrders->id;
                            $getOrderDetails->product_id = $key;
                            $getOrderDetails->user_id = Auth::user()->id;
                            $getOrderDetails->quantity = $getProduct['quantity'];
                            $getOrderDetails->product_price = $getProduct['price'];
                            $getOrderDetails->total_price = $getProduct['quantity']*$getProduct['price'];
                            $getOrderDetails->save();
                        } 
                    }
                }
                CustomerAddress::where('user_id',Auth::user()->id)->update(['order_id'=>$getOrders->id]);
            }
            return redirect()->back()->with('success', 'Orders successfully added');   
        }
        return redirect()->back()->with('error', 'You are not logged in please logged in...'); 
        
    }
}
