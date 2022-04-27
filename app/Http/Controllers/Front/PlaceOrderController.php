<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Auth;
use Redirect;
use App\Http\Controllers\Front\LoginController;

class PlaceOrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $getEmailExists = User::where('email',$request->cust_email)->count();

        if($getEmailExists > 1){
            return response()->json(['status'=>500,'msg'=>'Email is already exist please login and continue place order']);
        }else{

            $userDetails = [
                'email'=> $request->cust_email,
                'username' => $request->cust_username,
                'password' => $request->cust_password,
            ];

            $getLoginStatusResponse = new LoginController;
            $getResponses = $getLoginStatusResponse->registerCheckoutCustomer($userDetails);

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
                    $getCustomerAddress->email = $request->cust_email;
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
                    $getCustomerAddress->email = $request->cust_email;
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

                    return response()->json(['status'=>200,'msg'=>'Order Successfully placed']); 
                }
            }
            return response()->json(['status'=>500,'msg'=>'User is not logged in']);
        }
        return response()->json(['status'=>500,'msg'=>'Order is not submitted']);
    }
}
