<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use App\Models\RepnetData;
use App\Models\ProductVariationAttributes;
use App\Models\Attributes;
use App\Models\DiamondStock;
use SoapClient;
use Rapnet;
use App\Repnet\nusoap;
use App\Http\Controllers\Front\ApiController;

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
        $getParentData = Category::with('grandchildren')->where('status',1)->where('id',$request->cate_id)->select('id','parent_id')->first()->toArray();

        $getParentHierarchy = array($getParentData['id']);
        foreach($getParentData['grandchildren'] as $keyName => $childId){
            array_push($getParentHierarchy,$childId['id']);
            if(is_array($childId['grandchildren'])){
                foreach($childId['grandchildren'] as $keyName1 => $childId1){
                    array_push($getParentHierarchy,$childId1['id']);
                }
            }
        }

        // return response()->json($getParentHierarchy);

        // $blankArray = [];
        // foreach($getParentData as $key1 => $valueArray1){
        //     if($key1 == 'id'){
        //         array_push($blankArray,$valueArray1);
        //     }
        //     if($key1 == 'parent_cate'){
        //         if(is_array($valueArray1)){
        //             foreach($valueArray1 as $key2 => $valueArray2){
        //                 if($key2 == 'id'){
        //                     array_push($blankArray,$valueArray2);
        //                 }
        //                 if($key2 == 'parent_cate'){
        //                     if(is_array($valueArray2)){
        //                         foreach($valueArray2 as $key3 => $valueArray3){
        //                             if($key3 == 'id'){
        //                                 array_push($blankArray,$valueArray3);
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // }
       
        $getCateProductId = array();

        if(count($getParentHierarchy)){
            foreach($getParentHierarchy as $prKey => $proVal){
                $getProductList = Products::whereRaw("find_in_set('".$proVal."',categories)")
                ->pluck('id')->toArray();
                array_push($getCateProductId,$getProductList);
            }
        }
        $output = array_unique(call_user_func_array('array_merge', $getCateProductId));
        
        // return response()->json($getCateProductId);

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
        $getArray = [
            'caret' => 'DI',
            'Color' => 'D',
        ];

        $getApiController = new ApiController;
        $getActualData = $getApiController->getRepnetApiFunction($getArray);        
        
        RepnetData::truncate();

        foreach($getActualData as $key => $val){
            RepnetData::create([
                'diamond_id'=> $val->DiamondID,
                'shape_title'=> $val->ShapeTitle,
                'weight'=> $val->Weight,
                'color_title'=> $val->ColorTitle,
                'lab_title'=> $val->LabTitle,
                'repnet_price'=> $val->RapNetPrice,
                'final_price'=> $val->FinalPrice,
                'certificate_number'=> $val->CertificateNumber,
                'vendor_stock_number'=> $val->VendorStockNumber,
                'symmetry_title'=> $val->SymmetryTitle,
                'polish_title'=> $val->PolishTitle,
                'depth_percentage'=> $val->DepthPercent,
                'table_percentage'=> $val->TablePercent,
                'meas_length'=> $val->MeasLength,
                'meas_width'=> $val->MeasWidth,
                'meas_depth'=> $val->MeasDepth,
                'girdle_size_min'=> isset($val->GirdleSizeMin)?$val->GirdleSizeMin:'',// $val->GirdleSizeMin,
                'girdle_size_max'=> isset($val->GirdleSizeMax)?$val->GirdleSizeMax:'',// $val->GirdleSizeMax,
                'culet_size_title'=> isset($val->CuletSizeTitle)?$val->CuletSizeTitle:'',
                'fluorescence_intensity_title'=> $val->FluorescenceIntensityTitle,
                'fancy_color_overtones'=> isset($val->FancyColorOvertones)?json_encode($val->FancyColorOvertones):'',
                'has_cert_file'=> $val->HasCertFile,
                'currency_short_title'=> $val->CurrencyShortTitle,
                'currency_symbol'=> $val->CurrencySymbol,
                'total_sales_price_in_currency'=> $val->TotalSalesPriceInCurrency,
                'eye_clean_title'=> isset($val->EyeCleanTitle)?$val->EyeCleanTitle:'',
                'has_image_file'=> $val->HasImageFile,
                'image_video_type_id'=> $val->ImageVideoTypeID,
                'has_video'=>isset($val->HasVideo)?$val->HasVideo:'',
            ]);
        }
        return true;
    }

    public function getCustomFilter(Request $request)
    {
        $getProduct = Products::where('slug',$request->slug)->select('id')->first();

        $getProductSelectedAttribute = ProductVariationAttributes::where('product_id',$getProduct->id)->first();
        $getProductSelectedAttribute = str_replace('attri_', '', explode(',',$getProductSelectedAttribute->attr_values));

        if(count($getProductSelectedAttribute)){
            $selectedDesign = '';
            foreach($getProductSelectedAttribute as $key => $value){
                $getAttributeValues = Attributes::where('slug',$value)->select('name','slug','values')->first();
                $selectedDesign .= '<label for="diamond-colour"> '.$getAttributeValues->name.' </label><select name="'.trim($value).'" id="'.trim($value).'" class="form-control"><option value="">Select Any</option>';
                $getData = explode('|',$getAttributeValues->values);
                foreach($getData as $keyNew => $sepValue){
                    if($keyNew == 0){
                        $selectedVariable = 'selected';
                    }else{
                        $selectedVariable = '';
                    }
                    $selectedDesign .= '<option '.$selectedVariable.' value="'.trim($sepValue).'">'.trim($sepValue).'</option>';
                }
                $selectedDesign .= '</select> <br>';
            }
        }
        return response()->json($selectedDesign);
    }

    public function getCustomApiFilterData(Request $request)
    {
       

        $getHariKrishnaData = DiamondStock::where('Carat',$request->carat)->where('Color',$request->color)->where('Clarity',$request->clarity)->where('Cut',$request->grade)->where('Lab',$request->certificate)->get();

        echo "<pre>";
        print_r($request->all());
        print_r($getHariKrishnaData);
        die;

    }
    

}
