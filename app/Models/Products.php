<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Masters;
use App\Models\ProductVariationsMaster;
use App\Models\GlobalCombinationsVariations;
use App\Models\DiscountRange;
use App\Models\Category;
use App\Models\Discount;
use App\Models\ProductVariations;
use App\Models\ProductVariationDetails;
use App\Models\LabPricesList;
use DB;


class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title','slug','old_slug','tags','is_variable','diamond_shape','short_description','description','lab_description','old_description','categories','sale_price','regular_price','meta_title','meta_keyword','meta_description','status','dfinder_status','is_featured','is_taxable','stock_status'
    ];

    protected $appends = ['cat_details','ProductVariationMinMaxPrice','AdditionalPriceMetalType'];

    public function getProductImages(){
        return $this->hasOne(ProductImages::class,'product_id','id')->where('is_featured',1);
    }

    public function getProductGallery(){
        return $this->hasMany(ProductImages::class,'product_id','id');
    }

    public function getProductVariation(){
        return $this->hasMany(ProductVariations::class,'product_id','id');
    }

    public function getProductVariationMinMaxPriceAttribute(){
        return ProductVariations::select(\DB::raw('MIN(regular_price) AS MinPrice, MAX(regular_price) AS MaxPrice'))->where('product_id',$this->id)->first();
        // return $this->hasOne(ProductVariations::class,'product_id','id')->select(\DB::raw('MIN(regular_price) AS minPrice, MAX(regular_price) AS MaxPrice'));
    }

    public function getAdditionalPriceMetalTypeAttribute(){
        
        $getVariationId = ProductVariations::where('product_id',$this->id)->pluck('id');
        $get18CaratRecord = ProductVariationDetails::whereIn('variation_id',$getVariationId)->where('value','Platinum')->first();
        $getVariationIdArray = ProductVariations::where('id',$get18CaratRecord->variation_id)->first();

        $newPrice = LabPricesList::whereBetween('carat', [1.00, 1.19])->where(['color'=> 'D', 'clarity'=>'VS2','is_active'=>1, 'is_deleted'=>0])->first();

        $finalAdditionalPrices = [
            'regular_price' => $getVariationIdArray->regular_price,
            'lab_price' => $newPrice->price
        ];

        return $finalAdditionalPrices;
    }

    public function getCatDetailsAttribute()
    {
        $ids = explode(',',$this->categories);
        $users = Category::whereIn('id',$ids)->pluck('name')->toArray();
        return implode(',',$users);
    }


    public static function product_pricing($data=[]){
        $productData = self::where('slug', $data['slug'])->first();
        $runOldCode = true;

        $priceUpdateBy = 35;

        if(!empty($productData)){
            $prodCategoriesDJ = explode(',', $productData->categories);
            if(in_array('2', $prodCategoriesDJ)  ||  in_array('47', $prodCategoriesDJ)){

                $allCarats = Masters::where(['type'=>'carat','is_deleted'=>0, 'is_active'=>1])->pluck('name');
                if($allCarats->count()){ $allCarats = $allCarats->toArray(); }else{ $allCarats = []; }
                $metalTypes = Masters::where(['type'=>'metal_types','is_deleted'=>0, 'is_active'=>1])->pluck('name');
                if($metalTypes->count()){ $metalTypes = $metalTypes->toArray(); }else{ $metalTypes = []; }
             
                /** mined and lab_grown id exists in masters table request */
                /** get carat metal type and product type */
                $productType = !empty($data['diamond_type']) && $data['diamond_type'] == 'mined' ? 1 : 2;
                $selectedMetalType = "";
                $selectedMetalTypeId = "";
                $carat = "";

                foreach ($data['variations'] as $variations_key => $variations_value) {
                    if(in_array($variations_value, $metalTypes)){
                        $selectedMetalType = $variations_value;
                        $metalData = Masters::where(['type'=>'metal_types', 'name'=> $selectedMetalType])->first();
                        $selectedMetalTypeId = $metalData->id;
                    }else if(in_array($variations_value, $allCarats)){
                        $carat = $variations_value;
                    }
                }

                $combinations = ProductVariationsMaster::with(['masterData'])
                                ->whereHas('masterData', function($q) use ($carat) { $q->where('name',$carat); })
                                ->where(['product_id'=> $productData->id, 'is_deleted'=> 0, 'is_active'=>1 ])
                                ->first();
                
                if(!empty($combinations)){
                    $combinations = $combinations->toArray();

                    $combinationsPriceFormula = GlobalCombinationsVariations::where(['is_deleted'=>0 ,'is_active'=> 1, 'global_combinations_id'=> 1 ])
                    ->where('variations_id->metal_types',$selectedMetalTypeId)
                    ->where('variations_id->product_type',$productType)
                    ->first();

                    if(!empty($combinationsPriceFormula)){

                        $combinationsPriceFormula = $combinationsPriceFormula->toArray();

                        $totalPrice =   !empty($combinations['total_price']) ? ( ((float)$combinationsPriceFormula['price']) / 100) * ((float)$combinations['total_price']) : 0;
                        $price = ( ((float)$combinationsPriceFormula['price']) / 100) * ((float)$combinations['price']);
                        $runOldCode = false;


                        // $priceUpdateBy

                        $newArray['formula'] = true;
                        $newArray['regular_price'] = round($price);
                        $newArray['regular_price_with_vat'] = round($price);
                        $newArray['combination_total_price'] = $combinations['price'];
                        $newArray['master_varitation_id'] = $combinations['id'];
                        
                        return $newArray;
                    }
                }
            }
        }


        $product_id = self::where('slug', $data['slug'])->value('id');
        if ($product_id != '' && $runOldCode) {

            // with(['getProductImages', 'getProductVariation'])
            $getProduct = self::where('slug', $data['slug'])->first();

            $prod_categories = explode(',', $getProduct->categories);

            if (in_array("18", $prod_categories)) {
                $prod_categories = ['18'];
                $checkPlanCatArray = Category::whereIn('id', $prod_categories)->first()->toArray();
            } else {
                $checkPlanCatArray = Category::whereIn('id', $prod_categories)->where('parent_id', 0)->first()->toArray();
            }

            $getProductVariationId = ProductVariations::where('product_id', $product_id)
                                    ->pluck('id')
                                    ->toArray();



            if (!empty($getProductVariationId)) {

                $getVariDetails = ProductVariationDetails::groupBy('value')
                                ->whereIn('variation_id', $getProductVariationId)
                                ->whereIn('value', $data['variations'])
                                ->get()
                                ->toArray();
                

                $attributeCount = count($data['variations']);
                // prd($getProductVariationId); request

                foreach ($getProductVariationId as $key1 => $productVariationId) {
                    $variationDetails = array();

                    foreach ($data['variations'] as $key2 => $variations) {
                        $getVariDetails =   ProductVariationDetails::where('variation_id', $productVariationId)
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
                                                    ->select(DB::raw('(regular_price) as regular_price_without_vat'), DB::raw('(sale_price) as sale_price_without_vat'), 'vari_image', 'vari_video', 'regular_price', 'sale_price')
                                                    ->first();
                
                /** Price change for lab grown */
                if ($data['diamond_type']== 'lab_grown' && $getSelectedVariationVideoImages->regular_price_without_vat <= 3000) {
                    $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat - ($getSelectedVariationVideoImages->regular_price_without_vat * 0.35)); 
                } elseif ($data['diamond_type']== 'lab_grown' && $getSelectedVariationVideoImages->regular_price_without_vat > 3000) {
                    $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat - ($getSelectedVariationVideoImages->regular_price_without_vat * 0.5));
                } else {
                    $regular_p_final = ($getSelectedVariationVideoImages->regular_price_without_vat);
                }

                $increaseDiscount = 1;
                $discountPercentage = 1;
                
                $regular_p_final = (($regular_p_final) * $increaseDiscount) * $vat;

                $categorySlugs = Category::whereIn('id',$prod_categories )->pluck('slug');
                if($categorySlugs->count()){
                    $categorySlugs = $categorySlugs->toArray();
                }

                /** Discount not applicable to exclusive to marlows */
                if(in_array('exclusive-to-marlows', $categorySlugs)){
                    $newArray['vari_image'] = $getSelectedVariationVideoImages->vari_image;
                    $newArray['vari_video'] = $getSelectedVariationVideoImages->vari_video;
                    $newArray['regular_price'] = $getSelectedVariationVideoImages->regular_price;
                    $newArray['regular_price_with_vat'] = $getSelectedVariationVideoImages->regular_price;
                    $newArray['regular_price_with_vat_discount'] = $getSelectedVariationVideoImages->regular_price;
                    return $newArray;
                }

                
                $regular_p_discount_final = $regular_p_final / $discountPercentage;
                $newArray['vari_image'] = $getSelectedVariationVideoImages->vari_image;
                $newArray['vari_video'] = $getSelectedVariationVideoImages->vari_video;
                $newArray['regular_price'] = $getSelectedVariationVideoImages->regular_price;
                $newArray['regular_price_with_vat'] = round($regular_p_final);
                $newArray['regular_price_with_vat_discount'] = round($regular_p_discount_final);


                return $newArray;
            } else {
                return ['statusCode' => '500', 'msg' => 'No Variation Found'];
            }
        }
    }


    public static function getMinMaxPrice($productId=""){

        /** Check if product is valid or not */
        $product = Products::where('id',$productId)->first();
        if(empty($product)){
            return null;
        }

        /** Check if product belongs to a specific combintaion */
        $combinations = ProductVariationsMaster::where(['product_id'=> $productId, 'is_deleted'=> 0, 'is_active'=>1 ])->pluck('price');
        if(!empty($combinations) && $combinations && $combinations->count()){
            $combinations = $combinations->toArray();
            return [
                'minimumValue' => round(((55/ 100) * min($combinations))),
                'maximumValue' => round(max($combinations)),
            ];
        }else{
            
            /** If category belongs to engagment rings with dfinder_status = 1 
             * get price range from lab_grown table
            */
            if($product->dfinder_status == 1){
                $product_variations = ProductVariations::where(['product_id'=> $product->id])->where('regular_price', '>', 0 )->pluck('regular_price');
                if(!empty($product_variations) && $product_variations->count()){
                    $all_prices = LabPricesList::where(['is_deleted'=>0,'is_active'=>1])->pluck('price');
                    $vat = getVAT();
                    $product_variations = $product_variations->toArray();
                    return [
                        'minimumValue' => round((min($product_variations) + min($all_prices->toArray())) * $vat),
                        'maximumValue' => round((max($product_variations) + max($all_prices->toArray())) * $vat),
                    ];
                }
            }

            /** for all other products that are not belongs to combination and d-finder status */
            $product_variations = ProductVariations::where(['product_id'=> $product->id])->where('regular_price', '>', 0 )->pluck('regular_price');
            if(!empty($product_variations) && $product_variations->count()){
                $product_variations = $product_variations->toArray();
                return [
                    'minimumValue' => round(min($product_variations)),
                    'maximumValue' =>  round(max($product_variations)),
                ];
            }
        }
        return null;

    }

}
