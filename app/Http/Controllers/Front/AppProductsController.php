<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use SoapClient;
use App\Http\Controllers\Admin\CategoryController;
use App\Models\AppProducts;
use App\Models\AppProductCategories;
use App\Models\AppProductImages;
use App\Models\AppProductAttributeVariations;
use App\Models\AppProductAttributes;
use App\Models\AppProductAttributeVariationDescripiton;
use App\Models\Masters;
use App\Models\Category;
use App\Models\GlobalCombinations;
use App\Models\GlobalCombinationsVariations;


use App\Models\Products;
use App\Models\ProductVariationAttributes;
use App\Models\Attributes;
use App\Models\ProductVariations;
use App\Models\ProductVariationDetails;

use View;

use billythekid\dekopay\Core\DekoPayApiClient;


class AppProductsController extends Controller{

    public function __construct(Request $request){
        $this->view_path = "admin.app_products";
        $this->default_pagination_limit = 12;
        $this->module_name = "Products";
        $this->route_path = "admin.app_products";
    }

    /**
     * getProductDetails
     * slug of product
     */
    public function getProductDetails(Request $request){
        
        $productSlug = $request['slug'];
        $getProduct = AppProducts::with(['getProductImages'])->where('slug',$productSlug)->first();
        if(empty($getProduct)){
            return view('layouts.errors.404');
        }
        $requestData = $request->query() ? $request->query() : [];

        /** Deko live api */
        $dekoEnabled = true;
        $pay_mode =  env('DEKOPAY_MODE');
        if ($dekoEnabled) {
            $url = ($pay_mode == 'live' ? 'https://secure.dekopay.com/' : 'https://test.dekopay.com/') . 'js_api/FinanceDetails.js.php?api_key=' . env('DEKOPAY_API_KEY');
        }

        /** get product categories */
        $prod_categories = AppProductCategories::where(['product_id'=>$getProduct->id, 'is_active'=>1, 'is_deleted'=>0])->pluck('category_id')->toArray();

        /** Check if plain category exists */
        $checkPlanCat = Category::select('id')->whereIn('id', $prod_categories)->where('name', 'LIKE', '%plain%')->get()->toArray();
        if (!empty($checkPlanCat)){ $plainband = true; }else { $plainband = false; }

        /** Check if plan category of multi stone */
        $checkPlanCatMultiStone = Category::select('id')->whereIn('id', $prod_categories)->where('name', 'LIKE', '%Multi-Stone%')->get()->toArray();
        if (!empty($checkPlanCatMultiStone)) {$plainbandMulti = true;} else {$plainbandMulti = false;}

        /** Check if category exists in Diadmonds jewellery */
        $checkPlanCatJwellery = Category::select('id')->whereIn('id', $prod_categories)->where('name', 'LIKE', '%Diamond Jewellery%')->get()->toArray();
        if (!empty($checkPlanCatJwellery)) {$plainbandJewellery = true;} else {$plainbandJewellery = false;}

        // store in session for recent viewd products start
        $recentProduct = session()->get('recentproducts', []);

        /** Check if global combination is added in product */
        // $selectedCombination = AppProductAttributes::with(['selectedVariations'])->where(['product_id'=> $product_id,'is_active'=>1,'is_deleted'=>0,'is_attribute'=>0])->value('global_combination_id');
        // if(!empty($selectedCombination)){ $globalCombination = true; }else{  }

        $recentProduct[$getProduct->id] = [
            "name" => $getProduct->title,
            "slug" => $getProduct->slug,
            "image" => isset($getProduct->getProductImages) ? $getProduct->getProductImages->image_url : '',
        ];

        session()->put('recentproducts', $recentProduct);
        // store in session for recent viewd products End

        /** get product images */
        $prodImages = AppProductImages::select(['*', 'image as image_url' ])->where('product_id', $getProduct->id)->get();
        if ($getProduct->dfinder_status) {



            // $productVariationId = ProductVariations::where('product_id', $getProduct->id)->pluck('id')->toArray();
            // if (isset($productVariationId) && !empty($productVariationId)) {
            //     $variDetails =  ProductVariationDetails::whereIn('variation_id', $productVariationId)
            //         ->where('value', 'Platinum')
            //         ->select('id', 'variation_id', 'value')
            //         ->first();

            //     if (empty($variDetails)) {
            //         $variDetails =  ProductVariationDetails::whereIn('variation_id', $productVariationId)
            //             ->select('id', 'variation_id', 'value')
            //             ->first();
            //     }
            // }

            $variationDetails = null;
            // ProductVariations::where('id', $variDetails->variation_id)
            //     ->select('vari_image', 'vari_video', 'regular_price', 'sale_price')
            //     ->first();


            return  view(
                'front.pages.app_products.details_dyes',
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
            
            $variationDetails = null;
            // ProductVariations::where('product_id', $getProduct->id)
            //     ->select('vari_image')
            //     ->groupBy('vari_image')
            //     ->get();
                
            return  view(
                'front.pages.app_products.details_dno',
                [
                    'data' => $getProduct,
                    'prodImages' => $prodImages,
                    'plainbandMulti' => $plainbandMulti,
                    'plainbandJewellery' => $plainbandJewellery,
                    'url' => $url,
                    'plainband' => $plainband,
                    'variationImages' => $variationDetails,
                    'requestData' => $requestData
                ]
            );
        }
        // } else {
        //     return view('layouts.errors.404');
        // }
        




    }//endof getProductDetails



    public function getCustomFilter(Request $request){

        $product_id = Products::where('slug', $request->slug)->value('id'); // old
        if ($product_id != '') {
            $productSelectedAttribute = ProductVariationAttributes::where('product_id', $product_id)->value('attr_values');

            

            if ($productSelectedAttribute != '') {
                $productSelectedAttribute = str_replace('attri_', '', explode(',', $productSelectedAttribute));

                // Get Attributes
                $attributes = Attributes::whereIn('slug', $productSelectedAttribute)->get()->toArray();
                prd($attributes);

                if (!empty($attributes)) {

                    $variation_ids = ProductVariations::where('product_id', $product_id)->pluck('id')->toArray();

                    $variationArray = $final_attr = [];
                    foreach ($attributes as $key => $attribute) {
                        $final_attr['name'] = $attribute['name'];
                        $final_attr['slug'] = $attribute['slug'];
                        $selected = isset($request[$final_attr['slug']]) ? $request[$final_attr['slug']] : '';


                        $explode_attr = explode('|', $attribute['values']);

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

                        if ($is_empty)
                            $final_attr['attri_' . $attribute['slug']] = $explode_attr;
                        else
                            $final_attr['attri_' . $attribute['slug']] = $found;

                        $variationArray[] = View::make('front.includes.show_variations', ['final_attr' => $final_attr, 'type' => $request->type, 'selected' => $selected])->render();
                    }
                }
                return $variationArray;
            }
        }
        return response()->json(['status' => 'Not attribute selected']);
    }

    public function getCustomFilterNew(Request $request){

        $product_id = AppProducts::where('slug', $request->slug)->value('id');
        if (!empty($product_id)) {

            $selectedAttributes = AppProductAttributes::with(['selectedVariations'])->where(['product_id'=> $product_id,'is_active'=>1,'is_deleted'=>0,'is_attribute'=>1])->get();
            $returnHtml = [];

            // prd($selectedAttributes->toArray());

            if($selectedAttributes->count()){
                foreach ($selectedAttributes as $attr_key => $attr_value) {
                    $html = '<div class="type-variations-col">';
                    $html .= '<label for="'.$attr_value['information']['slug'].'">'.$attr_value['information']['name'].'</label>';
                    $html .= '<select name="'.$attr_value['information']['slug'].'" id="'.$attr_value['information']['slug'].'" class="form-control">';
                    if(!empty($attr_value->selectedVariations)){
                        foreach ($attr_value->selectedVariations as $variations_key => $variations_value) {
                            $html .= '<option value="'. $variations_value['selected_variation_data']['id'] .'">'.$variations_value['selected_variation_data']['name'].'</option>';
                        }
                    }
                    $html .= '</select>';
                    $html .= '</div>';
                    array_push($returnHtml, $html);
                }
            }


            $selectedCombination = AppProductAttributes::with(['selectedVariations'])->where(['product_id'=> $product_id,'is_active'=>1,'is_deleted'=>0,'is_attribute'=>0])->value('global_combination_id');
            if(!empty($selectedCombination)){
                $combinationData = GlobalCombinationsVariations::where(['global_combinations_id'=>$selectedCombination, 'is_deleted'=>0,'is_active'=>1])->get();
                $new_ar = array_map(function($item){ return $item['variations_id']['metal_types']; },$combinationData->toArray());
                $new_ar = array_unique($new_ar);
                $metal_types = Masters::whereIn('id', $new_ar)->get();
                if(!empty($metal_types[0]['parent_id'])){
                    $parentData = Masters::where('id',$metal_types[0]['parent_id'])->first();
                    if(!empty($parentData)){
                        $html = '<div class="type-variations-col">';
                        $html .= '<label for="'.$parentData['slug'].'">'.$parentData['name'].'</label>';
                        $html .= '<select name="'.$parentData['slug'].'" id="'.$parentData['name'].'" class="form-control">';
                        if(!empty($metal_types)){
                            foreach ($metal_types as $variations_key => $variations_value) {
                                $html .= '<option value="'. $variations_value['id'] .'">'.$variations_value['name'].'</option>';
                            }
                        }
                        $html .= '</select>';
                        $html .= '</div>';
                        array_push($returnHtml, $html);
                    }
                }
            }
            return $returnHtml;

            // echo json_encode($selectedCombination);die;
            // prd($selectedAttributes->toArray());
            // $variations = [];
            // if($productSelectedAttribute->count()){
            //     foreach ($productSelectedAttribute as $attribute_key => $attribute_value) {
            //         if($attribute_value->is_attribute){
            //             $attribute_info = json_decode($attribute_value->information);
            //             $selectedVariations = AppProductAttributeVariationDescripiton::where(['product_id'=>$product_id , 'selected_variation_parent_id'=> $attribute_value->attribute_id, 'is_deleted'=>0, 'is_active'=>1 ] )->get();
            //             $selected_varitions_join = [];
            //             foreach ($selectedVariations as $selectedVariations_key => $selectedVariations_value) {
            //                 $selectedVariationsInfo = json_decode($selectedVariations_value->selected_variation_data);
            //                 array_push($selected_varitions_join, $selectedVariationsInfo->name);
            //             }
            //             $dataForVariations = [
            //                 'id'=> $attribute_value->id,
            //                 'name' =>  $attribute_info->name,
            //                 'slug' =>$attribute_info->slug,
            //                 'selectedVariationsInfo' => implode(' | ',$selected_varitions_join)
            //             ];
            //             array_push($variations, $dataForVariations);
            //         }else{
            //             $masterInfo = Masters::where(['type'=>'metal_types', 'is_active'=>1, 'is_deleted'=>0 ])->pluck('name')->toArray();
            //             $masterInfoParent = Masters::where('id', $masterInfo[0]['parent_id'] )->first();
            //             // $dataForVariations = [
            //             //     'id'=> $attribute_value->id,
            //             //     'name' =>  $attribute_info->name,
            //             //     'slug' =>$attribute_info->slug,
            //             //     'selectedVariationsInfo' => implode(' | ',$selected_varitions_join)
            //             // ];
            //             // array_push($variations, $dataForVariations);
            //             // $combinationData = GlobalCombinations::combinations($attribute_value->global_combination_id);
            //             prd($masterInfoParent);
            //         }
            //     }
            // }
            // prd($variations);
            // if ($productSelectedAttribute != '') {
            //     $productSelectedAttribute = str_replace('attri_', '', explode(',', $productSelectedAttribute));
            //     // Get Attributes
            //     $attributes = Attributes::whereIn('slug', $productSelectedAttribute)->get()->toArray();
            //     if (!empty($attributes)) {
            //         $variation_ids = ProductVariations::where('product_id', $product_id)->pluck('id')->toArray();
            //         $variationArray = $final_attr = [];
            //         foreach ($attributes as $key => $attribute) {
            //             $final_attr['name'] = $attribute['name'];
            //             $final_attr['slug'] = $attribute['slug'];
            //             $selected = isset($request[$final_attr['slug']]) ? $request[$final_attr['slug']] : '';
            //             $explode_attr = explode('|', $attribute['values']);
            //             $getAttrVals = ProductVariationDetails::whereIn('variation_id', $variation_ids)->where('key', 'attri_' . $attribute['slug'])->pluck('value')->toArray();
            //             $found = [];
            //             foreach ($explode_attr as $num) {
            //                 if (in_array(trim($num), $getAttrVals)) {
            //                     $found[] = $num;
            //                 }
            //             }
            //             $is_empty = true;
            //             foreach ($getAttrVals as $value) {
            //                 if ($value != '') {
            //                     $is_empty = false;
            //                 }
            //             }
            //             if ($is_empty)
            //                 $final_attr['attri_' . $attribute['slug']] = $explode_attr;
            //             else
            //                 $final_attr['attri_' . $attribute['slug']] = $found;
            //             $variationArray[] = View::make('front.includes.show_variations', ['final_attr' => $final_attr, 'type' => $request->type, 'selected' => $selected])->render();
            //         }
            //     }
            //     return $variationArray;
            // }
        }
        return response()->json(['status' => 'Not attribute selected']);
    }


    public function getSelectedVariationsData(Request $request){


        $product_id = AppProducts::where('slug', $request->slug)->value('id');
        if (!empty($product_id)) {

            $selectedCombination = AppProductAttributes::with(['selectedVariations'])->where(['product_id'=> $product_id,'is_active'=>1,'is_deleted'=>0,'is_attribute'=>0])->value('global_combination_id');
            if(!empty($selectedCombination)){
                /** if global available then get price and take global combinations */
                $global_varitions = GlobalCombinationsVariations::where(['global_combinations_id'=> $selectedCombination , 'is_active'=>1, 'is_deleted'=> 0 ] )->get()->toArray();
                $global_metals = array_map(function($element){ return  $element['variations_id']['metal_types']; }, $global_varitions);
                $global_metals = array_unique($global_metals); // They all are global combination metal types
                prd($global_metals);

                // if(count($global_varitions)){
                //     foreach ($global_varitions as $global_varitions_key => $global_varitions_value) {
                //         $metalData = Masters::where('id', $global_varitions_value['variations_id']['metal_types'])->first()->toArray();
                //         $global_varitions[$global_varitions_key]['variation_metal_name'] = $metalData['name'];
                //         $metalData = Masters::where('id', $global_varitions_value['variations_id']['product_type'])->first()->toArray();
                //         $global_varitions[$global_varitions_key]['variation_product_type_name'] = $metalData['slug'] == 'mined-diamond' ? 'mined' : 'lab_grown';
                //     }
                //     $global_metals = array_map(function($element){ return  $element['variation_metal_name']; }, $global_varitions);
                //     $global_metals = array_unique($global_metals);
                //     $new_ar = array_diff($request['variations'], $global_metals);
                // } 
            }

            // $valid_diamond_types = ['lab_grown','mined'];
            // if(!empty($request['diamond_type']) &&  in_array($request['diamond_type'],$valid_diamond_types)){
                
            // }
        }

        // $product_id = Products::where('slug', $request->slug)->value('id');

        // if ($product_id != '') {
        //     $getProduct = Products::where('slug', $request->slug)->first();

        //     $prod_categories = explode(',', $getProduct->categories);

        //     if (in_array("18", $prod_categories)) {
        //         $prod_categories = ['18'];
        //         $checkPlanCatArray = Category::whereIn('id', $prod_categories)->first()->toArray();
        //     } else {
        //         $checkPlanCatArray = Category::whereIn('id', $prod_categories)->where('parent_id', 0)->first()->toArray();
        //     }
        //     $disPercentage = Discount::select('category_id', 'discount', 'inc_percentage', 'end_date','is_login_users')
        //                     ->where('category_id', $checkPlanCatArray['id'])
        //                     ->where('status', 1)
        //                     ->first();
        //     $getProductVariationId = ProductVariations::where('product_id', $product_id)
        //                             ->pluck('id')
        //                             ->toArray();
        //     if (!empty($getProductVariationId)) {
        //         $getVariDetails = ProductVariationDetails::groupBy('value')
        //                         ->whereIn('variation_id', $getProductVariationId)
        //                         ->whereIn('value', $request->variations)
        //                         ->get()
        //                         ->toArray();
        //         $attributeCount = count($request->variations);
        //         // prd($getProductVariationId);
        //         foreach ($getProductVariationId as $key1 => $productVariationId) {
        //             $variationDetails = array();
        //             foreach ($request->variations as $key2 => $variations) {
        //                 $getVariDetails =   ProductVariationDetails::where('variation_id', $productVariationId)
        //                                     ->where('value', $variations)
        //                                     ->get()
        //                                     ->toArray();
        //                 if (!empty($getVariDetails))
        //                     $variationDetails[] = $getVariDetails;
        //             }
        //             if ($attributeCount == count($variationDetails))
        //                 break;
        //         }
        //         // prd($variationDetails);
        //     }
        //     $vat = getVAT();
        //     $newArray = [];
        //     if (isset($getVariDetails) && !empty($getVariDetails)) {
        //         $getSelectedVariationVideoImages = ProductVariations::where('id', $variationDetails[0][0]['variation_id'])
        //                                             ->select(DB::raw('(regular_price) as regular_price_without_vat'), DB::raw('(sale_price) as sale_price_without_vat'), 'vari_image', 'vari_video', 'regular_price', 'sale_price')
        //                                             ->first();
        //         if ($request->diamond_type == 'lab_grown' && $getSelectedVariationVideoImages->regular_price_without_vat <= 3000) {
        //             $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat - ($getSelectedVariationVideoImages->regular_price_without_vat * 0.35)); 
        //         } elseif ($request->diamond_type == 'lab_grown' && $getSelectedVariationVideoImages->regular_price_without_vat > 3000) {
        //             $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat - ($getSelectedVariationVideoImages->regular_price_without_vat * 0.5));
        //         } else {
        //             $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat);
        //         }
        //         $increaseDiscount = 1;
        //         $discountPercentage = 1;
        //         $regular_p_final = (($regular_p_final) * $increaseDiscount) * $vat;
        //         if (isset($disPercentage) && !empty($disPercentage)) {
        //             $disPercentage = $disPercentage->toArray();
        //             if($disPercentage['is_login_users']){
        //                 $isDiscountApplicable = auth()->guard('customer')->check();
        //             }else{
        //                 $isDiscountApplicable = true;
        //             }
        //             if ( $isDiscountApplicable ) {
        //                 if (isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1) {
        //                     $increaseDiscount = 1 + ($disPercentage['inc_percentage'] / 100);
        //                 } else {
        //                     $increaseDiscount = 1;
        //                 }
        //                 $regular_p_final = (($regular_p_final) * $increaseDiscount) * $vat;
        //                 if ($disPercentage['end_date'] >= date('Y-m-d')) {
        //                     $getDiscountRange = DiscountRange::select('category_id', 'from_price', 'to_price', 'discount')
        //                                         ->where('category_id', $checkPlanCatArray['id'])
        //                                         ->whereRaw('"' . $regular_p_final . '" between `from_price` and `to_price`')
        //                                         ->first();
        //                     $discountPercentage = 1 + ($disPercentage['discount'] / 100);
        //                     if (isset($getDiscountRange) && !empty($getDiscountRange->discount)) {
        //                         if ($getDiscountRange->discount > 1) {
        //                             $discountPercentage = 1 + ($getDiscountRange->discount / 100);
        //                         } else {
        //                             $discountPercentage = 1;
        //                         }
        //                     } else {
        //                         $discountPercentage = 1;
        //                     }
        //                 } else {
        //                     $discountPercentage = 1;
        //                 }
        //             } else {
        //                 if (isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1) {
        //                     $increaseDiscount = 1 + ($disPercentage['inc_percentage'] / 100);
        //                 } else {
        //                     $increaseDiscount = 1;
        //                 }
        //                 $regular_p_final = (($regular_p_final) * $increaseDiscount) * $vat;
        //             }
        //         }
        //         $regular_p_discount_final = $regular_p_final / $discountPercentage;
        //         $newArray['vari_image'] = $getSelectedVariationVideoImages->vari_image;
        //         $newArray['vari_video'] = $getSelectedVariationVideoImages->vari_video;
        //         $newArray['regular_price'] = $getSelectedVariationVideoImages->regular_price;
        //         $newArray['regular_price_with_vat'] = round($regular_p_final);
        //         $newArray['regular_price_with_vat_discount'] = round($regular_p_discount_final);
        //         return response()->json($newArray);
        //     } else {
        //         return response()->json(['statusCode' => '500', 'msg' => 'No Variation Found']);
        //     }
        // }
    }
}