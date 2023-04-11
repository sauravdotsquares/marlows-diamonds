<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Country;
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

        if(!empty($request['diamond_type']) && $request['diamond_type']=='lab_grown' && !empty($request->slug) ){
            /** Add item in cart for lab grown */
            $productData = Products::with('getProductImages','getProductVariation')->where('slug',$request->slug)->first();
            if(!empty($productData)){

                /** If product already exists then show exit message */
                $cart = session()->get('cart', []);
                if(isset($cart[$productData->id])) {
                    return response()->json(['error'=>'This product is already exists in cart']);
                }

                $customArray = [];
                foreach($request->all('') as $key => $value){
                    $customArray[$key]=$value;
                    if(isset($key) && $key == 'jsondata'){
                        foreach($value as $key2 => $value2){
                            $customArray[$key2]=$value2;
                        }
                    }
                }
                $customArray['Clarity'] = !empty($request['lab_grown_clarity']) ? $request['lab_grown_clarity'] : '';
                $customArray['Color'] = !empty($request['lab_grown_colour']) ? $request['lab_grown_colour'] : '';
                $customArray['Carat'] = !empty($request['lab_grown_carat']) ? $request['lab_grown_carat'] : '';
                $customArray['choose_diamond'] = !empty($request['diamond_type']) ? $request['diamond_type'] : '';
                
                unset($customArray['jsondata']);
                unset($customArray['_token']);
                unset($customArray['CertificateLink']);
                unset($customArray['ImageLink']);
                unset($customArray['CERT_NO']);
                unset($customArray['Lab']);
                
                $cart[$productData->id] = [
                    "name" => $productData->title,
                    'customArray'=> $customArray,
                    "quantity" => 1,
                    "price" => $request['lab_grown_price'],
                    "vat" => getVATPriceFunction($request['setting_price']),
                    "image" => $productData->getProductImages->image_url
                ];

                session()->put('cart', $cart);
                return response()->json(['cartcount'=>count((array) session('cart')),'success'=>'Product added to cart successfully!']);
            }

            
        }

        if(isset($request['price']) && !empty($request['price'])){

            $customArray = [];
            foreach($request->all('') as $key => $value){
                $customArray[$key]=$value;
                if(isset($key) && $key == 'jsondata'){
                    foreach($value as $key2 => $value2){
                        $customArray[$key2]=$value2;
                    }
                }
            }
            unset($customArray['jsondata']);
            unset($customArray['_token']);

            $productData = Products::with('getProductImages','getProductVariation')->where('slug',$request->slug)->first();

            $input = $request->all('');
            unset($request['slug']);
            unset($request['price']);
            unset($request['setting_price']);
            unset($request['_token']);
            unset($request['jsondata']);


            // prd($customArray);

            $titleHtml = '';


            if(isset($productData) && !empty($productData->title)){
                // $titleHtml .= '<div class="cartproduct-title"><a href="'.env('APP_URL').'/'.'product/'.$input['slug'].'">'.$productData->title.'</a></div> <dl class="variation">';
                $selectedAttributes = [];
                foreach($request->all('') as $key => $finalVal){
                    $selectedAttributes['title'] = $productData->title;
                    $selectedAttributes[$key] = $finalVal;
                    if($key == 'certificatelink'){
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Certificate</a></dd>';
                    }elseif($key == 'imagelink'){
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Image</a></dd>';
                    }else{
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><p>:-'.ucwords($finalVal).'</p></dd>';
                    }
                }
                $titleHtml .= ' </dl>';

                $cart = session()->get('cart', []);
                
                if(isset($cart[$productData->id])) {
                    return response()->json(['error'=>'This product is already exists in cart']);
                    // $cart[$productData->id]['quantity']++;
                } else {
                    
                    $customArray['choose_diamond'] = !empty($request['diamond_type']) ? $request['diamond_type'] : $request['choose_diamond']  ;
                    
                    $cart[$productData->id] = [
                        "name" => $productData->title,
                        // "selected_parameter"=> $selectedAttributes,
                        'customArray'=> $customArray,
                        "quantity" => 1,
                        "price" => $input['price'],
                        "deposited_price" => $input['price'],
                        "vat" => getVATPriceFunction($input['setting_price']),
                        "image" => $productData->getProductImages->image_url
                    ];
                }
                session()->put('cart', $cart);

                return response()->json(['cartcount'=>count((array) session('cart')),'success'=>'Product added to cart successfully!']);
            }else{
                return response()->json(['error'=>'Not Match']);
            }
        }else{
            return response()->json(['error'=>'Please Wait...']);
        }
    }

    public function addToCartDiamond(Request $request)
    {

        if(isset($request->CERT_NO) && !empty($request->CERT_NO) && $request->CERT_NO > 0){

            $input = $request->all('');
            unset($request['slug']);
            unset($request['price']);
            unset($request['partial_amount']);
            unset($request['total_amount']);
            unset($request['_token']);

            // $titleHtml = '';

            // $titleHtml .= '<div class="cartproduct-title">Custom Diamond</div> <dl class="variation">';
            $selectedAttributes = [];
            foreach($request->all('') as $key => $finalVal){
                // $selectedAttributes['title'] = 'Custom Diamond';
                if(isset($finalVal) && !empty($finalVal)){
                    $selectedAttributes[$key] = $finalVal;
                    // if($key == 'certificatelink'){
                    //     $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                    //     $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Certificate</a></dd>';
                    // }elseif($key == 'imagelink'){
                    //     // Image Link is shown blank
                    // }else{
                    //     $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                    //     $titleHtml .= '<dd class="variation-Colour"><p>:-'.ucwords($finalVal).'</p></dd>';
                    // }


                }
            }
            // $titleHtml .= ' </dl>';

            $cart = session()->get('cart', []);
            // echo "<pre>";
            // print_r($selectedAttributes);
            // // print_r($request->all(''));
            // die;
            if(isset($cart[$request->CERT_NO])) {
                // $cart[$request->CERT_NO]['quantity']++;
            } else {
                $cart[$request->CERT_NO] = [
                    "name" => 'Custom Diamond',
                    "customArray"=> $selectedAttributes,
                    "quantity" => 1,
                    "price" => $input['price'],
                    "deposited_price" => $input['partial_amount'],
                    "vat" => getVATPriceFunction($input['partial_amount']),
                    "image" => ''
                ];
            }
            session()->put('cart', $cart);

            return response()->json(['cartcount'=>count((array) session('cart')),'success'=>'Product added to cart successfully!']);
        }else{
            return response()->json(['error'=>'Not Added...']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
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
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['status'=>200,'msg'=>'Product removed successfully']);
        }
    }


    public function checkoutOrder(Request $request)
    {
        $dekoEnabled = true;
        $client = new DekoPayApiClient('','', env('DEKOPAY_API_KEY'));
        $pay_url =  env('DEKOPAY_MODE');

        if($dekoEnabled){
            $url = $pay_url == 'live' ? 'https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key='.env('DEKOPAY_API_KEY')  : 'https://test.dekopay.com/js_api/FinanceDetails.js.php?api_key='.env('DEKOPAY_API_KEY');
        }

        $cart = session()->get('cart');
        if(isset($cart) && !empty($cart)){
            $getCountries = Country::get();
            $getUsersDetails = [];
            if(auth()->guard('customer')->check()){
                $getUsersDetails = User::with('getCustomerAddressFunction')->where('id',Auth::user()->id)->first();
            }
            return view('front.pages.checkout',compact('getCountries','getUsersDetails','url'));
        }
        return redirect()->route('home');
    }
}
