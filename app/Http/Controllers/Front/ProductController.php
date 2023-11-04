<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use App\Models\RepnetData;
use App\Models\ProductVariationAttributes;
use App\Models\Attributes;
use App\Models\MarginApiRange;
use App\Models\ProductVariations;
use App\Models\ProductVariationDetails;
use App\Models\ProductImages;
use App\Models\Discount;
use App\Models\DiscountRange;
use App\Models\Masters;
use App\Models\ProductVariationsMaster;
use App\Models\GlobalCombinationsVariations;
use App\Models\UrlRedirects;
use App\Models\LabPricesList;
use App\Models\SitemapUrls;
use App\Models\Posts;
use App\Models\PostCategory;
use App\Models\Pages;
use App\Models\ProductFilter;
use App\Models\ProductFilterItems;
use Illuminate\Support\Facades\Redirect;
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

    public function productCategory($cat1 = null, $cat2 = null, $cat3 = null)
    {
        $request = request();
        $path =  $request->path();
        $slugs = explode('/', $path);

        if (count($slugs) < 3 && $slugs[1] == 'engagement-rings') {
            echo "if ";
            $slugs[1] = 'diamond-engagement-rings';
        }

        $makeNewURL = '';
        if (isset($slugs[1]) && !empty($slugs[1])) {
            $makeNewURL .= $slugs[1];
        }

        if (isset($slugs[2]) && !empty($slugs[2])) {
            $makeNewURL .= '/' . $slugs[2];
        }

        if (isset($slugs[3]) && !empty($slugs[3])) {

            $getShapeAttribute = ProductFilterItems::where('item_type', 'filter-by-shape')->pluck('item_value')->toArray();
            if (isset($getShapeAttribute) && !empty($getShapeAttribute)) {
                $input = explode('-', $slugs[3]); // for get same string found in array with upper case.
                $input = array_flip($input);
                $input = array_change_key_case($input, CASE_UPPER);
                $input = array_flip($input);
                $slugs[4] = array_values(array_intersect($getShapeAttribute, $input));

                if (isset($slugs[4]) && !empty($slugs[4])) {
                    $makeNewURL = $slugs[1] . '/' . strtolower($slugs[4][0]);
                } else {
                    if (isset($slugs[2]) && $slugs[2] == 'womens') {
                        $makeNewURL .= '/' . str_replace('-' . $slugs[2], "", $slugs[3]);
                    } else {
                        $makeNewURL .= '/' . $slugs[3];
                    }
                }
            } else {
                $makeNewURL .= '/' . strtolower($slugs[3][0]);
            }
        }
        return Redirect::to($makeNewURL, 301);

        if ($cat3 != null) {
            // echo "cat3";
            $getCatId = Category::where('slug', $cat3)->first();
        } elseif ($cat2 != null) {
            // echo "cat2";
            $getCatId = Category::where('slug', $cat2)->first();
        } elseif ($cat1 != null) {

            $to404 = ['all-products'];
            if (in_array($cat1, $to404)) {
                return view('layouts.errors.404');
            }
            $getCatId = Category::where('slug', $cat1)->first();
        } else {
            return view('layouts.errors.404');
        }
        if (!$getCatId) {
            return view('layouts.errors.404');
        }
        return view('front.pages.product-listing', ['data' => $getCatId, 'cat1' => $cat1, 'cat2' => $cat2, 'cat3' => $cat3]);
    }

    public function productDetails(Request $request, $productSlug = null)
    {



        $dekoEnabled = true;
        $client = new DekoPayApiClient('', '', env('DEKOPAY_API_KEY'));
        $pay_url =  env('DEKOPAY_MODE');

        if ($dekoEnabled) {
            $url = $pay_url == 'live' ? 'https://secure.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY')  : 'https://test.dekopay.com/js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY');
        }

        $requestData = $request->query() ? $request->query() : [];



        if ($productSlug != null) {
            // $productSlug = str_replace("_","-",$productSlug);
            $getProduct = Products::with(['getProductImages', 'getProductVariation'])->where('status',1)->where('slug', $productSlug)->first();

            if (empty($getProduct)) {
                /** If data not found with existing slug then check in redirections table and redirect */
                $redirectTo = UrlRedirects::where('old_url', $productSlug)->where(['type' => 'product', 'is_active' => 1, 'is_deleted' => 0])->first();
                if (!empty($redirectTo) && !empty($redirectTo->new_url)) {
                    $redirectTo = route('product.details', $redirectTo->new_url);
                    return redirect($redirectTo, 301);
                }
            }

            if (isset($getProduct) && !empty($getProduct)) {
                // Product Categories
                $prod_categories = explode(',', $getProduct->categories);


                $checkPlanCat = Category::select('id')->whereIn('id', $prod_categories)->where('name', 'LIKE', '%plain%')->get()->toArray();
                if (!empty($checkPlanCat)) $plainband = true;
                else $plainband = false;


                $checkPlanCatMultiStone = Category::select('id')->whereIn('id', $prod_categories)->where('name', 'LIKE', '%Multi-Stone%')->get()->toArray();
                if (!empty($checkPlanCatMultiStone)) $plainbandMulti = true;
                else $plainbandMulti = false;

                $checkPlanCatJwellery = Category::select('id')->whereIn('id', $prod_categories)->where('name', 'LIKE', '%Diamond Jewellery%')->get()->toArray();

                if (!empty($checkPlanCatJwellery)) $plainbandJewellery = true;
                else $plainbandJewellery = false;

                // store in session for recent viewd products start
                $recentProduct = session()->get('recentproducts', []);

                $recentProduct[$getProduct->id] = [
                    "name" => $getProduct->title,
                    "slug" => $getProduct->slug,
                    "image" => isset($getProduct->getProductImages) ? $getProduct->getProductImages->image_url : '',
                ];

                session()->put('recentproducts', $recentProduct);
                // store in session for recent viewd products End

                // Product Images
                $prodImages = ProductImages::where('product_id', $getProduct->id)->get();

                if ($getProduct->dfinder_status == 1) {
                    $productVariationId = ProductVariations::where('product_id', $getProduct->id)->pluck('id')->toArray();

                    if (isset($productVariationId) && !empty($productVariationId)) {
                        $variDetails =  ProductVariationDetails::whereIn('variation_id', $productVariationId)
                            ->where('value', '9ct White Gold')
                            ->select('id', 'variation_id', 'value')
                            ->orderBy('variation_id', 'desc')
                            ->first();

                        if (empty($variDetails)) {
                            $variDetails =  ProductVariationDetails::whereIn('variation_id', $productVariationId)
                                ->select('id', 'variation_id', 'value')
                                ->where('value', '!=', '')
                                ->first();
                        }
                    }

                    $variationDetails = ProductVariations::where('id', $variDetails->variation_id)
                        ->select('vari_image', 'vari_video', 'regular_price', 'sale_price')
                        ->first();

                    return  view(
                        'front.pages.product-details-dyes',
                        [
                            'data' => $getProduct,
                            'plainbandMulti' => $plainbandMulti,
                            'plainbandJewellery' => $plainbandJewellery,
                            'variationDetails' => $variationDetails,
                            'prodImages' => $prodImages,
                            'url' => $url,
                            'requestData' => $requestData
                        ]
                    );
                } else {

                    $all_categories_slug = Category::select(['id', 'slug'])->whereIn('id', $prod_categories)->pluck('slug');
                    if ($all_categories_slug->count()) {
                        $all_categories_slug = $all_categories_slug->toArray();
                    } else {
                        $all_categories_slug = [];
                    }

                    /** This code is for removing duplicate iamges */
                    $prdIdsToRmvDplictImgs = duplicateProductRemoveIds();
                    if (in_array($getProduct->id, $prdIdsToRmvDplictImgs)) {
                        $variationDetails = null;
                        $customSlider = 1;
                    } else {
                        $variationDetails = ProductVariations::where('product_id', $getProduct->id)
                            ->select('vari_image')
                            ->groupBy('vari_image')
                            ->get();
                        $customSlider = 0;
                    }

                    return  view(
                        'front.pages.product-details-dno',
                        [
                            'data' => $getProduct,
                            'prodImages' => $prodImages,
                            'plainbandMulti' => $plainbandMulti,
                            'plainbandJewellery' => $plainbandJewellery,
                            'url' => $url,
                            'plainband' => $plainband,
                            'variationImages' => $variationDetails,
                            'requestData' => $requestData,
                            'all_categories_slug' => $all_categories_slug,
                            'customSlider' => $customSlider,
                        ]
                    );
                }
            } else {
                return view('layouts.errors.404');
            }
        } else {
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

        $getParentData = Category::with('grandchildren')->where('status', 1)->where('id', $request->cate_id)->select('id', 'parent_id', 'slug')->first()->toArray();

        $getParentHierarchy = array($getParentData['id']);
        foreach ($getParentData['grandchildren'] as $keyName => $childId) {
            array_push($getParentHierarchy, $childId['id']);
            if (is_array($childId['grandchildren'])) {
                foreach ($childId['grandchildren'] as $keyName1 => $childId1) {
                    array_push($getParentHierarchy, $childId1['id']);
                }
            }
        }

        $getCateProductId = array();
        if (count($getParentHierarchy)) {
            foreach ($getParentHierarchy as $prKey => $proVal) {
                $getProductList = Products::whereRaw("find_in_set('" . $proVal . "',categories)")->pluck('id')->toArray();
                array_push($getCateProductId, $getProductList);
            }
        }

        $output = array_unique(call_user_func_array('array_merge', $getCateProductId));

        /** Order by  */
        switch ($getParentData['slug']) {
            case 'exclusive-to-marlows': {
                    $orderKey = "created_at";
                    $orderValue = "desc";
                    break;
                }
            default: {
                    $orderKey = "title";
                    $orderValue = "asc";
                    break;
                }
        }

        $getProductListFinal = Products::with('getProductImages')->orderBy($orderKey, $orderValue)->where('status', 1)->whereIn('id', $output)->simplePaginate(12);


        if (isset($getProductListFinal) && !empty($getProductListFinal)) {
            $notInList = 0;
            foreach ($getProductListFinal as $product_list_key => $product_list_value) {


                $minMaxPrice = Products::getMinMaxPrice($product_list_value->id);
                if ($minMaxPrice) {
                    $getProductListFinal[$product_list_key]->minimumValue = $minMaxPrice['minimumValue'];
                    $getProductListFinal[$product_list_key]->maximumValue = $minMaxPrice['maximumValue'];
                }
                // $categories = explode(',', $product_list_value->categories);
                // $combinations = ProductVariationsMaster::where(['product_id'=> $product_list_value->id, 'is_deleted'=> 0, 'is_active'=>1 ])
                //                 ->orderBy('price','DESC')
                //                 ->pluck('price');
                // if(!empty($combinations) && $combinations && $combinations->count()){
                //     $combinations = $combinations->toArray();
                //     $min = min($combinations);
                //     $max = max($combinations);
                //     $minimumValue = (55/ 100) * $min;
                //     $maximumValue = $max;
                //     /** Inside this */
                //     $getProductListFinal[$product_list_key]->minimumValue = $minimumValue;
                //     $getProductListFinal[$product_list_key]->maximumValue = $maximumValue;
                // }else{
                //     $categorySlgs = Category::whereIn('id',$categories)->pluck('slug');
                //     if($categorySlgs->count()){
                //         $categorySlgs = $categorySlgs->toArray();
                //     }
                //     if(!in_array('8', $categories) && !in_array('exclusive-to-marlows', $categorySlgs) ){
                //         $product_variations = ProductVariations::where(['product_id'=> $product_list_value->id])->pluck('regular_price');
                //         if(!empty($product_variations) && $product_variations->count()){
                //             $product_variations = $product_variations->toArray();
                //             $getProductListFinal[$product_list_key]->minimumValue = min($product_variations);
                //             $getProductListFinal[$product_list_key]->maximumValue = max($product_variations);
                //         }
                //     }
                // }
            }
            $getAjaxResponses = false;
            $view = view('front.ajax.productlistajax', compact('getProductListFinal','getAjaxResponses'))->render();
        } else {
            $view = '';
            $getProductListFinal = '';
        }

        return response()->json(['page' => $getProductListFinal, 'html' => $view]);
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

    public function getSingleArray($blankArray, $cateArray, $level = 0)
    {
        $level++;
        if (count($cateArray)) {
            foreach ($cateArray as $key => $val) {
                if ($key == 'id') {
                    $blankArray[$level] = $val;
                }
                if ($key == 'parent_cate') {
                    if (is_array($val)) {
                        $this->getSingleArray($blankArray, $val, $level);
                    }
                }
            }
        }
        return json_encode($blankArray);
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

        foreach ($getActualData as $key => $val) {
            RepnetData::create([
                'diamond_id' => $val->DiamondID,
                'shape_title' => $val->ShapeTitle,
                'weight' => $val->Weight,
                'color_title' => $val->ColorTitle,
                'lab_title' => $val->LabTitle,
                'repnet_price' => $val->RapNetPrice,
                'final_price' => $val->FinalPrice,
                'certificate_number' => $val->CertificateNumber,
                'vendor_stock_number' => $val->VendorStockNumber,
                'symmetry_title' => $val->SymmetryTitle,
                'polish_title' => $val->PolishTitle,
                'depth_percentage' => $val->DepthPercent,
                'table_percentage' => $val->TablePercent,
                'meas_length' => $val->MeasLength,
                'meas_width' => $val->MeasWidth,
                'meas_depth' => $val->MeasDepth,
                'girdle_size_min' => isset($val->GirdleSizeMin) ? $val->GirdleSizeMin : '', // $val->GirdleSizeMin,
                'girdle_size_max' => isset($val->GirdleSizeMax) ? $val->GirdleSizeMax : '', // $val->GirdleSizeMax,
                'culet_size_title' => isset($val->CuletSizeTitle) ? $val->CuletSizeTitle : '',
                'fluorescence_intensity_title' => $val->FluorescenceIntensityTitle,
                'fancy_color_overtones' => isset($val->FancyColorOvertones) ? json_encode($val->FancyColorOvertones) : '',
                'has_cert_file' => $val->HasCertFile,
                'currency_short_title' => $val->CurrencyShortTitle,
                'currency_symbol' => $val->CurrencySymbol,
                'total_sales_price_in_currency' => $val->TotalSalesPriceInCurrency,
                'eye_clean_title' => isset($val->EyeCleanTitle) ? $val->EyeCleanTitle : '',
                'has_image_file' => $val->HasImageFile,
                'image_video_type_id' => $val->ImageVideoTypeID,
                'has_video' => isset($val->HasVideo) ? $val->HasVideo : '',
            ]);
        }
        return true;
    }

    public function getCustomFilter(Request $request)
    {

        $product_id = Products::where('slug', $request->slug)->value('id');
        if ($product_id != '') {
            $productSelectedAttribute = ProductVariationAttributes::where('product_id', $product_id)->value('attr_values');

            if ($productSelectedAttribute != '') {
                $productSelectedAttribute = str_replace('attri_', '', explode(',', $productSelectedAttribute));

                // Get Attributes
                $attributes = Attributes::whereIn('slug', $productSelectedAttribute)->get()->toArray();


                if (!empty($attributes)) {

                    $variation_ids = ProductVariations::where('product_id', $product_id)->pluck('id')->toArray();

                    $variationArray = $final_attr = [];

                    // remove after update product start gk.

                    if (isset($request->categorySlug) && !empty($request->categorySlug)) {
                        $insert[] =  [
                            "id" => 2,
                            "name" => "Finger Size",
                            "slug" => "finger-size",
                            "values" => "G | G-1/2 | H | H-1/2 | I | I-1/2 | J | J-1/2 | K | K-1/2 | L | L-1/2 | M | M-1/2 | N | N-1/2 | O | O-1/2 | P | P-1/2 | Q | Q-1/2 | R | R-1/2 | S | S-1/2 | T | T-1/2 | U | U-1/2 | V | V-1/2 | W | W-1/2 | X | X-1/2 | Y | Y-1/2 | Z | Z-1/2 "
                        ];

                        $temp_array = array_column($attributes, 'slug');
                        if (!in_array('finger-size', $temp_array)) {
                            $attributes = array_merge(
                                array_slice($attributes, 0, 1),
                                $insert,
                                array_slice($attributes, 1)
                            );
                        }
                    }
                    // remove after update product end gk.


                    foreach ($attributes as $key => $attribute) {
                        $final_attr = [];
                        $final_attr['name'] = $attribute['name'];
                        $final_attr['slug'] = $attribute['slug'];
                        $selected = isset($request[$final_attr['slug']]) ? $request[$final_attr['slug']] : '';


                        $explode_attr = explode('|', $attribute['values']);

                        if (isset($request->diamond_type) && $request->diamond_type == 'mined_diamond') {
                            $arr_2 = "9ct";
                            $explode_attr = array_filter($explode_attr, function ($value) use ($arr_2) {
                                return stripos($value, $arr_2) === false;
                            });
                        }
                        $getAttrVals = ProductVariationDetails::whereIn('variation_id', $variation_ids)->where('key', 'attri_' . $attribute['slug'])->pluck('value')->toArray();


                        $found = [];
                        foreach ($explode_attr as $num) {
                            if (in_array(trim($num), $getAttrVals)) {
                                $found[] = $num;
                            }
                        }

                        $is_empty = true;
                        foreach ($getAttrVals as $value) {
                            if ($value != '') {
                                $is_empty = false;
                            }
                        }

                        if ($is_empty) {
                            $final_attr['attri_' . $attribute['slug']] = $explode_attr;

                            if ($request->typeName && $attribute['slug'] == 'finger-size') {
                                $alphaRange = range('I', 'M');
                                $result = preg_replace("/[^A-Z]+/", "", $final_attr['attri_' . $attribute['slug']]);
                                $finalAlphaData = [];
                                foreach ($result as $keyName => $valueData) {
                                    if (in_array($valueData, $alphaRange)) {
                                        if ($keyName % 2 == 0) {
                                            array_push($finalAlphaData, $valueData);
                                        } elseif ($keyName % 2 == 1) {
                                            array_push($finalAlphaData, $valueData . '-1/2');
                                        }
                                    }
                                }
                                $final_attr['attri_' . $attribute['slug']] = $finalAlphaData;
                            }
                        } else {
                            $final_attr['attri_' . $attribute['slug']] = $found;
                        }

                        $variationArray[] = View::make('front.includes.show_variations', ['final_attr' => $final_attr, 'type' => $request->type, 'selected' => $selected])->render();
                    }
                }
                return $variationArray;
            }
        }
        return response()->json(['status' => 'Not attribute selected']);
    }

    public function getProductVideo(Request $request)
    {
        $getProduct = Products::where('slug', $request->slug)->select('id')->first();

        if (isset($getProduct) && !empty($getProduct->id)) {
            $getProductVariationId = ProductVariations::where('product_id', $getProduct->id)->pluck('id')->toArray();

            if (isset($getProductVariationId) && !empty($getProductVariationId)) {
                $getVariDetails = ProductVariationDetails::whereIn('variation_id', $getProductVariationId)->where('value', $request->metal_color)->select('id', 'variation_id', 'value')->first();
            }

            if (isset($getVariDetails) && !empty($getVariDetails)) {
                $getSelectedVariationVideoImages = ProductVariations::where('id', $getVariDetails->variation_id)->select('vari_image', 'multi_vari_video', 'multi_vari_img', 'vari_video', 'regular_price', 'sale_price')->first();

                return response()->json($getSelectedVariationVideoImages);
            }
        }
        return response()->json($getProductVariationId);
    }

    public function getCustomApiFilterData(Request $request)
    {
        $caratFrom = '0.30';
        $caratTo = '0.39';
        if ($request->carat != '') {
            $carat = explode('-', $request->carat);
            $caratFrom = $carat[0];
            $caratTo = $carat[1];
        }

        $colorFrom = $colorTo = 'D';
        $colour = array();
        if ($request->color != '') {
            $colour = explode(',', $request->color);
            $colorFrom = $colorTo = $request->color;
        }

        $clarityFrom = $clarityTo = 'SI2';
        $clarity = array();
        if ($request->clarity != '') {
            $clarity = explode(',', $request->clarity);
            $clarityFrom = $clarityTo = $request->clarity;
        }

        $gradeFrom = $gradeTo = 'EX';
        $grade = array();
        if ($request->grade != '') {
            $grade = explode(',', $request->grade);
            $gradeFrom = $gradeTo = $request->grade;
        }

        $polishFrom = 'EX';
        $polishTo = 'GD';
        $polish = array();
        $symmetryFrom = 'EX';
        $symmetryTo = 'GD';
        $symmetry = array();
        $fluorescence = array();

        $certificate = array();
        if ($request->certificate != '') {
            $certificate = explode(',', $request->certificate);
        }

        $data = [
            'shape' => $request->shape,
            'colorFrom' => $colorFrom,
            'colorTo' => $colorTo,
            'colour' => $colour,
            'clarityFrom' => $clarityFrom,
            'clarityTo' => $clarityTo,
            'clarity' => $clarity,
            'caratFrom' => $caratFrom,
            'caratTo' => $caratTo,
            'gradeFrom' => $gradeFrom,
            'gradeTo' => $gradeTo,
            'grade' => $grade,
            'polishFrom' => $polishFrom,
            'polishTo' => $polishTo,
            'polish' => $polish,
            'symmetryFrom' => $symmetryFrom,
            'symmetryTo' => $symmetryTo,
            'symmetry' => $symmetry,
            'fluorescence' => $fluorescence,
            'certificate' => $certificate,
            'num_of_row' => 1,
            'PageSize' => 2
        ];

        $hkData = getHKApiRecords($data);
        $hkData = array_map(array($this, "amountChange"), $hkData);
        $rapnetData = getRapnetApiRecordsDiamondSearch($data, 1);
        
        $rapnetRecords = [];
        if (!empty($rapnetData)) {
            foreach ($rapnetData as $key => $result) {
                $rapnetRecords[$key]['Shape'] = $result->shape;
                $rapnetRecords[$key]['Carat'] = $result->size;
                $rapnetRecords[$key]['Color'] = $result->color;
                $rapnetRecords[$key]['Clarity'] = $result->clarity;
                if (isset($result->cut))
                    $rapnetRecords[$key]['Cut'] = $result->cut;

                $rapnetRecords[$key]['Lab'] = $result->lab;
                $rapnetRecords[$key]['Amount'] = $result->total_sales_price;
                $rapnetRecords[$key]['Stock_NO'] = $result->diamond_id;
                $rapnetRecords[$key]['CERT_NO'] = !empty($result->cert_num) ? $result->cert_num : '';


                if ($result->lab == 'GIA') {
                    $rapnetRecords[$key]['CertificateLink'] = 'https://www.gia.edu/cs/Satellite?reportno=' . $rapnetRecords[$key]['CERT_NO'] . '&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
                } else if ($result->lab == 'IGI') {
                    $rapnetRecords[$key]['CertificateLink'] = 'https://www.igi.org/reports/verify-your-report?r=' . $rapnetRecords[$key]['CERT_NO'];
                } else if ($result->lab == 'HRD') {
                    $rapnetRecords[$key]['CertificateLink'] = 'https://www.hrdantwerplink.be/?record_number=' . $rapnetRecords[$key]['CERT_NO'] . '&weight=' . $result->size;
                } else {
                    $rapnetRecords[$key]['CertificateLink'] = 'https://www.diamondselections.com/GetCertificate.aspx?diamondid=' . $result->DiamondID;
                }
            }
        }
        $apiData['data'] = Arr::collapse([$hkData, $rapnetRecords]);

        $apiData['VAT'] = getVAT();
        
        if (!empty($apiData['data'])) {
            if($request->type && $request->diamond_type == "mined_diamond"){
                if(isset($request->selectedDiamondPrice) && !empty($request->selectedDiamondPrice)){
                    return $request->selectedDiamondPrice;
                }
                return $apiData['data'][0]['Amount'];
            }else{
                $dataArray = [];
                foreach ($apiData['data'] as $key => $data) {
                    $dataArray[] = View::make('front.includes.product_detail_diamonds', ['key' => $key, 'apiRecords' => $data, 'VAT' => $apiData['VAT']])->render();
                }
            }
        }
        return response()->json(['html' => $dataArray]);
    }

    public function amountChange($num){
		$marginAPIPercentage = MarginApiRange::where('api_type','harikrishna')->whereRaw('"'.$num['Amount'].'" between `from_price` and `to_price`')
		->where('status', 1)
		->first();
		$num['oldAmount'] = $num['Amount'];
        if(isset($num['Amount']))
            $num['Amount'] = $num['Amount'] * $marginAPIPercentage->percentage;
        return $num;
    }
    
    public function autocomplete(Request $request)
    {
        $getSearchedData = Products::with(['getProductImages'])->select("title", 'id', 'slug')
            ->where("title", "LIKE", "%{$request['query']}%")
            ->get();

        $view = view('front.ajax.search_suggesion', compact('getSearchedData'))->render();
        return response()->json(['html' => $view]);
    }

    public function getSelectedVariationsData(Request $request)
    {

        $productData = Products::where('slug', $request->slug)->first();
        $runOldCode = true;

        if (!empty($productData)) {
            $prodCategoriesDJ = explode(',', $productData->categories);
            if (!in_array('3', $prodCategoriesDJ)  &&  in_array('2', $prodCategoriesDJ)  ||  in_array('47', $prodCategoriesDJ)) {

                $allCarats = Masters::where(['type' => 'carat', 'is_deleted' => 0, 'is_active' => 1])->pluck('name');
                if ($allCarats->count()) {
                    $allCarats = $allCarats->toArray();
                } else {
                    $allCarats = [];
                }
                $metalTypes = Masters::where(['type' => 'metal_types', 'is_deleted' => 0, 'is_active' => 1])->pluck('name');
                if ($metalTypes->count()) {
                    $metalTypes = $metalTypes->toArray();
                } else {
                    $metalTypes = [];
                }

                /** mined and lab_grown id exists in masters table */
                /** get carat metal type and product type */
                $productType = !empty($request['diamond_type']) && $request['diamond_type'] == 'mined' ? 1 : 2;
                $selectedMetalType = "";
                $selectedMetalTypeId = "";
                $carat = "";

                foreach ($request['variations'] as $variations_key => $variations_value) {
                    if (in_array($variations_value, $metalTypes)) {
                        $selectedMetalType = $variations_value;
                        $metalData = Masters::where(['type' => 'metal_types', 'name' => $selectedMetalType])->first();
                        $selectedMetalTypeId = $metalData->id;
                    } else if (in_array($variations_value, $allCarats)) {
                        $carat = $variations_value;
                    }
                }


                $combinations = ProductVariationsMaster::with(['masterData'])
                    ->whereHas('masterData', function ($q) use ($carat) {
                        $q->where('name', $carat);
                    })
                    ->where(['product_id' => $productData->id, 'is_deleted' => 0, 'is_active' => 1])
                    ->first();
                // ->toArray();



                if (!empty($combinations)) {
                    $combinations = $combinations->toArray();

                    $combinationsPriceFormula = GlobalCombinationsVariations::where(['is_deleted' => 0, 'is_active' => 1, 'global_combinations_id' => 1])
                        ->where('variations_id->metal_types', $selectedMetalTypeId)
                        ->where('variations_id->product_type', $productType)
                        ->first();
                    // ->toArray();

                    if (!empty($combinationsPriceFormula)) {

                        $combinationsPriceFormula = $combinationsPriceFormula->toArray();

                        $totalPrice =   !empty($combinations['total_price']) ? (((float)$combinationsPriceFormula['price']) / 100) * ((float)$combinations['total_price']) : 0;
                        $price = (((float)$combinationsPriceFormula['price']) / 100) * ((float)$combinations['price']);
                        $runOldCode = false;


                        $image = getProductVariationImage($productData->id, $request);

                        /** Apply discount */
                        $getDiscountRange = DiscountRange::whereHas('discount_data', function ($q) {
                            $q->whereDate('end_date', '>', now());
                        })
                            ->with(['discount_data'])
                            ->whereIn('category_id', $prodCategoriesDJ)
                            ->whereRaw('"' . $price . '" between `from_price` and `to_price`')
                            ->first();

                        if (!empty($getDiscountRange)) {
                            $price_after_discount = ($getDiscountRange->discount / 100) * $price;
                        } else {
                            $price_after_discount = 0;
                        }

                        $newArray['vari_image'] = !empty($image['vari_image']) ? $image['vari_image'] : '';
                        $newArray['multi_vari_img'] =  !empty($image['multi_vari_img']) ? $image['multi_vari_img'] : '';
                        $newArray['multi_vari_video'] =  !empty($image['multi_vari_video']) ? $image['multi_vari_video'] : '';
                        $newArray['formula'] = true;
                        $newArray['vari_video'] = !empty($image['vari_video']) ? $image['vari_video'] : '';
                        $newArray['regular_price'] = round($price);
                        $newArray['discount_data'] =  $getDiscountRange;
                        // $newArray['now'] =  now();
                        $newArray['regular_price_with_vat'] = round($price);
                        // $newArray['regular_price_with_vat_discount'] = round($price);
                        $newArray['regular_price_with_vat_discount'] = round($price) - round($price_after_discount);

                        // $newArray['regular_price_with_vat'] = $totalPrice ? number_format((float)$totalPrice, 2, '.', '') : '0.00';
                        // $newArray['regular_price_with_vat_discount'] = number_format((float)$price, 2, '.', '');

                        return response()->json($newArray);
                    }
                }
            }
        }


        $product_id = Products::where('slug', $request->slug)->value('id');
        if ($product_id != '' && $runOldCode) {

            // with(['getProductImages', 'getProductVariation'])
            $getProduct = Products::where('slug', $request->slug)->first();

            $prod_categories = explode(',', $getProduct->categories);

            // prd($prod_categories);

            if (in_array("18", $prod_categories)) {
                $prod_categories = ['18'];
                $checkPlanCatArray = Category::whereIn('id', $prod_categories)->first()->toArray();
            } else {
                $checkPlanCatArray = Category::whereIn('id', $prod_categories)->where('parent_id', 0)->first()->toArray();
            }

            // prd($checkPlanCatArray);

            $disPercentage = Discount::select('category_id', 'discount', 'inc_percentage', 'end_date', 'is_login_users')
                ->where('category_id', $checkPlanCatArray['id'])
                ->where('status', 1)
                ->first();

            // echo 'asdf';
            // prd($disPercentage);

            $getProductVariationId = ProductVariations::where('product_id', $product_id)
                ->pluck('id')
                ->toArray();



            if (!empty($getProductVariationId)) {

                $getVariDetails = ProductVariationDetails::groupBy('value')
                    ->whereIn('variation_id', $getProductVariationId)
                    ->whereIn('value', $request->variations)
                    ->get()
                    ->toArray();


                $attributeCount = count($request->variations);
                // prd($getProductVariationId);

                foreach ($getProductVariationId as $key1 => $productVariationId) {
                    $variationDetails = array();

                    foreach ($request->variations as $key2 => $variations) {
                        $getVariDetails = ProductVariationDetails::where('variation_id', $productVariationId)
                            ->where('value', $variations)
                            ->get()
                            ->toArray();

                        if (!empty($getVariDetails))
                            $variationDetails[] = $getVariDetails;
                    }

                    if ($attributeCount == count($variationDetails))
                        break;
                }
            }

            $vat = getVAT(); // Fixed 1.2

            // echo 'vat:- '. $vat;die;
            $newArray = [];
            if (isset($getVariDetails) && !empty($getVariDetails)) {

                // Get product variation price
                $getSelectedVariationVideoImages = ProductVariations::where('id', $variationDetails[0][0]['variation_id'])
                    ->select(DB::raw('(regular_price) as regular_price_without_vat'), DB::raw('(sale_price) as sale_price_without_vat'), 'vari_image', 'vari_video', 'multi_vari_img', 'multi_vari_video', 'regular_price', 'sale_price', 'mined_diamond', 'lab_grown')
                    ->first();

                /** Price change for lab grown */
                if ($request->diamond_type == 'lab_grown' && $getSelectedVariationVideoImages->regular_price_without_vat <= 3000) {
                    $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat - ($getSelectedVariationVideoImages->regular_price_without_vat * 0.35));
                } elseif ($request->diamond_type == 'lab_grown' && $getSelectedVariationVideoImages->regular_price_without_vat > 3000) {
                    $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat - ($getSelectedVariationVideoImages->regular_price_without_vat * 0.5));
                } else {
                    $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat);
                }

                $increaseDiscount = 1;
                $discountPercentage = 1;

                $regular_p_final = (($regular_p_final) * $increaseDiscount);

                // prd($disPercentage);
                if (isset($disPercentage) && !empty($disPercentage)) {
                    $disPercentage = $disPercentage->toArray();

                    if ($disPercentage['is_login_users']) {
                        $isDiscountApplicable = auth()->guard('customer')->check();
                    } else {
                        $isDiscountApplicable = true;
                    }

                    if ($isDiscountApplicable) {

                        if (isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1) {
                            $increaseDiscount = 1 + ($disPercentage['inc_percentage'] / 100);
                        } else {
                            $increaseDiscount = 1;
                        }

                        // echo $regular_p_final * $increaseDiscount;
                        // echo (($regular_p_final) * $increaseDiscount);die;

                        $regular_p_final = (($regular_p_final) * $increaseDiscount) * $vat;

                        if ($disPercentage['end_date'] >= date('Y-m-d')) {

                            $getDiscountRange = DiscountRange::select('category_id', 'from_price', 'to_price', 'discount')
                                ->where('category_id', $checkPlanCatArray['id'])
                                ->whereRaw('"' . $regular_p_final . '" between `from_price` and `to_price`')
                                ->first();


                            $discountPercentage = 1 + ($disPercentage['discount'] / 100);

                            if (isset($getDiscountRange) && !empty($getDiscountRange->discount)) {
                                if ($getDiscountRange->discount > 1) {
                                    $discountPercentage = 1 + ($getDiscountRange->discount / 100);
                                } else {
                                    $discountPercentage = 1;
                                }
                            } else {
                                $discountPercentage = 1;
                            }
                        } else {
                            $discountPercentage = 1;
                        }
                    } else {
                        if (isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1) {
                            $increaseDiscount = 1 + ($disPercentage['inc_percentage'] / 100);
                        } else {
                            $increaseDiscount = 1;
                        }
                        $regular_p_final = (($regular_p_final) * $increaseDiscount) * $vat;
                    }
                }


                $categorySlugs = Category::whereIn('id', $prod_categories)->pluck('slug');
                if ($categorySlugs->count()) {
                    $categorySlugs = $categorySlugs->toArray();
                }

                // echo "asdfds<pre>";

                // die;

                /** Discount not applicable to exclusive to marlows */
                if (in_array('exclusive-to-marlows', $categorySlugs)) {
                    $newArray['vari_image'] = $getSelectedVariationVideoImages->vari_image;
                    $newArray['multi_vari_img'] = $getSelectedVariationVideoImages->multi_vari_img;
                    $newArray['multi_vari_video'] = $getSelectedVariationVideoImages->multi_vari_video;
                    $newArray['vari_video'] = $getSelectedVariationVideoImages->vari_video;
                    $newArray['regular_price'] = $getSelectedVariationVideoImages->regular_price;
                    $newArray['regular_price_with_vat'] = $getSelectedVariationVideoImages->regular_price;
                    $newArray['regular_price_with_vat_discount'] = $getSelectedVariationVideoImages->regular_price;
                    return response()->json($newArray);
                } elseif (in_array('bracelets', $categorySlugs)) {
                    $newArray['vari_image'] = $getSelectedVariationVideoImages->vari_image;
                    $newArray['multi_vari_img'] = $getSelectedVariationVideoImages->multi_vari_img;
                    $newArray['multi_vari_video'] = $getSelectedVariationVideoImages->multi_vari_video;
                    $newArray['vari_video'] = $getSelectedVariationVideoImages->vari_video;

                    if ($request->diamond_type == 'lab_grown') {
                        $newArray['regular_price'] = $getSelectedVariationVideoImages->lab_grown;
                        // $newArray['regular_price_with_vat'] = $getSelectedVariationVideoImages->lab;
                        $newArray['regular_price_with_vat_discount'] = $getSelectedVariationVideoImages->lab_grown;
                    } elseif ($request->diamond_type == 'mined_diamond') {
                        $newArray['regular_price'] = $getSelectedVariationVideoImages->mined_diamond;
                        // $newArray['regular_price_with_vat'] = $getSelectedVariationVideoImages->mined;
                        $newArray['regular_price_with_vat_discount'] = $getSelectedVariationVideoImages->mined_diamond;
                    } else {
                        $newArray['regular_price'] = $getSelectedVariationVideoImages->regular_price;
                        $newArray['regular_price_with_vat'] = $getSelectedVariationVideoImages->regular_price;
                        $newArray['regular_price_with_vat_discount'] = $getSelectedVariationVideoImages->regular_price;
                    }


                    return response()->json($newArray);
                }


                $regular_p_discount_final = $regular_p_final / $discountPercentage;
                $newArray['vari_image'] = $getSelectedVariationVideoImages->vari_image;
                $newArray['vari_video'] = $getSelectedVariationVideoImages->vari_video;
                $newArray['multi_vari_img'] = $getSelectedVariationVideoImages->multi_vari_img;
                $newArray['multi_vari_video'] = $getSelectedVariationVideoImages->multi_vari_video;
                $newArray['regular_price'] = $getSelectedVariationVideoImages->regular_price;
                $newArray['regular_price_with_vat'] = round($regular_p_final);
                $newArray['regular_price_with_vat_discount'] = round($regular_p_discount_final);


                return response()->json($newArray);
            } else {
                return response()->json(['statusCode' => '500', 'msg' => 'No Variation Found']);
            }
        }
    }


    public function getRelatedProductList(Request $request)
    {
        $getCatIdArray = explode(',', $request->catid);
        $getAjaxResponses = false;
        $getCateProductId = array();
        foreach ($getCatIdArray as $prKey => $proVal) {
            $getProductList = Products::whereRaw("find_in_set('" . $proVal . "',categories)")
                ->pluck('id')->toArray();
            array_push($getCateProductId, $getProductList);
        }

        $output = array_unique(call_user_func_array('array_merge', $getCateProductId));

        $getProductListFinal = Products::with('getProductImages')->whereIn('id', $output)->where('status',1)->take(4)->get();
        if (isset($getProductListFinal) && !empty($getProductListFinal)) {
            $view = view('front.ajax.productlistajax', compact('getProductListFinal','getAjaxResponses'))->render();
        } else {
            $view = '';
        }

        return response()->json(['html' => $view]);
    }

    public function exclusiveMarlows(Request $request)
    {
        return View::make('front.pages.exclusive_products');
    }

    public function productSlugs(Request $request)
    {
        /** TODO:
         * 1. get all previous slugs of products
         * 2. update new slug after checking duplication
         */
        // redirects

        $blog_categories_slugs = [
            "certified-diamonds",
            "custom-engagement-rings",
            "diamond-earrings",
            "diamond-engagement-ring",
            "diamond-eternity-ring",
            "diamond-eternity-rings",
            "diamond-industry-insight",
            "diamond-pendants",
            "diamond-rings",
            "diamond-wedding-rings",
            "diamonds",
            "essential-guide-to-diamonds",
            "fancy-shaped-diamond-rings",
            "gia-certified-diamond-rings",
            "gold-jewellery",
            "loose-diamonds",
            "multi-stone-diamond-rings",
            "other-jewellery",
            "precious-stones",
            "princess-cut-engagement-ring",
            "uncategorized"
        ];
        $blog_affected_records = 0;
        $blog_category_meta_description = "Get idea about the latest ITEM_TO_CHANGE by read the latest news and resources from the Marlows Diamond blog.";

        foreach ($blog_categories_slugs as $blog_slug_key => $blog_slug_value) {
            $categorySlugItem = PostCategory::where('slug', $blog_slug_value)->first();
            if (!empty($categorySlugItem)) {
                $categorySlugItem->meta_description = str_replace('ITEM_TO_CHANGE', $categorySlugItem->name, $blog_category_meta_description);
                $categorySlugItem->save();
                $blog_affected_records++;
            }
        }
        echo 'Blog affected records:- ' . $blog_affected_records;

        /** Product categories */
        $product_categories_slugs = [
            "engagement-rings",
            "halo-cushion",
            "emerald-multi-stone-rings",
            "heart-multi-stone-rings",
            "marquise-multi-stone-rings",
            "multi-stone-cushion",
            "oval-multi-stone-rings",
            "pear-multi-stone-rings",
            "princess-multi-stone-rings",
            "shoulder-cushion",
            "solitaire-cushion",
            "diamond"
        ];
        $product_categories_total_updated = 0;
        $product_categories_description = "Browse our stunning range of Round cut ITEM_TO_CHANGE_TWO Stunning certified diamond rings available online and in store.";
        foreach ($product_categories_slugs as $product_cateogry_slug_key => $product_cateogry_slug_value) {
            $categorySlugItem = Category::where('slug', $product_cateogry_slug_value)->first();
            if (!empty($categorySlugItem)) {
                $categorySlugItem->meta_description = str_replace('ITEM_TO_CHANGE_TWO', $categorySlugItem->name, $product_categories_description);
                $categorySlugItem->save();
                $product_categories_total_updated++;
            }
        }

        echo '<br>';
        echo "product categories total updated:- " . $product_categories_total_updated;
        die;

        // $filePath = public_path("imports/redirection_phase_2.csv");
        // $file = fopen($filePath, "r");
        // $newItemsAdded = 0;
        // $existingItems = 0;
        // $totalRecords = 0;
        // //ini_set('memory_limit', '-1');
        // set_time_limit(500);
        //  try {
        //     $records = [];
        //     while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
        //         $totalRecords++;
        //         // $old_url = urlencode(str_replace('https://marlows-diamonds.co.uk','',$getData[0]));
        //         // $new_url = urlencode(str_replace('https://marlows-diamonds.co.uk','',$getData[1]));
        //         $records[] = [
        //             'old_url' => urlencode(str_replace('https://marlows-diamonds.co.uk','',$getData[0])),
        //             'new_url' => urlencode(str_replace('https://marlows-diamonds.co.uk','',$getData[1])),
        //         ];
        //     }
        //     $collection = collect($records);
        //     foreach ($collection->chunk(100) as  $chunk) {
        //         $chunk = $chunk->toArray();
        //         foreach ($chunk as $key => $value) {
        //             $item = UrlRedirects::where('old_url', $value['old_url'])->first();
        //             if(!empty($item)){
        //                 $item->new_url = $value['new_url'];
        //                 $item->is_deleted = 0;
        //                 $item->save();
        //                 $existingItems++;
        //             }else{
        //                 $new_url = new UrlRedirects();
        //                 $new_url->old_url = $value['old_url'];
        //                 $new_url->new_url = $value['new_url'];
        //                 $new_url->save();
        //                 $newItemsAdded++;
        //             }
        //         }
        //         // HKDiamondStock::insert($chunk->toArray());
        //         // $recordsAdded = $recordsAdded + $chunk->count();
        //     }
        //     echo 'existingItems:- ' . $existingItems;
        //     echo '<br>';
        //     echo 'newItemsAdded:- ' . $newItemsAdded;
        //     echo '<br>';
        //     echo 'Total itmes :- ' . $totalRecords;
        //     //prd($records);
        // } catch (\Exception $th) {
        //     prd($th);
        //     echo 'totalRecordsAdded:- '. $newItemsAdded;die;
        // }



        // $filePath = public_path('revert_redirect.json');
        // $fileData = file_get_contents($filePath, "r");
        // $urls = json_decode($fileData);

        // $totalAffectedRecords = 0;
        // foreach($urls as $url){
        //     $old_url =  urlencode($url);
        //     $redirectInfo = UrlRedirects::where('old_url',$old_url)->where('is_deleted',0)->first();
        //     if(!empty($redirectInfo)){
        //         $redirectInfo->is_deleted = 1;
        //         $redirectInfo->save();
        //         $totalAffectedRecords++;
        //     }
        // }

        // echo 'totalAffectedRecords:- ' . $totalAffectedRecords . '<br>';
        // echo 'totalRecords:- ' . count($urls);die;

        // $productSlugs =
        // Products::select(['slug','id','title','description','lab_description','categories'])
        // ->whereRaw('FIND_IN_SET(2, categories) OR FIND_IN_SET(47, categories)')
        // ->get();
        // // ;
        // // prd($productSlugs->toSql());

        // $fileName = date('d-m-Y') .'-product-new-urls.csv';
        // $headers = array(
        //     "Content-type"        => "text/csv; charset=utf-8",
        //     "Content-Disposition" => "attachment; filename=$fileName",
        //     "Pragma"              => "no-cache",
        //     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        //     "Expires"             => "0"
        // );

        // $columns = array('id', 'Slug','title', 'Description','Lab description','Html description','Html lab description');
        // $callback = function() use($productSlugs, $columns) {
        //     $file = fopen('php://output', 'w');
        //     fputcsv($file, $columns);

        //     foreach ($productSlugs as $key => $value) {

        //         $replaceText = [
        //             "Diamond Color F-G Clarity VS-SI",
        //             "Diamond Colour F-G Clarity VS-SI",
        //             "Diamond quality is FVS",
        //             "Diamond colour F, Clarity VS",
        //             "Diamond color F-G diamond clarity VS-SI",
        //             "Diamond colour F-G diamond clarity VS-SI",
        //             "Diamond Colour G-H Clarity SI",
        //             "Diamond Clarity G-H SI",
        //             "Diamond Color G-H Clarity SI",
        //             "G SI Quality",
        //         ];

        //         $lab_description =  $value->description;
        //         foreach ($replaceText as $replace_key => $replace_value) {
        //             $lab_description = str_replace($replace_value, 'Diamond Color D-E Clarity VVS',$lab_description );
        //         }


        //         $row['id']  = $value->id;
        //         $row['slug']  = $value->slug;
        //         $row['title']  = $value->title;
        //         $row['description']  = strip_tags($value->description);
        //         $row['lab_description']  = strip_tags($lab_description);
        //         $row['description_with_html']  = $value->description;
        //         $row['lab_description_with_html']  = $lab_description;
        //         fputcsv($file, array($row['id'],$row['slug'],$row['title'], $row['description'], $row['lab_description'], $row['description_with_html'], $row['lab_description_with_html']));
        //     }
        //     fclose($file);
        // };

        // return response()->stream($callback, 200, $headers);


        // %2Fblog-resources%2Fpage%2F9
        // $data = UrlRedirects::where(['type'=>'other', 'is_active'=>1 ])->get();
        // foreach ($data as $key => $value) {
        //     // $data
        //     $value->old_url = urlencode($value->old_url);
        //     $value->new_url = urlencode($value->new_url);
        //     $value->is_active = 0;
        //     $value->save();
        // }
        // echo $data->count();

        // SitemapUrls::generateXml();

        /** Import all redirect urls */
        // TODO:
        //SELECT * FROM `md_products` WHERE dfinder_status=1 AND lab_description is null;
        // $add_description = "<div>All of our sustainable diamonds in this section come with independent diamond reports (GIA/IGI/WGI/GCAL) for peace of mind. All our diamonds are grown in labs under our supervision with the aim to achieve carbon neutrality within these labs by 2030. These diamonds are polished by semi automatic machines to achieve perfection with cut polish and symmetry. None of our lab grown diamonds have any fluorescence, as such no sparkle is lost. Our diamonds are manufactured under our Trademark (pending) Green Earth Diamonds</div>";
        // $products = Products::where('dfinder_status',1)->whereNull('lab_description')->get();
        // $totalUpdated = 0;
        // foreach ($products as $product_key => $product_value) {
        //     $product_value->lab_description = $add_description .'<br />'. $product_value->description;
        //     if($product_value->save()){$totalUpdated++;}
        // }
        // echo 'Total updated:- ' . $totalUpdated;
        // prd();

        // $filePath = public_path('exports/products_description_live.csv');
        // $file = fopen($filePath, "r");
        // $totalRecordsAdded = 0;

        // try {
        //     $records = [];
        //     while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){

        //         $product = Products::where('id', $getData[0])->first();
        //         // $records[] = $getData;
        //         if(!empty($product)){
        //             $product->old_description = $product->description;
        //             $product->description = '<p>' . $getData[3] . '</p>';
        //             $product->lab_description = '<p>'. $getData[4] . '</p>';
        //             $product->save();
        //             $totalRecordsAdded++;
        //         }

        //     }
        //     // prd($records);
        //     echo 'totalRecordsAdded- success:- '. $totalRecordsAdded;die;
        // } catch (\Exception $th) {
        //     prd($th);
        //     echo 'totalRecordsAdded:- '. $totalRecordsAdded;die;
        // }die;
        // TODO:

        // while (($getData = fgetcsv($file, 10000, ",")) !== FALSE){
        //     $old =  $getData[0];
        //     $new = str_replace('https://marlows-diamonds.co.uk','',$getData[1]);

        //     $data = UrlRedirects::where(['old_url'=> $old, 'is_deleted'=>0])->first();
        //     if(empty($data)){
        //         $newRedirect = new UrlRedirects();
        //         $newRedirect->old_url = urlencode($old);
        //         $newRedirect->new_url = urlencode($new);
        //         $newRedirect->type = "other";
        //         $newRedirect->save();
        //         $totalRecordsAdded++;
        //     }

        // }
        // echo 'totalRecordsAdded:- '. $totalRecordsAdded;die;

        // prd($totalRecords);

        /** Export all products urls */
        // $productSlugs = Products::select(['slug','id','old_slug'])->get();
        // $fileName = date('d-m-Y') .'-product-new-urls.csv';
        // $headers = array(
        //     "Content-type"        => "text/csv",
        //     "Content-Disposition" => "attachment; filename=$fileName",
        //     "Pragma"              => "no-cache",
        //     "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        //     "Expires"             => "0"
        // );

        // $columns = array('id', 'Current url', 'Old url');
        // $baseUrl = "https://marlows-diamonds.co.uk/product/";
        // $callback = function() use($productSlugs, $columns, $baseUrl) {
        //     $file = fopen('php://output', 'w');
        //     fputcsv($file, $columns);

        //     foreach ($productSlugs as $key => $value) {
        //         $row['id']  = $value->id;
        //         $row['product']  = $baseUrl . $value->slug;
        //         $row['old_url']  = $baseUrl . $value->old_slug;
        //         fputcsv($file, array($row['id'],$row['product'], $row['old_url']));
        //     }
        //     fclose($file);
        // };

        // return response()->stream($callback, 200, $headers);

        // prd($productSlugs);

        // $productSlugs = Products::pluck('old_slug','id')->toArray();
        // $affectedRows = 0;
        // foreach ($productSlugs as $key => $value) {
        //     $product_data = Products::where('id', $key)->first();
        //     if(!empty($product_data)){
        //         $product_data->slug = $product_data->old_slug;
        //         $product_data->save();
        //         $affectedRows = $affectedRows + 1;
        //     }
        // }


        // $productSlugs = Products::pluck('slug','id')->toArray();
        // $dataToRevert = [];
        // $affectedRows = 0;
        // foreach ($productSlugs as $key => $value) {
        //     $product_data = Products::where('id', $key)->first();
        //     if(!empty($product_data)){
        //         $new_slug = generateSlugProductPurpose($product_data->title,Products::class, "slug",$product_data->id);
        //         $dataToRevert[$affectedRows]['id'] = $product_data->id;
        //         $dataToRevert[$affectedRows]['old_slug'] = $value   ;
        //         $dataToRevert[$affectedRows]['new_slug'] = $new_slug;
        //         $affectedRows = $affectedRows + 1;
        //     }
        // }
        // prd($dataToRevert);


        // $productSlugs = [
        //     "wed002" => "D Shaped Wedding Band | Wed002",
        //     "wed004" => "Court Shape Wedding Band | Wed004",
        //     "wed005" => "Rounded Inner Flatter Style Wedding Band | Wed005",
        //     "wed006" => "Rounded Inner Flatter Style Wedding Band | Wed006",
        //     "wed007" => "Chunky Wedding Bands | Wed007",
        //     "wed010" => "Court Shape Wedding Ring | Wed010",
        //     "wed021" => "Court Shape Wedding Ring | Wed021",
        //     "wed022" => "D Shaped Wedding Band | Wed022",
        //     "wed023" => "Modern 6mm Wedding Band | Wed023",
        //     "wed026" => "Cut Out Diamond Wedding Band | Wed026",
        //     "wed027" => "6mm Court Shaped Round Wedding Band | Wed027",
        //     "wed028" => "5mm Flat Round Cut Diamond Wedding Band | Wed028",
        //     "wed029" => "7mm Princess Cut Diamonds Wedding Band | Wed029",
        //     "wed030" => "6mm Court Shaped Wedding Band | Wed030",
        // ];

        // $affectedRows = 0;
        // // $productSlugs = Products::pluck('slug','id')->toArray();
        // foreach ($productSlugs as $key => $value) {
        //     $product_data = Products::where('slug', $key)->first();
        //     if(!empty($product_data)){

        //         $new_slug = generateSlugProductPurpose($value,Products::class, "slug",$product_data->id);

        //         $product_data->slug = $new_slug;
        //         $product_data->old_slug = $key;
        //         $product_data->title = $value;
        //         $product_data->save();

        //         $url_data = UrlRedirects::where('old_url', $key)->first();
        //         if(!empty($url_data)){
        //             $url_data->new_url = $new_slug;
        //             $url_data->save();
        //         }else{
        //             $new_redirect = new UrlRedirects();
        //             $new_redirect->type = "product";
        //             $new_redirect->old_url = $key;
        //             $new_redirect->new_url = $new_slug;
        //             $new_redirect->save();
        //         }
        //         $affectedRows = $affectedRows + 1;
        //     }
        // }
        // prd($affectedRows);
    }


    public function productListingData(Request $request)
    {

        $productListingData = getProductListing($request['slug'], $request['slug2'], $request['slug3'], $request->all());
        if ($productListingData['status'] == 404) {
            // return view('layouts.errors.404');
            return response()->json([
                'status' => false,
                'message' => "Something went wrong"
            ]);
        } else if ($productListingData['status'] == 200) {
            return response()->json([
                'status' => true,
                'productItems' => $productListingData['productItems'],
                'isNextPage' => $productListingData['isNextPage'],
                'nextPage' => $productListingData['nextPage'],
                "slug" => $request['slug'],
                "slug2" => $request['slug2'],
                "slug3" => $request['slug3']
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Something went wrong"
            ]);
        }
        // prd($productListingData);

        // // echo ;die;
        // $pageNo = !empty($request['page']) ? $request['page'] : 1;

        // // $categoryIds = [
        // //     1,2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54
        // // ];

        // $query = Products::with('getProductImages')->where('status',1);


        // $category_custom_query = "";
        // foreach ($categoryIds as $cat_key => $cat_value) {
        //     if(!$cat_key){  $category_custom_query .= '( '; }
        //     $category_custom_query .= " find_in_set('".$cat_value."',categories)";
        //     if($cat_key+1 != count($categoryIds)){ $category_custom_query .= " OR "; }
        //     else{ $category_custom_query .= ' ) '; }
        // }

        // $getProductListFinal = $query->whereRaw(DB::raw($category_custom_query))->paginate(16,['*'],'page',$pageNo);

        // $productItems = "";
        // if($getProductListFinal->count()){
        //     $productItems = view('front.ajax.productlistajax', compact('getProductListFinal'))->render();
        // }
        // $nextPage = $pageNo+1;
        // $token = csrf_token();
        // if($request->ajax()){
        //     return response()->json([
        //         'status' => $getProductListFinal->count() ? true : false,
        //         'html' => $productItems,
        //         'nextPage' => $nextPage,
        //         'token' => $token
        //     ]);
        // }

        return view('front.pages.multi-category-product-listing', compact(['productItems', 'nextPage']));
    }


    public function generateSitemap(Request $request)
    {

        // ->where('status',1)
        // ->where('status',1)
        $products = Products::select('slug', 'updated_at')->groupBy('slug')->get();
        $posts = Posts::select('slug', 'updated_at')->groupBy('slug')->where('status', 1)->get();
        $posts_categories = PostCategory::select('slug', 'updated_at')->groupBy('slug')->where('status', 1)->get();
        $pages = Pages::select('slug', 'updated_at')->groupBy('slug')->where(['status' => 1, 'is_deleted' => 0])->get();

        $otherPages = [
            'product/wishlist',
            '/',
            'my-account',
            'products/cart',
            'products/wishlist',
            '/users/forget-password',
        ];

        $categorySitemap = $this->categoriesSitemap();
        $dataOfCategories = explode(',', $categorySitemap);
        $categoryUrlsList = [];
        foreach ($dataOfCategories as $category_key => $category_value) {
            if (!empty($category_value)) {
                $categoryItem = explode('@', $category_value);
                $categoryUrl = $this->attachParentSlugToCategory($categoryItem[0]);
                $categoryUrlsList[$category_key]['url'] =  env('APP_ROOT_URL') . '/product-category/' . $categoryUrl;
                $categoryUrlsList[$category_key]['updated_at'] = $categoryItem[1];
            }
        }

        return response()->view('front.sitemap', [
            'products' => $products,
            'posts' => $posts,
            'posts_categories' => $posts_categories,
            'pages' => $pages,
            'otherPages' => $otherPages,
            'categoryUrlsList' => $categoryUrlsList
        ])->header('Content-Type', 'text/xml');
    }


    public function categoriesSitemap($level = 0, $prefix = "")
    {

        $rows = Category::select(['name', 'title', 'id', 'parent_id', 'slug', 'updated_at'])
            ->where('slug', '!=', 'all-products')
            ->where('parent_id', $level)->get();
        $html = '';
        if ($rows->count()) {
            $rows = $rows->toArray();
            foreach ($rows as $row) {
                $html .= $row['slug'] . '@' . $row['updated_at'] . ',';
                $html .= $this->categoriesSitemap($row['id']);
            }
        }
        return $html;
    }

    public function categoriesHtmlSitemap($level = 0, $prefix = "")
    {

        $rows = Category::select(['name', 'title', 'id', 'parent_id', 'slug', 'updated_at'])
            ->where('slug', '!=', 'all-products')
            ->where('parent_id', $level)->get();
        $html = '';
        if ($rows->count()) {
            $rows = $rows->toArray();
            foreach ($rows as $row) {
                $html .= $row['slug'] . '@' . $row['title'] . ',';
                $html .= $this->categoriesHtmlSitemap($row['id']);
            }
        }
        return $html;
    }


    public function attachParentSlugToCategory($categorySlugs = "", $dataToReturn = "")
    {

        $dataToReturn = $categorySlugs . '/' . $dataToReturn;
        $categoryInfo = Category::where('slug', $categorySlugs)->first();

        if (!empty($categoryInfo)) {
            $data = Category::where('id', $categoryInfo->parent_id)->first();
            if (!empty($data)) {
                return $this->attachParentSlugToCategory($data->slug,  $dataToReturn);
            }
        }
        return $dataToReturn;
    }


    public function htmlSiteMap(Request $request)
    {

        // ->where('status',1)
        // ->where('status',1)
        $products = Products::select('slug', 'updated_at', 'title')->groupBy('slug')->get();
        $posts = Posts::select('slug', 'updated_at', 'title')->groupBy('slug')->where('status', 1)->get();
        $posts_categories = PostCategory::select('slug', 'updated_at', 'name')->groupBy('slug')->where('status', 1)->get();
        $pages = Pages::select('slug', 'updated_at', 'title')->groupBy('slug')->where(['status' => 1, 'is_deleted' => 0])->get();

        $otherPages = [
            'Wishlist' => 'product/wishlist',
            'Homepage' => '/',
            'My Account' => 'my-account',
            'Cart' => 'products/cart',
            'Forgot password' => '/users/forget-password',
        ];

        $categorySitemap = $this->categoriesHtmlSitemap();
        $dataOfCategories = explode(',', $categorySitemap);
        $categoryUrlsList = [];
        foreach ($dataOfCategories as $category_key => $category_value) {
            if (!empty($category_value)) {
                $categoryItem = explode('@', $category_value);
                $categoryUrl = $this->attachParentSlugToCategory($categoryItem[0]);
                $categoryUrlsList[$category_key]['url'] = url('product-category/' . $categoryUrl);
                $categoryUrlsList[$category_key]['name'] = $categoryItem[1];
            }
        }

        $data =  (object)['image' => ''];

        return view('front.html_sitemap', compact([
            'products',
            'posts',
            'pages',
            'otherPages',
            'posts_categories',
            'categoryUrlsList',
            'data'
        ]));
    }


    /**
     * Get Product Listing page direct hitting url
     *
     * @param [type] $all
     * @return void
     */
    public function productListPage($all)
    {
        $request = request();
        $path =  $request->path();
        $slugs = explode('/', $path);
        $productListingData = getProductListing($slugs, request()->all());
        if (!empty($productListingData)) {

            $productItems = $productListingData['productItems'];
            $product_count = $productListingData['product_count'];
            
            $isNextPage = $productListingData['isNextPage'];
            $nextPage = $productListingData['nextPage'];
            $categoryData = $productListingData['categoryData'];

            $path = request()->path();

            /** Items for filter */
            $filter_items = ProductFilter::whereHas('product_items', function ($query) {
                $query->where(['is_deleted' => 0, 'is_active' => 1]);
            })
                ->with('product_items')
                ->where(['is_deleted' => 0, 'is_active' => 1])
                ->get();

            $slugText = '';
            if (isset($slugs[1]) && !empty($slugs[1])) {
                $slugText = $slugs[1];
            } elseif (isset($slugs[0]) && !empty($slugs[0])) {
                $slugText = $slugs[0];
            }

            $filterItemTextData = ProductFilterItems::where('item_slug', $slugText)->select('top_text', 'bottom_text')->first();


            if ($request->isMethod('POST')) {
                return response()->json([
                    "status" => true,
                    "productItems" => $productItems,
                    "isNextPage" => $isNextPage,
                    "nextPage" => $nextPage
                ]);
            }

            $data = $categoryData;
            $pageData = Pages::where('slug','engagement-rings')->where(['status'=>1, 'is_deleted'=>0])->first();
            return view('front.pages.product_listing_page', compact([
                'filterItemTextData',
                'productItems',
                'product_count',
                'isNextPage',
                'nextPage',
                'filter_items',
                'categoryData',
                'data',
                'pageData',
                'path',
                'slugs'
            ]));
        } else {
            return view('layouts.errors.404');
        }
    }

   /**
     * Get Product Listing Data 
     *
     * @param Request $request
     * @return void
     */
    public function getProductListData(Request $request)
    {
        $dataArray = [];
        if (isset($request->ids) && !empty($request->ids)) {
           foreach ($request->ids as $key => $value) {
                $dataArray[$value['name']][] = $value['value'];
            }
          }
          $sorting = 'ASC';
            if (isset($request->sorting) && !empty($request->sorting)) {
               $sorting = $request->sorting;
            }
        $dataArray['sorting'] = $request->sorting;
        $dataArray['page'] = $request->page;
        $dataArray['per_page_product'] = $request->per_page_product;
        $dataArray['keyword'] = $request->keyword;
        $slugs = explode('/', $request->path);
        return $productListingData = getProductListing($slugs, $dataArray, $sorting);
        return view('front.includes.productCard', $productListingData);
    }

    public function getProductVariationPrices(Request $request)
    {
        $getRegularPrices = getRagularFilterPrices($request->all(),$request['diamond_type'], $request->slug, $request->metal_type);
        $getLabDiamondPrices = 0;

        if (isset($request->selectedDiamondPrice) || $request->selectedDiamondPrice == "") {
            if(isset($request->type) && $request->type){
                if(isset($request->diamond_type) && $request->diamond_type == 'mined_diamond'){
                    $getLabDiamondPrices = $this->getCustomApiFilterData($request);
                }else{
                    $getLabDiamondPrices = getLabDiamondPrices($request->all())['price'];
                }
            }
        }else{
            $getLabDiamondPrices = $request->selectedDiamondPrice;
        }

        $resultedArray = array_map(function($num) use ($getLabDiamondPrices) {
            return round($num + $getLabDiamondPrices,2);
        }, $getRegularPrices);
        unset($resultedArray['parent_category']);
        if(isset($resultedArray) && !empty($resultedArray)){
            return [
                'status'=> 200,
                'allPrices'=>getFlatDiscountRanges($resultedArray,$getRegularPrices['parent_category'],$request['diamond_type']),
                'getLabDiamondPrices'=>round($getLabDiamondPrices,2),
            ];
        }

        return [
            'status'=> 500,
            'allPrices'=>0.00,
            'getLabDiamondPrices'=>0.00,
        ];
    }
}
