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
        if(isset($request['price']) && !empty($request['price'])){

            $productData = Products::with('getProductImages','getProductVariation')->where('slug',$request->slug)->first();

            $input = $request->all('');
            unset($request['slug']);
            unset($request['price']);
            unset($request['_token']);

            $titleHtml = '';

            if(isset($productData) && !empty($productData->title)){
                $titleHtml .= '<div class="cartproduct-title"><a href="'.env('APP_URL').'/'.'product/'.$input['slug'].'">'.$productData->title.'</a></div> <dl class="variation">';
                $selectedAttributes = [];
                foreach($request->all('') as $key => $finalVal){
                    $selectedAttributes['title'] = $productData->title;
                    $selectedAttributes[$key] = $finalVal;
                    if($key == 'certificatelink'){
                        $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Certificate</a></dd>';
                    }elseif($key == 'imagelink'){
                        $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Image</a></dd>';
                    }else{
                        $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        $titleHtml .= '<dd class="variation-Colour"><p>:-'.ucwords($finalVal).'</p></dd>';
                    }
                }
                $titleHtml .= ' </dl>';

                $cart = session()->get('cart', []);

                if(isset($cart[$productData->id])) {
                    $cart[$productData->id]['quantity']++;
                } else {
                    $cart[$productData->id] = [
                        "name" => $titleHtml,
                        "selected_parameter"=> $selectedAttributes,
                        "quantity" => 1,
                        "price" => $input['price'],
                        "image" => $productData->getProductImages->image_url
                    ];
                }
                session()->put('cart', $cart);

                return response()->json(['cartcount'=>count((array) session('cart')),'success'=>'Product added to cart successfully!']);
                // return redirect()->back()->with('success', 'Product added to cart successfully!');
            }else{
                return response()->json(['error'=>'Not Match']);
            }
        }else{
            return response()->json(['error'=>'Please Wait...']);
        }
    }

    public function addToCartDiamond(Request $request)
    {
        if(isset($request->certificate_number) && !empty($request->certificate_number) && $request->certificate_number > 0){

            $input = $request->all('');
            unset($request['slug']);
            unset($request['price']);
            unset($request['_token']);

            $titleHtml = '';

            $titleHtml .= '<div class="cartproduct-title">Custom Diamond</div> <dl class="variation">';
            $selectedAttributes = [];
            foreach($request->all('') as $key => $finalVal){
                $selectedAttributes['title'] = 'Custom Diamond';
                if(isset($finalVal) && !empty($finalVal)){
                    $selectedAttributes[$key] = $finalVal;
                    if($key == 'certificatelink'){
                        $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Certificate</a></dd>';
                    }elseif($key == 'imagelink'){
                        // $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        // $titleHtml .= '<dd class="variation-Colour"><a href="'.$finalVal.'" target="_blank">:-View Image</a></dd>';
                    }else{
                        $titleHtml .= '<dt class="variation-Colour">'.ucwords($key).'</dt>';
                        $titleHtml .= '<dd class="variation-Colour"><p>:-'.ucwords($finalVal).'</p></dd>';
                    }


                }
            }
            $titleHtml .= ' </dl>';

            // echo "<pre>";
            // print_r($selectedAttributes);
            // die;

            $cart = session()->get('cart', []);

            if(isset($cart[$request->certificate_number])) {
                $cart[$request->certificate_number]['quantity']++;
            } else {
                $cart[$request->certificate_number] = [
                    "name" => $titleHtml,
                    "selected_parameter"=> $selectedAttributes,
                    "quantity" => 1,
                    "price" => $input['price'],
                    "image" => ''
                ];
            }
            session()->put('cart', $cart);

            return response()->json(['cartcount'=>count((array) session('cart')),'success'=>'Product added to cart successfully!']);
            // return redirect()->back()->with('success', 'Product added to cart successfully!');

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
            // session()->flash('success', 'Product removed successfully');
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
                // echo "if check ";
                // die;
                $getUsersDetails = User::with('getCustomerAddressFunction')->where('id',Auth::user()->id)->first();
            }
            // if(Auth::user()->id){
            //     echo "Check if".Auth::user()->id;
            // }else{
            //     echo "Check else";
            // }
            // die;
            return view('front.pages.checkout',compact('getCountries','getUsersDetails','url'));
        }
        return redirect()->route('home');
    }
}
