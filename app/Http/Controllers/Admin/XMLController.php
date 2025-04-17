<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountRange;
use App\Http\Controllers\Front\ProductController;

class XMLController extends Controller
{
    public function XMLFunction()
    {
        set_time_limit(0);

        // Products::with(['getProductImages','getProductGallery','getProductVariation'])->chunk(150, function ($records) {
        //     $this->createXMLfileNewFormat($records);

        //     // foreach ($records as $record) {
        //     //     unset($record['id']);
        //     //     $record['created_at'] = date('Y-m-d h:i:s');
        //     //     $record['updated_at'] = date('Y-m-d h:i:s');
        //     //     HariKrishna::create($record->toArray());
        //     // }
        // });

        // Fetch records from database
        // $getProductData = Products::with(['getProductImages','getProductGallery','getProductVariation'])->select('*')->latest()
        // // ->whereRaw("NOT find_in_set(8,categories)")
        // ->get();
        
        $getProductData = Products::with(['getProductImages','getProductGallery','getProductVariation'])->select('*')->where('status',1)
        //->where('id',188)
        ->latest()
        // ->whereRaw("NOT find_in_set(8,categories)")
        ->get();

        $this->createXMLfileNewFormat($getProductData);
        echo "XML Done";
    }

    public function createXMLfileNewFormat($productArray){

        if (!file_exists(public_path('files/'))) {
            mkdir(public_path('files/'), 0777);
        }

        $filePath = public_path('files/book_final.xml');

        $dom     = new \DOMDocument('1.0', 'utf-8');

        $root = $dom->createElement('rss');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', 'http://base.google.com/ns/1.0');
        $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:c', 'http://base.google.com/ns/1.0');
        $root->setAttributeNS('', 'version', '2.0');
        $root->setAttributeNS('', 'encoding', 'utf-8');

        $channelNew = $dom->createElement('channel');

        foreach($productArray as $key => $productArrayNew){

            
            
            $diamondTypeArray = ["lab_grown","mined_diamond"];

            foreach($productArrayNew->getProductVariation as $var => $dataArray){
                $getVariationMetalType = array_filter($dataArray->get_vari_details_id->pluck('value')->toArray());
                $getResult9ctValues = $this->getWordsMatchFunctions($getVariationMetalType,'9ct');
                $getResult18ctValues = $this->getWordsMatchFunctions($getVariationMetalType,'18ct');
                $getResultPlatValues = $this->getWordsMatchFunctions($getVariationMetalType,'plat');
                $getResultSilverValues = $this->getWordsMatchFunctions($getVariationMetalType,'Silver');

                if(!empty($getResult9ctValues)){
                    $getResultValue = $getResult9ctValues[1];
                }else if(!empty($getResult18ctValues)){
                    $getResultValue = $getResult18ctValues[1];
                }else if(!empty($getResultPlatValues)){
                    $getResultValue = $getResultPlatValues[1];
                }else if(!empty($getResultSilverValues)){
                    $getResultValue = $getResultSilverValues[1];
                }

                if(isset($productArrayNew->title_xml) && !empty($productArrayNew->title_xml)){
                    $productArrayNew->title = str_replace('metaltypecolor', $getResultValue, $productArrayNew->title_xml);
                }else{
                    $productArrayNew->title = $productArrayNew->title;
                }

                foreach($diamondTypeArray as $diamondKey => $diamondType){

                    $prod_categories = explode(',',$productArrayNew->categories);
                    if((in_array("50",$prod_categories) || in_array("53",$prod_categories) || in_array("54",$prod_categories)) && $diamondType == 'lab_grown'){
                        
                    }else if(in_array("8", $prod_categories) && $diamondType == 'lab_grown'){
                        // No entry in data
                        if (in_array("18", $prod_categories)){
                            $arrayVariationValue = array_reverse(array_values(array_filter($dataArray->get_vari_details_id->pluck('value')->toArray())));
                            $priceVariationArrayBeforePrices = new Request([
                                'metal_type' => $getResultValue,
                                'variations' => 
                                    $arrayVariationValue,
                                'slug' => $productArrayNew->slug,
                                'diamond_type' => $diamondType,
                                'type' => 0
                            ]);

                            $getFinalPriceArray = $this->getProductVariationPrices($priceVariationArrayBeforePrices);
                            // $getFinalPriceArray = $this->getPriceCalculationFunction($productArrayNew,$diamondType,$dataArray->regular_price);
                            if(isset($getFinalPriceArray) && $getFinalPriceArray != 0){
                                $title = '';
                                $metalType = '';
                                $price = '';
                                $caratType = '';
                                $widthType = '';
                                $diamondWeight = '';
                                $linkQuery = '';
                                foreach($dataArray->get_vari_details_id as $key2 => $var2){
                                    $var2->key = str_replace("attri_","",$var2->key);
                                    if($var2->value){
                                        $linkQuery .= $linkQuery ? '&diamond_type='.$diamondType.'&'.$var2->key.'='.$var2->value : $var2->key.'='.$var2->value;
                                    }
                                    if(isset($var2->key) && $var2->key == 'metal-type'){
                                        $metalType .= str_replace(['9ct ','18ct '],['',''],$var2->value);
                                    }
                                    if(isset($var2->key) && $var2->key == 'carat'){
                                        $caratType .= $var2->value;
                                    }
                                    if(isset($var2->key) && $var2->key == 'total-diamond-weight'){
                                        $diamondWeight .= $var2->value;
                                    }
                                    if(isset($var2->key) && $var2->key == 'width-mm'){
                                        $widthType = $var2->value;
                                    }
                                    $price = $dataArray->regular_price;
                                }

                                echo "data<pre>";
                                print_r($productArrayNew->id);
                                die;

                                $productGroupId        =  'ig_'.$productArrayNew->id;
                                $productName = htmlspecialchars($productArrayNew->title.' - '.(($caratType!='')?$caratType.' - ':'').(($diamondWeight!='')?$diamondWeight.' - ':'').(($widthType!='')?$widthType.' - ':'').(($diamondType!='')?$diamondType.'  ':''));
                                $productId        =  'p_id_'.$productArrayNew->id;
                                $productDescription    =  htmlspecialchars(strip_tags($productArrayNew->short_description));
                                $productQueryLink=  url('').'/product/'.$productArrayNew->slug . ($linkQuery ? '?'.$linkQuery : '');
                                $productLink     =  url('').'/product/'.$productArrayNew->slug;
                                $productImageLink      =  env('APP_IMAGE_STAG_URL').'/storage/'.$productArrayNew->getProductImages->image_url;
                                $productCondition  =  'new';
                                $productAvailability  =  'in_stock';
                                $productIdentifierExists  =  'no';
                                $productType  =  $productArrayNew->cat_details;
                                $product = $dom->createElement('item');
                                $productid  = $dom->createElement('g:id', $productId);
                                $product->appendChild($productid);
                                $title   = $dom->createElement('g:title', $productName);
                                $product->appendChild($title);
                                $description   = $dom->createElement('g:description', $productDescription);
                                $product->appendChild($description);
                                $item_group_id   = $dom->createElement('g:item_group_id', $productGroupId);
                                $product->appendChild($item_group_id);
                                $link    = $dom->createElement('g:link', htmlentities($productQueryLink));
                                $product->appendChild($link);
                                $link    = $dom->createElement('g:product_type', $productType);
                                $product->appendChild($link);
                                $image_link     = $dom->createElement('g:image_link', $productImageLink);
                                $product->appendChild($image_link);
                                $condition = $dom->createElement('g:condition', $productCondition);
                                $product->appendChild($condition);
                                $availability = $dom->createElement('g:availability', $productAvailability);
                                $product->appendChild($availability);
                                $price = $dom->createElement('g:price', isset($getFinalPriceArray['allPrices']['discounted_price'])?$getFinalPriceArray['allPrices']['discounted_price'].' GBP':$getFinalPriceArray['allPrices']['shop_price'].' GBP');
                                $product->appendChild($price);
                                $price = $dom->createElement('g:brand', 'Marlows Diamonds');
                                $product->appendChild($price);
                                $price = $dom->createElement('g:canonical_link', $productLink);
                                $product->appendChild($price);
                                foreach($productArrayNew->getProductGallery as $key => $addImages){
                                    $additional_image_link = $dom->createElement('g:additional_image_link', env('APP_IMAGE_STAG_URL').'/storage/'.$addImages->image_url);
                                    $product->appendChild($additional_image_link);
                                }
                                $shipping_label = $dom->createElement('g:shipping_label', 0.00);
                                $product->appendChild($shipping_label);
                                $gender = $dom->createElement('g:gender', 'Female');
                                $product->appendChild($gender);
                                $age_group = $dom->createElement('g:age_group', 'Adult');
                                $product->appendChild($age_group);
                                $metal = $dom->createElement('g:color', $metalType);
                                $product->appendChild($metal);
                                $identifier_exists = $dom->createElement('g:identifier_exists', $productIdentifierExists);
                                $product->appendChild($identifier_exists);
                                $channelNew->appendChild($product);
                                $root->appendChild($channelNew);
                            }
                        }
                    }else if($getResultValue == 'Silver' && $diamondType == 'mined_diamond'){
                        // No silver with mined diamond variation shown in the xml files.
                    }else{
                        if (in_array("8", $prod_categories)){ 
                            //not upload engagement rings products
                        }else{
                            $arrayVariationValue = array_values(array_filter($dataArray->get_vari_details_id->pluck('value')->toArray()));
                            $priceVariationArrayBeforePrices = new Request([
                                'metal_type' => $getResultValue,
                                'variations' => 
                                    $arrayVariationValue,
                                'slug' => $productArrayNew->slug,
                                'diamond_type' => $diamondType,
                                'type' => 0
                            ]);
        
                            $getFinalPriceArray = $this->getProductVariationPrices($priceVariationArrayBeforePrices);

                            if(isset($getFinalPriceArray) && $getFinalPriceArray != 0){
                                $title = '';
                                $metalType = '';
                                $price = '';
                                $caratType = '';
                                $widthType = '';
                                $diamondWeight = '';
                                $linkQuery = '';
                                foreach($dataArray->get_vari_details_id as $key2 => $var2){
                                    $var2->key = str_replace("attri_","",$var2->key);
                                    if($var2->value){
                                        $linkQuery .= $linkQuery ? '&diamond_type='.$diamondType.'&'.$var2->key.'='.$var2->value : $var2->key.'='.$var2->value;
                                    }
                                    if(isset($var2->key) && $var2->key == 'metal-type'){
                                        $metalType .= str_replace(['9ct ','18ct '],['',''],$var2->value);
                                    }
                                    if(isset($var2->key) && $var2->key == 'carat'){
                                        $caratType .= $var2->value;
                                    }
                                    if(isset($var2->key) && $var2->key == 'total-diamond-weight'){
                                        $diamondWeight .= $var2->value;
                                    }
                                    if(isset($var2->key) && $var2->key == 'width-mm'){
                                        $widthType = $var2->value;
                                    }
                                    $price = $dataArray->regular_price;
                                }
    
    
                                if(isset($linkQuery) && !empty($linkQuery)){
                                    $productGroupId        =  'ig_'.$productArrayNew->id;
                                    $productName = htmlspecialchars($productArrayNew->title.' - '.(($caratType!='')?$caratType.' - ':'').(($diamondWeight!='')?$diamondWeight.' - ':'').(($widthType!='')?$widthType.' - ':'').(($diamondType!='')?$diamondType.'  ':''));
                                    $productId        =  'p_id_'.($productArrayNew->id);
                                    $productDescription    =  htmlspecialchars(strip_tags($productArrayNew->short_description));
                                    $productQueryLink=  url('').'/product/'.$productArrayNew->slug . ($linkQuery ? '?'.$linkQuery : '');
                                    $productLink     =  url('').'/product/'.$productArrayNew->slug;
                                    $productImageLink      =  env('APP_IMAGE_STAG_URL').'/storage/'.$productArrayNew->getProductImages->image_url;
                                    $productCondition  =  'new';
                                    $productAvailability  =  'in_stock';
                                    $productIdentifierExists  =  'no';
                                    $productType  =  $productArrayNew->cat_details;
                                    $product = $dom->createElement('item');
                                    $productid  = $dom->createElement('g:id', $productId);
                                    $product->appendChild($productid);
                                    $title   = $dom->createElement('g:title', $productName);
                                    $product->appendChild($title);
                                    $description   = $dom->createElement('g:description', $productDescription);
                                    $product->appendChild($description);
                                    $item_group_id   = $dom->createElement('g:item_group_id', $productGroupId);
                                    $product->appendChild($item_group_id);
                                    $link    = $dom->createElement('g:link', htmlentities($productQueryLink));
                                    $product->appendChild($link);
                                    $link    = $dom->createElement('g:product_type', $productType);
                                    $product->appendChild($link);
                                    $image_link     = $dom->createElement('g:image_link', $productImageLink);
                                    $product->appendChild($image_link);
                                    $condition = $dom->createElement('g:condition', $productCondition);
                                    $product->appendChild($condition);
                                    $availability = $dom->createElement('g:availability', $productAvailability);
                                    $product->appendChild($availability);
                                    $price = $dom->createElement('g:price', isset($getFinalPriceArray['allPrices']['discounted_price'])?$getFinalPriceArray['allPrices']['discounted_price'].' GBP':$getFinalPriceArray['allPrices']['shop_price'].' GBP');
                                    $product->appendChild($price);
                                    $price = $dom->createElement('g:brand', 'Marlows Diamonds');
                                    $product->appendChild($price);
                                    $price = $dom->createElement('g:canonical_link', $productLink);
                                    $product->appendChild($price);
                                    foreach($productArrayNew->getProductGallery as $key => $addImages){
                                        $additional_image_link = $dom->createElement('g:additional_image_link', env('APP_IMAGE_STAG_URL').'/storage/'.$addImages->image_url);
                                        $product->appendChild($additional_image_link);
                                    }
                                    $shipping_label = $dom->createElement('g:shipping_label', 0.00);
                                    $product->appendChild($shipping_label);
                                    $gender = $dom->createElement('g:gender', 'Female');
                                    $product->appendChild($gender);
                                    $age_group = $dom->createElement('g:age_group', 'Adult');
                                    $product->appendChild($age_group);
                                    $metal = $dom->createElement('g:color', $metalType);
                                    $product->appendChild($metal);
                                    $identifier_exists = $dom->createElement('g:identifier_exists', $productIdentifierExists);
                                    $product->appendChild($identifier_exists);
                                    $channelNew->appendChild($product);
                                    $root->appendChild($channelNew);
                                }
                            }
                        }

                    }
                }
            }
        }
        $dom->appendChild($root);
        $dom->save($filePath);
    }

    public function getProductVariationPrices(Request $request)
    {
        $getRegularPrices = getRagularFilterPrices($request->all(),$request['diamond_type'], $request->slug, $request->metal_type);
        $getLabDiamondPrices = 0;

        if (isset($request->selectedDiamondPrice) || $request->selectedDiamondPrice == "") {
            if(isset($request->type) && $request->type){
                if(isset($request->diamond_type) && $request->diamond_type == 'mined_diamond'){
                    $getLabDiamondPricesNew = new ProductController;
                    $getLabDiamondPrices = $getLabDiamondPricesNew->getCustomApiFilterData($request);
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

    function getWordsMatchFunctions($getVariationMetalType,$word) {
        $results    = array_filter(
            $getVariationMetalType,
            function($value) use ($word){
                return preg_match('/' . $word . '/i', $value);
            }
        );
        return array_filter(array_merge(array(0), $results));
    }

}
