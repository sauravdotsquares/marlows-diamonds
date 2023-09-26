<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
use Illuminate\Http\Request;
use App\Models\AppProducts;
use App\Models\Products\AppWishList;
use View;

class AppWishListController extends Controller{
    

    public function __construct(){
        $this->view_path = "admin.app_products.products.";
        $this->default_pagination_limit = 12;
        $this->module_name = "Products";
        $this->route_path = "admin.app_products.";
    }   

    /**
     * addToWishList
     * @param productSlug
     */
    public function addToWishList(Request $request){
        
        if(auth()->guard('customer')->check()){
            $userId = auth()->guard('customer')->user()->id;
            $isSession = 0;
        }else{
            $userId = session()->getId();
            $isSession = 1;
        }

        /** Check if product is valid or not */
        $product = AppProducts::select(['id','slug'])->where(['slug'=> $request['productSlug']])->first();
        if(empty($product)){
            return response()->json([
                'status' => false,
                'message' => "Product not identified"
            ]);
        }

        /** if product is already in wishlist then remove other add product in wishlist */
        $exist = AppWishList::where(['is_deleted'=>0, 'user_id'=> $userId, 'product_id' => $product->id])->first();
        if(empty($exist)){
            if(!empty($product)){
                $new_item = new AppWishList();
                $new_item->user_id = $userId;
                $new_item->is_session = $isSession;
                $new_item->product_id = $product->id;
                $new_item->save();
            }
            return response()->json([
                'status' => true,
                'wishlist_status' => true
            ]);
        }else{
            $exist->is_deleted = 1;
            $exist->save();
            return response()->json([
                'status' => true,
                'wishlist_status' => false
            ]);
        }
    }//endof addToWishList

}