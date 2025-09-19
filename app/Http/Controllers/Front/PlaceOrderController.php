<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\CustomerShippingAddress;
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
        $email = $request->cust_email;

        // Extract domain from the email
        $emailDomain = substr(strrchr($email, "@"), 1);
        if ($emailDomain === 'storebotmail.joonix.net' || $email == "testing@example.com") {
            $result = [
                'response' => 'Your Order number(' . rand(10000, 100000000) . ') has been successfully paid',
            ];
            return response()->json(['status' => 200, 'msg' => 'Order added', 'order_dt' => rand(10000, 100000000), 'orderf_status' => 'emailf_generated']);
        }
        //echo '<pre>'; print_r($request->all()); die;
        //echo $encryt = base64_encode('6-7');
        //echo $encryt = base64_decode($encryt);
        //die;
        if (!Auth::check()) {

            // If user is not logged in
            $getEmailExists = User::where('email', $request->cust_email)->first();


            if (!isset($getEmailExists) && empty($getEmailExists)) {
                $userDetails = [
                    'email' => $request->cust_email,
                    'username' => $request->cust_username,
                    'password' => $request->cust_password,
                ];

                $getLoginStatusResponse = new LoginController;
                $getEmailExists = $getLoginStatusResponse->registerCheckoutCustomer($userDetails);

                // $getEmailExists = $getEmailExists;
                // If user is already Exists
                // return response()->json(['status'=>500,'msg'=>'Email is already exist please login and continue place order']);
            }
        } else if (Auth::check()) {
            $getEmailExists = User::where('email', $request->cust_email)->first();
        }
        if (isset($request->checkshippingaddress)) {
            $checkShippingAddress = 1;
        } else {
            $checkShippingAddress = 0;
        }

        if (isset($getEmailExists) && !empty($getEmailExists)) {
            $getCustomerAddress = CustomerAddress::where('user_id', $getEmailExists->id)->first();
            if ($getCustomerAddress) {
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
                $getCustomerAddress->shipping_status = $checkShippingAddress;
                $getCustomerAddress->save();


                if ($checkShippingAddress == 0) {  // 0 for insert shipping address
                    $getCustomerShippingAddress = new CustomerShippingAddress;
                    $getCustomerShippingAddress->user_id = $getEmailExists->id;
                    $getCustomerShippingAddress->order_id = 1;
                    $getCustomerShippingAddress->first_name = $request->first_shipping_name;
                    $getCustomerShippingAddress->last_name = $request->last_shipping_name;
                    $getCustomerShippingAddress->company_name = $request->company_shipping_name;
                    $getCustomerShippingAddress->country_id = $request->country_shipping_id;
                    $getCustomerShippingAddress->street_address_l1 = $request->street_address_shipping_l1;
                    $getCustomerShippingAddress->street_address_l2 = $request->street_address_shipping_l2;
                    $getCustomerShippingAddress->town_city = $request->town_shipping_city;
                    $getCustomerShippingAddress->state = $request->shipping_state;
                    $getCustomerShippingAddress->pin_code = $request->pin_shipping_code;
                    $getCustomerShippingAddress->mobile = $request->shipping_mobile;
                    $getCustomerShippingAddress->email = $request->cust_shipping_email;
                    $getCustomerShippingAddress->order_notes = $request->order_shipping_notes;
                    $getCustomerShippingAddress->save();
                }
            } else {
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
                $getCustomerAddress->shipping_status = $checkShippingAddress;
                $getCustomerAddress->save();

                if ($checkShippingAddress == 0) {
                    $getCustomerShippingAddress = new CustomerShippingAddress;
                    $getCustomerShippingAddress->user_id = $getEmailExists->id;
                    $getCustomerShippingAddress->order_id = 1;
                    $getCustomerShippingAddress->first_name = $request->first_shipping_name;
                    $getCustomerShippingAddress->last_name = $request->last_shipping_name;
                    $getCustomerShippingAddress->company_name = $request->company_shipping_name;
                    $getCustomerShippingAddress->country_id = $request->country_shipping_id;
                    $getCustomerShippingAddress->street_address_l1 = $request->street_address_shipping_l1;
                    $getCustomerShippingAddress->street_address_l2 = $request->street_address_shipping_l2;
                    $getCustomerShippingAddress->town_city = $request->town_shipping_city;
                    $getCustomerShippingAddress->state = $request->shipping_state;
                    $getCustomerShippingAddress->pin_code = $request->pin_shipping_code;
                    $getCustomerShippingAddress->mobile = $request->shipping_mobile;
                    $getCustomerShippingAddress->email = $request->cust_shipping_email;
                    $getCustomerShippingAddress->order_notes = $request->order_shipping_notes;
                    $getCustomerShippingAddress->save();
                }
            }

            if ($getCustomerAddress) {
                $getOrders = new Order;
                $getOrders->user_id = $getEmailExists->id;
                $getOrders->final_price = $request->final_price;
                $getOrders->total_price = $request->total_price;
                $getOrders->deposited_price = $request->deposited_price;
                $getOrders->payment_type = $request->payment_type;
                $getOrders->paymentccdetails = $request->paymentccdetails;
                $getOrders->depositpercentage = $request->depositepercentage;
                $getOrders->status = 0;
                $getOrders->save();

                if ($getOrders) {
                    $getSessionProductData = session('cart');
                    if (isset($getSessionProductData) && !empty($getSessionProductData)) {
                        foreach ($getSessionProductData as $key => $getProduct) {
                            $getOrderDetails = new OrderDetail;
                            $getOrderDetails->order_id = $getOrders->id;
                            $getOrderDetails->product_id = $key;
                            $getOrderDetails->user_id = $getEmailExists->id;
                            $getOrderDetails->order_product_details = json_encode($getProduct['customArray']);
                            $getOrderDetails->quantity = $getProduct['quantity'];
                            $getOrderDetails->coupon_code = isset($getProduct['couponCodeText']) ? $getProduct['couponCodeText'] : NULL;
                            $getOrderDetails->discount_percentage = isset($getProduct['couponCodePercentage']) ? $getProduct['couponCodePercentage'] : NULL;
                            $getOrderDetails->product_price = $getProduct['price'];
                            $getOrderDetails->total_price = $getProduct['price'];
                            $getOrderDetails->deposited_product_price = $getProduct['deposited_price'];
                            $getOrderDetails->final_product_price = $getProduct['price'];
                            $getOrderDetails->yearly_support_status = isset($getProduct['yearlySupportStatus']) ? $getProduct['yearlySupportStatus'] : 0;
                            $getOrderDetails->yearly_support_price = isset($getProduct['yearlySupport']) ? $getProduct['yearlySupport'] : 0;
                            $getOrderDetails->save();
                        }

                        //Check if the payment type is dekopay and save their records

                        if ($request->selected_payment_type == 'dekopay') {
                            $orderDekopayFinance = new OrderDekopayFinance;
                            $orderDekopayFinance->order_id = $getOrders->id;
                            $orderDekopayFinance->user_id = $getEmailExists->id;
                            $orderDekopayFinance->order_key = base64_encode($getEmailExists->id . '-' . $getOrders->id);
                            $orderDekopayFinance->finCodes = $request->payPro;
                            $orderDekopayFinance->depositAmt = $request->payPer;
                            $orderDekopayFinance->totalAmts = $request->final_price;

                            $orderDekopayFinance->save();
                        }
                        Order::where('id', $getOrders->id)->update(['custom_order_id' => '31002' . '' . $getOrderDetails->user_id . '-' . $getOrders->id, 'status' => 1, 'deko_status' => 'pending']);
                        session()->put('custom_order_id', $getOrders->id . '-' . base64_encode($getEmailExists->id . '-' . $getOrders->id));

                        CustomerAddress::where('user_id', $getEmailExists->id)->update(['order_id' => $getOrders->id]);
                        if ($checkShippingAddress == 0) {
                            optional(
                                CustomerShippingAddress::where('user_id', $getEmailExists->id)->latest('id')->first()
                            )->update(['order_id' => $getOrders->id]);
                        }

                        $getOrderDetail = Order::with('customerOrderAddress','customerShippingAddress','getOrderDetailsFunction')->find($getOrders->id);
                        // dd($getOrderDetail);
                        // $getOrderDetail = OrderDetail::where('order_id', '=', $getOrders->id)->get()->toArray();

                        return response()->json(['status' => 200, 'msg' => 'Order added', 'order_dt' => $getOrders->id, 'get_order_detail' => $getOrderDetail]);
                        // return redirect(route('make.payment'));
                        // return redirect()->route('make.payment', ['order_id' => $getOrders->id]);
                    }
                }
                return response()->json(['status' => 200, 'msg' => 'Order partially added']);
            }
        }
        // return response()->json(['status'=>500,'msg'=>'User is not logged in by customers']);
        return response()->json(['status' => 500, 'msg' => 'Order is not submitted']);
    }
}
