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
use App\Models\ProductVariations;
use App\Models\ProductVariationDetails;
use App\Models\ProductImages;
use SoapClient;
use Rapnet;
use App\Repnet\nusoap;
use App\Http\Controllers\Front\ApiController;
use View;
use Illuminate\Support\Arr;
use DB;
use billythekid\dekopay\Core\DekoPayApiClient;

class ProductController extends Controller
{
    public function productCategory($cat1=null,$cat2=null,$cat3=null)
    {
        if($cat3 != null){
            // echo "cat3";
            $getCatId = Category::where('slug', $cat3)->first();

        }elseif($cat2 != null){
            // echo "cat2";
            $getCatId = Category::where('slug', $cat2)->first();

        }elseif($cat1 !=null){
            // echo "cat1<pre>";
            $getCatId = Category::where('slug', $cat1)->first();

        }else{
            return view('layouts.errors.404');
        }
        if(!$getCatId){
            return view('layouts.errors.404');

        }
        return view('front.pages.product-listing',['data'=>$getCatId,'cat1'=>$cat1,'cat2'=>$cat2,'cat3'=>$cat3]);
    }

    public function productDetails($productSlug = null)
    {
            $dekoEnabled = true;
            $client = new DekoPayApiClient('','', env('DEKOPAY_API_KEY'));
            $pay_url =  env('DEKOPAY_MODE');

            if($dekoEnabled){
                $url = $pay_url == 'live' ? 'https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key='.env('DEKOPAY_API_KEY')  : 'https://test.dekopay.com/js_api/FinanceDetails.js.php?api_key='.env('DEKOPAY_API_KEY');
            }

        if($productSlug !=null){
            $getProduct = Products::with(['getProductImages','getProductVariation'])->where('slug',$productSlug)->first();

            if(isset($getProduct) && !empty($getProduct)){
                // Product Categories
                $prod_categories = explode(',',$getProduct->categories);
                $checkPlanCat = Category::select('id')->whereIn('id',$prod_categories)->where('name','LIKE','%plain%')->get()->toArray();
                if(!empty($checkPlanCat)) $plainband = true;
                else $plainband = false;
                // store in session for recent viewd products start
                $recentProduct = session()->get('recentproducts', []);

                $recentProduct[$getProduct->id] = [
                    "name" => $getProduct->title,
                    "slug" => $getProduct->slug,
                    "image" => isset($getProduct->getProductImages)?$getProduct->getProductImages->image_url:'',
                ];

                session()->put('recentproducts', $recentProduct);
                // store in session for recent viewd products End


                // Product Images
                $prodImages = ProductImages::where('product_id',$getProduct->id)->get();
                if($getProduct->dfinder_status == 1){
                    $productVariationId = ProductVariations::where('product_id',$getProduct->id)->pluck('id')->toArray();
                    //print_r($getProductVariationId); die;
                    if(isset($productVariationId) && !empty($productVariationId)){
                        $variDetails = ProductVariationDetails::whereIn('variation_id',$productVariationId)->where('value','Platinum')->select('id','variation_id','value')->first();
                        if(empty($variDetails)){
                            $variDetails = ProductVariationDetails::whereIn('variation_id',$productVariationId)->select('id','variation_id','value')->first();
                        }
                    }
                    $variationDetails = ProductVariations::where('id',$variDetails->variation_id)->select('vari_image','vari_video','regular_price','sale_price')->first();

                    //echo '<pre>';print_r($variationDetails); die;
                    return view('front.pages.product-details-dyes',['data'=>$getProduct,'variationDetails'=>$variationDetails,'prodImages'=>$prodImages,'url'=>$url]);
                }else{
                    $variationDetails = ProductVariations::where('product_id',$getProduct->id)->select('vari_image')->groupBy('vari_image')->get();
                   // echo '<pre>';print_r($variationDetails); die;
                    return view('front.pages.product-details-dno',['data'=>$getProduct,'prodImages'=>$prodImages,'url'=>$url,'plainband'=>$plainband,'variationImages'=>$variationDetails]);
                }
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

        $getProductListFinal = Products::with('getProductImages')->orderBy('title','asc')->whereIn('id',$output)->simplePaginate(12);

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
        $product_id = Products::where('slug',$request->slug)->value('id');
        if($product_id!=''){
            $productSelectedAttribute = ProductVariationAttributes::where('product_id',$product_id)->value('attr_values');

            if($productSelectedAttribute!=''){
                $productSelectedAttribute = str_replace('attri_', '', explode(',',$productSelectedAttribute));

                // Get Attributes
                $attributes = Attributes::whereIn('slug',$productSelectedAttribute)->get()->toArray();


                if(!empty($attributes)){

                    $variation_ids = ProductVariations::where('product_id',$product_id)->pluck('id')->toArray();

                    $variationArray = $final_attr = [];
                    foreach ($attributes as $key => $attribute) {
                        $final_attr['name'] = $attribute['name'];
                        $final_attr['slug'] = $attribute['slug'];

                        $explode_attr = explode('|', $attribute['values']);

                        $getAttrVals = ProductVariationDetails::whereIn('variation_id',$variation_ids)->where('key','attri_'.$attribute['slug'])->pluck('value')->toArray();


                        $found = [];
                        foreach($explode_attr as $num) {
                            if (in_array(trim($num),$getAttrVals)) {
                                $found[] = $num;
                            }
                        }

                        $is_empty = true;
                        foreach ($getAttrVals as $value) {
                            if ($value != ''){
                                $is_empty = false;

                            }
                        }

                        if ($is_empty)
                            $final_attr['attri_'.$attribute['slug']] = $explode_attr;
                        else
                            $final_attr['attri_'.$attribute['slug']] = $found;



                        $variationArray[] = View::make('front.includes.show_variations',['final_attr'=>$final_attr])->render();
                    }

                }
                return $variationArray;
            }
        }
        return response()->json(['status'=>'Not attribute selected']);
    }

    public function getProductVideo(Request $request)
    {
        $getProduct = Products::where('slug',$request->slug)->select('id')->first();

        if(isset($getProduct) && !empty($getProduct->id)){
            $getProductVariationId = ProductVariations::where('product_id',$getProduct->id)->pluck('id')->toArray();

            if(isset($getProductVariationId) && !empty($getProductVariationId)){
                $getVariDetails = ProductVariationDetails::whereIn('variation_id',$getProductVariationId)->where('value',$request->metal_color)->select('id','variation_id','value')->first();
            }

            if(isset($getVariDetails) && !empty($getVariDetails)){
                $getSelectedVariationVideoImages = ProductVariations::where('id',$getVariDetails->variation_id)->select('vari_image','vari_video','regular_price','sale_price')->first();

                return response()->json($getSelectedVariationVideoImages);
            }
        }
        return response()->json($getProductVariationId);
    }

    public function getCustomApiFilterData(Request $request)
    {

        // echo '<pre>'; print_r($request->all()); die;

        $caratFrom = '0.30'; $caratTo = '0.39';
        if($request->carat!=''){
            $carat = explode('-',$request->carat);
            $caratFrom = $carat[0]; $caratTo = $carat[1];
        }

        $colorFrom = $colorTo = 'D'; $colour = array();
        if($request->color!=''){
            $colour = explode(',',$request->color);
            $colorFrom = $colorTo = $request->color;
        }

        $clarityFrom = $clarityTo = 'SI2'; $clarity=array();
        if($request->clarity!=''){
            $clarity = explode(',',$request->clarity);
            $clarityFrom = $clarityTo = $request->clarity;
        }

        $gradeFrom = $gradeTo = 'EX'; $grade=array();
        if($request->grade!=''){
            $grade = explode(',',$request->grade);
            $gradeFrom = $gradeTo = $request->grade;
        }

        $polishFrom = 'EX'; $polishTo = 'GD'; $polish=array();
        $symmetryFrom = 'EX'; $symmetryTo = 'GD'; $symmetry=array();
        $fluorescence = array();

        $certificate = array();
        if($request->certificate!=''){
            $certificate = explode(',',$request->certificate);
        }

        $data = array('shape'=>$request->shape,'colorFrom'=>$colorFrom,'colorTo'=>$colorTo,'colour'=>$colour,'clarityFrom'=>$clarityFrom,'clarityTo'=>$clarityTo,'clarity'=>$clarity,'caratFrom'=>$caratFrom,'caratTo'=>$caratTo,'gradeFrom'=>$gradeFrom,'gradeTo'=>$gradeTo,'grade'=>$grade,'polishFrom'=>$polishFrom,'polishTo'=>$polishTo,'polish'=>$polish,'symmetryFrom'=>$symmetryFrom,'symmetryTo'=>$symmetryTo,'symmetry'=>$symmetry,'fluorescence'=>$fluorescence,'certificate'=>$certificate,'num_of_row'=>1,'PageSize'=>2);

        //echo '<pre>'; print_r($data); die;

        $hkData = getHKApiRecords($data);
        $rapnetData = getRapnetApiRecordsDiamondSearch($data,1);

        //echo '<pre>'; print_r($rapnetData); die;
        $rapnetRecords = [];
        if(!empty($rapnetData)){
            foreach ($rapnetData as $key => $result) {
                $rapnetRecords[$key]['Shape'] = $result->ShapeTitle;;
                $rapnetRecords[$key]['Carat'] = $result->Weight;
                $rapnetRecords[$key]['Color'] = $result->ColorTitle;
                $rapnetRecords[$key]['Clarity'] = $result->ClarityTitle;
                if(isset($result->CutLongTitle))
                    $rapnetRecords[$key]['Cut'] = $result->CutLongTitle;

                $rapnetRecords[$key]['Lab'] = $result->LabTitle;
                $rapnetRecords[$key]['Amount'] = $result->FinalPrice;
                $rapnetRecords[$key]['Stock_NO'] = $result->DiamondID;


                if($result->LabTitle=='GIA'){
                        $rapnetRecords[$key]['CertificateLink']= 'https://www.gia.edu/cs/Satellite?reportno='.$result->CertificateNumber.'&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
                    }
                    else if($result->LabTitle=='IGI'){
                        $rapnetRecords[$key]['CertificateLink']= 'https://www.igi.org/reports/verify-your-report?r='.$result->CertificateNumber;
                    }
                    else if($result->LabTitle=='HRD'){
                        $rapnetRecords[$key]['CertificateLink']= 'https://www.hrdantwerplink.be/?record_number='.$result->CertificateNumber.'&weight='.$result->Weight;
                    }
                    else {
                        $rapnetRecords[$key]['CertificateLink']= 'https://www.diamondselections.com/GetCertificate.aspx?diamondid='.$result->DiamondID;
                    }

            }
          }
         //echo '<pre>'; print_r($rapnetRecords); die;
          $apiData['data'] = Arr::collapse([$hkData, $rapnetRecords]);

          $apiData['VAT'] = getVAT();
          //echo '<pre>'; print_r($apiData); die;

          if(!empty($apiData['data'])){
            $dataArray = [];
            foreach ($apiData['data'] as $key => $data) {
                $dataArray[] = View::make('front.includes.product_detail_diamonds',['key'=>$key,'apiRecords'=>$data,'VAT'=>$apiData['VAT']])->render();
            }
          }
          return response()->json(['html'=> $dataArray]);

            // $getApiController = new ApiController;
            // $getActualData = $getApiController->getRepnetApiFunction($request->all());

            // if(count($getActualData)){
            //     $view = view('front.ajax.product_refinesearch',compact('getActualData'))->render();
            //     return response()->json(['html'=> $view]);
            // }

            // return response()->json(['html'=> '']);
    }

    public function autocomplete(Request $request)
    {
        $getSearchedData = Products::with(['getProductImages'])->select("title",'id','slug')
                ->where("title","LIKE","%{$request['query']}%")
                ->get();

        $view = view('front.ajax.search_suggesion',compact('getSearchedData'))->render();
        return response()->json(['html'=> $view]);

    }


    public function getSelectedVariationsData(Request $request){
        $product_id = Products::where('slug',$request->slug)->value('id');
        //print_r($request->variations); die;
        if($product_id!=''){
            $getProductVariationId = ProductVariations::where('product_id',$product_id)->pluck('id')->toArray();

            if(!empty($getProductVariationId)){
                $getVariDetails = ProductVariationDetails::groupBy('value')->whereIn('variation_id',$getProductVariationId)->whereIn('value',$request->variations)->get()->toArray();
               $attributeCount = count($request->variations);
                foreach ($getProductVariationId as $key1 => $productVariationId) {
                        $variationDetails = array();
                        foreach ($request->variations as $key2 => $variations) {
                            $getVariDetails = ProductVariationDetails::where('variation_id',$productVariationId)->where('value',$variations)->get()->toArray();

                            if(!empty($getVariDetails))
                                $variationDetails[] = $getVariDetails;
                            //echo '<pre> '.$key1.'='.$key2; print_r($getVariDetails);
                        }
                       // die;
                        if($attributeCount == count($variationDetails))
                            break;

                    # code...
                }
                //echo '<pre>'; print_r($variationDetails);
                //die;
                //echo '<pre>'; print_r($getVariDetails); die;
            }
            $vat = getVAT();
            if(isset($getVariDetails) && !empty($getVariDetails)){
                $getSelectedVariationVideoImages = ProductVariations::where('id',$variationDetails[0][0]['variation_id'])->select(DB::raw('(regular_price*"'.$vat.'") as regular_price_with_vat'),DB::raw('(sale_price*"'.$vat.'") as sale_price_with_vat'),'vari_image','vari_video','regular_price','sale_price')->first();

                return response()->json($getSelectedVariationVideoImages);
            }
        }
    }


    public function getRelatedProductList(Request $request)
    {
        $getCatIdArray = explode(',',$request->catid);

        $getCateProductId = array();
        foreach($getCatIdArray as $prKey => $proVal){
            $getProductList = Products::whereRaw("find_in_set('".$proVal."',categories)")
            ->pluck('id')->toArray();
            array_push($getCateProductId,$getProductList);
        }

        $output = array_unique(call_user_func_array('array_merge', $getCateProductId));

        $getProductListFinal = Products::with('getProductImages')->whereIn('id',$output)->take(4)->get();
        //dd($getProductListFinal);
        if(isset($getProductListFinal) && !empty($getProductListFinal)){
            $view = view('front.ajax.productlistajax',compact('getProductListFinal'))->render();
        }else{
            $view = '';

        }

        return response()->json(['html'=>$view]);

    }


}
