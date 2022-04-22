<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function getProductFinalPrice(Request $request){
        
        // $variationPrice = $CurrentVariationPrice * 1.3;

        $settingPrice = $request->variation_price * 1.2;

        $diamondPrice = $request->diamond_price * 1.2;

        $finalPrice = $settingPrice + $diamondPrice;
        return $finalPrice;
    }
}
