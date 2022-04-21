<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;

class WishlistController extends Controller
{
    public function index(){
        return view('front.pages.products-wishlists');
    }

    public function addToWishlist(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // die;
        $productData = Products::with('getProductImages','getProductVariation')->where('slug',$request->slug)->first();
        
        // echo "sfa<pre>";
        // print_r($request->all());
        // print_r($productData);
        // die;

        if(isset($productData) && !empty($productData)){
            
            if(isset($productData) && !empty($productData->title)){
                $titleHtml = $productData->title.'<br>Metal Colour:-'.$request->metalcolor.'<br>Finger Size:- '.$request->fingersize.'<br>DiamondShape:-'.$request->color.'<br>Diamond Carat:-'.$request->carat.'<br>Diamond Colour:- '.$request->color.'<br>Diamond Cut Grade:- '.$request->grade.'<br>Diamond Clarity:- '.$request->clarity.' <br> Certificate:- '.$request->certificate.'<br>Certificate Link:- <a href="'.$request->color.'" >View Certificate</a><br>Image:-<a href="'.$request->color.'" >ViewDiamond</a><br>Certificate:- '.$request->color.'';
            }else{
                $titleHtml = '';
            }
    
            // return response()->json($productData);
    
            $wishlist = session()->get('wishlist', []);
            
            if(isset($wishlist[$productData->id])) {
                // echo "if";
                // die;
                return response()->json(['error'=>'Already added!']);
            } else {
                $wishlist[$productData->id] = [
                    "name" => $titleHtml,
                    "price" => $request->price,
                    "added_date" => date('M d, Y'),
                    "stock_status"=> "In stock",
                    "image" => $productData->getProductImages->image_url
                ];
            }
            session()->put('wishlist', $wishlist);
            return response()->json(['wishcount'=>count((array) session('wishlist')),'success'=>'Product added to wishlist successfully!']);
            // return redirect()->back()->with('success', 'Product added to cart successfully!');
        }else{
            return response()->json(['error'=>'Not Match']);
        }
    }

}
