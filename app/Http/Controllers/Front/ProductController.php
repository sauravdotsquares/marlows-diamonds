<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use SoapClient;
use Rapnet;
use App\Repnet\nusoap;

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
            // echo "<pre>";
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

    public function getIds()
    {
        $ids =  [$this->id];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getIds());
        }
        return $ids;
    }

    public function getProductList(Request $request)
    {
        $getParentData = Category::where('status',1)->where('id',$request->cate_id)->select('id','parent_id')->first()->toArray();

        $blankArray = [];
        foreach($getParentData as $key1 => $valueArray1){
            if($key1 == 'id'){
                array_push($blankArray,$valueArray1);
            }
            if($key1 == 'parent_cate'){
                if(is_array($valueArray1)){
                    foreach($valueArray1 as $key2 => $valueArray2){
                        if($key2 == 'id'){
                            array_push($blankArray,$valueArray2);
                        }
                        if($key2 == 'parent_cate'){
                            if(is_array($valueArray2)){
                                foreach($valueArray2 as $key3 => $valueArray3){
                                    if($key3 == 'id'){
                                        array_push($blankArray,$valueArray3);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
       
        $getCateProductId = array();

        if(count($blankArray)){
            foreach($blankArray as $prKey => $proVal){
                $getProductList = Products::whereRaw("find_in_set('".$proVal."',categories)")
                ->pluck('id')->toArray();
               
                array_push($getCateProductId,$getProductList);
            }
        }
        $output = array_unique(call_user_func_array('array_merge', $getCateProductId));


        $getProductListFinal = Products::with('getProductImages')->whereIn('id',$output)->simplePaginate(4);

        if(isset($getProductListFinal) && !empty($getProductListFinal)){
            $view = view('front.ajax.productlistajax',compact('getProductListFinal'))->render();
        }else{
            $view = '';
            $getProductListFinal = '';
        }



        return response()->json(['page'=> $getProductListFinal,'html'=>$view]);
        // echo "<pre>";
        // print_r($view);
        // die;

        // echo "<pre>";
        // print_r($getProductListFinal);
        // die;

        // $cateArrayData = [];
        // $getnewArray = $this->getSingleArray($cateArrayData,$getParentData,0);
        // print_r($getnewArray);
        // die;

        // $getProductIds = Products::where()->

        // if(isset($getParentData) && !empty($getParentData) && $getParentData['parent_id'] == 0){
        //     $catId = $getParentData['id'];
        //     $getProductList = Products::whereRaw("find_in_set('".$catId."',categories)")
        //     ->get();
        // }

        // echo "aad<pre>";
        // print_r($catId);
        // print_r($getParentData);
        // die;
    }

    public function getSingleArray($blankArray,$cateArray,$level=0)
    {   
        $level++;
        if(count($cateArray)){
            foreach($cateArray as $key => $val){
                if($key == 'id'){
                    $blankArray[$level]= $val;
                }
                if($key == 'parent_cate'){
                    if(is_array($val)){
                        $this->getSingleArray($blankArray,$val,$level);
                    }
                }
            }
        }

        return json_encode($blankArray);
    }

    public function getRepNetAPI(Request $request)
    {
        Rapnet::setDiamondParams(
            // $request->input('diamond_shape'),
            // $request->input('carat_weight'),
            // $request->input('diamond_color'),
            // $request->input('estimated_clarity')
            'ROUND',
            '0.3',
            'D',
            'IF'
        );
        // $getData = Rapnet::setDiamondParams(
        //     $request->input('Round'),
        //     $request->input('0.30'),
        //     $request->input('I'),
        //     $request->input('VVS2')
        // );
        
        $price = Rapnet::getPrice();
        
        echo "Testing again ada da adsd <pre>";
        print_r($price);
        die;  
        
    }

    public function getNewRepNetFunction(Type $var = null)
    {

        $client = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL",
        array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );
        
        $params = array('Username'=>'95503', 'Password'=>'@diamond1');
        $client->__soapCall("Login", array($params), NULL, NULL, $output_headers);
    
        $ticket = $output_headers["AuthenticationTicketHeader"]->Ticket;
    
        $client1 = new SoapClient("https://technet.rapaport.com/WebServices/RetailFeed/Feed.asmx?WSDL", array( "trace" => 1, "exceptions" => 0, "cache_wsdl" => 0) );
    
        $ns = "http://technet.rapaport.com/";
        $headerBody = array("Ticket" => $ticket);
        $header = new \SoapHeader($ns, 'AuthenticationTicketHeader', $headerBody);
        $client1->__setSoapHeaders($header);
    
        $searchParams = array(
            "ShapeCollection" => array("ROUND", "PEAR"),
            "LabCollection" => array("GIA"),
            "ColorFrom" => "D",
            "ColorTo" => "J",
            "ClarityFrom" => "IF",
            "ClarityTo" => "I1",
            "SizeFrom" => "0.3",
            "SizeTo" => "1.5",
            "CutFrom" => "EXCELLENT",
            "CutTo" => "GOOD",
            "GirdleSizeMin" => "EXTR_THICK",
            "GirdleSizeMax" => "SLIGHTLY_THICK",
            "TablePercentFrom" => "48.2",
            "TablePercentTo" => "73.4",
            "DepthPercentFrom" => "33.86",
            "DepthPercentTo" => "73.8",
            "MeasLengthFrom" => "3.7",
            "MeasLengthTo" => "6.4",
            "MeasWidthFrom" => "2.8",
            "MeasWidthTo" => "7.9",
            "MeasDepthFrom" => "2.7",
            "MeasDepthTo" =>"3.86",
            "PriceFrom" => "1",
            "PriceTo" => "999999",
            "PageNumber" => 1,
            "PageSize" => 25,
            "SortDirection" => "ASC",
            "SortBy" => "PRICE"
        );
    
    
        $params1 = array("SearchParams" => $searchParams, "DiamondsFound" => 0);
        $results=$client1->__soapCall("GetDiamonds", array($params1), NULL, NULL, $output_headers);
    
        //You can improve performance by making the first login request over HTTPS, like above, and the second request to get the diamonds over HTTP.
    
        echo '<h2>Result diamonds</h2><pre>';
        print_r($results);
    }

}
