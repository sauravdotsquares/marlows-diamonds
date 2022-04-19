<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function getProductFinalPrice(Request $request){
        
        $disValue = 10;
        
        $catId = $request->cat_id;
        $displayPrice = $request->display_price;
        $diamondPrice = $request->diamond_price;
        $vatValue = $request->cat_id;

        $settingPrice = $displayPrice * 1.3;
        $diamondPrice = $diamondPrice * 1.2;

        $disPrice = round($settingPrice/$disValue);

        $remainingTotal = $displayPrice - $disPrice;
         
    }
}
