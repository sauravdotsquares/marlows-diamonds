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
use Redirect;
use App\Http\Controllers\Front\LoginController;

class PlaceOrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        //echo '<pre>'; print_r($request->all()); die;
        //echo $encryt = base64_encode('6-7');
        //echo $encryt = base64_decode($encryt);
        //die;
        if(!Auth::check()){
            
            // If user is not logged in
            $getEmailExists = User::where('email',$request->cust_email)->first();


            if(!isset($getEmailExists) && empty($getEmailExists)){
                $userDetails = [
                    'email'=> $request->cust_email,
                    'username' => $request->cust_username,
                    'password' => $request->cust_password,
                ];

                $getLoginStatusResponse = new LoginController;
                $getEmailExists = $getLoginStatusResponse->registerCheckoutCustomer($userDetails);

                // $getEmailExists = $getEmailExists;
                // If user is already Exists
                // return response()->json(['status'=>500,'msg'=>'Email is already exist please login and continue place order']);
            }


        }else if(Auth::check()){
            $getEmailExists = User::where('email',$request->cust_email)->first();
        }
        // echo "<pre>";
        // print_r($getEmailExists);
        // die;

        if(isset($getEmailExists) && !empty($getEmailExists)){
            $getCustomerAddress = CustomerAddress::where('user_id',$getEmailExists->id)->first();
            if($getCustomerAddress){          
                $getCustomerAddress->user_id = $getEmailExists->id;
                $getCustomerAddress->order_id = 1;
                $getCustomerAddress->first_name = $request->first_name;
                $getCustomerAddress->last_name = $request->last_name;
                $getCustomerAddress->company_name = $request->company_name;
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
                $getCustomerAddress->user_id = $getEmailExists->id;
                $getCustomerAddress->order_id = 1;
                $getCustomerAddress->first_name = $request->first_name;
                $getCustomerAddress->last_name = $request->last_name;
                $getCustomerAddress->company_name = $request->company_name;
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
                $getOrders->user_id = $getEmailExists->id;
                $getOrders->final_price = $request->final_price;
                $getOrders->total_price = $request->total_price;
                $getOrders->deposited_price = $request->deposited_price;
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
                            $getOrderDetails->user_id = $getEmailExists->id;
                            $getOrderDetails->order_product_details = json_encode($getProduct['customArray']);
                            $getOrderDetails->quantity = $getProduct['quantity'];
                            $getOrderDetails->product_price = $getProduct['price'];
                            $getOrderDetails->total_price = $getProduct['quantity']*$getProduct['price'];
                            $getOrderDetails->deposited_product_price = $getProduct['quantity']*$getProduct['deposited_price'];
                            $getOrderDetails->final_product_price = $getProduct['quantity']*$getProduct['price'];
                            $getOrderDetails->save();
                        }

                        //Check if the payment type is dekopay and save their records

                        if($request->selected_payment_type == 'dekopay'){
                            $orderDekopayFinance = new OrderDekopayFinance;
                            $orderDekopayFinance->order_id = $getOrders->id;
                            $orderDekopayFinance->user_id = $getEmailExists->id;
                            $orderDekopayFinance->order_key = base64_encode($getEmailExists->id.'-'.$getOrders->id);
                            $orderDekopayFinance->finCodes = $request->payPro;
                            $orderDekopayFinance->depositAmt = $request->payPer;
                            $orderDekopayFinance->totalAmts = $request->final_price;

                            $orderDekopayFinance->save();
                        }

                        CustomerAddress::where('user_id',$getEmailExists->id)->update(['order_id'=>$getOrders->id]);


                        return response()->json(['status'=>200,'msg'=>'Order added','order_dt'=>$getOrders->id]);
                        // return redirect(route('make.payment'));
                        // return redirect()->route('make.payment', ['order_id' => $getOrders->id]);
                    }
                }
                return response()->json(['status'=>200,'msg'=>'Order partially added']);
            }
        }
        // return response()->json(['status'=>500,'msg'=>'User is not logged in by customers']);
        return response()->json(['status'=>500,'msg'=>'Order is not submitted']);
    }
}
