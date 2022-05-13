<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function getProductFinalPrice(Request $request){
        
        // $variationPrice = $CurrentVariationPrice * 1.3;
    	$vat = getVAT();
        $settingPrice = $request->variation_price * $vat;

        $diamondPrice = $request->diamond_price;

        $finalPrice = $settingPrice + $diamondPrice;
        return round($finalPrice);
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
        $settingPrice = sprintf('%0.2f', $request->variation_price * $vat); 
        $hkData = getHKApiRecords($data);
        //echo '<pre>'; print_r($hkData); die;
        if(!empty($hkData)){
        	$diamondPrice = sprintf('%0.2f', ($hkData[0]['Amount']*1.25)*$vat);
        	$finalPrice = round((float)$settingPrice+(float)$diamondPrice);
        	//echo $settingPrice; die;
        	return json_encode(array('finalPrice'=>$finalPrice,'diamondPrice'=>$diamondPrice,'settingPrice'=>$settingPrice,'Stock_NO'=>$hkData[0]['Stock_NO'],'CertificateLink'=>$hkData[0]['CertificateLink']));
        }else{
        	$rapnetData = getRapnetApiRecords($data,1);
        	//echo '<pre>'; print_r($rapnetData); die;

        	
        	$diamondPrice = sprintf('%0.2f', ($rapnetData[0]->FinalPrice*1.25)*$vat);
        	$rapnetCertificateLink = '';
        	if($rapnetData[0]->LabTitle=='GIA'){
				$rapnetCertificateLink= 'https://www.gia.edu/cs/Satellite?reportno='.$rapnetData[0]->CertificateNumber.'&childpagename=GIA%2FPage%2FReportCheck&pagename=GIA%2FDispatcher&c=Page&cid=1355954554547';
			}
			else if($rapnetData[0]->LabTitle=='IGI'){
				$rapnetCertificateLink= 'https://www.igi.org/reports/verify-your-report?r='.$rapnetData[0]->CertificateNumber;
			}
        	//echo $settingPrice; die;
        	$finalPrice = round((float)$settingPrice+(float)$diamondPrice);
        	return json_encode(array('finalPrice'=>$finalPrice,'diamondPrice'=>$diamondPrice,'settingPrice'=>$settingPrice,'Stock_NO'=>$rapnetData[0]->DiamondID,'CertificateLink'=>$rapnetCertificateLink));
        }
    }
}
