<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

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
        // echo "<pre>";
        // print_r();
        // die;

        return view('front.pages.cart');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart(Request $request)
    {
        $productData = Products::with('getProductImages','getProductVariation')->where('slug',$request->slug)->first();
        
        // echo "sfa<pre>";
        // print_r($request->all());
        // print_r($productData);
        // die;

        if(isset($productData) && !empty($productData->title)){
            $titleHtml = $productData->title.'<br>Metal Colour:-'.$request->metalcolor.'<br>Finger Size:- '.$request->fingersize.'<br>DiamondShape:-'.$request->color.'<br>Diamond Carat:-'.$request->carat.'<br>Diamond Colour:- '.$request->color.'<br>Diamond Cut Grade:- '.$request->grade.'<br>Diamond Clarity:- '.$request->clarity.' <br> Certificate:- '.$request->certificate.'<br>Certificate Link:- <a href="'.$request->color.'" >View Certificate</a><br>Image:-<a href="'.$request->color.'" >ViewDiamond</a><br>Certificate:- '.$request->color.'';
        

            // return response()->json($productData);

            $cart = session()->get('cart', []);
    
            if(isset($cart[$productData->id])) {
                $cart[$productData->id]['quantity']++;
            } else {
                $cart[$productData->id] = [
                    "name" => $titleHtml,
                    "quantity" => 1,
                    "price" => $request->price,
                    "image" => $productData->getProductImages->image_url
                ];
            }
            session()->put('cart', $cart);

            return response()->json(['cartcount'=>count((array) session('cart')),'success'=>'Product added to cart successfully!']);
            // return redirect()->back()->with('success', 'Product added to cart successfully!');
        }else{
            return response()->json(['error'=>'Not Match']);
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
            session()->flash('success', 'Product removed successfully');
        }
    }

    
    public function checkoutOrder(Request $request)
    {
        return view('front.pages.checkout');
    }

    
}
