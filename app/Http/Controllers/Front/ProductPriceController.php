<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountRange;

class ProductPriceController extends Controller
{
    public function getProductFinalPrice(Request $request){

        // $variationPrice = $CurrentVariationPrice * 1.3;
        $settingPrice = $request->setting_price;
        //1053+440 = 1493   

        $diamondPrice = $request->diamond_price;

        $finalPrice = $settingPrice + $diamondPrice;

        $finalDiscountedPrice = $this->getActualSettingPrice($request->slug,$finalPrice);

        return response()->json([
            'finalPrice'=>round($finalDiscountedPrice['settingPriceWithVat']),
            'discountedPrice'=>round($finalDiscountedPrice['settingPriceWithVatDiscount'])]); // round($getStatusSettingPrice);
    }

    public function getProductFinalPriceWithDiamond(Request $request){

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

        $data = array('shape'=>$request->shape,'colorFrom'=>$colorFrom,'colorTo'=>$colorTo,'colour'=>$colour,'clarityFrom'=>$clarityFrom,'clarityTo'=>$clarityTo,'clarity'=>$clarity,'caratFrom'=>$caratFrom,'caratTo'=>$caratTo,'gradeFrom'=>$gradeFrom,'gradeTo'=>$gradeTo,'grade'=>$grade,'polishFrom'=>$polishFrom,'polishTo'=>$polishTo,'polish'=>$polish,'symmetryFrom'=>$symmetryFrom,'symmetryTo'=>$symmetryTo,'symmetry'=>$symmetry,'fluorescence'=>$fluorescence,'certificate'=>$certificate,'num_of_row'=>1,'PageSize'=>1);

        //echo '<pre>'; print_r($data); die;
        $vat = getVAT();
        $settingPrice = sprintf('%0.2f', $request->variation_price);
        $hkData = getHKApiRecords($data);

        if(!empty($hkData)){
        	$diamondPrice = sprintf('%0.2f', ($hkData[0]['Amount']*1.25));
        	$finalPrice = round((float)$settingPrice+(float)$diamondPrice);

            $finalDiscountedPrice = $this->getActualSettingPrice($request->slug,$finalPrice);


        	return json_encode(array(
                'statuscode'=>'200',
                'finalPrice'=>round($finalDiscountedPrice['settingPriceWithVat']),
                'discountedPrice'=>round($finalDiscountedPrice['settingPriceWithVatDiscount']),
                'diamondPrice'=>$diamondPrice,
                'settingPrice'=>$settingPrice,
                'Stock_NO'=>$hkData[0]['Stock_NO'],
                'CertificateLink'=>$hkData[0]['CertificateLink']
            ));
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

                $finalDiscountedPrice = $this->getActualSettingPrice($request->slug,$finalPrice);


                return json_encode(array(
                    'statuscode'=>'200',
                    'finalPrice'=>round($finalDiscountedPrice['settingPriceWithVat']),
                    'discountedPrice'=>round($finalDiscountedPrice['settingPriceWithVatDiscount']),
                    'diamondPrice'=>$diamondPrice,
                    'settingPrice'=>$settingPrice,
                    'Stock_NO'=>$rapnetData[0]->DiamondID,
                    'CertificateLink'=>$rapnetCertificateLink
                ));
            }else{
                $finalPrice = 0;
                return json_encode(array('statuscode'=>'500','finalPrice'=>'0'));
            }
        }
    }

    public function getActualSettingPrice($slug,$finalPrice)
    { // 1493 

        $product_id = Products::where('slug',$slug)->value('id');

        if($product_id!=''){
            $getProduct = Products::with(['getProductImages','getProductVariation'])->where('slug',$slug)->first();

            $prod_categories = explode(',',$getProduct->categories);

            $checkPlanCatArray = Category::whereIn('id',$prod_categories)->where('parent_id',0)->first()->toArray();

            $disPercentage = Discount::select('category_id','discount','inc_percentage','end_date','is_login_users')
                            ->where('category_id',$checkPlanCatArray['id'])
                            ->where('status',1)
                            ->first();
            // prd($disPercentage->toArray());

            $vat = getVAT();
            // echo $vat;die; 
            $increaseDiscount = 1;
            $discountPercentage = 1;

            $settingPriceWithOutVat = $finalPrice*$increaseDiscount;
            $settingPriceWithVat = $settingPriceWithOutVat*$vat;

            if(isset($disPercentage) && !empty($disPercentage)){
                $disPercentage = $disPercentage->toArray();

                if($disPercentage['is_login_users']){
                    $isDiscountApplicable = auth()->guard('customer')->check();
                }else{
                    $isDiscountApplicable = true;
                }

                // prd($disPercentage['is_login_users']);

                if( $isDiscountApplicable ){

                    if(isset($disPercentage['inc_percentage']) && $disPercentage['inc_percentage'] > 1){
                        $increaseDiscount = 1 + ($disPercentage['inc_percentage']/100);
                    }

                    $settingPriceWithOutVat = $finalPrice*$increaseDiscount;
                    $settingPriceWithVat = $settingPriceWithOutVat*$vat;

                    if($disPercentage['end_date'] >= date('Y-m-d')){

                        $getDiscountRange = DiscountRange::select('category_id','from_price','to_price','discount')->where('category_id', $checkPlanCatArray['id'])
                        ->whereRaw('"'.$settingPriceWithVat.'" between `from_price` and `to_price`')
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

                        // if(isset($getDiscountRange)){
                        //     if($getDiscountRange->discount > 1){
                        //         $discountPercentage = 1 + ($getDiscountRange->discount/100);
                        //     }
                        // }
                    }

                }
            }


            $settingPriceWithVatDiscount = $settingPriceWithVat/$discountPercentage;

            $result = [
                'finalPrice' => $finalPrice,
                'settingPriceWithVat' =>  $settingPriceWithVat,
                'settingPriceWithVatDiscount' =>  $settingPriceWithVatDiscount,
                'discountedPrice' => $settingPriceWithVat - $settingPriceWithVatDiscount,
            ];

            return $result;
        }
    }


}
