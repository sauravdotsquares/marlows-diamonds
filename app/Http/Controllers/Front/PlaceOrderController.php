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
    /**
     * Get placeorder data
     *
     * @param Request $request
     * @return void
     */
    public function placeOrder(Request $request)
    {
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
                $getEmailExists = $getLoginStatusResponse->registerFrontEndUsers($userDetails);

                // If user is already Exists
                // return response()->json(['status'=>500,'msg'=>'Email is already exist please login and continue place order']);
            }
        } else if (Auth::check()) {
            $getEmailExists = User::where('email', $request->cust_email)->first();
        }

        if (isset($getEmailExists) && !empty($getEmailExists)) {
            $getCustomerAddress = CustomerAddress::updateOrCreate(
                ['user_id' => $getEmailExists->id],
                [
                    'user_id' => $getEmailExists->id,
                    'order_id' => 1,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'company_name' => $request->company_name,
                    'country_id' => $request->country_id,
                    'street_address_l1' => $request->street_address_l1,
                    'street_address_l2' => $request->street_address_l2,
                    'town_city' => $request->town_city,
                    'state' => $request->state,
                    'pin_code' => $request->pin_code,
                    'mobile' => $request->mobile,
                    'email' => $request->cust_email,
                    'order_notes' => $request->order_notes,
                ]
            );


            if ($getCustomerAddress) {
                $getOrders = new Order;
                $getOrders->user_id = $getEmailExists->id;
                $getOrders->payment_type = $request->payment_type;
                $getOrders->paymentccdetails = $request->paymentccdetails;
                $getOrders->depositpercentage = $request->depositepercentage;
                $getOrders->status = 0;
                $getOrders->save();

                if ($getOrders) {
                    $getSessionProductData = session('cart');
                    if (isset($getSessionProductData) && !empty($getSessionProductData)) {
                        $rrpTotal = 0;
                        $shopPriceTotal = 0;
                        $salePriceTotal = 0;
                        $savePriceTotal = 0;
                        $finalPriceTotal = 0;
                        $vat = 0;
                        $depositedPriceTotal = 0;
                        foreach ($getSessionProductData as $key => $getProduct) {
                            $rrpTotal += isset($getProduct['rrp_price']) ? $getProduct['rrp_price'] : 0;
                            $shopPriceTotal += isset($getProduct['shop_price']) ? $getProduct['shop_price'] : 0;
                            $salePriceTotal += isset($getProduct['price']) ? $getProduct['price'] : 0;
                            $savePriceTotal += isset($getProduct['savePrice']) ? $getProduct['savePrice'] : 0;
                            $finalPriceTotal += isset($getProduct['price']) ? $getProduct['price'] : 0;
                            $vat += isset($getProduct['vat']) ? $getProduct['vat'] : 0;
                            $depositedPriceTotal += isset($getProduct['deposited_price']) ? $getProduct['deposited_price'] : 0;

                            $getOrderDetails = new OrderDetail;
                            $getOrderDetails->order_id = $getOrders->id;
                            $getOrderDetails->product_id = $key;
                            $getOrderDetails->user_id = $getEmailExists->id;
                            $getOrderDetails->order_product_details = json_encode($getProduct['customArray']);
                            $getOrderDetails->quantity = $getProduct['quantity'];
                            $getOrderDetails->product_price = $getProduct['price'];
                            $getOrderDetails->total_price = $getProduct['quantity'] * $getProduct['price'];
                            $getOrderDetails->deposited_product_price = $getProduct['quantity'] * $getProduct['deposited_price'];
                            $getOrderDetails->final_product_price = $getProduct['quantity'] * $getProduct['price'];
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
                            Order::where('id', $getOrders->id)->update(['custom_order_id' => $getOrders->id . '-' . base64_encode($getEmailExists->id . '-' . $getOrders->id), 'status' => 1, 'deko_status' => 'pending']);
                            session()->put('custom_order_id', $getOrders->id . '-' . base64_encode($getEmailExists->id . '-' . $getOrders->id));
                        }

                        CustomerAddress::where('user_id', $getEmailExists->id)->update([
                            'order_id' => $getOrders->id,
                        ]);

                        Order::where('id', $getOrders->id)->update([
                            'rrp_price' => $rrpTotal,
                            'shop_price' => $shopPriceTotal,
                            'sale_price' => $salePriceTotal,
                            'save_price' => $savePriceTotal,
                            'vat_price' => $vat,
                            'final_price' => $salePriceTotal,
                            'total_price' => $salePriceTotal,
                            'deposited_price' => $salePriceTotal,
                        ]);

                        return response()->json(['status' => 200, 'msg' => 'Order added', 'order_dt' => $getOrders->id]);
                        
                    }
                }
                return response()->json(['status' => 200, 'msg' => 'Order partially added']);
            }
        }
        return response()->json(['status' => 500, 'msg' => 'Order is not submitted']);
    }
}
