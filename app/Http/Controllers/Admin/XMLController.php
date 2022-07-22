<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountRange;

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
        $getProductData = Products::with(['getProductImages','getProductGallery','getProductVariation'])->select('*')->latest()
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

            $diamondTypeArray = ["lab_grown","mined"];

            foreach($productArrayNew->getProductVariation as $var => $dataArray){
                foreach($diamondTypeArray as $diamondKey => $diamondType){

                    $prod_categories = explode(',',$productArrayNew->categories);

                    if(in_array("8", $prod_categories) && $diamondType == 'lab_grown'){
                        // No entry in data
                        if (in_array("18", $prod_categories)){
                            $getFinalPriceArray = $this->getPriceCalculationFunction($productArrayNew,$diamondType,$dataArray->regular_price);
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
                                        $metalType .= $var2->value;
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


                                $productGroupId        =  'ig_'.$productArrayNew->id;
                                $productName = htmlspecialchars($productArrayNew->title.' - '.(($caratType!='')?$caratType.' - ':'').(($diamondWeight!='')?$diamondWeight.' - ':'').(($widthType!='')?$widthType.' - ':'').(($diamondType!='')?$diamondType.' - ':'').$metalType);

                                $productId        =  'p_id_'.md5($productName);



                                $productDescription    =  htmlspecialchars(strip_tags($productArrayNew->short_description));

                                $productQueryLink=  url('').'/product/'.$productArrayNew->slug . ($linkQuery ? '?'.$linkQuery : '');
                                $productLink     =  url('').'/product/'.$productArrayNew->slug;
                                $productImageLink      =  url('').'/storage/'.$productArrayNew->getProductImages->image_url;
                                $productPrice  =  round($getFinalPriceArray);
                                $productCondition  =  'new';
                                $productAvailability  =  'in stock';
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

                                // $link    = $dom->createElement('g:google_product_category', '200');

                                // $product->appendChild($link);

                                $image_link     = $dom->createElement('g:image_link', $productImageLink);

                                $product->appendChild($image_link);

                                $condition = $dom->createElement('g:condition', $productCondition);

                                $product->appendChild($condition);

                                $availability = $dom->createElement('g:availability', $productAvailability);

                                $product->appendChild($availability);

                                $price = $dom->createElement('g:price', $productPrice.' GBP ');

                                $product->appendChild($price);

                                $price = $dom->createElement('g:brand', 'Marlows Diamonds');

                                $product->appendChild($price);

                                $price = $dom->createElement('g:canonical_link', $productLink);

                                $product->appendChild($price);

                                foreach($productArrayNew->getProductGallery as $key => $addImages){
                                    $additional_image_link = $dom->createElement('g:additional_image_link', url('').'/storage/'.$addImages->image_url);

                                    $product->appendChild($additional_image_link);
                                }



                                $shipping_label = $dom->createElement('g:shipping_label', 0.00);

                                $product->appendChild($shipping_label);

                                $gender = $dom->createElement('g:gender', 'Female');

                                $product->appendChild($gender);

                                $age_group = $dom->createElement('g:age_group', 'Adult');

                                $product->appendChild($age_group);

                                $metal = $dom->createElement('g:metal', $metalType);

                                $product->appendChild($metal);

                                $identifier_exists = $dom->createElement('g:identifier_exists', $productIdentifierExists);

                                $product->appendChild($identifier_exists);

                                $channelNew->appendChild($product);
                                $root->appendChild($channelNew);
                            }
                        }

                    }else{
                        $getFinalPriceArray = $this->getPriceCalculationFunction($productArrayNew,$diamondType,$dataArray->regular_price);

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
                                    $metalType .= $var2->value;
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
                                $productName = htmlspecialchars($productArrayNew->title.' - '.(($caratType!='')?$caratType.' - ':'').(($diamondWeight!='')?$diamondWeight.' - ':'').(($widthType!='')?$widthType.' - ':'').(($diamondType!='')?$diamondType.' - ':'').$metalType);

                                $productId        =  'p_id_'.md5($productName);



                                $productDescription    =  htmlspecialchars(strip_tags($productArrayNew->short_description));
                                // $productDescription = str_replace(['<p>', '</p>'], '', $productDescription);


                                $productQueryLink=  url('').'/product/'.$productArrayNew->slug . ($linkQuery ? '?'.$linkQuery : '');
                                $productLink     =  url('').'/product/'.$productArrayNew->slug;
                                $productImageLink      =  url('').'/storage/'.$productArrayNew->getProductImages->image_url;
                                $productPrice  =  round($getFinalPriceArray);
                                // $productSalePrice  =  '';
                                // $productSalePriceEffectiveDate  =  '';
                                $productCondition  =  'new';
                                // $productShippingWeight  =  '1.00 lb';
                                $productAvailability  =  'in stock';
                                $productIdentifierExists  =  'no';
                                // $productAdditionalImageLink  =  'https://mccoyhome.com/media/catalog/product/s/q/squareall6.jpeg';
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

                                // $link    = $dom->createElement('g:google_product_category', '200');

                                // $product->appendChild($link);

                                $image_link     = $dom->createElement('g:image_link', $productImageLink);

                                $product->appendChild($image_link);

                                $condition = $dom->createElement('g:condition', $productCondition);

                                $product->appendChild($condition);

                                $availability = $dom->createElement('g:availability', $productAvailability);

                                $product->appendChild($availability);

                                $price = $dom->createElement('g:price', $productPrice.' GBP ');

                                $product->appendChild($price);

                                $price = $dom->createElement('g:brand', 'Marlows Diamonds');

                                $product->appendChild($price);

                                $price = $dom->createElement('g:canonical_link', $productLink);

                                $product->appendChild($price);

                                foreach($productArrayNew->getProductGallery as $key => $addImages){
                                    $additional_image_link = $dom->createElement('g:additional_image_link', url('').'/storage/'.$addImages->image_url);

                                    $product->appendChild($additional_image_link);
                                }



                                $shipping_label = $dom->createElement('g:shipping_label', 0.00);

                                $product->appendChild($shipping_label);

                                $gender = $dom->createElement('g:gender', 'Female');

                                $product->appendChild($gender);

                                $age_group = $dom->createElement('g:age_group', 'Adult');

                                $product->appendChild($age_group);

                                $metal = $dom->createElement('g:metal', $metalType);

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

        $dom->appendChild($root);

        $dom->save($filePath);

    }

    public function getPriceCalculationFunction($productData,$diamondType,$finalPrices)
    {
        $getDiamondShape = '';
        if(isset($productData->diamond_shape) && !empty($productData->diamond_shape)){
            $getDiamondShape = $productData->diamond_shape;
        }


        $vat = getVAT();
        $prod_categories = explode(',',$productData->categories);

        if (in_array("18", $prod_categories))
        {
            $prod_categories = ['18'];
            $checkPlanCatArray = Category::whereIn('id',$prod_categories)->first()->toArray();
        }else if(in_array("8", $prod_categories)){
            $getSendingData = [
                'variation_price' =>$finalPrices,
                'carat' =>'0.30-0.39',
                'color' =>'D',
                'clarity' =>'SI2',
                'grade' =>'EX',
                'certificate' =>'GIA',
                'shape'=> $getDiamondShape,
                'slug' => $productData->slug,
            ];

            $regular_p_final = $this->getProductFinalPriceWithDiamondUsingXMLFiles($getSendingData);

            return $regular_p_final;

        }else{
            $checkPlanCatArray = Category::whereIn('id',$prod_categories)->where('parent_id',0)->first()->toArray();
        }

        $checkPlanCat = Category::select('id')->whereIn('id',$prod_categories)->where('name','LIKE','%plain%')->get()->toArray();
        if(!empty($checkPlanCat)) $plainband = true;
        else $plainband = false;


        $disPercentage = Discount::select('category_id','discount','inc_percentage','end_date')->where('category_id',$checkPlanCatArray['id'])->where('status',1)->first();

        if($plainband != true){
            if($diamondType == 'lab_grown' && $finalPrices<=3000){
                $regular_p_final = ($finalPrices-($finalPrices*0.35));
            }elseif($diamondType == 'lab_grown' && $finalPrices>3000){
                $regular_p_final = ($finalPrices-($finalPrices*0.5));
            }else{
                $regular_p_final = $finalPrices;
            }
        }else{
            $regular_p_final = $finalPrices;
        }

        $increaseDiscount = 1;
        $discountPercentage = 1;
        $regular_p_final = (($regular_p_final)*$increaseDiscount)*$vat;
        if(isset($disPercentage) && !empty($disPercentage)){
            $disPercentage = $disPercentage->toArray();
            if(auth()->guard('customer')->check()){
                if(isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1){
                    $increaseDiscount = 1 + ($disPercentage['inc_percentage']/100);
                }else{
                    $increaseDiscount = 1;
                }

                $regular_p_final = (($regular_p_final)*$increaseDiscount)*$vat;


                if($disPercentage['end_date'] >= date('Y-m-d')){

                    $getDiscountRange = DiscountRange::select('category_id','from_price','to_price','discount')->where('category_id', $checkPlanCatArray['id'])
                    ->whereRaw('"'.$regular_p_final.'" between `from_price` and `to_price`')
                    ->first();

                    $discountPercentage = 1 + ($disPercentage['discount']/100);

                    if(isset($getDiscountRange) && !empty($getDiscountRange->discount)){
                        if($getDiscountRange->discount > 1){
                            $discountPercentage = 1 + ($getDiscountRange->discount/100);
                        }else{
                            $discountPercentage = 1;
                        }
                    }else{
                        $discountPercentage = 1;
                    }
                }else{
                    $discountPercentage = 1;
                }

            }else{
                if(isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1){
                    $increaseDiscount = 1 + ($disPercentage['inc_percentage']/100);
                }else{
                    $increaseDiscount = 1;
                }
                $regular_p_final = (($regular_p_final)*$increaseDiscount)*$vat;
            }
        }


        return $regular_p_final;

    }

    public function getProductFinalPriceWithDiamondUsingXMLFiles($requestDataArray){

        $caratFrom = '0.30'; $caratTo = '0.39';
        if($requestDataArray['carat']!=''){
            $carat = explode('-',$requestDataArray['carat']);
            $caratFrom = $carat[0]; $caratTo = $carat[1];
        }

        $colorFrom = $colorTo = 'D'; $colour = array();
        if($requestDataArray['color']!=''){
            $colour = explode(',',$requestDataArray['color']);
            $colorFrom = $colorTo = $requestDataArray['color'];
        }

        $clarityFrom = $clarityTo = 'SI2'; $clarity=array();
        if($requestDataArray['clarity']!=''){
            $clarity = explode(',',$requestDataArray['clarity']);
            $clarityFrom = $clarityTo = $requestDataArray['clarity'];
        }

        $gradeFrom = $gradeTo = 'EX'; $grade=array();
        if($requestDataArray['grade']!=''){
            $grade = explode(',',$requestDataArray['grade']);
            $gradeFrom = $gradeTo = $requestDataArray['grade'];
        }

        $polishFrom = 'EX'; $polishTo = 'GD'; $polish=array();
        $symmetryFrom = 'EX'; $symmetryTo = 'GD'; $symmetry=array();
        $fluorescence = array();

        $certificate = array();
        if($requestDataArray['certificate']!=''){
            $certificate = explode(',',$requestDataArray['certificate']);
        }

        $data = array('shape'=>$requestDataArray['shape'],'colorFrom'=>$colorFrom,'colorTo'=>$colorTo,'colour'=>$colour,'clarityFrom'=>$clarityFrom,'clarityTo'=>$clarityTo,'clarity'=>$clarity,'caratFrom'=>$caratFrom,'caratTo'=>$caratTo,'gradeFrom'=>$gradeFrom,'gradeTo'=>$gradeTo,'grade'=>$grade,'polishFrom'=>$polishFrom,'polishTo'=>$polishTo,'polish'=>$polish,'symmetryFrom'=>$symmetryFrom,'symmetryTo'=>$symmetryTo,'symmetry'=>$symmetry,'fluorescence'=>$fluorescence,'certificate'=>$certificate,'num_of_row'=>1,'PageSize'=>1);

        $vat = getVAT();
        $settingPrice = sprintf('%0.2f', $requestDataArray['variation_price']);
        $hkData = getHKApiRecords($data);

        if(!empty($hkData)){
        	$diamondPrice = sprintf('%0.2f', ($hkData[0]['Amount']*1.25));
        	$finalPrice = round((float)$settingPrice+(float)$diamondPrice);

            $finalDiscountedPrice = $this->getActualSettingPrice($requestDataArray['slug'],$finalPrice);

        	return $finalDiscountedPrice;
        }else{
        	$rapnetData = getRapnetApiRecords($data,1);

            if(isset($rapnetData[0]) && !empty($rapnetData[0]->FinalPrice)){
                $diamondPrice = sprintf('%0.2f', ($rapnetData[0]->FinalPrice*1.25));
                $rapnetCertificateLink = '';
                if($rapnetData[0]->LabTitle=='GIA'){
                    $rapnetCertificateLink= 'https://www.gia.edu/cs/Satellite?reportno='.$rapnetData[0]->CertificateNumber.'&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
                }
                else if($rapnetData[0]->LabTitle=='IGI'){
                    $rapnetCertificateLink= 'https://www.igi.org/reports/verify-your-report?r='.$rapnetData[0]->CertificateNumber;
                }

                $finalPrice = round((float)$settingPrice+(float)$diamondPrice);

                $finalDiscountedPrice = $this->getActualSettingPrice($requestDataArray['slug'],$finalPrice);

                return $finalDiscountedPrice;
            }
        }

        $finalPrice = 0;
        return $finalPrice;
    }

    public function getActualSettingPrice($slug,$finalPrice)
    {

        $product_id = Products::where('slug',$slug)->value('id');

        if($product_id!=''){
            $getProduct = Products::with(['getProductImages','getProductVariation'])->where('slug',$slug)->first();

            $prod_categories = explode(',',$getProduct->categories);

            $checkPlanCatArray = Category::whereIn('id',$prod_categories)->where('parent_id',0)->first()->toArray();

            $disPercentage = Discount::select('category_id','discount','inc_percentage','end_date')->where('category_id',$checkPlanCatArray['id'])->where('status',1)->first();


            $vat = getVAT();

            $increaseDiscount = 1;
            $discountPercentage = 1;

            $finalPriceWithVat = ($finalPrice*$increaseDiscount)*$vat;

            if(isset($disPercentage) && !empty($disPercentage)){
                $disPercentage = $disPercentage->toArray();
                if(auth()->guard('customer')->check()){

                    if(isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1){
                        $increaseDiscount = 1 + ($disPercentage['inc_percentage']/100);
                    }

                    $finalPriceWithVat = ($finalPrice*$increaseDiscount)*$vat;

                }
            }

            return $finalPriceWithVat;
        }
    }

}
