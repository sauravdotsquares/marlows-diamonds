<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;

class ProductController extends Controller
{
    public function productCategory($cat1=null,$cat2=null,$cat3=null)
    {
        if($cat3 != null){
            // echo "cat3";
            $getCatId = Category::where('slug', $cat3)->first();
            if(isset($getCatId) && !empty($getCatId)){
                $getProduct = Products::where('categories',$getCatId)->get();
            }else{
                return view('layouts.errors.404');
            }
        }elseif($cat2 != null){
            // echo "cat2";
            $getCatId = Category::where('slug', $cat2)->first();
            if(isset($getCatId) && !empty($getCatId)){
                $getProduct = Products::where('categories',$getCatId)->get();
            }else{
                return view('layouts.errors.404');
            }
        }elseif($cat1 !=null){
            // echo "cat1<pre>";
            $getCatId = Category::where('slug', $cat1)->first();
           
            if(isset($getCatId) && !empty($getCatId)){
                // $getProduct = Products::whereRaw("find_in_set('".$getCatId[0]."',categories)")->get();

                // return response()->json($getProduct);
                // print_r($getProduct);
                // die;
            }else{
                return view('layouts.errors.404');
            }
        }else{
            return view('layouts.errors.404');
        }

        // echo "<pre>";
        // print_r($getCatId);
        // die;

        return view('front.pages.product-listing',['data'=>$getCatId]);
    }

    public function productDetails($productSlug = null)
    {   
        if($productSlug !=null){
            $getProduct = Products::where('slug',$productSlug)->first();

            // echo "checking <pre>";
            // print_r($getProduct);
            // die;

            if(isset($getProduct) && !empty($getProduct)){
                return view('front.pages.product-details',['data'=>$getProduct]);
            }else{
                return view('layouts.errors.404');
            }
        }else{
            return view('layouts.errors.404');
        }
    }

}
