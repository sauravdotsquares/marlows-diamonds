<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\ProductController;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Country;
use App\Models\CouponCodeDetail;
use App\Models\User;
use Auth;
use billythekid\dekopay\Core\DekoPayApiClient;

class AddToCartController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $cart = session()->get('cart');
        return view('front.pages.cart');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request)
    {
        $getActualPrice = new ProductController;
        $getPriceFunction = $getActualPrice->getProductVariationPrices($request);


        if (!empty($request['diamond_type']) && $request['diamond_type'] == 'lab_grown' && !empty($request->slug)) {
            /** Add item in cart for lab grown */
            $productData = Products::with('getProductImages', 'getProductVariation')->where('slug', $request->slug)->first();
            if (!empty($productData)) {

                /** If product already exists then show exit message */
                $cart = session()->get('cart', []);
                if (isset($cart[$productData->id])) {
                    return response()->json(['error' => 'This product is already exists in cart']);
                }

                $customArray = [];
                foreach ($request->all('') as $key => $value) {
                    // if ($key == 'fingersize') {
                    //     $getFingerValueVariable = checkFingerSizeAvailable($value);
                    //     if($getFingerValueVariable === false){
                    //         return response()->json(['error' => 'Not Match']);
                    //     }
                    // }
                    $customArray[$key] = $value;
                    if (isset($key) && $key == 'jsondata') {
                        foreach ($value as $key2 => $value2) {
                            $customArray[$key2] = $value2;
                        }
                    }
                }
                $customArray['Clarity'] = !empty($request['clarity']) ? $request['clarity'] : '';
                $customArray['Color'] = !empty($request['color']) ? $request['color'] : '';
                $customArray['Carat'] = !empty($request['carat']) ? $request['carat'] : '';
                $customArray['choose_diamond'] = !empty($request['diamond_type']) ? $request['diamond_type'] : '';

                unset($customArray['jsondata']);
                unset($customArray['_token']);
                unset($customArray['CertificateLink']);
                unset($customArray['ImageLink']);
                unset($customArray['CERT_NO']);
                unset($customArray['Lab']);

                $cart[$productData->id] = [
                    "name" => $productData->title,
                    'customArray' => $customArray,
                    "quantity" => 1,
                    // "price" => $request['lab_grown_price'],
                    "deposited_price" => $getPriceFunction['allPrices']['discounted_price'],
                    "vat" => getVATPriceFunction($request['setting_price']),
                    "image" => $productData->getProductImages->image_url,
                    "price_front" => $request['lab_grown_price'],
                    "rrp_price"=> $getPriceFunction['allPrices']['rrp_price'],
                    "shop_price"=> $getPriceFunction['allPrices']['shop_price'],
                    'price' => $getPriceFunction['allPrices']['discounted_price'],
                    "savePrice"=> $getPriceFunction['allPrices']['rrp_price'] - $getPriceFunction['allPrices']['discounted_price'],
                    "deposited_price" => $getPriceFunction['allPrices']['discounted_price'],
                    'getLabDiamondPrices' => $getPriceFunction['getLabDiamondPrices'],
                ];

                session()->put('cart', $cart);
                return response()->json(['cartcount' => count((array) session('cart')), 'success' => 'Product added to cart successfully!']);
            }
        }

        if (isset($request['price']) && !empty($request['price'])) {

            $customArray = [];
            foreach ($request->all('') as $key => $value) {
                $customArray[$key] = $value;
                if (isset($key) && $key == 'jsondata') {
                    foreach ($value as $key2 => $value2) {
                        $customArray[$key2] = $value2;
                    }
                }
            }
            unset($customArray['jsondata']);
            unset($customArray['_token']);

            $productData = Products::with('getProductImages', 'getProductVariation')->where('slug', $request->slug)->first();

            $input = $request->all('');
            unset($request['slug']);
            unset($request['price']);
            unset($request['shopPrice']);
            unset($request['savePrice']);
            unset($request['rrpPrice']);
            unset($request['setting_price']);
            unset($request['_token']);
            unset($request['jsondata']);
     

            
            // prd($customArray);

            $titleHtml = '';


            if (isset($productData) && !empty($productData->title)) {
                // $titleHtml .= '<div class="cartproduct-title"><a href="'.env('APP_URL').'/'.'product/'.$input['slug'].'">'.$productData->title.'</a></div> <dl class="variation">';
                $selectedAttributes = [];
                foreach ($request->all('') as $key => $finalVal) {
                    $selectedAttributes['title'] = $productData->title;
                    $selectedAttributes[$key] = $finalVal;
                    // if ($key == 'fingersize') {
                    //     $getFingerValueVariable = checkFingerSizeAvailable($value);
                    //     if($getFingerValueVariable === false){
                    //         return response()->json(['error' => 'Not Match']);
                    //     }
                    // }
                    if ($key == 'certificatelink') {
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Certificate</a></dd>';
                    } elseif ($key == 'imagelink') {
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Image</a></dd>';
                    } else {
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><p>:-'.ucwords($finalVal).'</p></dd>';
                    }
                }
                $titleHtml .= ' </dl>';

                $cart = session()->get('cart', []);

                if (isset($cart[$productData->id])) {
                    return response()->json(['error' => 'This product is already exists in cart']);
                    // $cart[$productData->id]['quantity']++;
                } else {

                    $customArray['choose_diamond'] = !empty($request['diamond_type']) ? $request['diamond_type'] : $request['choose_diamond'];

                    $cart[$productData->id] = [
                        "name" => $productData->title,
                        // "selected_parameter"=> $selectedAttributes,
                        'customArray' => $customArray,
                        "quantity" => 1,
                        // "price" => $input['price'],
                        "deposited_price" => $getPriceFunction['allPrices']['discounted_price'],
                        "vat" => getVATPriceFunction($input['setting_price']),
                        "price_front" => $getPriceFunction['allPrices']['discounted_price'],
                        "rrp_price"=> $getPriceFunction['allPrices']['rrp_price'],
                        "shop_price"=> $getPriceFunction['allPrices']['shop_price'],
                        'price' => $getPriceFunction['allPrices']['discounted_price'],
                        "savePrice"=> $getPriceFunction['allPrices']['rrp_price'] - $getPriceFunction['allPrices']['discounted_price'],
                        "deposited_price" => $getPriceFunction['allPrices']['discounted_price'],
                        'getLabDiamondPrices' => $getPriceFunction['getLabDiamondPrices'],
                        "image" => $productData->getProductImages->image_url
                    ];
                }
                session()->put('cart', $cart);

                return response()->json(['cartcount' => count((array) session('cart')), 'success' => 'Product added to cart successfully!']);
            } else {
                return response()->json(['error' => 'Not Match']);
            }
        } else {
            return response()->json(['error' => 'Please Wait...']);
        }

    }

    public function addToCartDiamond(Request $request)
    {

        if (isset($request->CERT_NO) && !empty($request->CERT_NO) && $request->CERT_NO > 0) {

            $input = $request->all('');
            unset($request['slug']);
            unset($request['price']);
            unset($request['partial_amount']);
            unset($request['total_amount']);
            unset($request['_token']);

            
            $selectedAttributes = [];
            foreach ($request->all('') as $key => $finalVal) {
                if($key == 'Carat'){
                    $getCaratStatus = checkCaratDiamondValue($finalVal);
                    if($getCaratStatus === false){
                        return response()->json(['error' => 'Something went wrong...']);
                    }
                }else if($key == 'Shape'){
                    $getDiamondShapeStatus = checkDiamondTypeValue($finalVal);
                    if($getDiamondShapeStatus === false){
                        return response()->json(['error' => 'Something went wrong...']);
                    }
                }else if($key == 'Color'){
                    $getDiamondColourStatus = checkDiamondColourValue($finalVal);
                    if($getDiamondColourStatus === false){
                        return response()->json(['error' => 'Something went wrong...']);
                    }
                }else if($key == 'Clarity'){
                    $getDiamondClarityStatus = checkDiamondClarityValue($finalVal);
                    if($getDiamondClarityStatus === false){
                        return response()->json(['error' => 'Something went wrong...']);
                    }
                }else if($key == 'Cut'){
                    $getDiamondCutGradeStatus = true;
                    if($getDiamondCutGradeStatus === false){
                        return response()->json(['error' => 'Something went wrong...']);
                    }
                }else if($key == 'Lab'){
                    $getDiamondLabStatus = checkDiamondLabValue($finalVal);
                    if($getDiamondLabStatus === false){
                        return response()->json(['error' => 'Something went wrong...']);
                    }
                }
                if (isset($finalVal) && !empty($finalVal)) {
                    $selectedAttributes[$key] = $finalVal;
                }
            }

            $cart = session()->get('cart', []);  
            if (isset($cart[$request->CERT_NO])) {
                // $cart[$request->CERT_NO]['quantity']++;
            } else {
                $cart[$request->CERT_NO] = [
                    "name" => 'Custom Diamond',
                    "customArray" => $selectedAttributes,
                    "quantity" => 1,
                    "price" => isset($input['total_amount']) ? floatval(preg_replace('/[^\d.]/', '', $input['total_amount'])) : $input['price'],
                    "deposited_price" => floatval(preg_replace('/[^\d.]/', '', $input['partial_amount'])),
                    "vat" => getVATPriceFunction($input['partial_amount']),
                    "image" => ''
                ];
            }
            session()->put('cart', $cart);

            return response()->json(['cartcount' => count((array) session('cart')), 'success' => 'Product added to cart successfully!']);
        } else {
            return response()->json(['error' => 'Not Added...']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function updateCartCouponCode(Request $request)
    // {
    //     if ($request->cartid && $request->coupon_code) {
    //         $cart = session()->get('cart');
    //         $validateCouponCode = CouponCodeDetail::where('coupon_code',$request->coupon_code)->where('diamond_type',$cart[$request->cartid]['customArray']["choose_diamond"])->first();
    //         if((isset($validateCouponCode) && !empty($validateCouponCode))){
    //             if(isset($cart[$request->cartid]["couponCodeText"]) && !empty($cart[$request->cartid]["couponCodeText"])){
    //                 $key = 'deposited_price';
    //                 $sumDepositedPrice = array_sum(array_column($cart,$key));
                    
    //                 $result = [
    //                     'pre_deposited_price' => round($cart[$request->cartid]["pre_deposited_price"],2),
    //                     'deposited_price' => round($cart[$request->cartid]["deposited_price"],2),
    //                     'status' => 200,
    //                     'statustext' => 'Already Applied',
    //                     'errormsg' => 'Coupon Code is valid',
    //                     'finalPrice' => round($sumDepositedPrice,2)
    //                 ];
    //                 return $result;
    //             }else{
    //                 $cart[$request->cartid]["cartId"] = $request->cartid;
    //                 $cart[$request->cartid]["couponCodeText"] = $request->coupon_code;
    //                 $cart[$request->cartid]["couponCodePercentage"] = 10;
    //                 $cart[$request->cartid]["pre_deposited_price"] = $cart[$request->cartid]["deposited_price"];
    //                 $cart[$request->cartid]["deposited_price"] = $cart[$request->cartid]["deposited_price"] * (1 - ($validateCouponCode->discount/100));
    
    //                 session()->put('cart', $cart);
    //                 session()->flash('success', 'Cart updated successfully');
    
    //                 $key = 'deposited_price';
    //                 $sumDepositedPrice = array_sum(array_column($cart,$key));
    
    //                 $result = [
    //                     'pre_deposited_price' => round($cart[$request->cartid]["pre_deposited_price"],2),
    //                     'deposited_price' => round($cart[$request->cartid]["deposited_price"],2),
    //                     'status' => 500,
    //                     'statustext' => 'Applied',
    //                     'errormsg' => 'Coupon Code is valid',
    //                     'finalPrice' => round($sumDepositedPrice,2)
    //                 ];
    //                 return $result;
    //             }
    //         }else{
    //             $cart[$request->cartid]["deposited_price"] = $cart[$request->cartid]["pre_deposited_price"];
    //             $cart[$request->cartid]["couponCodeText"] = '';
    //             $cart[$request->cartid]["cartId"] = '';
    //             $cart[$request->cartid]["couponCodePercentage"] = '';
    //             session()->put('cart', $cart);

    //             $key = 'deposited_price';
    //             $sumDepositedPrice = array_sum(array_column($cart,$key));
                
    //             $result = [
    //                 'pre_deposited_price' => round($cart[$request->cartid]["pre_deposited_price"],2),
    //                 'deposited_price' => round($cart[$request->cartid]["deposited_price"],2),
    //                 'status' => 500,
    //                 'statustext' => 'Apply',
    //                 'errormsg' => 'Coupon Code is not valid',
    //                 'finalPrice' => round($sumDepositedPrice,2)
    //             ];
    //             return $result;
    //         }
    //     }
    // }

    public function updateCartCouponCode(Request $request)
    {
        if(isset($request->priceStatus) && $request->priceStatus == 1){
            $cart = session()->get('cart');
            $cart[$request->cartid]["deposited_price"] = $cart[$request->cartid]["price"] + $request->price;
            $cart[$request->cartid]["couponCodeText"] = '';
            $cart[$request->cartid]["cartId"] = '';
            $cart[$request->cartid]["priceStatus"] = 1;
            $cart[$request->cartid]["yearlySupportStatus"] = ($request->price>1)?1:0;
            $cart[$request->cartid]["yearlySupport"] = $request->price;
            $cart[$request->cartid]["couponCodePercentage"] = '';
            session()->put('cart', $cart);

            $sumDepositedPrice = array_sum(array_column($cart,'deposited_price'));

            $result = [
                'sessionCartValues' => $cart,
                'status' => 500,
                'statustext' => 'Apply',
                'errormsg' => 'Applied',
                'finalPrice' => round($sumDepositedPrice,2)
            ];
        }elseif(isset($request->priceStatus) && $request->priceStatus == 0){
            $cart = session()->get('cart');
            $cart[$request->cartid]["deposited_price"] = $cart[$request->cartid]["price"] - $request->price;
            $cart[$request->cartid]["couponCodeText"] = '';
            $cart[$request->cartid]["cartId"] = '';
            $cart[$request->cartid]["priceStatus"] = 0;
            $cart[$request->cartid]["couponCodePercentage"] = '';
            session()->put('cart', $cart);

            $sumDepositedPrice = array_sum(array_column($cart,'deposited_price'));

            $result = [
                'sessionCartValues' => $cart,
                'status' => 500,
                'statustext' => 'Apply',
                'errormsg' => 'Removed',
                'finalPrice' => round($sumDepositedPrice,2)
            ];
        }else{
            $cart = session()->get('cart');
            foreach($cart as $key => $valueData){
                if(isset($request->coupon_code) && $request->coupon_code != '' && $request->coupon_status == 1){
                    $validateCouponCode = CouponCodeDetail::where('coupon_code',$request->coupon_code)->where('diamond_type',$cart[$request->cartid]['customArray']["choose_diamond"])->first();
                    if((isset($validateCouponCode) && !empty($validateCouponCode))){ 
                       
                        if(isset($cart[$key]["couponCodeText"]) && !empty($cart[$key]["couponCodeText"])){
                            $validationMessage = "Coupon code is applied";
                            $statusText = "Applied";
                        }else{
                            if(isset($valueData['customArray']['diamond_type']) && $valueData['customArray']['diamond_type'] == 'lab_grown') {
                                $cart[$key]["cartId"] = $request->cartid;
                                $cart[$key]["couponCodeText"] = $request->coupon_code;
                                $cart[$key]["couponCodePercentage"] = $validateCouponCode->discount;
                                $cart[$key]["pre_deposited_price"] = $valueData["deposited_price"];
                                $cart[$key]["deposited_price"] = $valueData["deposited_price"] * (1 - ($validateCouponCode->discount/100));
                                session()->put('cart', $cart);
    
                                $validationMessage = "Coupon code is valid";
                                $statusText = "Applied";
                            }else{
                                $validationMessage = "Coupon code is not valid";
                                $statusText = "Apply";
                            }
                        }
                    }else{
                        $validationMessage = "Coupon code is not valid";
                        $statusText = "Apply";
                    }
                    $sumDepositedPrice = array_sum(array_column($cart,'deposited_price'));
    
                    $result = [
                        'sessionCartValues' => $cart,
                        'status' => 200,
                        'statustext' => $statusText,
                        'errormsg' => $validationMessage,
                        'finalPrice' => round($sumDepositedPrice,2)
                    ];
                    
                }elseif($request->coupon_status == 2){
                    $cart[$key]["deposited_price"] = isset($cart[$key]["pre_deposited_price"])?$cart[$key]["pre_deposited_price"]:$cart[$key]["deposited_price"];
                    $cart[$key]["couponCodeText"] = '';
                    $cart[$key]["cartId"] = '';
                    $cart[$key]["couponCodePercentage"] = '';
                    session()->put('cart', $cart);
    
                    $sumDepositedPrice = array_sum(array_column($cart,'deposited_price'));
    
                    $result = [
                        'sessionCartValues' => $cart,
                        'status' => 500,
                        'statustext' => 'Apply',
                        'errormsg' => 'Coupon Code is Cancelled',
                        'finalPrice' => round($sumDepositedPrice,2)
                    ];
                }else{
                    $sumDepositedPrice = array_sum(array_column($cart,'deposited_price'));
                    $result = [
                        'sessionCartValues' => $cart,
                        'status' => 500,
                        'statustext' => 'Apply',
                        'errormsg' => 'Coupon Code is required',
                        'finalPrice' => round($sumDepositedPrice,2)
                    ];
                }
            }
        }

        $view = view('front.ajax.checkoutorderdetailsscripts')->render();

        $resultArray = [
            'orderview' => $view,
            'result' => $result,
        ];

        return $resultArray;
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['status' => 200, 'msg' => 'Product removed successfully']);
        }
    }


    public function checkoutOrder(Request $request)
    {
        $dekoEnabled = true;
        $client = new DekoPayApiClient('', '', env('DEKOPAY_API_KEY'));
        $pay_url =  env('DEKOPAY_MODE');

        if ($dekoEnabled) {
            $url = $pay_url == 'live' ? 'https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY')  : 'https://test.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY');
        }

        $cart = session()->get('cart');
        if (isset($cart) && !empty($cart)) {
            $getCountries = Country::get();
            $getUsersDetails = [];
            if (Auth::guard('customer')->check() && isset(Auth::guard('customer')->user()->id)) {
                $getUsersDetails = User::with('getCustomerAddressFunction','getCustomerShippingAddressFunction')->where('id', Auth::guard('customer')->user()->id)->first();
            }
            return view('front.pages.checkout', compact('getCountries', 'getUsersDetails', 'url'));
        }
        return redirect()->route('home');
    }
}
