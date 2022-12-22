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

    public function addToWishlist(Request $request){
        $productData = Products::with('getProductImages','getProductVariation')->where('slug',$request->slug)->first();


        if(isset($productData) && !empty($productData)){

            if(isset($productData) && !empty($productData->title)){
                //  $titleHtml = $productData->title.'<br>Metal Colour:-'.$request->metalcolor.'<br>Finger Size:- '.$request->fingersize.'<br>DiamondShape:-'.$request->color.'<br>Diamond Carat:-'.$request->carat.'<br>Diamond Colour:- '.$request->color.'<br>Diamond Cut Grade:- '.$request->grade.'<br>Diamond Clarity:- '.$request->clarity.' <br> Certificate:- '.$request->certificate.'<br>Certificate Link:- <a href="'.$request->color.'" >View Certificate</a><br>Image:-<a href="'.$request->color.'" >ViewDiamond</a><br>Certificate:- '.$request->color.'';

                $titleName = `<a href="{{route('product/')}}/`.$request->slug.`">`.$productData->title.`</a>
                <dl class="variation">
                    <dt class="variation-MetalColour">Metal Colour :
                    </dt>
                    <dd class="variation-MetalColour">`.$request->metalcolor.`</dd>
                    <dt class="variation-FingerSize">Finger Size :
                    </dt>
                    <dd class="variation-FingerSize">`.$request->fingersize.`</dd>
                </dl>
                <dl class="variation">
                    <dt class="variation-carat">carat :
                    </dt>
                    <dd class="variation-carat">`.$request->carat.`</dd>
                    <dt class="variation-diamond-colour">diamond-colour :
                    </dt>
                    <dd class="variation-diamond-colour">`.$request->color.`</dd>
                    <dt class="variation-diamond-clarity">diamond-clarity :
                    </dt>
                    <dd class="variation-diamond-clarity">`.$request->clarity.`</dd>
                    <dt class="variation-diamond-grade">diamond-grade :
                    </dt>
                    <dd class="variation-diamond-grade">`.$request->grade.`</dd>
                    <dt class="variation-diamond-certificate">diamond-certificate :
                    </dt>
                    <dd class="variation-diamond-certificate">`.$request->certificate.`</dd>
                </dl>`;
            }else{
                $titleName = '';
            }

            $wishlist = session()->get('wishlist', []);

            if(isset($wishlist[$productData->id])) {
                return response()->json(['error'=>'Already added!']);
            } else {
                $wishlist[$productData->id] = [
                    "name" => $titleName,
                    "price" => $request->price,
                    "added_date" => date('M d, Y'),
                    "stock_status"=> "In stock",
                    "image" => $productData->getProductImages->image_url
                ];
            }
            session()->put('wishlist', $wishlist);
            return response()->json(['wishcount'=>count((array) session('wishlist')),'success'=>'Product added to wishlist successfully!']);
        }else{
            return response()->json(['error'=>'Not Match']);
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function removeWishlist(Request $request)
    {
        if($request->id) {
            $cart = session()->get('wishlist');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('wishlist', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

}
